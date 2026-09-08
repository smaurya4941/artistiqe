<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Artwork;
use Illuminate\Support\Facades\Storage;

class ArtworkController extends Controller
{
    public function create()
{
    return view('artist.artwork.create');
}
public function update(Request $request, Artwork $artwork)
{
    if ($artwork->artist_id !== auth('artist')->id()) {
        abort(403);
    }

    $artwork->fill($request->except([
        'primary_image','angle_images','action_type'
    ]));
$action = $request->input('action_type', 'publish');

$rules = [
    'title' => 'required|string|max:255',
];

if ($action === 'publish') {
    $rules['price'] = 'required|numeric|min:0';
}

$request->validate($rules);

    // primary image replace
    if ($request->hasFile('primary_image')) {
        $artwork->primary_image =
            $request->file('primary_image')->store('artworks', 'public');
    }

    // angle images replace
    if ($request->hasFile('angle_images')) {
        $imgs = [];
        foreach ($request->file('angle_images') as $img) {
            $imgs[] = $img->store('artworks', 'public');
        }
        $artwork->angle_images = $imgs;
    }

    // pricing recalc
    $price = $request->price ?? 0;

$artwork->price = $price;
$artwork->commission = $price * 0.20;
$artwork->gst = ($price * 0.20) * 0.18;
$artwork->earn = $price - $artwork->commission - $artwork->gst;

    // status
    $artwork->status = $request->action_type === 'draft'
        ? 'draft'
        : 'published';

    $artwork->save();

    return redirect()
        ->route('artist.dashboard')
        ->with('success', '✏️ Artwork updated successfully!');
}

public function edit(Artwork $artwork)
{
    // security check
    if ($artwork->artist_id !== auth('artist')->id()) {
        abort(403);
    }

    return view('artist.artwork.create', compact('artwork'));
}


    public function store(Request $request)
{
    $action = $request->input('action_type', 'publish');

    // ✅ CONDITIONAL VALIDATION
    $rules = [
        'title' => 'required|string|max:255',
        'primary_image' => 'nullable|image|max:20480',
        'angle_images.*' => 'nullable|image|max:20480',
    ];

    if ($action === 'publish') {
        $rules['price'] = 'required|numeric|min:0';
    }

    $request->validate($rules);

    $artwork = new Artwork();
    $artwork->artist_id = auth('artist')->id();

    // Core
    $artwork->title = $request->title;
    $artwork->year = $request->year;
    $artwork->description = $request->description;
    $artwork->category = $request->category;
    $artwork->medium = $request->medium;

    // Physical
    $artwork->orientation = $request->orientation;
    $artwork->width = $request->width;
    $artwork->height = $request->height;
    $artwork->depth = $request->depth;

    // Delivery
    $artwork->delivery_type = $request->delivery_type;
    $artwork->packaging_notes = $request->packaging_notes;

    // Pricing (SAFE)
    $price = $request->price ?? 0;
    $artwork->price = $price;
    $artwork->commission = $price * 0.20;
    $artwork->gst = ($price * 0.20) * 0.18;
    $artwork->earn = $price - $artwork->commission - $artwork->gst;

    // Images
    if ($request->hasFile('primary_image')) {
        $artwork->primary_image = $request
            ->file('primary_image')
            ->store('artworks', 'public');
    }

    $imgs = [];
    if ($request->hasFile('angle_images')) {
        foreach ($request->file('angle_images') as $img) {
            $imgs[] = $img->store('artworks', 'public');
        }
    }
    $artwork->angle_images = $imgs;

    // Status
    $artwork->status = ($action === 'draft') ? 'draft' : 'published';

    $artwork->save();

    return redirect()
        ->route('artist.dashboard')
        ->with(
            'success',
            $action === 'draft'
                ? '📝 Artwork saved as draft'
                : '🎉 Artwork published successfully!'
        );
}


}
