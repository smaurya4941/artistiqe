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

            <p>
                We’re delighted to welcome you to <b>ArtistiQe</b>.  
                By completing this form, you take the first step toward presenting your work within our artist community and to collectors who value depth and creativity.
            </p>

            <ul class="mb-0">
                <li>Register to your 14-Days Free trial registration</li>
                <li>Fields marked with (*) are mandatory</li>
                <li>You can update details later</li>
            </ul>
        </div>
<form method="POST" action="{{ route('artist.register.store') }}">
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
                </div>

                <div class="col-md-6 mb-3">
                    <label>Last Name</label>
<input name="last_name" type="text" class="form-control" required>
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
        <input name="address1" type="text" class="form-control"
               placeholder="Apartment, Suite, Unit, Building, Floor, etc.">
    </div>

    <div class="mb-3">
        <label>Address Line 2</label>
        <input name="address2" type="text" class="form-control"
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
            <input name="pincode" type="text" class="form-control" placeholder="Value">
        </div>
    </div>
</div>


        <!-- Education -->
        <div class="soft-card">
            <h5 class="mb-3">Education</h5>

            <div class="mb-3">
                <label>College</label>
                <input name="college" type="text" class="form-control">
            </div>

            <div class="mb-3">
                <label>Degree</label>
                <input name="degree" type="text" class="form-control">
            </div>

            <div class="mb-3">
                <label>Portfolio Link (if any)</label>
                <input name="portfolio" type="text" class="form-control">
            </div>
        </div>

        <!-- Journey -->
        <div class="soft-card">
            <p>
                We would love to hear how your ArtistiQe journey has grown and taken shape beyond your education.
            </p>

            <textarea name="journey" rows="5" class="form-control" placeholder="Value"></textarea>
        </div>

        <!-- Submit -->
        <div class="text-center">
            <button class="btn btn-submit">Submit</button>
        </div>
</form>
    </div>
</div>

@endsection
<script>
   
const form = document.querySelector('form[action="{{ route('artist.register.store') }}"]');

/* ---------- helpers ---------- */
function msgElFor(input){
  let el = input.nextElementSibling;
  if (!el || !el.classList.contains('field-msg')) {
    el = document.createElement('small');
    el.className = 'field-msg d-block mt-1';
    input.after(el);
  }
  return el;
}

function showMsg(input, text, ok) {
  const m = msgElFor(input);
  m.textContent = text || "";
  m.classList.remove("text-danger","text-success");
  if (!text) return;
  m.classList.add(ok ? "text-success" : "text-danger");
}

/* ---------- elements ---------- */
const emailEl = form.querySelector('input[name="email"]');
const phoneEl = form.querySelector('input[name="phone"]');
const pinEl   = form.querySelector('input[name="pincode"]');
const firstEl = form.querySelector('input[name="first_name"]');

/* ---------- validators ---------- */
function validateEmail(){
  const v = (emailEl.value || "").trim().toLowerCase();
  if (!v){
    showMsg(emailEl, "Email is required.", false);
    return false;
  }
  if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v)){
    showMsg(emailEl, "Enter a valid email address.", false);
    return false;
  }
  showMsg(emailEl, "Looks good.", true);
  return true;
}

function validatePhone(){
  const v = (phoneEl.value || "").replace(/\D/g,"");
  if (!v){
    showMsg(phoneEl, "Phone number is required.", false);
    return false;
  }
  if (v.length !== 10){
    showMsg(phoneEl, "Phone must be exactly 10 digits.", false);
    return false;
  }
  showMsg(phoneEl, "Looks good.", true);
  return true;
}

function validatePin(){
  if (!pinEl) return true;
  const v = (pinEl.value || "").replace(/\D/g,"");
  if (!v) return true;
  if (v.length !== 6){
    showMsg(pinEl, "Pincode must be 6 digits.", false);
    return false;
  }
  showMsg(pinEl, "Looks good.", true);
  return true;
}

function validateName(){
  if (!firstEl.value.trim()){
    showMsg(firstEl, "First name is required.", false);
    return false;
  }
  showMsg(firstEl, "Looks good.", true);
  return true;
}

/* ---------- live events ---------- */
emailEl.addEventListener("input", validateEmail);
phoneEl.addEventListener("input", validatePhone);
pinEl && pinEl.addEventListener("input", validatePin);
firstEl.addEventListener("blur", validateName);

/* ---------- submit ---------- */
form.addEventListener("submit", function(e){
  const ok = [
    validateName(),
    validateEmail(),
    validatePhone(),
    validatePin()
  ].every(Boolean);

  if (!ok){
    e.preventDefault();
    const err = form.querySelector(".text-danger");
    err && err.scrollIntoView({behavior:"smooth", block:"center"});
  }
});

function validatePasswordMatch(){
  if (pwdEl.value !== pwd2El.value){
    showMsg(pwd2El, "Passwords do not match", false);
    return false;
  }
  showMsg(pwd2El, "", true);
  return true;
}

pwdEl.addEventListener("input", validatePassword);
pwd2El.addEventListener("input", validatePasswordMatch);

</script>