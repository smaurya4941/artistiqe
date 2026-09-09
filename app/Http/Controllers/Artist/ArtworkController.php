<?php

namespace App\Http\Controllers\Artist;

use App\Http\Controllers\Controller;
use App\Models\Artwork;
use Illuminate\Http\Request;

class ArtworkController extends Controller
{
    /**
     * The current artist's profile row (artists.id), used as artworks.artist_id.
     */
    private function artistProfileId(): int
    {
        $profile = auth()->user()?->artistProfile;

        abort_if($profile === null, 403, translate('Artist profile not found.'));

        return $profile->id;
    }

    public function index()
    {
        $artworks = Artwork::where('artist_id', $this->artistProfileId())
            ->latest()
            ->paginate(12);

        return view('artist.artwork.index', compact('artworks'));
    }

    public function create()
    {
        return view('artist.artwork.create');
    }

    public function edit(Artwork $artwork)
    {
        abort_if($artwork->artist_id !== $this->artistProfileId(), 403);

        return view('artist.artwork.create', compact('artwork'));
    }

    public function store(Request $request)
    {
        $action = $request->input('action_type', 'publish');

        $rules = [
            'title'           => 'required|string|max:255',
            'primary_image'   => 'nullable|image|max:20480',
            'angle_images.*'  => 'nullable|image|max:20480',
        ];
        if ($action === 'publish') {
            $rules['price'] = 'required|numeric|min:0';
        }
        $request->validate($rules);

        $artwork = new Artwork();
        $artwork->artist_id = $this->artistProfileId();
        $this->fillCoreFields($artwork, $request);
        $this->applyPricing($artwork, (float) ($request->price ?? 0));
        $this->handleImages($artwork, $request);
        $artwork->status = ($action === 'draft') ? 'draft' : 'published';
        $artwork->save();

        return redirect()
            ->route('artist.artworks.index')
            ->with('success', $action === 'draft'
                ? translate('Artwork saved as draft')
                : translate('Artwork published successfully!'));
    }

    public function update(Request $request, Artwork $artwork)
    {
        abort_if($artwork->artist_id !== $this->artistProfileId(), 403);

        $action = $request->input('action_type', 'publish');

        $rules = ['title' => 'required|string|max:255'];
        if ($action === 'publish') {
            $rules['price'] = 'required|numeric|min:0';
        }
        $request->validate($rules);

        $this->fillCoreFields($artwork, $request);
        $this->applyPricing($artwork, (float) ($request->price ?? 0));
        $this->handleImages($artwork, $request);
        $artwork->status = ($action === 'draft') ? 'draft' : 'published';
        $artwork->save();

        return redirect()
            ->route('artist.artworks.index')
            ->with('success', translate('Artwork updated successfully!'));
    }

    public function saveDraft(Request $request)
    {
        $request->merge(['action_type' => 'draft']);

        return $this->store($request);
    }

    /* ===================== helpers ===================== */

    private function fillCoreFields(Artwork $artwork, Request $request): void
    {
        foreach ([
            'title', 'year', 'description', 'category', 'medium',
            'orientation', 'width', 'height', 'depth',
            'delivery_type', 'packaging_notes',
        ] as $field) {
            $artwork->{$field} = $request->input($field);
        }
    }

    private function applyPricing(Artwork $artwork, float $price): void
    {
        $commission = $price * 0.20;
        $gst = $commission * 0.18;

        $artwork->price = $price;
        $artwork->commission = $commission;
        $artwork->gst = $gst;
        $artwork->earn = $price - $commission - $gst;
    }

    private function handleImages(Artwork $artwork, Request $request): void
    {
        if ($request->hasFile('primary_image')) {
            $artwork->primary_image = $request->file('primary_image')->store('artworks', 'public');
        }

        if ($request->hasFile('angle_images')) {
            $images = [];
            foreach ($request->file('angle_images') as $image) {
                $images[] = $image->store('artworks', 'public');
            }
            $artwork->angle_images = $images;
        } elseif (! $artwork->exists) {
            $artwork->angle_images = [];
        }
    }
}
