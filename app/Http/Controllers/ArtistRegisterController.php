<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ArtistRegisterController extends Controller
{
    
public function store(Request $request)
{
    $request->validate([
        'first_name' => 'required|string|max:255',

        'email' => [
            'required',
            'email',
            Rule::unique('artists', 'email') // table name check karein
        ],

        'phone' => [
            'required',
            'digits:10',
            Rule::unique('artists', 'phone')
        ],

        'pincode' => 'nullable|digits:6',
    ], [
        'email.required' => 'Email is required.',
        'email.email' => 'Enter a valid email address.',
        'email.unique' => 'This email already exists.',

        'phone.required' => 'Phone number is required.',
        'phone.digits' => 'Phone must be 10 digits.',
        'phone.unique' => 'This phone number already exists.',
    ]);
        Artist::create($request->all());

        return redirect()->route('artist.register.success');
    }
}
