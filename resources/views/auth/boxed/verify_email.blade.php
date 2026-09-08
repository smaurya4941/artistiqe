@extends('auth.layouts.authentication')

@section('content')
    <!-- aiz-main-wrapper -->
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
                <div class="col-xxl-6 col-xl-9 col-lg-10 col-md-7 mx-auto py-lg-4">

                    <div class="card shadow-none rounded-0 border-0">
                        <div class="row no-gutters">
                            <!-- Left Side Image -->
                            <div class="col-lg-6">
                                <img src="{{ uploaded_asset(get_setting('password_reset_page_image')) }}" 
                                     alt="{{ translate('Password Reset Page Image') }}" 
                                     class="img-fit h-100">
                            </div>

                            <div class="col-lg-6 p-4 p-lg-5 d-flex flex-column justify-content-center border right-content" style="height: auto;">

                                <!-- Titles -->
                                <div class="text-center text-lg-left">
                                    <h1 class="fs-20 fs-md-20 fw-700 text-primary text-uppercase">
                                        {{ translate('Verify Your Email Address') }}
                                    </h1>
                                    <h5 class="fs-14 fw-400 text-dark">
                                        {{ translate('Before proceeding, please check your email for a verification link. If you did not receive the email.') }}
                                    </h5>
                                </div>

                                <!-- Reset password form -->
                                <div class="pt-3">
                                    <div class="">
                                        <a href="{{ route('verification.resend') }}" 
                                           class="btn btn-primary btn-block mb-2">
                                            {{ translate('Click here to request another OTP') }}
                                        </a>

                                 <a href="{{ route('home') }}" class="btn btn-primary btn-block">
    {{ translate('Verification Later') }}
</a>



                                        @if (session('resent'))
                                            <div class="alert alert-success mt-2 mb-0" role="alert">
                                                {{ translate('A fresh verification link has been sent to your email address.') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection


