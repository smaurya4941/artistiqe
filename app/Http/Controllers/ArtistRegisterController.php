<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Services\ArtCommunityRegistrar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ArtistRegisterController extends Controller
{
    public function store(Request $request, ArtCommunityRegistrar $registrar)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'email'      => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'phone'      => ['required', 'digits:10', Rule::unique('users', 'phone')],
            'password'   => 'required|string|min:6|confirmed',
            'pincode'    => 'nullable|digits:6',
            'address1'   => 'nullable|string|max:1000',
            'address2'   => 'nullable|string|max:1000',
            'city'       => 'nullable|string|max:255',
            'state'      => 'nullable|string|max:255',
            'country'    => 'nullable|string|max:255',
            'college'    => 'nullable|string|max:255',
            'degree'     => 'nullable|string|max:255',
            'portfolio'  => 'nullable|string|max:255',
            'journey'    => 'nullable|string',
        ], [
            'email.unique'    => translate('This email already exists.'),
            'phone.unique'    => translate('This phone number already exists.'),
            'phone.digits'    => translate('Phone must be 10 digits.'),
            'password.confirmed' => translate('Password and Confirm Password must match.'),
        ]);

        $registrar->register(
            userType: 'artist',
            name: trim($data['first_name'] . ' ' . ($data['last_name'] ?? '')),
            email: $data['email'],
            phone: $data['phone'],
            plainPassword: $data['password'],
            profileModel: Artist::class,
            profileData: collect($data)->only([
                'first_name', 'last_name', 'address1', 'address2', 'city', 'state',
                'country', 'pincode', 'college', 'degree', 'portfolio', 'journey',
            ])->toArray(),
        );

        return redirect()->route('artist.register.success');
    }
}
