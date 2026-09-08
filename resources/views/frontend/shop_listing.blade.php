@extends('frontend.layouts.app')

@section('content')
    <div class="position-relative">
        <div class="position-absolute" id="particles-js"></div>
        <div class="position-relative container">
            <!-- Breadcrumb -->
            <section class="pt-4 mb-3">
                <div class="row">
                    <div class="col-lg-6 text-center text-lg-left">
                        <h1 class="fw-700 fs-20 fs-md-24 text-dark">{{ translate('All Sellers') }}</h1>
                    </div>
                    <div class="col-lg-6">
                        <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                            <li class="breadcrumb-item has-transition opacity-60 hov-opacity-100">
                                <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                            </li>
                            <li class="text-dark fw-600 breadcrumb-item">
                                "{{ translate('All Sellers') }}"
                            </li>
                        </ul>
                    </div>
                </div>
            </section>
            <!-- All Sellers -->
            <section class="mb-3 pb-3">
                <div class="bg-white px-3">
                    <div class="row row-cols-xl-5 row-cols-md-3 row-cols-sm-2 row-cols-1 gutters-16 border-top border-left">
                        @foreach ($shops as $key => $shop)
                            @if ($shop->user != null)
                                <div class="col text-center border-right border-bottom has-transition hov-shadow-out z-1">
                                    <div class="position-relative px-3" style="padding-top: 2rem; padding-bottom:2rem;">
                                        <!-- Shop logo -->
                                        <div class="position-relative mx-auto size-100px size-md-120px">
                                            <a href="{{ route('shop.visit', $shop->slug) }}" class="d-flex mx-auto justify-content-center align-item-center size-100px size-md-120px border overflow-hidden hov-scale-img" tabindex="0" style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
                                                <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                                    data-src="{{ uploaded_asset($shop->logo) }}"
                                                    alt="{{ $shop->name }}"
                                                    class="img-fit lazyload has-transition"
                                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                            </a>
                                            
                                        </div>
                                        @php
    // limit to 13 characters including spaces, add "..." when trimmed
    $displayShopName = \Illuminate\Support\Str::limit($shop->name, 13, '...');
     $country = $shop->country ?? ($shop->user->country ?? null);
@endphp

<!-- Shop name -->
<h2 class="fs-14 fw-700 text-dark text-truncate-2 h-40px mt-4 " title="{{ $shop->name }}">
    <a href="{{ route('shop.visit', $shop->slug) }}" class="text-reset hov-text-primary" tabindex="0">
        {{ $displayShopName }}
    </a>
</h2>

<!-- Shop country -->
@if (!empty($country))
    <div class="artist-country">
        {{ ucfirst(strtolower($country)) }}
    </div>
@endif
<style>
    .artist-country {
  color: #6c757d;
  
  font-size: 0.92rem;
  line-height: 1.3;
}
/* Outer grid borders */
.row.border-top.border-left {
    border-color: #ffffff !important;
}

/* Inner grid cells */
.row .border-right,
.row .border-bottom {
    border-color: #ffffff !important;
}


</style>


                                        
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <!-- Pagination -->
                    <div class="aiz-pagination aiz-pagination-center mt-4">
                        {{ $shops->links() }}
                    </div>
                </div>
            </section>
        </div>
    </div>

@endsection

@section('script')
    <script>
        AIZ.plugins.particles();
    </script>
@endsection
