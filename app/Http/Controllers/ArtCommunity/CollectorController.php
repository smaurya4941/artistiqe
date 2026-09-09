<?php

namespace App\Http\Controllers\ArtCommunity;

use App\Models\User;
use Illuminate\Validation\Rule;

class CollectorController extends BaseArtCommunityController
{
    protected string $role = 'collector';

    protected array $editableProfileFields = [
        'first_name', 'last_name', 'address_line1', 'address_line2',
        'city', 'state', 'country', 'zip', 'journey', 'sell_interest',
    ];

    public function dashboard()
    {
        $user = $this->authUser();
        $profile = $this->profileModel();

        return view('art_community.collector.dashboard', [
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
            'name'          => 'required|string|max:255',
            'phone'         => ['nullable', 'string', 'max:20', Rule::unique('users', 'phone')->ignore($user->id)],
            'first_name'    => 'required|string|max:255',
            'last_name'     => 'required|string|max:255',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:255',
            'state'         => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:255',
            'zip'           => 'nullable|string|max:20',
            'journey'       => 'nullable|string',
            'sell_interest' => 'nullable|string|max:50',
        ];
    }
}
