<?php

namespace App\Http\Controllers;

use App\Models\GalleryRegister;
use App\Services\ArtCommunityRegistrar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GalleryRegisterController extends Controller
{
    public function create()
    {
        return view('auth.boxed.gallery_registration');
    }

    public function store(Request $request, ArtCommunityRegistrar $registrar)
    {
        $data = $request->validate([
            'owner_name'        => 'required|string|max:255',
            'owner_surname'     => 'required|string|max:255',
            'email'             => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'phone'             => ['required', 'string', 'max:20', Rule::unique('users', 'phone')],
            'password'          => 'required|string|min:6|confirmed',
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
        ], [
            'email.unique'                => translate('This email is already registered.'),
            'phone.unique'                => translate('This phone number is already registered.'),
            'curatorial_vision.required'  => translate('Curatorial vision is mandatory.'),
            'password.required'           => translate('Password is required.'),
            'password.confirmed'          => translate('Password and Confirm Password must match.'),
        ]);

        $registrar->register(
            userType: 'gallery',
            name: trim($data['owner_name'] . ' ' . $data['owner_surname']),
            email: $data['email'],
            phone: $data['phone'],
            plainPassword: $data['password'],
            profileModel: GalleryRegister::class,
            profileData: collect($data)->only([
                'owner_name', 'owner_surname', 'gallery_name', 'address1', 'address2',
                'city', 'state', 'country', 'pincode', 'website', 'curatorial_vision',
                'exhibition_types', 'past_links', 'sell_interest',
            ])->toArray(),
        );

        return redirect()->route('gallery.register.success');
    }
}
