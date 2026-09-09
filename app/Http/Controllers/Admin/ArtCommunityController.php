<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Shared admin management for the art community (artists / collectors / galleries).
 * Concrete subclasses set the profile model, the user_type and the view/route slug.
 */
abstract class ArtCommunityController extends Controller
{
    /** @var class-string<Model> */
    protected string $profileModel;

    /** 'artist' | 'collector' | 'gallery' */
    protected string $userType;

    /** route/view slug — 'artists' | 'collectors' | 'galleries' */
    protected string $slug;

    /** human label, singular */
    protected string $label;

    /** searchable profile columns */
    protected array $searchColumns = ['first_name', 'last_name', 'email', 'phone'];

    public function __construct()
    {
        $this->middleware('permission:view_' . $this->slug)->only('index', 'show');
        $this->middleware('permission:approve_art_community')->only('approve', 'reject');
        $this->middleware('permission:ban_art_community')->only('ban');
        $this->middleware('permission:delete_art_community')->only('destroy');
        $this->middleware('permission:login_as_art_community')->only('login_as');
    }

    public function index(Request $request)
    {
        $model = $this->profileModel;

        $query = $model::query()->with('user')->latest();

        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected'], true)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                foreach ($this->searchColumns as $col) {
                    $q->orWhere($col, 'like', "%{$search}%");
                }
            });
        }

        $records = $query->paginate(15)->appends($request->query());
        $pendingCount = $model::where('status', 'pending')->count();

        return view('backend.art_community.index', [
            'records'      => $records,
            'slug'         => $this->slug,
            'label'        => $this->label,
            'userType'     => $this->userType,
            'pendingCount' => $pendingCount,
            'search'       => $request->search,
            'status'       => $request->status,
        ]);
    }

    public function show($id)
    {
        $record = $this->profileModel::with(['user', 'reviewer'])->findOrFail($id);

        return view('backend.art_community.show', [
            'record'   => $record,
            'slug'     => $this->slug,
            'label'    => $this->label,
            'userType' => $this->userType,
        ]);
    }

    public function approve($id)
    {
        $record = $this->profileModel::findOrFail($id);
        $record->update([
            'status'           => 'approved',
            'approved_at'      => now(),
            'reviewed_by'      => Auth::id(),
            'rejection_reason' => null,
        ]);

        $this->notify($record, 'approved');

        flash(translate($this->label . ' approved successfully.'))->success();
        return back();
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['rejection_reason' => 'nullable|string|max:1000']);

        $record = $this->profileModel::findOrFail($id);
        $record->update([
            'status'           => 'rejected',
            'approved_at'      => null,
            'reviewed_by'      => Auth::id(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        $this->notify($record, 'rejected');

        flash(translate($this->label . ' rejected.'))->success();
        return back();
    }

    public function ban($id)
    {
        $record = $this->profileModel::with('user')->findOrFail($id);
        $user = $record->user;

        if (! $user) {
            flash(translate('No linked user account.'))->error();
            return back();
        }

        $user->banned = $user->banned ? 0 : 1;
        $user->save();

        flash(translate($user->banned ? $this->label . ' banned.' : $this->label . ' unbanned.'))->success();
        return back();
    }

    public function destroy($id)
    {
        $record = $this->profileModel::with('user')->findOrFail($id);
        $user = $record->user;

        if ($user && Order::where('user_id', $user->id)->exists()) {
            flash(translate('This account has orders and cannot be deleted. Ban it instead.'))->error();
            return back();
        }

        $record->delete();
        if ($user) {
            $user->forceDelete();
        }

        flash(translate($this->label . ' deleted successfully.'))->success();
        return redirect()->route("admin.{$this->slug}.index");
    }

    public function login_as($id)
    {
        $record = $this->profileModel::with('user')->findOrFail($id);

        if (! $record->user) {
            flash(translate('No linked user account.'))->error();
            return back();
        }

        if ($record->status !== 'approved') {
            flash(translate('Approve the account before logging in as this member.'))->warning();
            return back();
        }

        Auth::login($record->user);
        return redirect()->route($this->userType . '.dashboard');
    }

    protected function notify(Model $record, string $outcome): void
    {
        // Placeholder for a dedicated email template; kept non-fatal for now.
        try {
            // e.g. Mail::to($record->user->email)->send(new ArtCommunityDecision($record, $outcome));
        } catch (\Throwable $e) {
            // ignore
        }
    }
}
