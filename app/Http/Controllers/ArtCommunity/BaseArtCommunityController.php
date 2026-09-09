<?php

namespace App\Http\Controllers\ArtCommunity;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

abstract class BaseArtCommunityController extends Controller
{
    /** 'artist' | 'collector' | 'gallery' */
    protected string $role;

    /** profile columns editable from the front-end profile form */
    protected array $editableProfileFields = [];

    protected function authUser(): User
    {
        return auth()->user();
    }

    protected function profileModel(): Model
    {
        $profile = $this->authUser()->artCommunityProfile();

        abort_if($profile === null, 404, translate('Profile not found.'));

        return $profile;
    }

    /**
     * Percentage of editable profile fields that are filled in.
     */
    protected function profileCompleteness(Model $profile): int
    {
        $fields = $this->editableProfileFields;
        if (empty($fields)) {
            return 100;
        }

        $filled = 0;
        foreach ($fields as $field) {
            if (filled($profile->{$field})) {
                $filled++;
            }
        }

        return (int) round(($filled / count($fields)) * 100);
    }

    public function profile()
    {
        $profile = $this->profileModel();

        return view('art_community.profile', [
            'role'         => $this->role,
            'user'         => $this->authUser(),
            'profile'      => $profile,
            'completeness' => $this->profileCompleteness($profile),
        ]);
    }

    public function updateProfile(Request $request)
    {
        if (env('DEMO_MODE') == 'On') {
            flash(translate('Sorry! the action is not permitted in demo'))->error();
            return back();
        }

        $user = $this->authUser();
        $profile = $this->profileModel();

        $validated = $request->validate($this->profileValidationRules($user));

        $user->name = $request->input('name', $user->name);
        if ($request->filled('phone')) {
            $user->phone = $request->input('phone');
        }
        $user->save();

        $profile->fill(collect($validated)->only($this->editableProfileFields)->toArray());
        $profile->save();

        flash(translate('Profile updated successfully.'))->success();

        return redirect()->route("{$this->role}.profile");
    }

    abstract protected function profileValidationRules(User $user): array;

    /**
     * Buyer-side numbers shared by collector & gallery dashboards.
     */
    protected function buyerStats(User $user): array
    {
        return [
            'orders_count'    => \App\Models\Order::where('user_id', $user->id)->count(),
            'wishlist_count'  => \App\Models\Wishlist::where('user_id', $user->id)->count(),
            'cart_count'      => \App\Models\Cart::where('user_id', $user->id)->count(),
            'wallet_balance'  => (float) $user->balance,
        ];
    }

    protected function recentOrders(User $user, int $take = 5)
    {
        return \App\Models\Order::where('user_id', $user->id)
            ->latest()
            ->take($take)
            ->get();
    }
}
