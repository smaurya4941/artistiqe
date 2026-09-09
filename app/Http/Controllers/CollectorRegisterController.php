<?php

namespace App\Http\Controllers;

use App\Models\CollectorRegister;
use App\Services\ArtCommunityRegistrar;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CollectorRegisterController extends Controller
{
    public function create()
    {
        return view('auth.boxed.collector_registration');
    }

    public function store(Request $request, ArtCommunityRegistrar $registrar)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => ['required', 'email', 'max:255', Rule::unique('users', 'email')],
            'phone'      => ['required', 'string', 'max:20', Rule::unique('users', 'phone')],
            'password'   => 'required|string|min:6|confirmed',
            'address_line1' => 'nullable|string|max:255',
            'address_line2' => 'nullable|string|max:255',
            'city'          => 'nullable|string|max:255',
            'state'         => 'nullable|string|max:255',
            'country'       => 'nullable|string|max:255',
            'zip'           => 'nullable|string|max:20',
            'journey'       => 'nullable|string',
            'sell_interest' => 'nullable|string|max:50',
        ], [
            'email.unique'       => translate('This email is already registered.'),
            'phone.unique'       => translate('This mobile number is already registered.'),
            'password.required'  => translate('Password is required.'),
            'password.confirmed' => translate('Password and Confirm Password must match.'),
        ]);

        $registrar->register(
            userType: 'collector',
            name: trim($data['first_name'] . ' ' . $data['last_name']),
            email: $data['email'],
            phone: $data['phone'],
            plainPassword: $data['password'],
            profileModel: CollectorRegister::class,
            profileData: collect($data)->only([
                'first_name', 'last_name', 'address_line1', 'address_line2',
                'city', 'state', 'country', 'zip', 'journey', 'sell_interest',
            ])->toArray(),
        );

        return redirect()->route('collector.register.success');
    }
}
