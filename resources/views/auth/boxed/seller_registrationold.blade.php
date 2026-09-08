@extends('auth.layouts.authentication')

@section('content')
<div class="aiz-main-wrapper d-flex flex-column justify-content-md-center bg-white">
  <div class="col d-flex align-items-center">
    <!-- Logo -->
    <a class="d-block py-20px mr-3 ml-5" href="{{ route('home') }}">
        @php $header_logo = get_setting('header_logo'); @endphp
        @if ($header_logo != null)
            <img src="{{ uploaded_asset($header_logo) }}" alt="{{ env('APP_NAME') }}"
                 class="mw-100 h-30px h-md-40px" height="40">
        @else
            <img src="{{ static_asset('assets/img/newnewlogo.jpeg') }}" alt="{{ env('APP_NAME') }}"
                 class="mw-100 h-30px h-md-40px" height="40">
        @endif
    </a>
  </div>

  <section class="bg-white overflow-hidden">
    <div class="row">
      <div class="col-xxl-8 col-xl-10 col-lg-11 mx-auto py-lg-4">
        <div class="card shadow-none rounded-0 border-0">
          <div class="row justify-content-center no-gutters">
            <!-- FULL WIDTH FORM (Left image removed) -->
            <div class="col-12 p-4 p-lg-5 d-flex flex-column justify-content-center border right-content">

              <!-- Title -->
              <div class="text-center mb-3">
                <h1 class="fs-20 fs-md-24 fw-700 text-primary text-uppercase">
                  {{ translate('Register To Sell Your Art!') }}
                </h1>
              </div>

              <!-- Welcome Box -->
              <div class="p-3 mb-3 section-card">
                <h5 class="fw-700 mb-2">Welcome Note:</h5>
                <p class="mb-2">
                  Welcome to your <b>14-Days Free trial registration on Artistiqe.com!</b><br>
                  This step helps you set up your gallery so you can start showcasing your art. You can always update it later.
                </p>
                <ul class="mb-0 pl-3">
                  <li>Fields marked with (<span class="text-danger">*</span>) are mandatory.</li>
                  <li>Detailed guidance is available at the bottom of this page.</li>
                </ul>
              </div>

              <!-- Registration Form -->
              <form action="{{ route('shops.store') }}" method="POST" enctype="multipart/form-data" id="seller-registration-form" class="form-default">
                @csrf

                <!-- Personal Details -->
                <div class="p-3 mb-3 section-card">
                  <h6 class="fw-700 mb-3"><i class="las la-user text-danger"></i> Personal Details:</h6>

                  <div class="form-group">
                    <label class="fw-600 d-block mb-2">Is this site for an individual artist or a gallery? <span class="text-danger">*</span></label>
                    <div class="d-flex align-items-center gap-3">
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="type" id="type_artist" value="artist" {{ old('type','artist')=='artist' ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_artist">Artist</label>
                      </div>
                      <div class="form-check form-check-inline mb-0">
                        <input class="form-check-input" type="radio" name="type" id="type_gallery" value="gallery" {{ old('type')=='gallery' ? 'checked' : '' }}>
                        <label class="form-check-label" for="type_gallery">Gallery</label>
                      </div>
                    </div>
                  </div>

                  <div id="artist-fields" style="{{ old('type','artist')=='artist' ? 'display:block;' : 'display:none;' }}">
                    <div class="form-group">
                      <label>First Name <span class="text-danger">*</span></label>
                      <input type="text" name="first_name" value="{{ old('first_name') }}" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Last Name</label>
                      <input type="text" name="last_name" value="{{ old('last_name') }}" class="form-control">
                    </div>
                  </div>

                  <div id="gallery-fields" style="{{ old('type','artist')=='gallery' ? 'display:block;' : 'display:none;' }}">
                    <div class="form-group">
                      <label>Gallery Name <span class="text-danger">*</span></label>
                      <input type="text" name="gallery_name" value="{{ old('gallery_name') }}" class="form-control">
                    </div>
                    <div class="form-group">
                      <label>Gallery Location</label>
                      <input type="text" name="gallery_location" value="{{ old('gallery_location') }}" class="form-control">
                    </div>
                  </div>
                </div>

                <!-- Contact -->
                <div class="p-3 mb-3 section-card">
                  <h6 class="fw-700 mb-3"><i class="las la-phone text-danger"></i> Contact Details:</h6>
                  <div class="form-group">
                    <label>Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" value="{{ old('email') }}" class="form-control" placeholder="example@domain.com">
                  </div>
                  <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone" value="{{ old('phone') }}" class="form-control" maxlength="10">
                  </div>
                </div>

                <!-- Security -->
                <div class="p-3 mb-3 section-card">
                  <h6 class="fw-700 mb-3"><i class="las la-lock text-danger"></i> Security:</h6>
                  <!-- Password -->
<div class="form-group">
  <label>Password <span class="text-danger">*</span></label>
  <div class="password-wrapper">
    <input type="password" name="password" class="form-control" placeholder="Min 8 chars, Aa1@">
    <i class="las la-eye" id="toggle-password"></i>
  </div>
</div>

<!-- Confirm Password -->
<div class="form-group">
  <label>Confirm Password <span class="text-danger">*</span></label>
  <div class="password-wrapper">
    <input type="password" name="password_confirmation" class="form-control" placeholder="Re-enter password">
    <i class="las la-eye" id="toggle-password-confirm"></i>
  </div>
</div>


                <!-- Location -->
                <div class="p-3 mb-3 section-card">
                  <h6 class="fw-700 mb-3"><i class="las la-map-marker text-danger"></i> Location Details:</h6>
                  <div class="form-group">
                    <label>Country</label>
                    <input type="text" name="country" value="{{ old('country') }}" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>State / Province</label>
                    <input type="text" name="state" value="{{ old('state') }}" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>City</label>
                    <input type="text" name="city" value="{{ old('city') }}" class="form-control">
                  </div>
                  <div class="form-group">
                    <label>Pincode / ZIP</label>
                    <input type="text" name="pincode" value="{{ old('pincode') }}" class="form-control" maxlength="6">
                  </div>
                </div>

                <!-- Submit -->
                <div class="mb-4 mt-4">
                  <button type="submit" class="btn btn-primary btn-block fw-700 fs-14 rounded-0">
                    {{ translate('Register') }}
                  </button>
                </div>

                <!-- Login text -->
                <p class="fs-12 text-gray mb-0 text-center">
                  {{ translate('Already have an account?') }}
                  <a href="{{ route('seller.login') }}" class="ml-1 fs-14 fw-700 animate-underline-primary">
                    {{ translate('Login') }}
                  </a>
                </p>
              </form>

            </div> <!-- /col-12 -->
          </div><!-- /row -->
        </div><!-- /card -->
      </div>
    </div>
  </section>
</div>
@endsection
@section('script')


<script>
document.addEventListener("DOMContentLoaded", function () {
  /* ========== Particles (background) ========== */
  if (document.getElementById("particles-js")) {
    particlesJS("particles-js", {
      particles: {
        number: { value: 60, density: { enable: true, value_area: 1000 } },
        color: { value: "#dcdcdc" },
        shape: { type: "circle" },
        opacity: { value: 0.4 },
        size: { value: 3, random: true },
        line_linked: { enable: true, distance: 150, color: "#cfcfcf", opacity: 0.3, width: 1 },
        move: { enable: true, speed: 2, out_mode: "out" }
      },
      interactivity: {
        events: { onhover: { enable: true, mode: "grab" }, onclick: { enable: true, mode: "push" } },
        modes: { grab: { distance: 140, line_linked: { opacity: 0.5 } }, push: { particles_nb: 4 } }
      },
      retina_detect: true
    });
  }

  /* ========== Eye toggles for password fields ========== */
  function setupPasswordToggle(inputSelector, iconSelector) {
    const input = document.querySelector(inputSelector);
    const icon  = document.querySelector(iconSelector);
    if (!input || !icon) return;
    icon.addEventListener("click", function () {
      const isPwd = input.type === "password";
      input.type = isPwd ? "text" : "password";
      icon.classList.toggle("la-eye");
      icon.classList.toggle("la-eye-slash");
    });
  }
  setupPasswordToggle('input[name="password"]', '#toggle-password');
  setupPasswordToggle('input[name="password_confirmation"]', '#toggle-password-confirm');

  /* ========== Inline validation (red/green) ========== */
  const form = document.getElementById("seller-registration-form");
  if (!form) return;

  function msgElFor(input) {
  // put messages under the whole form-group (outside the password-wrapper)
  const group = input.closest('.form-group') || input.parentNode;
  let m = group.querySelector('.field-msg');
  if (!m) {
    m = document.createElement('div');
    m.className = 'field-msg small fst-italic mt-1';
    group.appendChild(m);
  }
  return m;
}

  function showMsg(input, text, ok) {
    const m = msgElFor(input);
    m.textContent = text || "";
    m.classList.remove("text-danger","text-success");
    if (!text) return;
    m.classList.add(ok ? "text-success" : "text-danger");
  }

  // Rules
  const emailEl   = form.querySelector('input[name="email"]');
  const phoneEl   = form.querySelector('input[name="phone"]');
  const pinEl     = form.querySelector('input[name="pincode"]');
  const pwdEl     = form.querySelector('input[name="password"]');
  const pwd2El    = form.querySelector('input[name="password_confirmation"]');
  const typeArtistEl  = form.querySelector('#type_artist');
  const typeGalleryEl = form.querySelector('#type_gallery');
  const firstEl   = form.querySelector('input[name="first_name"]');
  const galleryEl = form.querySelector('input[name="gallery_name"]');

  function selectedType(){
    if (typeGalleryEl && typeGalleryEl.checked) return 'gallery';
    return 'artist';
  }

  function validateEmail(){
    if (!emailEl) return true;
    const v = (emailEl.value||"").trim().toLowerCase();
    if (!v){ showMsg(emailEl, "Email is required.", false); return false; }
    const okBasic = /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(v);
    const okCom   = v.endsWith(".com");
    if (!okBasic){ showMsg(emailEl, "Enter a valid email address.", false); return false; }
    if (!okCom){ showMsg(emailEl, "Email must end with .com", false); return false; }
    showMsg(emailEl, "Looks good.", true); return true;
  }

  function validatePhone(){
    if (!phoneEl) return true;
    const v = (phoneEl.value||"").replace(/\D/g,"");
    if (!v){ showMsg(phoneEl, "", true); return true; } // optional
    if (v.length !== 10){ showMsg(phoneEl, "Phone must be exactly 10 digits.", false); return false; }
    showMsg(phoneEl, "Looks good.", true); return true;
  }

  function validatePin(){
    if (!pinEl) return true;
    const v = (pinEl.value||"").replace(/\D/g,"");
    if (!v){ showMsg(pinEl, "", true); return true; } // optional
    if (v.length !== 6){ showMsg(pinEl, "Pincode must be exactly 6 digits.", false); return false; }
    showMsg(pinEl, "Looks good.", true); return true;
  }

  function validatePassword(){
    if (!pwdEl) return true;
    const v = pwdEl.value||"";
    if (!v){ showMsg(pwdEl, "Password is required.", false); return false; }
    const strong = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&.])[A-Za-z\d@$!%*?&.]{8,}$/.test(v);
    if (!strong){
      showMsg(pwdEl, "Use 8+ chars with Aa1@ mix.", false); return false;
    }
    showMsg(pwdEl, "Strong password.", true); return true;
  }

  function validatePasswordMatch(){
    if (!pwdEl || !pwd2El) return true;
    const v1 = pwdEl.value||"", v2 = pwd2El.value||"";
    if (!v2){ showMsg(pwd2El, "Please re-enter password.", false); return false; }
    if (v1 !== v2){ showMsg(pwd2El, "Passwords do not match.", false); return false; }
    showMsg(pwd2El, "Passwords match.", true); return true;
  }

  function validatePersonalBlock(){
    const t = selectedType();
    let ok = true;
    if (t === 'artist' && firstEl){
      const v = (firstEl.value||"").trim();
      if (!v){ showMsg(firstEl, "First name is required.", false); ok = false; }
      else { showMsg(firstEl, "Looks good.", true); }
    }
    if (t === 'gallery' && galleryEl){
      const v = (galleryEl.value||"").trim();
      if (!v){ showMsg(galleryEl, "Gallery name is required.", false); ok = false; }
      else { showMsg(galleryEl, "Looks good.", true); }
    }
    return ok;
  }

  // Live validation bindings
  emailEl   && emailEl.addEventListener("blur",  validateEmail);
  emailEl   && emailEl.addEventListener("input", validateEmail);
  phoneEl   && phoneEl.addEventListener("input", validatePhone);
  pinEl     && pinEl.addEventListener("input",  validatePin);
  pwdEl     && pwdEl.addEventListener("input",  () => { validatePassword(); if (pwd2El && pwd2El.value) validatePasswordMatch(); });
  pwd2El    && pwd2El.addEventListener("input", validatePasswordMatch);
  [typeArtistEl, typeGalleryEl].forEach(el=>{
    el && el.addEventListener("change", validatePersonalBlock);
  });
  firstEl   && firstEl.addEventListener("blur",  validatePersonalBlock);
  galleryEl && galleryEl.addEventListener("blur",validatePersonalBlock);

  // Submit gate
  form.addEventListener("submit", function(e){
    const checks = [
      validatePersonalBlock(),
      validateEmail(),
      validatePhone(),
      validatePin(),
      validatePassword(),
      validatePasswordMatch()
    ];
    if (checks.includes(false)) {
      e.preventDefault();
      // scroll to first error
      const firstErr = form.querySelector(".field-msg.text-danger");
      if (firstErr) firstErr.scrollIntoView({ behavior: "smooth", block: "center" });
    }
  });
});
</script>

<style>
 /* Full page form layout */
  .right-content {
    max-width: 900px;
    margin: 0 auto;
    background: #fff;
    padding: 2.5rem;
    border-radius: 8px;
  }

  .section-card {
    background: #f8f9fa;
    border: 1px solid #dee2e6;
    border-radius: 6px;
  }

  @media (max-width: 768px) {
    .right-content {
      padding: 1.5rem;
    }
  }
  /* Particle background */
  #particles-js{
    position: fixed; inset: 0; width: 100%; height: 100%;
    z-index: 0; background: #ffffff;
  }

  /* Foreground content */
  .right-content{
    max-width: 900px; margin: 0 auto; background: #fff;
    padding: 2.5rem; border-radius: 8px; position: relative; z-index: 1;
  }

  .section-card{
    background:#f8f9fa; border:1px solid #dee2e6; border-radius:6px;
  }

  /* Messages styling */
  .field-msg.small{ display:block; }
  .text-success{ color:#198754 !important; } /* Bootstrap green */
  .text-danger{ color:#dc3545 !important; }  /* Bootstrap red */

  @media (max-width: 768px){
    .right-content{ padding: 1.5rem; }
  }
   /* Eye icon position */
  .password-wrapper {
    position: relative;
  }

  .password-wrapper i {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    cursor: pointer;
    font-size: 18px;
    color: #6c757d;
  }

  .password-wrapper i:hover {
    color: #007bff;
  }

  @media (max-width: 768px) {
    .right-content {
      padding: 1.5rem;
    }
  }
</style>
@endsection


