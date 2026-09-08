<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GalleryRegister;
use Illuminate\Support\Facades\Hash;


class GalleryRegisterController extends Controller
{
    /**
     * Show gallery registration form
     */
    public function create()
    {
        return view('auth.boxed.gallery_registration');
    }

    /**
     * Store gallery registration data
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                // Owner (MANDATORY)
                'owner_name'        => 'required|string|max:255',
                'owner_surname'     => 'required|string|max:255',
                'email'             => 'required|email|unique:gallery_registers,email',
                'phone'             => 'required|unique:gallery_registers,phone',
                // 🔐 PASSWORD
    'password'          => 'required|confirmed|min:6',

    'curatorial_vision' => 'required|string',
                // Gallery
                'gallery_name'      => 'nullable|string|max:255',
                'address1'          => 'nullable|string|max:255',
                'address2'          => 'nullable|string|max:255',
                'city'              => 'nullable|string|max:255',
                'state'             => 'nullable|string|max:255',
                'country'           => 'nullable|string|max:255',
                'pincode'           => 'nullable|string|max:20',
                'website'           => 'nullable|string|max:255',

                // Curatorial
                'curatorial_vision' => 'required|string',

                // Exhibition
                'exhibition_types'  => 'nullable|string|max:255',
                'past_links'        => 'nullable|string|max:255',

                // Selling
                'sell_interest'     => 'nullable|in:yes,later',
            ],
            [
                // Custom messages
                'owner_name.required'        => 'Owner name is required.',
                'owner_surname.required'     => 'Owner surname is required.',
                'email.required'             => 'Email is required.',
                'email.email'                => 'Enter a valid email address.',
                'email.unique'               => 'This email is already registered.',
                'phone.required'             => 'Phone number is required.',
                'phone.unique'               => 'This phone number is already registered.',
                'curatorial_vision.required' => 'Curatorial vision is mandatory.',
                'password.required'          => 'Password is required.',
                'password.confirmed'         => 'Password and Confirm Password must match.',
            ]
        );

        GalleryRegister::create([
            // Owner
            'owner_name'        => $request->owner_name,
            'owner_surname'     => $request->owner_surname,
            'email'             => $request->email,
            'phone'             => $request->phone,
             // 🔐 SAVE PASSWORD
            'password'          => Hash::make($request->password),
            // Gallery
            'gallery_name'      => $request->gallery_name,
            'address1'          => $request->address1,
            'address2'          => $request->address2,
            'city'              => $request->city,
            'state'             => $request->state,
            'country'           => $request->country,
            'pincode'           => $request->pincode,
            'website'           => $request->website,

            // Curatorial
            'curatorial_vision' => $request->curatorial_vision,

            // Exhibition
            'exhibition_types'  => $request->exhibition_types,
            'past_links'        => $request->past_links,

            // Selling
            'sell_interest'     => $request->sell_interest,
        ]);

        return redirect()->route('gallery.register.success');
    }
}
