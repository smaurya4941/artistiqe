<!-- collector_registration.blade.php -->
@extends('auth.layouts.authentication')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Merriweather:wght@400;600;700&family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

<style>
    body{
    font-family: 'Nunito', sans-serif;
    font-size: 15.5px;
    line-height: 1.6;
    color: #2c2c2c;
}

h1,h2,h3,h4,h5,h6{
    font-family: 'Merriweather', serif;
    color:#1f1f1f;
}

label{
    font-weight:600;
    font-size:14px;
}

.soft-card p,
.soft-card li{
    font-size:15px;
}

/* Background */
.art-bg{
    background:#f6f1ea;
    background-image: repeating-linear-gradient(
        0deg,
        rgba(0,0,0,0.02),
        rgba(0,0,0,0.02) 1px,
        transparent 1px,
        transparent 4px
    );
    min-height:100vh;
    padding:40px 0;
}

/* Outer red border */
.outer-box{
    border:3px solid #b30000;
    border-radius:16px;
    padding:40px 30px;
    max-width:1100px;
    margin:auto;
    background:transparent;
}

/* Section cards */
.soft-card{
    background:#f3e4d9;
    border-radius:28px;
    padding:30px;
    margin-bottom:30px;
}

/* Inputs */
.soft-card input,
.soft-card textarea{
    background:#f9f6f3;
    border:1px solid #ddd;
    border-radius:6px;
}

/* Logo */
.logo-wrap{
    text-align:center;
    margin-bottom:20px;
}

.logo-wrap img{
    height:120px;
}

/* Submit button */
.btn-submit{
    background:#b30000;
    color:#fff;
    border-radius:6px;
    padding:10px 40px;
}
</style>

<div class="art-bg">

    <!-- LOGO -->
    <div class="logo-wrap">
        <a class="d-block py-20px mr-3  ml-5" href="{{ route('home') }}">
        <img src="{{ static_asset('assets/img/Artistiqe_Logo_sd.png') }}" alt="Artistiqe">
    </a>
    </div>

    <div class="outer-box">

        <!-- Welcome -->
        <div class="soft-card">
            <div style="display:flex; align-items:center; gap:14px; margin-bottom:15px;">
    <img src="{{ static_asset('assets/img/Artistiqe_Logo_A 2.svg') }}" alt="Artistiqe" style="height:38px;">
    <!-- <strong style="font-family:'Merriweather',serif;">Welcome to ArtistiQe</strong> -->
</div>

            <h6>
               We’re glad to welcome you to <b>ArtistiQe.</b>Every collector carries a story, and this form helps us understand yours—what draws your eye, what moves you, and how art finds a place in your life.
With these details, we can prepare an experience shaped around your taste and help you explore artworks that meaningfully reflect your journey.

            </h6>

            <ul class="mb-0">
            	<p>If you wish to share pieces from your personal collection with new collectors, you may list them after completing this step(This requires a simple annual activation fee of ₹1,500. A platform fee is applied only when an artwork sells.)</p>
                <!-- <li>14-Day free trial registration</li> -->
    <li>Fields with (*) are mandatory.</li>
    <li> Additional guidance is available below.</li>
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

<form method="POST" action="{{ route('collector.register.store') }}">
@csrf

        <!-- Personal Details -->
        <div class="soft-card">
          <h5 class="mb-3">
    Personal Details
    <span style="color:red;font-size:14px;">*</span>
</h5>


            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Name</label>
                    <input name="first_name" type="text" class="form-control" required>
                    @error('first_name')
    <small class="text-danger">{{ $message }}</small>
@enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label>Last Name</label>
<input name="last_name" type="text" class="form-control" required>
@error('last_name')
    <small class="text-danger">{{ $message }}</small>
@enderror
                </div>
            </div>

            <h6 class="mt-3">Contact Details</h6>
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>Email <span style="color:red">*</span></label>
<input name="email" type="email" class="form-control" required>
@error('email')
    <small class="text-danger">{{ $message }}</small>
@enderror
                </div>
                <!-- <div class="col-md-3 mb-3">
                    <label>OTP</label>
                    <input type="text" class="form-control" placeholder="Value">
                </div> -->
                <div class="col-md-3 mb-3">
                    <label>Phone <span style="color:red">*</span></label>
<input name="phone" type="text" class="form-control" required>
@error('phone')
    <small class="text-danger">{{ $message }}</small>
@enderror

                </div>
                <!-- <div class="col-md-3 mb-3">
                    <label>OTP</label>
                    <input type="text" class="form-control" placeholder="Value">
                </div> -->
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
            <input name="password" type="password" class="form-control" required>
           @error('password')
    <small class="text-danger">{{ $message }}</small>
@enderror
        </div>

        <div class="col-md-6 mb-3">
            <label>Confirm Password <span style="color:red">*</span></label>
            <input name="password_confirmation" type="password" class="form-control" required>
        </div>
    </div>

    <!-- <small class="text-muted">
        Password must be at least 8 characters long.
    </small> -->
</div>

       <!-- Address -->
<div class="soft-card">
    <h5 class="mb-3">Address</h5>

    <div class="mb-3">
        <label>Address Line 1</label>
        <input name="address_line1" type="text" class="form-control"
               placeholder="Apartment, Suite, Unit, Building, Floor, etc.">
    </div>

    <div class="mb-3">
        <label>Address Line 2</label>
        <input name="address_line2" type="text" class="form-control"
               placeholder="Apartment, Suite, Unit, Building, Floor, etc.">
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>City</label>
            <input name="city" type="text" class="form-control" placeholder="Value">
        </div>

        <div class="col-md-4 mb-3">
            <label>State</label>
            <input name="state" type="text" class="form-control" placeholder="Value">
        </div>

        <div class="col-md-4 mb-3">
            <label>Country</label>
            <input name="country" type="text" class="form-control" placeholder="Value">
        </div>
    </div>

    <div class="row">
        <div class="col-md-4 mb-3">
            <label>ZIP / Postal Code</label>
            <input name="zip" type="text" class="form-control" placeholder="Value">
        </div>
    </div>
</div>


        

        <!-- Journey -->
        <div class="soft-card">
            <h6>
                Tell us about your journey as a collector.We would love to hear what draws you to art, the kinds of works you enjoy collecting, and how your collection has grown over time. (If you are new to collecting, feel free to share what inspires your interest in art.)
            </h6>

            <textarea name="journey" rows="5" class="form-control" placeholder="Value"></textarea>
        </div>
<div class="soft-card">
    <h5 class="mb-3">Are you interested in selling artworks from your collection?</h5>

    <div class="form-check mb-2">
        <input class="form-check-input" type="radio" name="sell_interest" value="yes" id="sell_yes">
        <label class="form-check-label" for="sell_yes">
            Yes, I would like to offer artworks for sale.
        </label>
    </div>

    <div class="form-check">
        <input class="form-check-input" type="radio" name="sell_interest" value="later" id="sell_later">
        <label class="form-check-label" for="sell_later">
            Not right now, but I may explore this later.
        </label>
    </div>
<!-- <small>Selling through ArtistiQe</small> -->
    <small class="text-muted d-block mt-2">
       Selling through ArtistiQe <br>Listing an artwork requires a ₹1,500 submission fee annually . A platform fee is applied only when the artwork sells. Our team supports verification, presentation, and a smooth transfer to the new collector.
    </small>
</div>

        <!-- Submit -->
        <div class="text-center">
            <button class="btn btn-submit">Submit</button>
        </div>
</form>
    </div>
</div>

<script>
/* ===============================
   FORM & ELEMENTS
================================ */
const form  = document.querySelector('form[action="{{ route('collector.register.store') }}"]');

const firstEl = form.querySelector('input[name="first_name"]');
const emailEl = form.querySelector('input[name="email"]');
const phoneEl = form.querySelector('input[name="phone"]');
const pinEl   = form.querySelector('input[name="zip"]');

const pwdEl  = form.querySelector('input[name="password"]');
const pwd2El = form.querySelector('input[name="password_confirmation"]');

/* ===============================
   HELPER FUNCTIONS
================================ */
function getMsgEl(input) {
    let el = input.nextElementSibling;
    if (!el || !el.classList.contains('field-msg')) {
        el = document.createElement('small');
        el.className = 'field-msg d-block mt-1 text-danger';
        input.after(el);
    }
    return el;
}

function showMsg(input, msg) {
    const el = getMsgEl(input);
    el.textContent = msg || '';
}

/* ===============================
   LIVE UX VALIDATIONS (NO BLOCK)
================================ */

// First name
firstEl.addEventListener('blur', () => {
    if (!firstEl.value.trim()) {
        showMsg(firstEl, 'First name is required.');
    } else {
        showMsg(firstEl, '');
    }
});

// Email
emailEl.addEventListener('blur', () => {
    if (!emailEl.value.trim()) {
        showMsg(emailEl, 'Email is required.');
    } else {
        showMsg(emailEl, '');
    }
});

// Phone
phoneEl.addEventListener('blur', () => {
    if (!phoneEl.value.trim()) {
        showMsg(phoneEl, 'Phone number is required.');
    } else {
        showMsg(phoneEl, '');
    }
});

// Pincode
if (pinEl) {
    pinEl.addEventListener('blur', () => {
        const v = pinEl.value.replace(/\D/g, '');
        if (v && v.length !== 6) {
            showMsg(pinEl, 'Pincode must be 6 digits.');
        } else {
            showMsg(pinEl, '');
        }
    });
}

/* ===============================
   PASSWORD MATCH (LIVE)
================================ */
pwd2El.addEventListener('input', () => {
    if (pwdEl.value && pwd2El.value && pwdEl.value !== pwd2El.value) {
        showMsg(pwd2El, 'Passwords do not match.');
    } else {
        showMsg(pwd2El, '');
    }
});

/* ===============================
   FINAL SUBMIT GUARD (IMPORTANT)
================================ */
form.addEventListener('submit', function (e) {

    // Password match is MANDATORY
    if (pwdEl.value !== pwd2El.value) {
        e.preventDefault();
        showMsg(pwd2El, 'Passwords do not match.');
        pwd2El.focus();
        return;
    }

    // Let Laravel handle everything else
});
</script>


@endsection