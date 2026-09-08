@extends('artist.layouts.app')

@section('content')
<div class="artist-dashboard">
<!-- <link rel="stylesheet" href="/Artistiqe/public/assets/artist/css/dashboard.css"> -->

    {{-- HEADER --}}
    <div class="dashboard-header">
        <div>
            <h2>Upload Artwork</h2>
            <p class="subtext">
                <span id="step-text">STEP 1 OF 4 • ARTWORK DETAILS</span>
            </p>
        </div>

        <div class="header-actions">
            <a href="#" class="help-link">HELP CENTER</a>
          <button type="submit" class="btn-outline" id="saveDraftBtn"
        onclick="document.getElementById('actionType').value='draft'">
    SAVE DRAFT
</button>

        </div>
    </div>

    {{-- STEPPER --}}
    <div class="stepper">
        <div class="step active" data-step="1">
            <span class="circle">1</span>
            <p>Artwork Details</p>
        </div>
        <div class="step" data-step="2">
            <span class="circle">2</span>
            <p>Upload Images</p>
        </div>
        <div class="step" data-step="3">
            <span class="circle">3</span>
            <p>Delivery & Logistics</p>
        </div>
        <div class="step" data-step="4">
            <span class="circle">4</span>
            <p>Pricing & Publish</p>
        </div>
    </div>

    {{-- FORM --}}
  <form id="artworkForm"
      method="POST"
      action="{{ isset($artwork)
          ? route('artist.artwork.update', $artwork->id)
          : route('artist.artwork.store') }}"
      enctype="multipart/form-data">

@csrf


        {{-- STEP 1 --}}
        <div class="step-content active" data-step="1">
           <div class="form-card">

    {{-- CORE INFORMATION --}}
    <h3>Core Information</h3>

    <div class="form-grid">
        <div>
            <label>Artwork Title</label>
            <input type="text"
       name="title"
       value="{{ old('title', $artwork->title ?? '') }}"
       placeholder="e.g. Echoes of Silence">
            <small>Keep it memorable and descriptive.</small>
        </div>

        <div>
            <label>Year of Creation</label>
           <input type="number"
       name="year"
       value="{{ old('year', $artwork->year ?? date('Y')) }}">
        </div>
    </div>

    {{-- DESCRIPTION --}}
    <div class="form-group">
        <div class="label-row">
            <label>Description</label>
            <a href="#" class="ai-help">✨ ASSIST WITH AI</a>
        </div>

        <textarea name="description" rows="4"
placeholder="Tell the story behind this piece...">{{ old('description', $artwork->description ?? '') }}</textarea>


        <small>Minimum 50 words recommended for search visibility.</small>
    </div>

    {{-- CATEGORY & MEDIUM --}}
    <div class="form-grid">
        <div>
            <label>Category</label>
            <select name="category">
    <option value="">Select a Category</option>
    @foreach(['Painting','Digital Art','Sculpture'] as $cat)
        <option value="{{ $cat }}"
        {{ old('category', $artwork->category ?? '') == $cat ? 'selected' : '' }}>
            {{ $cat }}
        </option>
    @endforeach
</select>

        </div>

        <div>
            <label>Medium & Material</label>
           <input type="text"
       name="medium"
       value="{{ old('medium', $artwork->medium ?? '') }}"
       placeholder="e.g. Oil on Canvas">

        </div>
    </div>

</div>

{{-- PHYSICAL ATTRIBUTES --}}
<div class="form-card">

    <h3>Physical Attributes</h3>

    {{-- ORIENTATION --}}
    <div class="form-group">
        <label>Orientation</label>

        <div class="orientation-group">
            <label class="orientation-btn">
                <input type="radio" name="orientation" value="portrait"
{{ old('orientation', $artwork->orientation ?? '') == 'portrait' ? 'checked' : '' }}>
                <span>Portrait</span>
            </label>

            <label class="orientation-btn">
               <input type="radio" name="orientation" value="landscape"
{{ old('orientation', $artwork->orientation ?? '') == 'landscape' ? 'checked' : '' }}>
                <span>Landscape</span>
            </label>

            <label class="orientation-btn">
               <input type="radio" name="orientation" value="square"
{{ old('orientation', $artwork->orientation ?? '') == 'square' ? 'checked' : '' }}>
                <span>Square</span>
            </label>
        </div>
    </div>

    {{-- DIMENSIONS --}}
    <div class="form-grid">
        <div>
            <label>Width (in)</label>
            <input type="number" step="0.1" name="width"
value="{{ old('width', $artwork->width ?? '') }}">
        </div>

        <div>
            <label>Height (in)</label>
            <input type="number" step="0.1" name="height"
value="{{ old('height', $artwork->height ?? '') }}">
        </div>

        <div>
            <label>Depth (in)</label>
            <input type="number" step="0.1" name="depth"
value="{{ old('depth', $artwork->depth ?? '') }}">
        </div>
    </div>

</div>



        </div>

        {{-- STEP 2 --}}
        <div class="step-content" data-step="2">
           <div class="form-card">

    {{-- PRIMARY IMAGE --}}
    <h3 class="text-center">Primary View</h3>
    <p class="text-center muted">
        This will be the first image customers see on your profile.
    </p>

    <div class="upload-primary" id="primaryDrop">
        <input type="file" name="primary_image" id="primaryInput" accept="image/*" hidden>

        <div class="upload-placeholder">
            <i class="fa-regular fa-image"></i>
            <p>
                Drag & drop or
                <span class="browse" onclick="document.getElementById('primaryInput').click()">
                    browse files
                </span>
            </p>
            <small>JPEG or PNG. Max size 20MB. Minimum 2400px wide.</small>
        </div>

        <img id="primaryPreview" hidden>
    </div>
     {{-- 👇👇 YAHI ADD KARNA HAI --}}
        @if(isset($artwork) && !empty($artwork->primary_image))
            <img src="{{ asset('storage/'.$artwork->primary_image) }}"
                 style="max-width:100%; border-radius:10px; margin-top:12px;">
        @endif
</div>

{{-- ADDITIONAL ANGLES --}}
<div class="form-card">

    <h3>Additional Views</h3>

    <div class="angle-grid">
        @for($i = 2; $i <= 5; $i++)
        <label class="angle-box">
            <input type="file" name="angle_images[]" accept="image/*" hidden>
            <span class="plus">+</span>
            <span class="angle-text">ANGLE {{ $i }}</span>
            <img hidden>
        </label>
        @if(!empty($artwork->angle_images))
<div class="angle-grid">
@foreach($artwork->angle_images as $img)
    <img src="{{ asset('storage/'.$img) }}"
         style="width:120px;height:120px;object-fit:cover;border-radius:8px;">
@endforeach
</div>
@endif

        @endfor
    </div>

    {{-- GUIDELINES --}}
    <div class="photo-guidelines">
        <strong>Photography Guidelines</strong><br>
        Avoid harsh shadows. Take photos in natural daylight.
        Do not include watermarks or digital filters.
    </div>

</div>

        </div>

        {{-- STEP 3 --}}
        <div class="step-content" data-step="3">
            <div class="form-card">

    <h3>How will this be delivered?</h3>

    <div class="delivery-options">

    <label class="delivery-card">
        <input type="radio" name="delivery_type" value="rolled"
{{ old('delivery_type', $artwork->delivery_type ?? '') == 'rolled' ? 'checked' : '' }}>
        <div class="delivery-content">
            <strong>Rolled in a Tube</strong>
            <p>Recommended for oversized canvas works.</p>
        </div>
        <span class="check-icon">✓</span>
    </label>

    <label class="delivery-card">
        <input type="radio" name="delivery_type" value="framed"
{{ old('delivery_type', $artwork->delivery_type ?? '') == 'framed' ? 'checked' : '' }}>
        <div class="delivery-content">
            <strong>Framed</strong>
            <p>Ready to hang. Ensure safe corner protection.</p>
        </div>
        <span class="check-icon">✓</span>
    </label>

    <label class="delivery-card">
       <input type="radio" name="delivery_type" value="stretched"
{{ old('delivery_type', $artwork->delivery_type ?? '') == 'stretched' ? 'checked' : '' }}>
        <div class="delivery-content">
            <strong>Stretched Canvas</strong>
            <p>Shipped on internal wooden chassis.</p>
        </div>
        <span class="check-icon">✓</span>
    </label>

</div>

</div>

{{-- SPECIAL PACKAGING --}}
<div class="form-card">

    <h3>Special Packaging Notes</h3>

   <textarea name="packaging_notes" rows="4">{{ old('packaging_notes', $artwork->packaging_notes ?? '') }}</textarea>


</div>

{{-- SHIPPING DISCLAIMER --}}
<div class="shipping-disclaimer">
    <i class="fa-regular fa-shield"></i>
    <div>
        <strong>Standard Shipping Disclaimer</strong>
        <p>
            ArtistiQe partners with premium logistics services.
            Sellers are responsible for primary packaging.
            Final shipping costs are calculated based on destination and dimensions.
        </p>
    </div>
</div>

        </div>

        {{-- STEP 4 --}}
        <div class="step-content" data-step="4">
           {{-- PRICING --}}
<div class="form-card">

    <h3>Pricing & Distribution</h3>

    <label>List Price (USD)</label>
    <div class="price-input">
        <span>$</span>
        <input type="number"
       name="price"
       id="priceInput"
       value="{{ old('price', $artwork->price ?? '') }}"
       min="0">

    </div>
    <small>Consider material costs, time, and current market value.</small>

    <div class="price-breakdown">
        <div>
            <span>ArtistiQe Commission (20%)</span>
            <span id="commission">-$0.00</span>
        </div>

        <div>
            <span>GST Deduction (18% on Commission)</span>
            <span id="gst">-$0.00</span>
        </div>

        <div>
            <span>Estimated Packing Support</span>
            <span class="included">Included</span>
        </div>

        <div class="earn-box">
            <span>You Earn</span>
            <strong id="earn">$0.00</strong>
        </div>
    </div>

    {{-- TAX --}}
    <div class="form-group">
        <label class="checkbox">
            <input type="checkbox" name="gst"
{{ old('gst', $artwork->gst ?? false) ? 'checked' : '' }}>

            I am GST registered
        </label>
    </div>

</div>

{{-- SUMMARY --}}
<div class="form-card">

    <h4 class="muted-title">SUMMARY PREVIEW</h4>

    <div class="summary-card">
        <div class="summary-left">
            <div class="summary-img"></div>
            <div>
                <strong>Untitled Artwork</strong>
                <p>Category • Medium</p>
                <small>x1 • Framed</small>
            </div>
        </div>

        <div class="summary-right">
            <strong id="summaryPrice">$0</strong>
            <span class="public">PUBLIC LISTING</span>
        </div>
    </div>

</div>

        </div>

       {{-- FOOTER --}}
<div class="form-footer">
    <div class="draft-info">
        Automatic draft saved at 10:45 AM<br>
        <button type="submit" class="btn-outline" id="saveDraftBtn"
        onclick="document.getElementById('actionType').value='draft'">
    SAVE DRAFT
</button>


    </div>

    <div class="footer-actions">
        <button type="button" class="btn-secondary" id="backBtn" disabled>
            Back
        </button>

        <button type="button" class="btn-primary btn-next">
            Continue
        </button>
    </div>
</div>

<input type="hidden" name="action_type" id="actionType"
value="{{ old('action_type','publish') }}">

    </form>

</div>
@endsection
