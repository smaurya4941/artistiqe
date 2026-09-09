<?php

namespace App\Http\Controllers\ArtCommunity;

use App\Models\User;
use Illuminate\Validation\Rule;

class GalleryController extends BaseArtCommunityController
{
    protected string $role = 'gallery';

    protected array $editableProfileFields = [
        'owner_name', 'owner_surname', 'gallery_name', 'address1', 'address2',
        'city', 'state', 'country', 'pincode', 'website', 'curatorial_vision',
        'exhibition_types', 'past_links', 'sell_interest',
    ];

    public function dashboard()
    {
        $user = $this->authUser();
        $profile = $this->profileModel();

        return view('art_community.gallery.dashboard', [
            'role'         => $this->role,
            'user'         => $user,
            'profile'      => $profile,
            'stats'        => $this->buyerStats($user),
            'recentOrders' => $this->recentOrders($user),
            'completeness' => $this->profileCompleteness($profile),
        ]);
    }

    protected function profileValidationRules(User $user): array
    {
        return [
            'name'              => 'required|string|max:255',
            'phone'             => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($user->id)],
            'owner_name'        => 'required|string|max:255',
            'owner_surname'     => 'required|string|max:255',
            'gallery_name'      => 'nullable|string|max:255',
            'address1'          => 'nullable|string|max:255',
            'address2'          => 'nullable|string|max:255',
            'city'              => 'nullable|string|max:255',
            'state'             => 'nullable|string|max:255',
            'country'           => 'nullable|string|max:255',
            'pincode'           => 'nullable|string|max:20',
            'website'           => 'nullable|string|max:255',
            'curatorial_vision' => 'required|string',
            'exhibition_types'  => 'nullable|string|max:255',
            'past_links'        => 'nullable|string|max:255',
            'sell_interest'     => 'nullable|in:yes,later',
        ];
    }
}
