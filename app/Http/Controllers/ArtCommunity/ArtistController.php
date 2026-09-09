<?php

namespace App\Http\Controllers\ArtCommunity;

use App\Models\Artwork;
use App\Models\User;
use Illuminate\Validation\Rule;

class ArtistController extends BaseArtCommunityController
{
    protected string $role = 'artist';

    protected array $editableProfileFields = [
        'first_name', 'last_name', 'address1', 'address2', 'city', 'state',
        'country', 'pincode', 'college', 'degree', 'portfolio', 'journey',
    ];

    public function dashboard()
    {
        $profile = $this->profileModel();

        $byStatus = Artwork::where('artist_id', $profile->id)
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $stats = [
            'artworks_total'     => (int) $byStatus->sum(),
            'artworks_published' => (int) ($byStatus['published'] ?? 0),
            'artworks_draft'     => (int) ($byStatus['draft'] ?? 0),
            'total_earnings'     => (float) Artwork::where('artist_id', $profile->id)
                                        ->where('status', 'published')->sum('earn'),
        ];

        $recentArtworks = Artwork::where('artist_id', $profile->id)
            ->latest()
            ->take(6)
            ->get();

        return view('art_community.artist.dashboard', [
            'role'           => $this->role,
            'user'           => $this->authUser(),
            'profile'        => $profile,
            'stats'          => $stats,
            'recentArtworks' => $recentArtworks,
            'completeness'   => $this->profileCompleteness($profile),
        ]);
    }

    protected function profileValidationRules(User $user): array
    {
        return [
            'name'       => 'required|string|max:255',
            'phone'      => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($user->id)],
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'address1'   => 'nullable|string|max:1000',
            'address2'   => 'nullable|string|max:1000',
            'city'       => 'nullable|string|max:255',
            'state'      => 'nullable|string|max:255',
            'country'    => 'nullable|string|max:255',
            'pincode'    => 'nullable|string|max:20',
            'college'    => 'nullable|string|max:255',
            'degree'     => 'nullable|string|max:255',
            'portfolio'  => 'nullable|string|max:255',
            'journey'    => 'nullable|string',
        ];
    }
}
