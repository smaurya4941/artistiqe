@extends('auth.layouts.authentication')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;600;700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

<style>
body{font-family:'Nunito',sans-serif;font-size:15.5px}
h1,h2,h3,h4,h5,h6{font-family:'Merriweather',serif}
.art-bg{background:#f6f1ea;min-height:100vh;padding:40px 0}
.outer-box{border:3px solid #b30000;border-radius:16px;padding:40px 30px;max-width:1100px;margin:auto}
.soft-card{background:#f3e4d9;border-radius:28px;padding:30px;margin-bottom:30px}
.soft-card input,.soft-card textarea{background:#f9f6f3;border:1px solid #ddd;border-radius:6px}
.logo-wrap{text-align:center;margin-bottom:20px}
.logo-wrap img{height:120px}
.btn-submit{background:#b30000;color:#fff;border-radius:6px;padding:10px 40px}
</style>

<div class="art-bg">

<div class="logo-wrap">
    <a href="{{ route('home') }}">
        <img src="{{ static_asset('assets/img/Artistiqe_Logo_sd.png') }}">
    </a>
</div>

<div class="outer-box">

<!-- INTRO -->
<div class="soft-card">
        <div style="display:flex; align-items:center; gap:14px; margin-bottom:15px;">
    <img src="{{ static_asset('assets/img/Artistiqe_Logo_A 2.svg') }}" alt="Artistiqe" style="height:38px;">
    <!-- <strong style="font-family:'Merriweather',serif;">Welcome to ArtistiQe</strong> -->
</div>
    <h6>
        Welcome to <b>ArtistiQe.</b> <br> We are honoured to partner with galleries and institutions that contribute to the cultural landscape through their vision, programming, and commitment to artistic growth.<br>Your responses help us understand your curatorial framework and ensure that your presence on ArtistiQe reflects your identity, exhibitions, and represented artists with clarity and respect.
    </h6>
    <ul>
        <p>Once registered, your gallery will have access to dedicated management tools, artwork uploads, and participation in curated digital showcases. (Registration includes an annual charges of ₹2,000. A platform fee is applied only when artworks are sold through ArtistiQe.)</p>
        <li>Fields marked (*) are mandatory</li>
        <!-- <li>Additional guidance is available below</li> -->
    </ul>
</div>

@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form method="POST" action="{{ route('gallery.register.store') }}">
@csrf

<!-- OWNER DETAILS -->
<div class="soft-card">
<h5>Owner Details:- <span style="color:red;font-size:14px;">*</span></h5>

<div class="row">
    <div class="col-md-6 mb-3">
        <label>Name</label>
        <input name="owner_name" class="form-control" placeholder="Enter your first name" required>
    </div>
    <div class="col-md-6 mb-3">
        <label>Lastname</label>
        <input name="owner_surname" class="form-control" placeholder="Enter your last name"required>
    </div>
</div>

<h6>Contact Details-</h6>
<div class="row">
    <div class="col-md-6 mb-3">
        <label>Email *</label>
        <input name="email" type="email" class="form-control" placeholder="Enter your email"required>
    </div>
    <div class="col-md-6 mb-3">
        <label>Phone *</label>
        <input name="phone" class="form-control" placeholder="Enter your phone number"required>
    </div>
</div>
</div>
<!-- Password -->
<div class="soft-card">
    <h5 class="mb-3">
        Account Security
        <span style="color:red;font-size:14px;">*</span>
    </h5>

    <div class="row">
        <div class="col-md-6 mb-3">
            <label>Password <span style="color:red">*</span></label>
            <input name="password" type="password" class="form-control" placeholder="Enter your password"required>

            @error('password')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>

        <div class="col-md-6 mb-3">
            <label>Confirm Password <span style="color:red">*</span></label>
            <input name="password_confirmation" type="password" class="form-control" placeholder="Enter your password_confirmation"required>
        </div>
    </div>
</div>


<!-- GALLERY DETAILS -->
<div class="soft-card">
<h5>Gallery / Institution / Studio Details:</h5>

<div class="mb-3">
    <label>Gallery Name:</label>
    <input name="gallery_name" class="form-control" placeholder="Enter your gallery name">
</div>

<div class="mb-3">
    <label>Address Line 1:</label>
    <input name="address1" class="form-control" placeholder="Enter your address1">
</div>

<div class="mb-3">
    <label>Address Line 2:</label>
    <input name="address2" class="form-control" placeholder="Enter your address2">
</div>

<div class="row">
    <div class="col-md-4 mb-3"><label>City:</label><input name="city" class="form-control" placeholder="Enter your city"></div>
    <div class="col-md-4 mb-3"><label>State:</label><input name="state" class="form-control" placeholder="Enter your state"></div>
    <div class="col-md-4 mb-3"><label>Country:</label><input name="country" class="form-control" placeholder="Enter your country"></div>
</div>

<div class="row">
    <div class="col-md-4 mb-3">
        <label>ZIP / Postal Code:</label>
        <input name="pincode" class="form-control" placeholder="Enter your zip code">
    </div>
    <div class="col-md-8 mb-3">
        <label>Website URL (if any)-</label>
        <input name="website" class="form-control" placeholder="Enter your website url">
    </div>
</div>
</div>

<!-- CURATORIAL VISION -->
<div class="soft-card">
<h5>
Tell us about your curatorial vision.<br>(What guides your programme, the ideas you explore, and the artists you champion?)* <span style="color:red">*</span>
</h5>
<textarea name="curatorial_vision" rows="5" class="form-control" placeholder="Tell us about your"required></textarea>
</div>

<!-- EXHIBITION INFO -->
<div class="soft-card">
<h5>Exhibition & Programme Information</h5>

<div class="mb-3">
    <label>Types of exhibitions you organise</label>
    <input name="exhibition_types" class="form-control" placeholder="Enter types of exhibitions">
</div>

<div class="mb-3">
    <label>Link to past exhibitions or catalogues (if any)</label>
    <input name="past_links" class="form-control" placeholder="Enter link to past">
</div>
</div>

<!-- SELLING -->
<div class="soft-card">
<h5>Do you plan to upload artworks for sale on ArtistiQe?</h5>

<div class="form-check">
    <input class="form-check-input" type="radio" name="sell_interest" value="yes" required>
    <label class="form-check-label">Yes, I would like to upload artworks for sale.</label>
</div>

<div class="form-check">
    <input class="form-check-input" type="radio" name="sell_interest" value="later">
    <label class="form-check-label">Not right now, but I may explore this later.</label>
</div>

<small class="text-muted d-block mt-2">
Selling through <b>ArtistiQe.</b>Listing an artwork requires a ₹2,000 submission fee annually . A platform fee is applied only when the artwork sells. Our team supports verification, presentation, and a smooth transfer to the collector.
</small>
</div>

<div class="text-center">
    <button class="btn btn-submit">Submit</button>
</div>

</form>
</div>
</div>
@endsection
