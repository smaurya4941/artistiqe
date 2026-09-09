@extends('auth.layouts.authentication')

@section('content')

<style>
@import url('https://fonts.googleapis.com/css2?family=Merriweather:wght@400;600;700&family=Nunito:wght@400;500;600;700&display=swap');

body{
    font-family:'Nunito', sans-serif;
    font-size:16px;
    line-height:1.7;
    color:#222;
}

.success-bg{
    background:#f6f1ea url("{{ static_asset('assets/img/loginbg.svg') }}");
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    padding:20px;
}

.success-box{
    background:#f3e4d9;
    border:2px dashed #b30000;
    border-radius:26px;
    padding:55px 50px;
    max-width:640px;
    width:100%;
    text-align:center;
}

.success-box img{
    height:70px; /* logo bigger */
}

.success-box h3{
    font-family:'Merriweather', serif;
    color:#b30000;
    font-weight:700;
    font-size:28px;
    margin-top:25px;
}

.success-box p{
    font-size:18px;
    margin:15px 0;
    font-weight:500;
}

.success-box small{
    font-size:15.5px;
    display:block;
    margin-top:10px;
    color:#333;
}
</style>


<div class="success-bg">
    <div class="success-box">
         <a href="{{ route('home') }}">
    <img src="{{ static_asset('assets/img/Artistiqe_Logo_sd.png') }}" alt="Artistiqe">
</a>
        <h3 class="mt-4">Application Received</h3>
        <p>Thank you for registering your gallery with ArtistiQe.</p>
        <small>
            Your gallery account is <strong>pending review</strong>. Our team will verify your
            details and be in touch shortly. You’ll be able to sign in once your account is approved.
        </small>
    </div>
</div>

@endsection
