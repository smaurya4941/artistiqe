<?php

namespace App\Http\Controllers;


use App\Models\CollectorRegister;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CollectorRegisterController extends Controller
{
    public function create() {
        return view('auth.boxed.collector_registration');
    }

    public function store(Request $request)
{
    // Validation
     $request->validate(
[
  'first_name' => 'required',
  'last_name'  => 'required',
  'email'      => 'required|email|unique:collector_registers,email',
  'phone'      => 'required|unique:collector_registers,phone',
  'password'   => 'required',
],
[
  'email.unique' => 'This email is already registered.',
  'phone.unique' => 'This mobile number is already registered.',
  'password.required'   => 'Password is required.',
    'password.confirmed'  => 'Password and Confirm Password must match.',
]
);

    // Store
    CollectorRegister::create([
        'first_name' => $request->first_name,
        'last_name'  => $request->last_name,
        'email'      => $request->email,
        'phone'      => $request->phone,
        'password'   => Hash::make($request->password),

        'address_line1' => $request->address_line1,
        'address_line2' => $request->address_line2,
        'city'     => $request->city,
        'state'    => $request->state,
        'country'  => $request->country,
        'zip'  => $request->zip,

        'journey'       => $request->journey,
        'sell_interest' => $request->sell_interest,
    ]);

    return redirect()->route('collector.register.success');
}
}
