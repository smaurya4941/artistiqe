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
    background:#f6f1ea url("{{ static_asset('assets/img/bg-pattern.png') }}");
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
.dashboard-btn{
    display:inline-block;
    margin-top:25px;
    padding:14px 34px;
    background:#b30000;
    color:#fff;
    font-size:16px;
    font-weight:600;
    border-radius:30px;
    text-decoration:none;
    transition:all 0.25s ease;
}

.dashboard-btn:hover{
    background:#8f0000;
    color:#fff;
    transform:translateY(-2px);
}

</style>


<div class="success-bg">
    <div class="success-box">
         <a href="{{ route('home') }}">
    <img src="{{ static_asset('assets/img/Artistiqe_Logo_sd.png') }}" alt="Artistiqe">
</a>
        <h3 class="mt-4">Application Received</h3>
        <p>Thank you for applying to join ArtistiQe.</p>
        <small>
            Your artist account is now <strong>pending review</strong>. Our Artist Manager will
            verify your details and connect with you within 24–48 working hours. You’ll be able
            to sign in and set up your studio once your account is approved.
        </small>
        <div class="mt-4">
    <a href="{{ route('home') }}" class="dashboard-btn">
        Back to Home
    </a>
</div>

    </div>
</div>

@endsection
