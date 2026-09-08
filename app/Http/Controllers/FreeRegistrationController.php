<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class FreeRegistrationController extends Controller
{
    public function store(Request $request)
    {
        try {
            // ✅ Save image
            $fileName = time() . '_' . $request->file('item_image')->getClientOriginalName();
            $request->file('item_image')->move(public_path('uploads'), $fileName);

            // ✅ Insert into table
            $inserted = DB::table('FreeRegistration')->insert([
                'type'              => $request->type,
                'first_name'        => $request->first_name,
                'last_name'         => $request->last_name,
                'gallery_name'      => $request->gallery_name,
                'gallery_location'  => $request->gallery_location,
                'country'           => $request->country,
                'city'              => $request->city,
                'state'             => $request->state,
                'item_title'        => $request->item_title,
                'description'       => $request->description,
                'short_description' => $request->short_description,
                'price'             => $request->price,
                'status'            => $request->status ?? 'for_sale',
                'image_path'        => 'uploads/' . $fileName,
                // remove created_at if DB already has default
                'created_at'        => now(),
            ]);

            // ✅ Debug
            if ($inserted) {
                return back()->with('success', '🎉 Registration successful!');
            } else {
                return back()->with('error', '⚠️ Insert failed, please try again.');
            }

        } catch (Exception $e) {
            return back()->with('error', 'DB Error: ' . $e->getMessage());
        }
    }
}
