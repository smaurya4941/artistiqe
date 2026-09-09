@extends('auth.layouts.authentication')

@section('content')

    <section class="welcome-section">

    <!-- Logo -->
    <div class="welcome-header">
          <a class="d-block py-20px mr-3  ml-5" href="{{ route('home') }}">
        
        <img src="{{ static_asset('assets/img/Artistiqe_Logo_Full_Name singup.svg') }}" alt="ArtistiQe" class="welcome-logo">
        
        <h2>Welcomes...</h2>
    </div>

    <!-- 3 Image Buttons -->
    <div class="welcome-cards">

        <a href="{{ url('shops/create') }}" class="welcome-card">
            <h3>Artists</h3>
            <img src="{{ static_asset('assets/img/Group.svg') }}" alt="Artists">
        </a>

        <a href="{{ route('collector.register') }}" class="welcome-card">
            <h3>Collectors</h3>
            <img src="{{ static_asset('assets/img/Groupc.svg') }}" alt="Collectors">
        </a>

        <a href="{{ route('gallery.register') }}" class="welcome-card">
            <h3>Gallery/Institution</h3>
            <img src="{{ static_asset('assets/img/Groupg.svg') }}" alt="Gallery">
        </a>

    </div>

</section>


                                
    <style>
   .welcome-section{
    min-height:100vh;
    padding:60px 20px 80px;
    background:
        url("/assets/img/paper-texture.png") repeat,
        #f5efe8;
    display:flex;
    flex-direction:column;
    align-items:center;
    text-align:center;
}

/* Header */
.welcome-header{
    margin-bottom:70px;
}

.welcome-logo{
    height:95px;
    margin-bottom:10px;
}

.welcome-header h2{
    font-size:26px;
    font-weight:500;
    color:#000;
}

/* Cards layout */
.welcome-cards{
    display:flex;
    gap:70px;
    justify-content:center;
    flex-wrap:wrap;
}

/* Card */
.welcome-card{
    width:260px;
    height:260px;
    background:#f2e3d8;
    border-radius:22px;
    padding:25px 20px;
    display:flex;
    flex-direction:column;
    align-items:center;
    justify-content:space-between;
    text-decoration:none;
    color:#000;
    transition:all .3s ease;
}

.welcome-card h3{
    font-size:20px;
    font-weight:600;
}

/* Image */
.welcome-card img{
    max-width:180px;
    max-height:160px;
    object-fit:contain;
}

/* Hover (soft, premium) */
.welcome-card:hover{
    transform:translateY(-6px);
    box-shadow:0 14px 32px rgba(0,0,0,.15);
}

</style>


                       
@endsection

@section('script')
    @if(get_setting('google_recaptcha') == 1 && get_setting('recaptcha_customer_register') == 1)
        <script src="https://www.google.com/recaptcha/api.js?render={{ env('CAPTCHA_KEY') }}"></script>
        
        <script type="text/javascript">
                document.getElementById('reg-form').addEventListener('submit', function(e) {
                    e.preventDefault();
                    grecaptcha.ready(function() {
                        grecaptcha.execute(`{{ env('CAPTCHA_KEY') }}`, {action: 'register'}).then(function(token) {
                            var input = document.createElement('input');
                            input.setAttribute('type', 'hidden');
                            input.setAttribute('name', 'g-recaptcha-response');
                            input.setAttribute('value', token);
                            e.target.appendChild(input);

                            e.target.submit();
                        });
                    });
                });
        </script>
    @endif
@endsection