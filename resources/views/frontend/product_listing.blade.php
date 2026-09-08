@extends('frontend.layouts.app') 

@if (isset($category_id))
    @php
        $meta_title = $category->meta_title;
        $meta_description = $category->meta_description;
    @endphp
@elseif (isset($brand_id))
    @php
        $meta_title = get_single_brand($brand_id)->meta_title;
        $meta_description = get_single_brand($brand_id)->meta_description;
    @endphp
@else
    @php
        $meta_title       = get_setting('meta_title');
        $meta_description = get_setting('meta_description');
    @endphp
@endif

@section('meta_title'){{ $meta_title }}@stop
@section('meta_description'){{ $meta_description }}@stop

@section('meta')
    <meta itemprop="name" content="{{ $meta_title }}">
    <meta itemprop="description" content="{{ $meta_description }}">
    <meta name="twitter:title" content="{{ $meta_title }}">
    <meta name="twitter:description" content="{{ $meta_description }}">
    <meta property="og:title" content="{{ $meta_title }}" />
    <meta property="og:description" content="{{ $meta_description }}" />
    <script>
  window.rangefilter = window.rangefilter || function (a, b) {
    var f = document.getElementById('search-form');
    var minEl = document.getElementById('filter_min_price');
    var maxEl = document.getElementById('filter_max_price');
    var min, max;
    if (typeof a === 'object' && a) {
      min = Number(a.min ?? a.low ?? a.start ?? (Array.isArray(a) ? a[0] : (minEl?.value ?? 0)));
      max = Number(a.max ?? a.high ?? a.end  ?? (Array.isArray(a) ? a[1] : (maxEl?.value ?? 0)));
    } else {
      min = Number(a ?? minEl?.value ?? 0);
      max = Number(b ?? maxEl?.value ?? 0);
    }
    if (minEl) minEl.value = Math.round(min);
    if (maxEl) maxEl.value = Math.round(max);
    if (f) { if (f.requestSubmit) f.requestSubmit(); else f.submit(); }
  };
</script>
<!-- then your <script src=".../aiz-core.js"></script> -->

@endsection

@section('content')

<!-- Page Intro Section -->
<div class="container mb-4 mt-4">
    <div class="row">
        <div class="col-12">
            <h2 class="page-intro-heading mb-3">{{ translate('Contemporary Paintings') }}</h2>
            <p class="page-intro-text">
                {{ translate("Artistiqe connects collectors and sellers through a trusted private sales network, Paintings & Sculptures by Modern, Contemporary, and Urban artists. With expertise, discretion, and trust, we make buying and selling art seamless, secure, and rewarding.") }}
            </p>
        </div>
    </div>
</div>

<section class="mb-4 pt-4">
    <div class="container sm-px-0 pt-2">
        <form id="search-form" action="{{ route('search') }}" method="GET">
            <div class="row">

                <!-- Sidebar Filters -->
                <div class="col-xl-3">
                    <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                        <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                        <div class="collapse-sidebar c-scrollbar-light text-left">
                            <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                    <i class="las la-times la-2x"></i>
                                </button>
                            </div>

                            @if(isset($product_type) && $product_type == 'preorder_product')
                                <!-- Categories (Preorder) -->
                                <div class="bg-white border mb-3">
                                    <div class="fw-700 p-3" style="font-size:18px;">
                                        <a href="#collapse_1" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                            {{ translate('Categories')}}
                                        </a>
                                    </div>
                                    @php
    // category selected on either route param ($category_id) or request('category')
    $catSelected = isset($category_id) || request()->filled('category');
    $catShow = $catSelected ? 'show' : '';
@endphp
<div class="collapse {{ $catShow }}" id="collapse_1">


                                        <ul class="p-3 mb-0 list-unstyled">
                                            @if (!isset($category_id))
                                                @foreach ($categories as $category)
                                                    <li class="mb-3 text-dark">
                                                        <a class="text-reset fs-14 hov-text-primary" href="{{ route('preorder.category', $category?->slug) }}">
                                                            {{ $category->getTranslation('name') }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li class="mb-3">
                                                    <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('search') }}">
                                                        <i class="las la-angle-left"></i>
                                                        {{ translate('All Categories')}}
                                                    </a>
                                                </li>
                                                @if ($category->parent_id != 0)
                                                    <li class="mb-3">
                                                        <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('preorder.category', get_single_category($category->parent_id)->slug) }}">
                                                            <i class="las la-angle-left"></i>
                                                            {{ get_single_category($category->parent_id)->getTranslation('name') }}
                                                        </a>
                                                    </li>
                                                @endif
                                                <li class="mb-3">
                                                    <a class="text-reset fs-14 fw-600 hov-text-primary" href="{{ route('preorder.category', $category?->slug) }}">
                                                        <i class="las la-angle-left"></i>
                                                        {{ $category->getTranslation('name') }}
                                                    </a>
                                                </li>
                                                @foreach ($category->childrenCategories as $immediate_children_category)
                                                    <li class="ml-4 mb-3">
                                                        <a class="text-reset fs-14 hov-text-primary" href="{{ route('preorder.category', $immediate_children_category?->slug) }}">
                                                            {{ $immediate_children_category->getTranslation('name') }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>

                                <!-- Availability -->
                                <div class="bg-white border mb-3">
                                    <div class="fw-700 p-3" style="font-size:18px;">
                                        <a href="#collapse_availability_filter" class="dropdown-toggle text-dark filter-section d-flex align-items-center justify-content-between" data-toggle="collapse">
                                            {{ translate('Filter by Availability') }}
                                        </a>
                                    </div>
                                    @php $show = $is_available !== null ? 'show' : ''; @endphp
                                    <div class="collapse {{ $show }}" id="collapse_availability_filter">
                                        <div class="p-3 aiz-checkbox-list">
                                            <label class="aiz-checkbox mb-3">
                                                <input type="radio" name="is_available" value="1" @if ($is_available == 1) checked @endif onchange="filter()">
                                                <span class="aiz-square-check"></span>
                                                <span class="fs-14 fw-400 text-dark">{{ translate('Available Now') }}</span>
                                            </label>
                                            <label class="aiz-checkbox mb-3">
                                                <input type="radio" name="is_available" value="0" @if ($is_available === '0') checked @endif onchange="filter()">
                                                <span class="aiz-square-check"></span>
                                                <span class="fs-14 fw-400 text-dark">{{ translate('Upcoming') }}</span>
                                            </label>
                                            <label class="aiz-checkbox mb-3">
                                                <input type="radio" name="is_available" value="" @if ($is_available === null) checked @endif onchange="filter()">
                                                <span class="aiz-square-check"></span>
                                                <span class="fs-14 fw-400 text-dark">{{ translate('All') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Categories (General) -->
                                <div class="bg-white border mb-3">
                                    <div class="fw-700 p-3" style="font-size:18px;">
                                        <a href="#collapse_1" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                            {{ translate('Categories')}}
                                        </a>
                                    </div>
                                    @php
    $catSelected = isset($category_id) || request()->filled('category');
    $catShow = $catSelected ? 'show' : '';
@endphp
<div class="collapse {{ $catShow }}" id="collapse_1">
    <ul class="p-3 mb-0 list-unstyled">
        @foreach ($categories as $category)
            <li class="mb-3 text-dark d-flex align-items-center">
                {{-- OPTION A: route-based navigation (SEO slug) --}}
                <input
                    type="radio"
                    name="category_radio_only_ui"
                    class="mr-2"
                    @checked(isset($category_id) && $category_id == $category->id)
                    onclick="location.href='{{ route('products.category', $category->slug) }}'"
                >
                <a class="text-reset fs-14 hov-text-primary @if(isset($category_id) && $category_id == $category->id) font-weight-bold @endif"
                   href="{{ route('products.category', $category->slug) }}">
                    {{ $category->getTranslation('name') }}
                </a>
            </li>
        @endforeach

        {{-- Deselect / All Categories --}}
        <!--<li class="mb-1">
            <a class="fs-13 text-muted" href="{{ route('search') }}">
                <i class="las la-undo mr-1"></i>{{ translate('All Categories') }}
            </a>
        </li>-->
    </ul>
</div>


                                </div>

                             @php
    $baseMin = floatval(get_product_min_unit_price() ?? 0);
    $baseMax = floatval(get_product_max_unit_price() ?? 0);
    if ($baseMax < $baseMin) { $t=$baseMin; $baseMin=$baseMax; $baseMax=$t; }

    // Same rate source as controller
    $uiCode = session('currency_code');
    $rate = session('currency_exchange_rate');
    if (empty($rate) || $rate <= 0) {
        $rate = \App\Models\Currency::where('code', $uiCode)->value('exchange_rate') ?? 1;
    }
    $defaultCurrencyId = (int) get_setting('system_default_currency');
    $defaultCode = optional(\App\Models\Currency::find($defaultCurrencyId))->code;
    if (!empty($defaultCode) && $uiCode === $defaultCode) { $rate = 1.0; }

    // UI currency values for slider
    $uiMin = $baseMin * $rate;
    $uiMax = $baseMax * $rate;

    // Request values are already UI currency from hidden inputs / URL
    $reqMin = request()->filled('min_price') ? floatval(preg_replace('/[^0-9.]/','', request('min_price'))) : null;
    $reqMax = request()->filled('max_price') ? floatval(preg_replace('/[^0-9.]/','', request('max_price'))) : null;

    $startMin = is_numeric($reqMin) ? max($uiMin, min($reqMin, $uiMax)) : $uiMin;
    $startMax = is_numeric($reqMax) ? max($uiMin, min($reqMax, $uiMax)) : $uiMax;

    $currencySymbol = currency_symbol() ?? '₹';
@endphp


                                <!-- Price range -->
                                <div class="bg-white border mb-3">
                                    <div class="fw-700 p-3" style="font-size:18px;">
                                        <a href="#collapse_price" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                            {{ translate('Price Range') }}
                                        </a>
                                    </div>
                                    @php
    $priceActive = (is_numeric($reqMin) || is_numeric($reqMax)) && (($startMin > $uiMin) || ($startMax < $uiMax));
    $priceShow = $priceActive ? 'show' : '';
@endphp
<div class="collapse {{ $priceShow }}" id="collapse_price">

                                        <div class="p-3 mr-3">
                                            <div class="aiz-range-slider">
                                               <div id="input-slider-range"
     data-range-value-min="{{ (int) floor($uiMin) }}"
     data-range-value-max="{{ (int) ceil($uiMax) }}"
     data-start-low="{{ (int) floor($startMin) }}"
     data-start-high="{{ (int) ceil($startMax) }}">
</div>

                                                <div class="row mt-2">
                                                    <div class="col-6">
                                                        <span id="input-slider-range-value-low" class="range-slider-value value-low fs-14 fw-600 opacity-70">
                                                            {!! $currencySymbol !!}{{ number_format($startMin, 2) }}
                                                        </span>
                                                    </div>
                                                    <div class="col-6 text-right">
                                                        <span id="input-slider-range-value-high" class="range-slider-value value-high fs-14 fw-600 opacity-70">
                                                            {!! $currencySymbol !!}{{ number_format($startMax, 2) }}
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="min_price" id="filter_min_price" value="{{ $startMin }}">
                                            <input type="hidden" name="max_price" id="filter_max_price" value="{{ $startMax }}">
                                        </div>
                                    </div>
                                </div>

                              <!-- Attributes (single-select via radio) -->
@php
    // Are we on any category page?
    $routeName = optional(request()->route())->getName();
    $onCategoryPage = isset($category_id)
        || (isset($category) && !empty($category->id))
        || in_array($routeName, ['products.category','preorder.category','category.products','products.by_category']);

    // If controller didn't pass OR we're on a category page -> load ALL attributes
    if ($onCategoryPage || !isset($attributes) || (is_countable($attributes) ? count($attributes) : 0) === 0) {
        // Force same natural order as search page: by id ascending (or creation order)
        $attributes = \App\Models\Attribute::with('attribute_values')
            ->orderBy('id', 'asc')
            ->get();
    }

    // safety: ensure it's a collection
    $attributes = collect($attributes ?? []);
@endphp



@php
    // current selections from query: attribute[<id>] = <value>
    $attrReq = (array) request()->input('attribute', []);
@endphp

@foreach ($attributes as $attribute)
    @php
        $paneId     = 'collapse_'.preg_replace('/\s+/', '_', $attribute->name);
        $currentVal = $attrReq[$attribute->id] ?? null;
        $show       = !empty($currentVal) ? 'show' : '';
    @endphp

    <div class="bg-white border mb-3">
        <div class="fw-700 p-3" style="font-size:18px;">
            <a href="#{{ $paneId }}" class="dropdown-toggle text-dark filter-section d-flex align-items-center justify-content-between" data-toggle="collapse" style="white-space: normal;">
                {{ $attribute->getTranslation('name') }}
            </a>
        </div>

        <div class="collapse {{ $show }}" id="{{ $paneId }}">
            <div class="p-3">
                @foreach ($attribute->attribute_values as $attribute_value)
                    <div class="form-check mb-2">
                        <input class="form-check-input" type="radio"
                               name="attribute[{{ $attribute->id }}]"
                               value="{{ $attribute_value->value }}"
                               onchange="filter()"
                               @checked($currentVal === $attribute_value->value)>
                        <label class="form-check-label">{{ $attribute_value->value }}</label>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endforeach
<!-- Color -->
                                @if (get_setting('color_filter_activation'))
                                    <div class="bg-white border mb-3">
                                        <div class="fw-700 p-3" style="font-size:18px;">
                                            <a href="#collapse_color" class="dropdown-toggle text-dark filter-section d-flex align-items-center justify-content-between" data-toggle="collapse">
                                                {{ translate('color')}}
                                            </a>
                                        </div>
                                        @php
                                            $show = '';
                                            foreach ($colors as $color){
                                                if(isset($selected_color) && $selected_color == $color->code){
                                                    $show = 'show';
                                                }
                                            }
                                        @endphp
                                        <div class="collapse {{ $show }}" id="collapse_color">
                                            <div class="p-3 aiz-radio-inline">
                                                @foreach ($colors as $color)
                                                    <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ $color->name }}">
                                                        <input type="radio" name="color" value="{{ $color->code }}" onchange="filter()" @if(isset($selected_color) && $selected_color == $color->code) checked @endif>
                                                        <span class="aiz-megabox-elem rounded d-flex align-items-center justify-content-center p-1 mb-2">
                                                            <span class="size-30px d-inline-block rounded" style="background: {{ $color->code }};"></span>
                                                        </span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>




                <!-- Contents -->
                <div class="col-xl-9">

                    @if(addon_is_activated('preorder') && Route::currentRouteName() == 'search')
                        <div class="product-tab">
                            @php
                                $activeClasses = "bg-soft-dark mr-2 my-2 text-white";
                                $inActiveClasses = "preorder-border-dashed m-2 text-muted fw-600";
                            @endphp
                            <div class="p-3 aiz-radio-inline">
                                <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ translate('General Products') }}">
                                    <input type="radio" name="product_type" value="general_product" onchange="filter()" @if(isset($product_type) && $product_type == 'general_product') checked @endif>
                                    <span class="badge badge-inline fs-12 p-3 rounded-3 {{ $product_type == 'general_product' ? $activeClasses : $inActiveClasses}}">
                                        {{ translate('General Products') }}
                                    </span>
                                </label>
                                <label class="aiz-megabox pl-0 mr-2" data-toggle="tooltip" data-title="{{ translate('Preorder Products') }}">
                                    <input type="radio" name="product_type" value="preorder_product" onchange="filter()" @if(isset($product_type) && $product_type == 'preorder_product') checked @endif>
                                    <span class="badge badge-inline fs-12 p-3 rounded-3 {{ $product_type == 'preorder_product' ? $activeClasses : $inActiveClasses}}">
                                        {{ translate('Preorder Products') }}
                                    </span>
                                </label>
                            </div>
                        </div>
                    @endif

                    <!-- Breadcrumb -->
                    <div class="mb-3">
                        <ul class="breadcrumb bg-transparent py-0 px-1">
                            <li class="breadcrumb-item has-transition opacity-50 hov-opacity-100">
                                <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                            </li>
                            @if(!isset($category_id))
                                <li class="breadcrumb-item fw-700 text-dark"><a class="text-reset" href="{{ route('search') }}">{{ translate('All Categories')}}</a> </li>
                            @else
                                <li class="breadcrumb-item opacity-50 hov-opacity-100">
                                    <a class="text-reset" href="{{ route('search') }}">{{ translate('All Categories')}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>

                  <!-- Product Grid (Masonry via CSS Columns) -->
<div class="product-grid">
    @foreach ($products as $product)
        @php
            $basePriceStr = home_base_price($product);
            $discountedPriceStr = home_discounted_base_price($product);
            $hasDiscount = trim($basePriceStr) !== trim($discountedPriceStr);

            // Add minus sign before percentage
            $badgeText = '';
            if (isset($product->discount) && $product->discount > 0) {
                if (($product->discount_type ?? null) === 'percent') {
                    $badgeText = '-' . intval($product->discount) . '%';
                } else {
                    $pct = (isset($product->unit_price) && $product->unit_price > 0)
                        ? round(($product->discount / $product->unit_price) * 100)
                        : null;
                    $badgeText = $pct ? ('-' . $pct . '%') : '';
                }
            }
        @endphp

        <div class="product-card">
            <div class="card border-0 shadow-none">

                {{-- Thumb + Badge --}}
                <div class="pp-thumb-wrap position-relative">
                    @if ($hasDiscount && $badgeText)
                        <span class="pp-discount-badge">{{ $badgeText }}</span>
                    @endif
                    <a href="{{ route('product', $product->slug) }}">
                        <img src="{{ uploaded_asset($product->thumbnail_img) }}" class="img-fluid w-100 mb-2" alt="{{ $product->name }}">
                    </a>
                </div>

                <div class="d-flex align-items-center justify-content-between mb-1 pp-name-row">
                    <h5 class="fs-14 fw-600 text-dark mb-1">{{ $product->name }}</h5>

                    <button type="button"
                        class="pp-wishlist-btn"
                        data-product-id="{{ $product->id }}"
                        onclick="addToWishList({{ $product->id }}); togglePPWishlist(this);"
                        aria-label="Add to wishlist"
                        title="{{ translate('Add to wishlist') }}">
                        <svg class="pp-heart pp-heart-outline" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" role="img" aria-hidden="true">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z" fill="none" stroke="#6b7280" stroke-width="1.4"/>
                        </svg>
                        <svg class="pp-heart pp-heart-filled" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" role="img" aria-hidden="true" style="display:none;">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z" fill="#e62e04"/>
                        </svg>
                    </button>
                </div>

                <div class="d-flex align-items-center mb-2 pp-artist-row">
                    <svg class="pp-artist-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#C59D28" d="M12 2l2.6 5.27L20 8.27l-4 3.9.94 5.5L12 15.77 7.06 17.77 8 12.27 4 8.37l5.4-.99L12 2z"/>
                    </svg>

                    @if ($product->user && isset($product->user->shop) && $product->user->shop)
                        <a href="{{ route('shop.visit', $product->user->shop->slug ?? $product->user->shop->id) }}" class="pp-artist-link ml-2">
                            {{ $product->user->shop->name }}
                        </a>
                    @elseif ($product->user)
                        <a href="{{ url('seller/'.$product->user->id) }}" class="pp-artist-link ml-2">
                            {{ $product->user->name }}
                        </a>
                    @else
                        <span class="pp-artist-link ml-2 text-muted">{{ translate('Unknown Artist') }}</span>
                    @endif
                </div>

                {{-- Price row --}}
                <div class="pp-price-row">
                    @if ($hasDiscount)
                        <span class="pp-price-old">{{ $basePriceStr }}</span>
                        <span class="pp-price-new">{{ $discountedPriceStr }}</span>
                    @else
                        <span class="pp-price-new">{{ $discountedPriceStr }}</span>
                    @endif
                </div>

            </div>
        </div>
    @endforeach
</div>


                    <!-- Pagination -->
                    <div class="aiz-pagination mt-4 d-flex justify-content-center">
                        {{ $products->appends(request()->input())->links() }}
                    </div>

                </div><!-- /col-xl-9 -->
            </div><!-- /row -->
        </form>
    </div>
</section>

@endsection

<style>
/* Lock 3 columns on desktop */
.product-grid{
  display: block;                     /* masonry via CSS columns */
  -webkit-column-count: 3 !important;
  -moz-column-count: 3 !important;
  column-count: 3 !important;
  -webkit-column-gap: 16px;
  -moz-column-gap: 16px;
  column-gap: 16px;
  column-width: auto !important;      /* avoid column-width forcing 4 */
}

/* Cards should not split across columns */
.product-card{
  display: inline-block;
  width: 100%;
  break-inside: avoid;
  -webkit-column-break-inside: avoid;
  -moz-column-break-inside: avoid;
}

/* Responsive (same as before, but force with !important) */
@media (max-width:1100px){
  .product-grid{ 
    -webkit-column-count: 2 !important;
    -moz-column-count: 2 !important;
    column-count: 2 !important;
  }
}
@media (max-width:700px){
  .product-grid{ 
    -webkit-column-count: 1 !important;
    -moz-column-count: 1 !important;
    column-count: 1 !important;
  }
}
/* 1) Wishlist icon: no grey box, no black border, no focus ring */
.pp-wishlist-btn{
  background: transparent !important;
  border: 0 !important;
  padding: 0 !important;
  line-height: 0;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;           /* optional, keeps it round if you add hover */
  box-shadow: none !important;
  outline: none !important;
}
.pp-wishlist-btn:focus,
.pp-wishlist-btn:active { 
  outline: none !important;
  box-shadow: none !important;
}
.pp-wishlist-btn svg{
  display: block;
  background: transparent !important;
  border: 0 !important;
}
.pp-heart-outline,
.pp-heart-filled{
  /* just in case any global rule adds background/border to inline svgs */
  background: transparent !important;
  border: 0 !important;
}

/* === Force filter sidebar always visible below 1440px === */
@media (max-width: 1439.98px){
  /* make the wrapper visible */
  .aiz-filter-sidebar.collapse-sidebar-wrap,
  .aiz-filter-sidebar.sidebar-xl,
  .aiz-filter-sidebar.sidebar-right{
    display: block !important;
    position: static !important;
    visibility: visible !important;
    opacity: 1 !important;
    transform: none !important;
  }

  /* the inner sliding panel should be a normal block */
  .aiz-filter-sidebar .collapse-sidebar{
    display: block !important;
    position: static !important;
    width: auto !important;
    max-width: none !important;
    height: auto !important;
    overflow: visible !important;
    transform: none !important;
    box-shadow: none !important;
    background: transparent !important;
  }

  /* kill overlay & the close button in this range */
  .aiz-filter-sidebar .overlay{ display: none !important; }
  .filter-sidebar-thumb{ display: none !important; }

  /* ensure the two columns layout remains */
  .col-xl-3{ flex: 0 0 25% !important; max-width: 25% !important; display:block !important; }
  .col-xl-9{ flex: 0 0 75% !important; max-width: 75% !important; display:block !important; }
}

/* (Optional) keep filters stacked above products on tablets/phones */
@media (max-width: 991.98px){
  .col-xl-3, .col-xl-9{ flex: 0 0 100% !important; max-width: 100% !important; }
  .col-xl-3{ margin-bottom: 1rem; }
}
/* Hide the extra "Filters" heading and close button always */
.aiz-filter-sidebar .d-flex.d-xl-none {
  display: none !important;
}
/* hide Bootstrap default caret */
.filter-section.dropdown-toggle::after {
  display: none !important;
}

/* custom caret look */
.filter-section .filter-caret {
  margin-left: auto;
  line-height: 1;
  transition: transform .2s ease-in-out;
}
/* ========== Filter Header Titles ========== */
.filter-section {
  font-size: 16px !important;     /* same as category title */
  font-weight: 600 !important;
  color: #111 !important;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 8px 0 !important;
}

/* Caret icon spacing */
.filter-section .filter-caret {
  margin-left: 8px;
  font-size: 18px;
}

/* ========== Radio + Label Alignment ========== */
form .form-check,
.aiz-radio-inline .form-check,
.aiz-checkbox-list .form-check {
  display: flex !important;
  align-items: center !important;
  gap: 8px !important;
  margin-bottom: 8px !important;
}

/* radio button vertical centering */
.form-check-input {
  margin-top: 0 !important;
  position: relative !important;
  top: 0 !important;
  transform: none !important;
}

/* label font size and spacing */
.form-check-label,
.aiz-checkbox-list label,
.aiz-radio-inline label {
  font-size: 16px !important;
  font-weight: 400 !important;
  color: #222 !important;
  line-height: 1.4 !important;
}

/* remove unwanted top/bottom padding */
.p-3 {
  padding-top: 6px !important;
  padding-bottom: 6px !important;
}
/* caret default + rotate based on aria-expanded */
.filter-section .filter-caret{
  transition: transform .2s ease-in-out;
  transform: rotate(0deg);
}
.filter-section[aria-expanded="true"] .filter-caret{ transform: rotate(180deg) !important; }
.filter-section[aria-expanded="false"] .filter-caret{ transform: rotate(0deg) !important; }
/* caret rotation driven by a class on the trigger */
.filter-section .filter-caret { transition: transform .2s ease-in-out; }
.filter-section.is-open .filter-caret { transform: rotate(180deg) !important; } /* up when open */
.filter-section:not(.is-open) .filter-caret { transform: rotate(0deg) !important; } /* down when closed */
/* Final authority: rotate caret based on its own class */
.filter-section .filter-caret { transition: transform .2s ease-in-out; }
.filter-section .filter-caret.is-open { transform: rotate(180deg) !important; }  /* up when open */


.pp-discount-badge {
    position: absolute;
    top: 12px;
    left: 12px;
    color: #fff;
    font-weight: 700;
    font-size: 12px;
    z-index: 6;
    background: #e63946;
    padding: 4px 6px;
    border-radius: 4px;
}

/* Price styling to match the card */
.pp-price-row {
    display: flex;
    align-items: center;
    gap: 8px;
}
.pp-price-old {
    text-decoration: line-through;
    color: #e62e04;
    font-size: 13px;
    font-weight: 500;
}
.pp-price-new {
    font-size: 15px;
    font-weight: 700;
    color: #111;
}



</style>

@section('script')
<script>
// price slider labels + auto-submit (requires noUiSlider if theme provides)
document.addEventListener('DOMContentLoaded', function(){
  const sliderEl  = document.getElementById('input-slider-range');
  const form      = document.getElementById('search-form');
  const minInput  = document.getElementById('filter_min_price');
  const maxInput  = document.getElementById('filter_max_price');
  const lowLbl    = document.getElementById('input-slider-range-value-low');
  const highLbl   = document.getElementById('input-slider-range-value-high');
  const curSym    = @json($currencySymbol ?? '₹');

  if (!sliderEl) return;

  const toNum = (v, fb=0) => {
    const n = parseFloat(String(v).replace(/[^0-9.\-]/g,''));
    return Number.isFinite(n) ? n : fb;
  };
  const attrNum = (name, fb=0) => toNum(sliderEl.getAttribute(name), fb);

  let baseMin   = attrNum('data-range-value-min', 0);
  let baseMax   = attrNum('data-range-value-max', 0);
  let startLow  = attrNum('data-start-low',  baseMin);
  let startHigh = attrNum('data-start-high', baseMax);

  if (!Number.isFinite(baseMin)) baseMin = 0;
  if (!Number.isFinite(baseMax) || baseMax <= baseMin) baseMax = baseMin + 1;
  if (!Number.isFinite(startLow))  startLow  = baseMin;
  if (!Number.isFinite(startHigh)) startHigh = baseMax;
  if (startLow < baseMin)  startLow  = baseMin;
  if (startHigh > baseMax) startHigh = baseMax;
  if (startLow > startHigh){ const t = startLow; startLow = startHigh; startHigh = t; }

  const setLabels = (l, h) => {
    const L = Number.isFinite(l) ? l : startLow;
    const H = Number.isFinite(h) ? h : startHigh;
    if (lowLbl)  lowLbl.textContent  = curSym + ' ' + Math.round(L).toLocaleString();
    if (highLbl) highLbl.textContent = curSym + ' ' + Math.round(H).toLocaleString();
  };

  if (minInput) minInput.value = Math.round(startLow);
  if (maxInput) maxInput.value = Math.round(startHigh);
  setLabels(startLow, startHigh);

  function wireEvents(){
    if (!sliderEl.noUiSlider) return false;
    try { sliderEl.noUiSlider.set([startLow, startHigh]); } catch(e) {}
    sliderEl.noUiSlider.on('update', function(values){
      const l = toNum(values && values[0], startLow);
      const h = toNum(values && values[1], startHigh);
      setLabels(l, h);
    });
    sliderEl.noUiSlider.on('change', function(values){
      const l = Math.round(toNum(values && values[0], startLow));
      const h = Math.round(toNum(values && values[1], startHigh));
      if (minInput) minInput.value = l;
      if (maxInput) maxInput.value = h;
      if (form) form.submit();
    });
    return true;
  }

  function ensureSlider(){
    if (sliderEl.noUiSlider) return wireEvents();
    if (window.noUiSlider && typeof window.noUiSlider.create === 'function') {
      try {
        window.noUiSlider.create(sliderEl, { start:[startLow,startHigh], connect:true, step:1, range:{ min:baseMin, max:baseMax } });
        return wireEvents();
      } catch(e) {}
    }
    return false;
  }

  if (!ensureSlider()){
    let tries = 0;
    const timer = setInterval(function(){
      tries++;
      if (ensureSlider()) clearInterval(timer);
      if (tries > 40) clearInterval(timer);
    }, 50);
  }
});

// submit helper + stale hidden cleanup (prevents deselect bug)
function filter() {
  var f = document.getElementById('search-form');
  if (!f) return;

  var page = f.querySelector('input[name="page"]');
  if (page) page.remove();

  // remove hidden carry-overs for filters
  ['input[name^="attributes["]',
   'input[name="selected_attribute_values[]"]',
   'input[name="color"]',
   'input[name="is_available"]',
   'input[name="min_price"]',
   'input[name="max_price"]',
   'input[name="product_type"]'
  ].forEach(sel => {
    f.querySelectorAll(sel).forEach(el => { if (el.type === 'hidden') el.remove(); });
  });

  if (f.requestSubmit) f.requestSubmit(); else f.submit();
}

// wishlist UI toggle (purely visual)
function togglePPWishlist(buttonEl) {
  buttonEl.classList.toggle('active');
}
document.addEventListener('DOMContentLoaded', function(){
  function forceFilters(){
    if (window.innerWidth < 1440) {
      document.querySelectorAll('.aiz-filter-sidebar').forEach(function(el){
        // some themes use these flags; adding them avoids off-canvas
        el.classList.add('active','shown','open');
      });
      document.querySelectorAll('.aiz-filter-sidebar .collapse-sidebar').forEach(function(el){
        el.style.display = 'block';
        el.style.transform = 'none';
        el.style.visibility = 'visible';
        el.style.opacity = '1';
      });
      // hide overlay if present
      document.querySelectorAll('.aiz-filter-sidebar .overlay').forEach(function(o){
        o.style.display = 'none';
      });
    }
  }
  forceFilters();
  window.addEventListener('resize', forceFilters);
});

// ---- Replace only your existing "caret handling" DOMContentLoaded block with this ----
document.addEventListener('DOMContentLoaded', function () {
  const toggles = document.querySelectorAll('.filter-section[data-toggle="collapse"]');

  toggles.forEach(a => {
    // ensure caret exists once
    let caret = a.querySelector('.filter-caret');
    if (!caret) {
      caret = document.createElement('i');
      caret.className = 'las filter-caret la-angle-down';
      a.appendChild(caret);
    }

    // resolve collapse pane
    const targetSel = a.getAttribute('href') || a.getAttribute('data-target');
    const pane = targetSel ? document.querySelector(targetSel) : null;

    // single source of truth: aria-expanded OR pane .show
    const updateCaret = () => {
      const expanded = a.getAttribute('aria-expanded') === 'true' || (pane && pane.classList.contains('show'));
      caret.classList.remove('la-angle-up', 'la-angle-down');
      caret.classList.add(expanded ? 'la-angle-up' : 'la-angle-down');
    };

    // initial paint
    updateCaret();

    // Bootstrap events (cover both in/out)
    if (pane) {
      ['show.bs.collapse','shown.bs.collapse','hide.bs.collapse','hidden.bs.collapse'].forEach(evt => {
        pane.addEventListener(evt, updateCaret);
      });
    }

    // click fallback (instant)
    a.addEventListener('click', () => setTimeout(updateCaret, 0));

    // mutation safety net
    if (pane && window.MutationObserver) {
      const o = new MutationObserver(updateCaret);
      o.observe(pane, { attributes: true, attributeFilter: ['class','style','aria-expanded'] });
    }
  });
});
document.addEventListener('DOMContentLoaded', function(){
  const currencySwitcher = document.querySelector('[name="currency"], .currency-switcher, .aiz-topbar-currency select');
  if (!currencySwitcher) return;
  currencySwitcher.addEventListener('change', function(){
    const url = new URL(location.href);
    url.searchParams.delete('min_price');
    url.searchParams.delete('max_price');
    location.href = url.toString();
  });
});
document.addEventListener('DOMContentLoaded', function(){
  // Helper: does a pane have any active selection?
  function paneHasSelection(pane){
    if (!pane) return false;

    // checkboxes/radios inside this pane
    const checked = pane.querySelectorAll('input[type="checkbox"]:checked, input[type="radio"]:checked').length;
    if (checked > 0) return true;

    // Price pane: if range != full range then it's active
    if (pane.id === 'collapse_price') {
      const el = document.getElementById('input-slider-range');
      if (!el) return false;
      const min = Number(el.getAttribute('data-range-value-min') || 0);
      const max = Number(el.getAttribute('data-range-value-max') || 0);
      const curMin = Number(document.getElementById('filter_min_price')?.value || min);
      const curMax = Number(document.getElementById('filter_max_price')?.value || max);
      return (curMin > min) || (curMax < max);
    }
    return false;
  }

  // On any filter input change, open if selection exists, else close
  document.querySelectorAll('.collapse .aiz-checkbox-list input, .collapse .aiz-radio-inline input, .collapse input[type="radio"], .collapse input[type="checkbox"]').forEach(inp=>{
    inp.addEventListener('change', function(e){
      // find parent pane for this input
      const pane = e.target.closest('.collapse');
      if (!pane) return;

      const shouldOpen = paneHasSelection(pane);

      // toggle with Bootstrap if available (preserves aria & classes)
      const useBs = typeof jQuery !== 'undefined' && typeof jQuery(pane).collapse === 'function';

      if (shouldOpen) {
        if (useBs) jQuery(pane).collapse('show');
        else pane.classList.add('show');
      } else {
        if (useBs) jQuery(pane).collapse('hide');
        else pane.classList.remove('show');
      }
    });
  });

  // Also, when price slider changes, keep pane state consistent
  const sliderEl = document.getElementById('input-slider-range');
  if (sliderEl && sliderEl.noUiSlider) {
    const pane = document.getElementById('collapse_price');
    sliderEl.noUiSlider.on('change', function(){
      if (!pane) return;
      const active = paneHasSelection(pane);
      const useBs = typeof jQuery !== 'undefined' && typeof jQuery(pane).collapse === 'function';
      if (active) { useBs ? jQuery(pane).collapse('show') : pane.classList.add('show'); }
      else        { useBs ? jQuery(pane).collapse('hide') : pane.classList.remove('show'); }
    });
  }
});
document.addEventListener('DOMContentLoaded', function () {
  // Allow re-click on already selected filter to deselect it
  document.querySelectorAll(
    '.collapse input[type="radio"], .collapse input[type="checkbox"]'
  ).forEach(function (input) {
    input.addEventListener('mousedown', function (e) {
      // store state before click
      this.wasChecked = this.checked;
    });

    input.addEventListener('click', function (e) {
      // if it was already checked, uncheck and trigger filter
      if (this.wasChecked) {
        e.preventDefault(); // stop browser from rechecking
        this.checked = false;

        // trigger form submission like normal filter()
        if (typeof filter === 'function') filter();
      }
    });
  });
});
document.addEventListener('DOMContentLoaded', function () {
  // Bind all filter toggles
  document.querySelectorAll('.filter-section[data-toggle="collapse"]').forEach(function (trigger) {
    // ensure caret exists once
    if (!trigger.querySelector('.filter-caret')) {
      var ic = document.createElement('i');
      ic.className = 'las la-angle-down filter-caret';
      trigger.appendChild(ic);
    }

    // resolve pane
    var sel = trigger.getAttribute('href') || trigger.getAttribute('data-target');
    var pane = sel ? document.querySelector(sel) : null;

    // keep aria-expanded in sync with pane .show (single source of truth for CSS rotate)
    var sync = function () {
      var expanded = !!(pane && pane.classList.contains('show'));
      trigger.setAttribute('aria-expanded', expanded ? 'true' : 'false');
    };

    // initial state
    sync();

    // bootstrap collapse events (when opened/closed programmatically or by click)
    if (pane) {
      pane.addEventListener('shown.bs.collapse', sync);
      pane.addEventListener('hidden.bs.collapse', sync);
      // safety for immediate state after click
      trigger.addEventListener('click', function(){ setTimeout(sync, 0); });
      // mutation fallback (in case classes change without events)
      if (window.MutationObserver) {
        var mo = new MutationObserver(sync);
        mo.observe(pane, { attributes: true, attributeFilter: ['class'] });
      }
    }
  });
});
// Make caret follow the real collapse state (no aria dependency)
document.addEventListener('DOMContentLoaded', function () {
  // Map pane id -> trigger <a>
  const triggers = Array.from(document.querySelectorAll('.filter-section[data-toggle="collapse"]'))
    .map(a => {
      const sel = a.getAttribute('href') || a.getAttribute('data-target');
      const pane = sel ? document.querySelector(sel) : null;
      // ensure a caret exists
      if (!a.querySelector('.filter-caret')) {
        const ic = document.createElement('i');
        ic.className = 'las la-angle-down filter-caret';
        a.appendChild(ic);
      }
      return { a, pane };
    });

  // Initial sync (handles server-side default 'show')
  triggers.forEach(({a, pane}) => {
    if (pane && pane.classList.contains('show')) a.classList.add('is-open');
    else a.classList.remove('is-open');
  });

  // Keep in sync with Bootstrap collapse lifecycle
  triggers.forEach(({a, pane}) => {
    if (!pane) return;
    pane.addEventListener('show.bs.collapse',  () => a.classList.add('is-open'));
    pane.addEventListener('shown.bs.collapse', () => a.classList.add('is-open'));
    pane.addEventListener('hide.bs.collapse',  () => a.classList.remove('is-open'));
    pane.addEventListener('hidden.bs.collapse',() => a.classList.remove('is-open'));

    // Safety net in case classes change without events
    if (window.MutationObserver) {
      const mo = new MutationObserver(() => {
        if (pane.classList.contains('show')) a.classList.add('is-open');
        else a.classList.remove('is-open');
      });
      mo.observe(pane, { attributes: true, attributeFilter: ['class'] });
    }
  });
});
document.addEventListener('DOMContentLoaded', function () {
  // Authoritative caret controller (wins over earlier scripts)
  document.querySelectorAll('.filter-section[data-toggle="collapse"]').forEach(function (trigger) {
    // find/create caret
    let caret = trigger.querySelector('.filter-caret');
    if (!caret) {
      caret = document.createElement('i');
      caret.className = 'las la-angle-down filter-caret';
      trigger.appendChild(caret);
    } else {
      // force base icon and remove any up/down flip classes from old scripts
      caret.classList.remove('la-angle-up');
      caret.classList.add('la-angle-down');
    }

    // resolve pane element
    const sel  = trigger.getAttribute('href') || trigger.getAttribute('data-target');
    const pane = sel ? document.querySelector(sel) : null;

    // single truth: pane.classList.contains('show') => caret.is-open
    const sync = () => {
      const open = !!(pane && pane.classList.contains('show'));
      caret.classList.toggle('is-open', open);
    };

    // initial
    sync();

    if (pane) {
      // Bootstrap collapse lifecycle
      pane.addEventListener('show.bs.collapse',  sync);
      pane.addEventListener('shown.bs.collapse', sync);
      pane.addEventListener('hide.bs.collapse',  sync);
      pane.addEventListener('hidden.bs.collapse',sync);

      // safety net in case any other script toggles classes silently
      if (window.MutationObserver) {
        const mo = new MutationObserver(sync);
        mo.observe(pane, { attributes: true, attributeFilter: ['class'] });
      }
    }

    // click fallback (immediate tick)
    trigger.addEventListener('click', function(){ setTimeout(sync, 0); });
  });
});
</script>
@endsection
