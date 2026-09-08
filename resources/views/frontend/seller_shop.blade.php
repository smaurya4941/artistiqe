@extends('frontend.layouts.app')

@section('meta_title'){{ $shop->meta_title }}@stop

@section('meta_description'){{ $shop->meta_description }}@stop

@section('meta')
    <!-- Schema.org markup for Google+ -->
    <meta itemprop="name" content="{{ $shop->meta_title }}">
    <meta itemprop="description" content="{{ $shop->meta_description }}">
    <meta itemprop="image" content="{{ uploaded_asset($shop->logo) }}">

    <!-- Twitter Card data -->
    <meta name="twitter:card" content="website">
    <meta name="twitter:site" content="@publisher_handle">
    <meta name="twitter:title" content="{{ $shop->meta_title }}">
    <meta name="twitter:description" content="{{ $shop->meta_description }}">
    <meta name="twitter:creator" content="@author_handle">
    <meta name="twitter:image" content="{{ uploaded_asset($shop->meta_img) }}">

    <!-- Open Graph data -->
    <meta property="og:title" content="{{ $shop->meta_title }}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{ route('shop.visit', $shop->slug) }}" />
    <meta property="og:image" content="{{ uploaded_asset($shop->logo) }}" />
    <meta property="og:description" content="{{ $shop->meta_description }}" />
    <meta property="og:site_name" content="{{ $shop->name }}" />
@endsection

@section('content')
    <!--<section class="mt-3 mb-3 bg-white">
        <div class="container">
            <!--  Top Menu 
            <div class="d-flex flex-wrap justify-content-center justify-content-md-start">
                <a class="fw-700 fs-11 fs-md-13 mr-3 mr-sm-4 mr-md-5 text-dark opacity-60 hov-opacity-100 @if(!isset($type)) opacity-100 @endif"
                href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'store-home']) }}">{{ translate('Store Home')}}</a>
                <a class="fw-700 fs-11 fs-md-13 mr-3 mr-sm-4 mr-md-5 text-dark opacity-60 hov-opacity-100 @if(isset($type) && $type == 'top-selling') opacity-100 @endif"
                        href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'top-selling']) }}">{{ translate('Top Selling')}}</a>
                <a class="fw-700 fs-11 fs-md-13 mr-3 mr-sm-4 mr-md-5 text-dark opacity-60 hov-opacity-100 @if(isset($type) && $type == 'cupons') opacity-100 @endif"
                        href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'cupons']) }}">{{ translate('Coupons')}}</a>

                <a class="fw-700 fs-11 fs-md-13 text-dark mr-3 mr-sm-4 mr-md-5 opacity-60 hov-opacity-100 @if(isset($type) && $type == 'all-products') opacity-100 @endif"
                          href="{{ route('shop.visit', $shop->slug) }}">{{ translate('All Products')}}</a>

                @if(addon_is_activated('preorder'))
                <a class="fw-700 fs-11 fs-md-13 mr-3 mr-sm-4 mr-md-5 text-dark opacity-60 hov-opacity-100 @if(isset($type) && $type == 'all-preorder-products') opacity-100 @endif"
                        href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'all-preorder-products']) }}">{{ translate('All Preorder Products')}}</a>
                @endif
            </div>
        </div>
    </section>-->

    @php
        $followed_sellers = [];
        if (Auth::check()) {
            $followed_sellers = get_followed_sellers();
        }
    @endphp

    @if (!isset($type) || $type == 'top-selling' || $type == 'cupons')
        @if ($shop->top_banner_image)
            <!-- Top Banner -->
            <section class="h-160px h-md-200px h-lg-300px h-xl-100 w-100">
                <a href="{{ $shop->top_banner_link }}">
                    <img class="d-block lazyload h-100 img-fit"
                        src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                        data-src="{{ uploaded_asset($shop->top_banner_image) }}" alt="{{ env('APP_NAME') }} offer">
                </a>
            </section>
        @endif
    @endif

    <!--<section class="@if (!isset($type) || $type == 'top-selling' || $type == 'cupons') mb-3 @endif border-top border-bottom" style="background: #fcfcfd;">
        <div class="container">
            <!-- Seller Info 
            <div class="py-4">
                <div class="row justify-content-md-between align-items-center">
                    <div class="col-lg-5 col-md-6">
                        <div class="d-flex align-items-center">
                            <!-- Shop Logo 
                            <a href="{{ route('shop.visit', $shop->slug) }}" class="overflow-hidden size-120px rounded-content" style="border: 1px solid #e5e5e5;
                                box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);min-width: fit-content;">
                                <img class="lazyload h-120px  mx-auto"
                                    src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                    data-src="{{ uploaded_asset($shop->logo) }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                            </a>
                            
                            <div class="ml-3">
                                <!-- Shop Name & Verification Status 
                                <a href="{{ route('shop.visit', $shop->slug) }}"
                                    class="text-dark d-block fs-16 fw-700">
                                    {{ $shop->name }}
                                    @if ($shop->verification_status == 1)
                                        <span class="ml-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17.5" height="17.5" viewBox="0 0 17.5 17.5">
                                                <g id="Group_25616" data-name="Group 25616" transform="translate(-537.249 -1042.75)">
                                                    <path id="Union_5" data-name="Union 5" d="M0,8.75A8.75,8.75,0,1,1,8.75,17.5,8.75,8.75,0,0,1,0,8.75Zm.876,0A7.875,7.875,0,1,0,8.75.875,7.883,7.883,0,0,0,.876,8.75Zm.875,0a7,7,0,1,1,7,7A7.008,7.008,0,0,1,1.751,8.751Zm3.73-.907a.789.789,0,0,0,0,1.115l2.23,2.23a.788.788,0,0,0,1.115,0l3.717-3.717a.789.789,0,0,0,0-1.115.788.788,0,0,0-1.115,0l-3.16,3.16L6.6,7.844a.788.788,0,0,0-1.115,0Z" transform="translate(537.249 1042.75)" fill="#3490f3"/>
                                                </g>
                                            </svg>
                                        </span>
                                    @else
                                        <span class="ml-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17.5" height="17.5" viewBox="0 0 17.5 17.5">
                                                <g id="Group_25616" data-name="Group 25616" transform="translate(-537.249 -1042.75)">
                                                    <path id="Union_5" data-name="Union 5" d="M0,8.75A8.75,8.75,0,1,1,8.75,17.5,8.75,8.75,0,0,1,0,8.75Zm.876,0A7.875,7.875,0,1,0,8.75.875,7.883,7.883,0,0,0,.876,8.75Zm.875,0a7,7,0,1,1,7,7A7.008,7.008,0,0,1,1.751,8.751Zm3.73-.907a.789.789,0,0,0,0,1.115l2.23,2.23a.788.788,0,0,0,1.115,0l3.717-3.717a.789.789,0,0,0,0-1.115.788.788,0,0,0-1.115,0l-3.16,3.16L6.6,7.844a.788.788,0,0,0-1.115,0Z" transform="translate(537.249 1042.75)" fill="red"/>
                                                </g>
                                            </svg>
                                        </span>
                                    @endif
                                </a>
                                
                                <!-- Ratting 
                                <div class="rating rating-mr-2 text-dark">
                                    {{ renderStarRating($shop->rating) }}
                                    <span class="opacity-60 fs-12">({{ $shop->num_of_reviews }}
                                        {{ translate('Reviews') }})</span>
                                </div>
                                <!-- Address 
                                <div class="location fs-12 opacity-70 text-dark mt-1">{{ $shop->address }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col pl-5 pl-md-0 ml-5 ml-md-0">
                        <div class="d-lg-flex align-items-center justify-content-lg-end">
                            <div class="d-md-flex justify-content-md-end align-items-md-baseline">
                                <!-- Member Since 
                                <div class="pr-md-3 mt-2 mt-md-0 border-md-right">
                                    <div class="fs-10 fw-400 text-secondary">{{ translate('Member Since') }}</div>
                                    <div class="mt-1 fs-16 fw-700 text-secondary">{{ date('d M Y',strtotime($shop->created_at)) }}</div>
                                </div>
                                <!-- Social Links 
                                @if ($shop->facebook || $shop->instagram || $shop->google || $shop->twitter || $shop->youtube)
                                    <div class="pl-md-3 pr-lg-3 mt-2 mt-md-0 border-lg-right">
                                        <span class="fs-10 fw-400 text-secondary">{{ translate('Social Media') }}</span><br>
                                        <ul class="social-md colored-light list-inline mb-0 mt-1">
                                            @if ($shop->facebook)
                                            <li class="list-inline-item mr-2">
                                                <a href="{{ $shop->facebook }}" class="facebook"
                                                    target="_blank">
                                                    <i class="lab la-facebook-f"></i>
                                                </a>
                                            </li>
                                            @endif
                                            @if ($shop->instagram)
                                            <li class="list-inline-item mr-2">
                                                <a href="{{ $shop->instagram }}" class="instagram"
                                                    target="_blank">
                                                    <i class="lab la-instagram"></i>
                                                </a>
                                            </li>
                                            @endif
                                            @if ($shop->google)
                                            <li class="list-inline-item mr-2">
                                                <a href="{{ $shop->google }}" class="google"
                                                    target="_blank">
                                                    <i class="lab la-google"></i>
                                                </a>
                                            </li>
                                            @endif
                                            @if ($shop->twitter)
                                            <li class="list-inline-item mr-2">
                                                <a href="{{ $shop->twitter }}" class="twitter"
                                                    target="_blank">
                                                    <i class="lab la-twitter"></i>
                                                </a>
                                            </li>
                                            @endif
                                            @if ($shop->youtube)
                                            <li class="list-inline-item">
                                                <a href="{{ $shop->youtube }}" class="youtube"
                                                    target="_blank">
                                                    <i class="lab la-youtube"></i>
                                                </a>
                                            </li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            </div>
                            <!-- follow 
                            <div class="d-flex justify-content-md-end pl-lg-3 pt-3 pt-lg-0">
                                @php $shopFollowers = count($shop->followers) + $shop->custom_followers; @endphp
                                @if(in_array($shop->id, $followed_sellers))
                                    <a href="{{ route("followed_seller.remove", ['id'=>$shop->id]) }}"  data-toggle="tooltip" data-title="{{ translate('Unfollow Seller') }}" data-placement="top"
                                        class="btn btn-success d-flex align-items-center justify-content-center fs-12 w-190px follow-btn followed"
                                        style="height: 40px; border-radius: 30px !important; justify-content: center;">
                                        <i class="las la-check fs-16 mr-2"></i>
                                        <span class="fw-700">{{ translate('Followed') }}</span> &nbsp; ({{ $shopFollowers }})
                                    </a>
                                @else
                                    <a href="{{ route("followed_seller.store", ['id'=>$shop->id]) }}"
                                        class="btn btn-primary d-flex align-items-center justify-content-center fs-12 w-190px follow-btn"
                                        style="height: 40px; border-radius: 30px !important; justify-content: center;">
                                        <i class="las la-plus fs-16 mr-2"></i>
                                        <span class="fw-700">{{ translate('Follow Seller') }}</span> &nbsp; ({{ $shopFollowers }})
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section-->
    
    <!-- Shop Meta Description (new section) 
<section class="border-top border-bottom mb-3" style="background: #fcfcfd;">
    <div class="container">
        <div class="py-4">
            <div class="row">
                <div class="col-12">
                    <h3 class="fs-18 fw-700 text-dark mb-2">{{ translate('About this shop') }}</h3>

                    {{-- Option A: Render plain text safely with line breaks and limit length --}}
                    <div class="text-secondary fs-14" style="white-space:pre-line;">
                       {{-- Shop Meta Description display (safe + read more) --}}
@php
    use Illuminate\Support\Str;
    $meta_raw = $shop->meta_description ?? '';
    $meta_plain = strip_tags($meta_raw);
    $limit = 250; // preview length, change if you want
@endphp

@if(trim($meta_plain) !== '')
    <div class="shop-meta-description text-secondary fs-14" style="white-space:pre-line;">
        {{-- Preview --}}
        <div class="meta-preview" id="meta-preview-{{ $shop->id }}">
            {!! nl2br(e(Str::limit($meta_plain, $limit))) !!}
            @if(strlen($meta_plain) > $limit)
                <a href="javascript:void(0)" onclick="document.getElementById('meta-preview-{{ $shop->id }}').style.display='none'; document.getElementById('meta-full-{{ $shop->id }}').style.display='block';" class="text-primary ml-2">
                    {{ translate('Read more') }}
                </a>
            @endif
        </div>

        {{-- Full text (hidden by default) --}}
        <div class="meta-full d-none" id="meta-full-{{ $shop->id }}">
            {!! nl2br(e($meta_plain)) !!}
            <a href="javascript:void(0)" onclick="document.getElementById('meta-full-{{ $shop->id }}').style.display='none'; document.getElementById('meta-preview-{{ $shop->id }}').style.display='block';" class="text-primary ml-2">
                {{ translate('Show less') }}
            </a>
        </div>
    </div>
@else
    <div class="opacity-70 fs-14">{{ translate('No meta description provided by this shop.') }}</div>
@endif


                  
</div>

                </div>
            </div>
        </div>
    </div>
</section>-->

<!-- Combined Shop Header + About (tight layout like screenshot) -->
<section class="shop-header-about border-top border-bottom">
  <div class="container">
    <div class="py-4">
      <div class="row align-items-start shop-header-row">

        <!-- LEFT: name + address + description -->
        <div class="col-lg-8 col-md-12 left-col">
          <div class="left-inner">

            <!-- name (big) -->
            <div class="d-flex align-items-center name-row">
              <a href="{{ route('shop.visit', $shop->slug) }}"
                 class="shop-header-name">
                {{ $shop->name }}
                @if ($shop->verification_status == 1)
                  <!-- svg -->
                @endif
              </a>

             <!-- follow 
                           
                                @php $shopFollowers = count($shop->followers) + $shop->custom_followers; @endphp
                                @if(in_array($shop->id, $followed_sellers))
                                    <a href="{{ route("followed_seller.remove", ['id'=>$shop->id]) }}"  data-toggle="tooltip" data-title="{{ translate('Unfollow Seller') }}" data-placement="top"
                                        class="btn btn-success d-flex align-items-center justify-content-center fs-12 w-190px follow-btn followed"
                                        style="height: 40px; border-radius: 30px !important; justify-content: center;">
                                        <i class="las la-check fs-16 mr-2"></i>
                                        <span class="fw-700">{{ translate('Followed') }}</span> &nbsp; ({{ $shopFollowers }})
                                    </a>
                                @else
                                    <a href="{{ route("followed_seller.store", ['id'=>$shop->id]) }}"
                                        class="btn btn-primary d-flex align-items-center justify-content-center fs-12 w-190px follow-btn"
                                        style="height: 40px; border-radius: 30px !important; justify-content: center;">
                                        <i class="las la-plus fs-16 mr-2"></i>
                                        <span class="fw-700">{{ translate('Follow Seller') }}</span> &nbsp; ({{ $shopFollowers }})
                                    </a>
                                @endif-->
                           
            </div>

            <!-- small row for address icon + address (very tight) -->
            <div class="address-row">
              <i class="las la-map-marker-alt"></i>
              <span class="location">{{ $shop->address }}</span>
            </div>

            <!-- meta description (truncated preview + read more) -->
            @php
              $meta_raw   = $shop->meta_description ?? '';
              $meta_plain = trim(strip_tags($meta_raw));
              $limit      = 250;
            @endphp

            @if($meta_plain !== '')
              <div class="shop-meta-description" data-shop-id="{{ $shop->id }}">
                <div class="meta-preview" id="meta-preview-{{ $shop->id }}">
                  {{ \Illuminate\Support\Str::limit($meta_plain, $limit, '...') }}
                   @if(mb_strlen($meta_plain) > $limit)
                      <a href="#" class="meta-toggle" data-action="show" data-target="{{ $shop->id }}">{{ translate('Read more') }}</a>
                   @endif

                </div>

                <div class="meta-full" id="meta-full-{{ $shop->id }}" style="display:none;">
                 {!! nl2br(e($meta_plain)) !!}
                  <a href="#" class="meta-toggle" data-action="hide" data-target="{{ $shop->id }}">{{ translate('Show less') }}</a>
                </div>
              </div>
            @else
              <div class="opacity-70 fs-14">No description provided by this Artist.</div>
            @endif

          </div>
        </div>

        <!-- RIGHT: circular logo aligned to top -->
        <div class="col-lg-4 col-md-12 text-lg-right text-center right-col">
          <a href="{{ route('shop.visit', $shop->slug) }}" class="shop-logo-wrapper">
            <img class="lazyload shop-logo-img"
                 src="{{ static_asset('assets/img/placeholder.jpg') }}"
                 data-src="{{ uploaded_asset($shop->logo) }}"
                 onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';"
                 alt="{{ $shop->name }}">
          </a>
        </div>

      </div>
    </div>
  </div>
</section>

<!-- Toggle JS (same as before) -->
<script>
  (function(){
    if (window.__shopMetaToggleInitialized) return;
    window.__shopMetaToggleInitialized = true;

    document.addEventListener('click', function(e){
      const el = e.target.closest && e.target.closest('.meta-toggle');
      if (!el) return;
      e.preventDefault();
      const action = el.getAttribute('data-action');
      const id = el.getAttribute('data-target');
      const preview = document.getElementById('meta-preview-' + id);
      const full = document.getElementById('meta-full-' + id);
      if (!preview || !full) return;
      if (action === 'show') {
        preview.style.display = 'none';
        full.style.display = 'block';
        full.scrollIntoView({behavior:'smooth', block:'nearest'});
      } else if (action === 'hide') {
        full.style.display = 'none';
        preview.style.display = 'inline';
      }
    }, false);
  })();
</script>

<!-- Strong, specific CSS: paste at end of file or main CSS loaded last -->
<style>
/* container & row */
.shop-header-about .shop-header-row { display: flex; align-items: flex-start; }

/* LEFT column */
.left-col { padding-right: 30px; }
.left-inner { width: 100%; }

/* shop name */
.shop-header-name {
  display: inline-block;
  font-size: 34px;       /* large like screenshot */
  font-weight: 700;
  margin: 0;
  line-height: 1.05;
  color: #111;
  text-decoration: none;
}

/* name row: keep follow button inline on same row */
.name-row { display: flex; align-items: center; gap: 12px; margin-bottom: 6px; }

/* follow button (compact) */
.follow-btn {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  height: 34px;
  padding: 0 12px;
  border-radius: 30px;
  font-size: 13px;
  text-decoration: none;
}
.follow-btn i { font-size: 14px; }

/* address row: very tight and small */
.address-row {
  display: flex;
  align-items: center;
  gap: 8px;
  margin: 0;
  padding: 0;
  font-size: 14px;
  color: #6b6b6b;
  margin-bottom: 6px; /* small gap to description */
}
.address-row i { color: #e62e04; font-size: 16px; line-height: 1; }

/* description: tight spacing and immediate inline preview */
.shop-meta-description {
  margin: 0;
  margin-top: 0px;
  line-height: 1.45;
  color: #000;           /* black text */
  font-size: 16px;       /* matches screenshot */
  
}

/* meta preview inline so read more sits right after ellipsis */
.shop-meta-description .meta-preview { display: inline; }
.shop-meta-description .meta-preview br { display: none; }

/* read more styling */
.meta-toggle {
  margin-left: 6px;
  color: #007bff;
  text-decoration: none;
  font-weight: 600;
}
.meta-toggle:hover { text-decoration: underline; }

/* meta full view small top gap */
.shop-meta-description .meta-full { display: none; margin-top: 8px; }

/* RIGHT column: circular image aligned to top */
.right-col { display: flex; justify-content: center; align-items: flex-start; }
.shop-logo-wrapper {
    margin-top: 25x;
  width: 200px;
  height: 200px;
  border-radius: 50%;
  overflow: hidden;
  border: 1px solid #e6e6e6;
  box-shadow: 0 10px 20px rgba(0,0,0,0.06);
  display: inline-block;
}
.shop-logo-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}

/* responsive: stack on small screens and keep spacing tight */
@media (max-width: 991.98px) {
  .left-col { padding-right: 0; }
  .shop-header-row { flex-direction: column; gap: 12px; }
  .right-col { justify-content: center; margin-top: 6px; }
  .shop-header-name { font-size: 28px; }
  .shop-meta-description { font-size: 15px; }
}
</style>



   
<!-- Safe Top Sellers (minimal backend change) 
<style>
.home-artists { padding: 40px 0; background:#fff; }
.home-artists .section-title { margin-bottom: 24px; font-size:1.25rem; font-weight:700; }

.artists-grid{
  display:grid;
  gap:24px;
  grid-template-columns: repeat(2, 1fr);
  align-items:start;
}
@media (min-width:576px){ .artists-grid{ grid-template-columns:repeat(3,1fr);} }
@media (min-width:768px){ .artists-grid{ grid-template-columns:repeat(4,1fr);} }
@media (min-width:992px){ .artists-grid{ grid-template-columns:repeat(6,1fr);} }
@media (min-width:1200px){ .artists-grid{ grid-template-columns:repeat(7,1fr);} }
@media (min-width:1400px){ .artists-grid{ grid-template-columns:repeat(8,1fr);} }

.artist-card{
  text-align:center;
  display:flex; flex-direction:column; align-items:center;
  gap:8px; color:#000;
  text-decoration:none;
  transition: transform .18s ease, box-shadow .18s ease;
}
.artist-card:hover{ transform:translateY(-4px); }

.artist-avatar{
  width:120px; height:120px;
  border-radius:50%;
  overflow:hidden;
  display:flex; align-items:center; justify-content:center;
  background:#f2f2f2;
  transition: transform .18s ease;
}
.artist-avatar img{
  width:100%; height:100%; object-fit:cover; display:block;
  filter:grayscale(100%);
  transform-origin:center;
}
.artist-card:hover .artist-avatar img { filter: none; transform:scale(1.03); }

.artist-name{
  font-weight:800; font-size:.82rem; letter-spacing:.5px; text-transform:uppercase;
}
.artist-count{
  font-size:.8rem; color:#7a7a7a; font-style:italic;
}

.artist-avatar.viewall{
  background:#111; color:#fff;
  font-weight:800; font-size:.9rem;
  display:flex; align-items:center; justify-content:center;
}
@media (max-width:360px){
  .artist-avatar{ width:100px; height:100px; }
}
</style>


@php
    $visibleCount = 6;
    $best_sellers = collect();

    try {
        $result = get_best_sellers($visibleCount);
        $best_sellers = is_array($result) ? collect($result) : collect($result);
    } catch (\Throwable $e) {
        \Log::error('get_best_sellers error: ' . $e->getMessage());
        $best_sellers = collect();
    }

    if ($best_sellers->isEmpty()) {
        try {
            $best_sellers = \App\Models\Seller::where('status', 1)
                                ->take($visibleCount)
                                ->get();
        } catch (\Throwable $e) {
            \Log::error('Fallback seller query error: ' . $e->getMessage());
            $best_sellers = collect();
        }
    }
@endphp

@if($best_sellers->isNotEmpty())
<section class="home-artists">
  <div class="container">
    <h2 class="section-title">{{ translate('Featured Artists') }}</h2>
    <div class="artists-grid">
      @foreach ($best_sellers->take($visibleCount) as $seller)
        @php
            $works = $seller->products_count ?? $seller->works_count ?? 0;
            $sellerName = $seller->name ?? 'Seller';
            $logoUrl = !empty($seller->logo) ? uploaded_asset($seller->logo) : static_asset('assets/img/placeholder-rect.jpg');
            $shopRoute = !empty($seller->slug) ? route('shop.visit', $seller->slug) : route('sellers');
        @endphp

        <a href="{{ $shopRoute }}" class="artist-card">
          <div class="artist-avatar">
            <img src="{{ $logoUrl }}" alt="{{ e($sellerName) }}" onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}'">
          </div>
          <div class="artist-name">{{ strtoupper(\Illuminate\Support\Str::limit($sellerName, 18)) }}</div>
          <div class="artist-count">{{ $works }} {{ translate('works') }}</div>
        </a>
      @endforeach

      <a href="{{ route('sellers') }}" class="artist-card">
        <div class="artist-avatar viewall">VIEW ALL</div>
      </a>
    </div>
  </div>
</section>
@endif-->


    @if (!isset($type))

        <!-- Featured Products -->
        @php
            $feature_products = $shop->user->products->where('published', 1)->where('approved', 1)->where('seller_featured', 1);
        @endphp
        @if (count($feature_products) > 0)
            <section class="mt-3 mb-3" id="section_featured">
                <div class="container">
                <!-- Top Section -->
                <div class="d-flex mb-4 align-items-baseline justify-content-between">
                        <!-- Title -->
                        <h3 class="fs-16 fs-md-20 fw-700 mb-3 mb-sm-0">
                            <span class="">{{ translate('Featured Products') }}</span>
                        </h3>
                        <!-- Links -->
                        <div class="d-flex">
                            <a type="button" class="arrow-prev slide-arrow text-secondary mr-2" onclick="clickToSlide('slick-prev','section_featured')"><i class="las la-angle-left fs-20 fw-600"></i></a>
                            <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_featured')"><i class="las la-angle-right fs-20 fw-600"></i></a>
                        </div>
                    </div>
                    <!-- Products Section -->
                    <div class="px-sm-3">
                        <div class="aiz-carousel sm-gutters-16 arrow-none" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-autoplay='true' data-infinute="true">
                            @foreach ($feature_products as $key => $product)
                            <div class="carousel-box px-3 position-relative has-transition hov-animate-outline border-right border-top border-bottom @if($key == 0) border-left @endif">
                                @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

        <!-- Banner Slider -->
        @if ($shop->slider_images != null)
            <section class="mt-3 mb-3">
                <div class="container">
                    <div class="aiz-carousel mobile-img-auto-height" data-arrows="true" data-dots="false" data-autoplay="true">
                        @php
                            $shop_slider_images = get_slider_images(json_decode($shop->slider_images, true));
                            $shop_slider_links = json_decode($shop->slider_links, true);
                        @endphp
                        @foreach ($shop_slider_images as $key => $slider)
                            <div class="carousel-box w-100 h-140px h-md-300px h-xl-450px">
                                <a href="{{ isset($shop_slider_links[$key]) ? $shop_slider_links[$key] : '' }}">
                                    <img class="d-block lazyload h-100 img-fit" 
                                        src="{{ $slider ? my_asset($slider->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                        alt="{{ $key }} offer">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif


        <!-- Coupons 
        @php
            $coupons = get_coupons($shop->user->id);
        @endphp
        @if (count($coupons)>0)
            <section class="mt-3 mb-3" id="section_coupons">
                <div class="container">
                <!-- Top Section 
                <div class="d-flex mb-4 align-items-baseline justify-content-between">
                        <!-- Title 
                        <h3 class="fs-16 fs-md-20 fw-700 mb-3 mb-sm-0">
                            <span class="pb-3">{{ translate('Coupons') }}</span>
                        </h3>
                        <!-- Links 
                        <div class="d-flex">
                            <a type="button" class="arrow-prev slide-arrow link-disable text-secondary mr-2" onclick="clickToSlide('slick-prev','section_coupons')"><i class="las la-angle-left fs-20 fw-600"></i></a>
                            <a class="text-blue fs-12 fw-700 hov-text-primary" href="{{ route('shop.visit.type', ['slug'=>$shop->slug, 'type'=>'cupons']) }}">{{ translate('View All') }}</a>
                            <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_coupons')"><i class="las la-angle-right fs-20 fw-600"></i></a>
                        </div>
                    </div>
                    <!-- Coupons Section 
                    <div class="aiz-carousel sm-gutters-16 arrow-none" data-items="3" data-lg-items="2" data-sm-items="1" data-arrows='true' data-infinite='false'>
                        @foreach ($coupons->take(10) as $key => $coupon)
                            <div class="carousel-box">
                                @include('frontend.partials.coupon_box',['coupon' => $coupon])
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif-->
        
        <!-- Banner full width 1 -->
        @if ($shop->banner_full_width_1_images)
            @php
                $shop_banner_full_width_1_images = get_slider_images(json_decode($shop->banner_full_width_1_images, true));
                $shop_banner_full_width_1_links = json_decode($shop->banner_full_width_1_links, true);
            @endphp
            @foreach ($shop_banner_full_width_1_images as $key => $banner)
                <section class="container mb-3 mt-3">
                    <div class="w-100">
                        <a href="{{ isset($shop_banner_full_width_1_links[$key]) ? $shop_banner_full_width_1_links[$key] : '' }}">
                            <img class="d-block lazyload h-100 img-fit"
                                src="{{ $banner ? my_asset($banner->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                alt="{{ env('APP_NAME') }} banner">
                        </a>
                    </div>
                </section>
            @endforeach
        @endif
        
        <!-- Banner half width -->
        @if($shop->banners_half_width_images)
            @php
                $shop_banners_half_width_images = get_slider_images(json_decode($shop->banners_half_width_images, true));
                $shop_banners_half_width_links = json_decode($shop->banners_half_width_links, true);
            @endphp
            <section class="container  mb-3 mt-3">
                <div class="row gutters-16">
                    @foreach ($shop_banners_half_width_images as $key => $banner)
                    <div class="col-md-6 mb-3 mb-md-0">
                        <div class="w-100">
                            <a href="{{ isset($shop_banners_half_width_links[$key]) ? $shop_banners_half_width_links[$key] : '' }}">
                                <img class="d-block lazyload h-100 img-fit"
                                    src="{{ $banner ? my_asset($banner->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                    alt="{{ env('APP_NAME') }} banner">
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>
        @endif

    @endif

    <section class="mb-3 mt-3" id="section_types">
        <div class="container">
            <!-- Top Section -->
            <div class="d-flex mb-4 align-items-baseline justify-content-between">
                <!-- Title -->
                <h3 class="fs-16 fs-md-20 fw-700 mb-3 mb-sm-0">
                    <span class="pb-3">
                        @if (!isset($type))
                            {{ translate('New Arrival Products')}}
                        @elseif ($type == 'top-selling')
                            {{ translate('Top Selling')}}
                        @elseif ($type == 'cupons')
                            {{ translate('All Cupons')}}
                        @endif
                    </span>
                </h3>
                @if (!isset($type))
                    <!-- Links -->
                    <div class="d-flex">
                        <a type="button" class="arrow-prev slide-arrow link-disable text-secondary mr-2" onclick="clickToSlide('slick-prev','section_types')"><i class="las la-angle-left fs-20 fw-600"></i></a>
                        <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_types')"><i class="las la-angle-right fs-20 fw-600"></i></a>
                    </div>
                @endif
            </div>

            @php
                if (!isset($type)){
                    $products = get_seller_products($shop->user->id);
                }
                elseif ($type == 'top-selling'){
                    $products = get_shop_best_selling_products($shop->user->id);
                }
                elseif ($type == 'cupons'){
                    $coupons = get_coupons($shop->user->id , 24);
                }
            @endphp

            @if (!isset($type))
                <!-- New Arrival Products Section -->
                <div class="px-sm-3 pb-3">
                    <div class="aiz-carousel sm-gutters-16 arrow-none" data-items="6" data-xl-items="5" data-lg-items="4"  data-md-items="3" data-sm-items="2" data-xs-items="2" data-arrows='true' data-infinite='false'>
                        @foreach ($products as $key => $product)
                        <div class="carousel-box px-3 position-relative has-transition hov-animate-outline border-right border-top border-bottom @if($key == 0) border-left @endif">
                            @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Banner full width 2 -->
                @if ($shop->banner_full_width_2_images)
                    @php
                        $shop_banner_full_width_2_images = get_slider_images(json_decode($shop->banner_full_width_2_images, true));
                        $shop_banner_full_width_2_links = json_decode($shop->banner_full_width_2_links, true);
                    @endphp
                    @foreach ($shop_banner_full_width_2_images as $key => $banner)
                        <div class="mt-3 mb-3 w-100">
                            <a href="{{ isset($shop_banner_full_width_2_links[$key]) ? $shop_banner_full_width_2_links[$key] : '' }}">
                                <img class="d-block lazyload h-100 img-fit"
                                    src="{{ $banner ? my_asset($banner->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                    onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';"
                                    alt="{{ env('APP_NAME') }} banner">
                            </a>
                        </div>
                    @endforeach
                @endif


                @elseif ($type == 'cupons')
                <!-- All Coupons Section -->
                <div class="row gutters-16 row-cols-xl-3 row-cols-md-2 row-cols-1">
                    @foreach ($coupons as $key => $coupon)
                        <div class="col mb-4">
                            @include('frontend.partials.coupon_box',['coupon' => $coupon])
                        </div>
                    @endforeach
                </div>
                <div class="aiz-pagination mt-4 mb-4">
                    {{ $coupons->links() }}
                </div>
                
                
                
                 @elseif ($type == 'all-products')
                <!-- All Products Section -->
                <form class="" id="search-form" action="" method="GET">
                    <div class="row gutters-16 justify-content-center">
 

                                        <!-- Sidebar 
                        <div class="col-xl-3 col-md-6 col-sm-8">

                            <!-- Sidebar Filters 
                            <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                                <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                                <div class="collapse-sidebar c-scrollbar-light text-left">
                                    <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                        <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                        <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" >
                                            <i class="las la-times la-2x"></i>
                                        </button>
                                    </div>

                                    <!-- Categories 
<div class="bg-white border mb-4 mx-3 mx-xl-0 mt-3 mt-xl-0" style="background-color:#f8f9fa;">
    <div style="font-size:18px; padding:0.5rem;" class="fw-700">
        <a href="#collapse_1" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
            {{ translate('Categories')}}
        </a>
    </div>
    <div class="collapse show px-3" id="collapse_1">
        @foreach (get_categories_by_products($shop->user->id) as $category)
            <label class="aiz-checkbox mb-3">
                <input
                    type="checkbox"
                    name="selected_categories[]"
                    value="{{ $category->id }}" @if (in_array($category->id, $selected_categories)) checked @endif
                    onchange="filter()"
                >
                <span class="aiz-square-check"></span>
                <span class="fs-14 fw-400 text-dark">{{ $category->getTranslation('name') }}</span>
            </label>
            <br>
        @endforeach
    </div>
</div>

<!-- Price range 
<div class="bg-white border mb-4 mx-3 mx-xl-0 mt-3 mt-xl-0" style="background-color:#f8f9fa;">
    <div style="font-size:18px; padding:0.5rem;" class="fw-700">
        <a href="#collapse_price"
           class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between"
           data-toggle="collapse">
            {{ translate('Price Range') }}
        </a>
    </div>
    <div class="collapse show px-3" id="collapse_price">
        <div class="aiz-range-slider">
            <div
                id="input-slider-range"
                data-range-value-min="0"
                data-range-value-max="50"
            ></div>

            <div class="row mt-2">
                <div class="col-6">
                    <span class="range-slider-value value-low fs-14 fw-600 opacity-70"
                          data-range-value-low="0"
                          id="input-slider-range-value-low">
                          $0
                    </span>
                </div>
                <div class="col-6 text-right">
                    <span class="range-slider-value value-high fs-14 fw-600 opacity-70"
                          data-range-value-high="50"
                          id="input-slider-range-value-high">
                          $50
                    </span>
                </div>
            </div>
        </div>
        <input type="hidden" name="min_price" value="0">
        <input type="hidden" name="max_price" value="50">
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    function updatePriceLabels() {
        let low = document.getElementById("input-slider-range-value-low");
        let high = document.getElementById("input-slider-range-value-high");
        
        if (low && !low.innerText.includes('$')) {
            low.innerText = "$" + low.innerText;
        }
        if (high && !high.innerText.includes('$')) {
            high.innerText = "$" + high.innerText;
        }
    }

    // Run once on load
    updatePriceLabels();

    // Run whenever slider updates
    setInterval(updatePriceLabels, 300);
});
</script>



<!-- Ratings 
<div class="bg-white border mb-4 mx-3 mx-xl-0 mt-3 mt-xl-0" style="background-color:#f8f9fa;">
    <div style="font-size:18px; padding:0.5rem;" class="fw-700">
        <a href="#collapse_2" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
            {{ translate('Ratings')}}
        </a>
    </div>
    <div class="collapse show px-3" id="collapse_2" style="font-size:10px;">
        <label class="aiz-checkbox mb-3">
            <input type="radio" name="rating" value="5" @if ($rating==5) checked @endif onchange="filter()">
            <span class="aiz-square-check"></span>
            <span class="rating rating-mr-2">{{ renderStarRating(5) }}</span>
        </label><br>
        <label class="aiz-checkbox mb-3">
            <input type="radio" name="rating" value="4" @if ($rating==4) checked @endif onchange="filter()">
            <span class="aiz-square-check"></span>
            <span class="rating rating-mr-2">{{ renderStarRating(4) }}</span>
        </label><br>
        <label class="aiz-checkbox mb-3">
            <input type="radio" name="rating" value="3" @if ($rating==3) checked @endif onchange="filter()">
            <span class="aiz-square-check"></span>
            <span class="rating rating-mr-2">{{ renderStarRating(3) }}</span>
        </label><br>
        <label class="aiz-checkbox mb-3">
            <input type="radio" name="rating" value="2" @if ($rating==2) checked @endif onchange="filter()">
            <span class="aiz-square-check"></span>
            <span class="rating rating-mr-2">{{ renderStarRating(2) }}</span>
        </label><br>
        <label class="aiz-checkbox mb-3">
            <input type="radio" name="rating" value="1" @if ($rating==1) checked @endif onchange="filter()">
            <span class="aiz-square-check"></span>
            <span class="rating rating-mr-2">{{ renderStarRating(1) }}</span>
        </label>
    </div>
</div>-->



                                    <!-- Brands 
                                    <div class="bg-white border mb-4 mx-3 mx-xl-0 mt-3 mt-xl-0">
                                        <div class="fs-16 fw-700 p-3">
                                            <a href="#collapse_3" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                                {{ translate('Brands')}}
                                            </a>
                                        </div>
                                        <div class="collapse show px-3" id="collapse_3">
                                            <div class="row gutters-10">
                                                @foreach (get_brands_by_products($shop->user->id) as $key => $brand)
                                                    <div class="col-6">
                                                        <label class="aiz-megabox d-block mb-3">
                                                            <input value="{{ $brand->slug }}" type="radio" onchange="filter()"
                                                                name="brand" @isset($brand_id) @if ($brand_id == $brand->id) checked @endif @endisset>
                                                            <span class="d-block aiz-megabox-elem rounded-0 p-3 border-transparent hov-border-primary">
                                                                <img src="{{ uploaded_asset($brand->logo) }}"
                                                                    class="img-fit mb-2" alt="{{ $brand->getTranslation('name') }}">
                                                                <span class="d-block text-center">
                                                                    <span
                                                                        class="d-block fw-400 fs-14">{{ $brand->getTranslation('name') }}</span>
                                                                </span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>-->

                                </div>
                            </div>
                        </div>
                       



                        <!-- Contents -->
                        <div class="col-xl-9">
                            <!-- Top Filters 
                            <div class="text-left mb-2">
                                <div class="row gutters-5 flex-wrap">
                                    <div class="col-lg col-10">
                                        <h1 class="fs-20 fs-md-24 fw-700 text-dark">
                                            {{ translate('All Products') }}
                                        </h1>
                                    </div>
                                    <div class="col-2 col-lg-auto d-xl-none mb-lg-3 text-right">
                                        <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                            <i class="la la-filter la-2x"></i>
                                        </button>
                                    </div>
                                    <div class="col-6 col-lg-auto mb-3 w-lg-200px">
                                        <select class="form-control form-control-sm aiz-selectpicker rounded-0" name="sort_by" onchange="filter()">
                                            <option value="">{{ translate('Sort by')}}</option>
                                            <option value="newest" @isset($sort_by) @if ($sort_by == 'newest') selected @endif @endisset>{{ translate('Newest')}}</option>
                                            <option value="oldest" @isset($sort_by) @if ($sort_by == 'oldest') selected @endif @endisset>{{ translate('Oldest')}}</option>
                                            <option value="price-asc" @isset($sort_by) @if ($sort_by == 'price-asc') selected @endif @endisset>{{ translate('Price low to high')}}</option>
                                            <option value="price-desc" @isset($sort_by) @if ($sort_by == 'price-desc') selected @endif @endisset>{{ translate('Price high to low')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>-->

                            
<!-- Products 
<div class="product-grid">
    @foreach ($products as $product)
        <div class="product-card">
            <div class="card border-0 shadow-none">
                <a href="{{ route('product', $product->slug) }}">
                    <img src="{{ uploaded_asset($product->thumbnail_img) }}" 
                         class="img-fluid w-100 mb-2" 
                         alt="{{ $product->name }}">
                </a>
                <h5 class="fs-14 fw-600 text-dark mb-1">{{ $product->name }}</h5>
                <span class="fs-14 fw-700 text-dark">${{ $product->unit_price }}</span>
            </div>
        </div>
    @endforeach
</div>

<style>
/* ✅ Row-wise Grid (CSS Grid) */
.product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr); /* 4 items per row */
    gap: 16px; /* space between items */
    margin-left: 50px; /* optional left margin */
}

.product-card {
    background: #fff;
}

/* Responsive breakpoints */
@media (max-width: 1200px) {
    .product-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 992px) {
    .product-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 576px) {
    .product-grid { grid-template-columns: 1fr; }
}
</style>-->

<!-- Products -->
<div class="product-grid">
    @foreach ($products as $product)
        @php
            $product_url = route('product', $product->slug);
            $artist_shop_url = '#';
            if ($product->user) {
                if (isset($product->user->shop) && $product->user->shop && isset($product->user->shop->id)) {
                    $artist_shop_url = url('shop/'.$product->user->shop->id);
                } else {
                    $artist_shop_url = url('seller/'.$product->user->id);
                }
            }
        @endphp

        <div class="product-card">
            <div class="card border-0 shadow-none p-2">

                <!-- Product Image -->
                <a href="{{ $product_url }}">
                    <img src="{{ uploaded_asset($product->thumbnail_img) }}"
                         class="img-fluid w-100 mb-2"
                         alt="{{ $product->name }}">
                </a>

                <!-- Row 1: NAME (left) + WISHLIST (right) -->
                <div class="d-flex align-items-center justify-content-between mb-1 pp-name-row">
                    <h5 class="fs-14 fw-600 text-dark mb-0">
                        <a href="{{ $product_url }}" class="text-reset">{{ $product->name }}</a>
                    </h5>

                    <button type="button"
                            class="pp-wishlist-btn"
                            data-product-id="{{ $product->id }}"
                            onclick="addToWishList({{ $product->id }}); togglePPWishlist(this);"
                            aria-label="Add to wishlist"
                            title="{{ translate('Add to wishlist') }}">
                        <!-- outline heart -->
                        <svg class="pp-heart pp-heart-outline" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                             viewBox="0 0 24 24" role="img" aria-hidden="true">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"
                                  fill="none" stroke="#6b7280" stroke-width="1.4"/>
                        </svg>

                        <!-- filled heart (hidden by default) -->
                        <svg class="pp-heart pp-heart-filled" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                             viewBox="0 0 24 24" role="img" aria-hidden="true" style="display:none;">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"
                                  fill="#e62e04"/>
                        </svg>
                    </button>
                </div>

                <!-- Row 2: ARTIST (icon + link) -->
                <div class="d-flex align-items-center mb-2 pp-artist-row">
                    <svg class="pp-artist-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                         viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#C59D28"
                              d="M12 2l2.6 5.27L20 8.27l-4 3.9.94 5.5L12 15.77 7.06 17.77 8 12.27 4 8.37l5.4-.99L12 2z"/>
                    </svg>

                   @if ($product->user && $product->user->shop)
    <a href="{{ route('shop.visit', $product->user->shop->slug) }}" class="pp-artist-link ml-2">
        {{ $product->user->shop->name }}
    </a>
@elseif ($product->user)
    <a href="{{ route('seller.profile', $product->user->id) }}" class="pp-artist-link ml-2">
        {{ $product->user->name }}
    </a>
@else
    <span class="pp-artist-link ml-2 text-muted">{{ translate('Unknown Artist') }}</span>
@endif

                </div>

                <!-- Price -->
                <span class="fs-14 fw-700 text-dark">
                {{ home_discounted_base_price($product) }}
                 </span>

            </div>
        </div>
    @endforeach
</div>

<!--<style>
/* ✅ Product Grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-left: 50px;
}
.product-card { background: #fff; }

/* Wishlist button */
.pp-wishlist-btn {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    line-height: 0;
}
.pp-heart { transition: transform 0.15s ease, opacity 0.15s ease; }
.pp-wishlist-btn.active .pp-heart-outline { display: none !important; }
.pp-wishlist-btn.active .pp-heart-filled { display: inline-block !important; }

/* Artist link hover styling */
.pp-artist-link {
    position: relative;
    color: inherit;
    text-decoration: none;
    transition: color 0.2s ease;
}
.pp-artist-link {
    color: inherit;
    text-decoration: none;
    transition: color 0.2s ease;
}
.pp-artist-link:hover {
    color: #e62e04;
    text-decoration: underline;
    text-decoration-color: #e62e04;
}


/* Responsive */
@media (max-width: 1200px) {
    .product-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 992px) {
    .product-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 576px) {
    .product-grid { grid-template-columns: 1fr; margin-left: 0; }
}
</style>-->

<style>
   
/* ✅ Product Grid Masonry (using CSS Columns) */
.product-grid {
    display: block;           /* turn off grid */
    column-count: 3;          /* 3 columns on large screens */
    column-gap: 16px;         /* horizontal gap between columns */
    margin-left: 50px;
}

/* Each card flows into the column */
.product-card {
    display: inline-block;          /* required for column flow */
    width: 100%;
    margin: 0 0 16px;               /* vertical gap between cards */
    break-inside: avoid;            /* prevent splitting */
    -webkit-column-break-inside: avoid;
    -moz-column-break-inside: avoid;
    background: #fff;
}

/* Images should resize correctly */
.product-card img {
    display: block;
    width: 100%;
    height: auto;
}

/* Wishlist button */
.pp-wishlist-btn {
    background: none;
    border: none;
    padding: 0;
    cursor: pointer;
    line-height: 0;
}
.pp-heart { transition: transform 0.15s ease, opacity 0.15s ease; }
.pp-wishlist-btn.active .pp-heart-outline { display: none !important; }
.pp-wishlist-btn.active .pp-heart-filled { display: inline-block !important; }

/* Artist link hover styling */
.pp-artist-link {
    position: relative;
    color: inherit;
    text-decoration: none;
    transition: color 0.2s ease;
}
.pp-artist-link:hover {
    color: #e62e04;
    text-decoration: underline;
    text-decoration-color: #e62e04;
}

/* ✅ Responsive Masonry */
@media (max-width: 1200px) {
    .product-grid { column-count: 3; }
}
@media (max-width: 992px) {
    .product-grid { column-count: 2; }
}
@media (max-width: 576px) {
    .product-grid { column-count: 1; margin-left: 0; }
}
</style>



<script>
/**
 * Toggle only UI state (outline ↔ filled heart).
 * We do NOT show alerts here — leave that to backend `addToWishList()`.
 */
function togglePPWishlist(buttonEl) {
    buttonEl.classList.toggle('active');
}
</script>

@section('script')
    <script>
        AIZ.plugins.particles();
    </script>
@endsection







                            <div class="aiz-pagination mt-4">
                                {{ $products->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </form>
                
     

            @elseif ($type == 'all-preorder-products')
                <!-- All preorder Products Section--> 
                <form class="" id="search-form" action="" method="GET">
                    <div class="row gutters-16 justify-content-center">
                        <!-- Sidebar -->
                        <div class="col-xl-3 col-md-6 col-sm-8">

                            <!-- Sidebar Filters -->
                            <div class="aiz-filter-sidebar collapse-sidebar-wrap sidebar-xl sidebar-right z-1035">
                                <div class="overlay overlay-fixed dark c-pointer" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" data-same=".filter-sidebar-thumb"></div>
                                <div class="collapse-sidebar c-scrollbar-light text-left">
                                    <div class="d-flex d-xl-none justify-content-between align-items-center pl-3 border-bottom">
                                        <h3 class="h6 mb-0 fw-600">{{ translate('Filters') }}</h3>
                                        <button type="button" class="btn btn-sm p-2 filter-sidebar-thumb" data-toggle="class-toggle" data-target=".aiz-filter-sidebar" >
                                            <i class="las la-times la-2x"></i>
                                        </button>
                                    </div>

                                        <!-- Categories -->
     
                                <div class="bg-white border mb-4 mx-3 mx-xl-0 mt-3 mt-xl-0">
                                     <div style="font-size:14px;" class="fw-700 p-3">
                                        <a href="#collapse_1" class="dropdown-toggle filter-section text-dark d-flex align-items-center justify-content-between" data-toggle="collapse">
                                            {{ translate('Categories')}}
                                        </a>
                                    </div>
                                    <div class="collapse show px-3" id="collapse_1">
                                       
                                        @php
                                        $product_categories = $type == 'all-preorder-products' ? get_categories_by_preorder_products($shop->user->id) : get_categories_by_products($shop->user->id);
                                        @endphp
                                        @foreach ($product_categories as $category)
                                            <label class="aiz-checkbox mb-3">
                                                <input
                                                    type="checkbox"
                                                    name="selected_categories[]"
                                                    value="{{ $category->id }}" @if (in_array($category->id, $selected_categories)) checked @endif
                                                    onchange="filter()"
                                                >
                                                <span class="aiz-square-check"></span>
                                                <span class="fs-14 fw-400 text-dark">{{ $category->getTranslation('name') }}</span>
                                            </label>
                                            <br>
                                        @endforeach
                                    </div>
                                </div>

                                 <!-- Attributes -->
                                 <div class="bg-white border mb-3">
                                    <div class="fs-16 fw-700 p-3">
                                        <a href="#" class="dropdown-toggle text-dark filter-section collapsed d-flex align-items-center justify-content-between" 
                                            data-toggle="collapse" data-target="#collapse_availability_filter" style="white-space: normal;">
                                            {{ translate('Filter by Availability') }}
                                        </a>
                                    </div>
                                    @php
                                        $show = $is_available !== null ? 'show' : '';
                                    @endphp
                                    <div class="collapse {{ $show }}" id="collapse_availability_filter">
                                        <div class="p-3 aiz-checkbox-list">
                                            <label class="aiz-checkbox mb-3">
                                                <input
                                                    type="radio"
                                                    name="is_available"
                                                    value="1" @if ($is_available == 1) checked @endif
                                                    onchange="filter()"
                                                >
                                                <span class="aiz-square-check"></span>
                                                <span class="fs-14 fw-400 text-dark">{{ translate('Available Now') }}</span>
                                            </label>
                                            <label class="aiz-checkbox mb-3">
                                                <input
                                                    type="radio"
                                                    name="is_available"
                                                    value="0" @if ($is_available === '0') checked @endif
                                                    onchange="filter()"
                                                >
                                                <span class="aiz-square-check"></span>
                                                <span class="fs-14 fw-400 text-dark">{{ translate('Upcoming') }}</span>
                                            </label>
                                            <label class="aiz-checkbox mb-3">
                                                <input
                                                    type="radio"
                                                    name="is_available"
                                                    value=""
                                                    @if ($is_available === null) checked @endif
                                                    onchange="filter()"
                                                >
                                                <span class="aiz-square-check"></span>
                                                <span class="fs-14 fw-400 text-dark">{{ translate('All') }}</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                </div>
                            </div>
                        </div>

                        <!-- Contents -->
                        <div class="col-xl-9">
                            <!-- Top Filters -->
                            <div class="text-left mb-2">
                                <div class="row gutters-5 flex-wrap">
                                    <div class="col-lg col-10">
                                        <h1 class="fs-20 fs-md-24 fw-700 text-dark">
                                            {{ translate('All Preorder Products') }}
                                        </h1>
                                    </div>
                                    <div class="col-2 col-lg-auto d-xl-none mb-lg-3 text-right">
                                        <button type="button" class="btn btn-icon p-0" data-toggle="class-toggle" data-target=".aiz-filter-sidebar">
                                            <i class="la la-filter la-2x"></i>
                                        </button>
                                    </div>
                                    <div class="col-6 col-lg-auto mb-3 w-lg-200px">
                                        <select class="form-control form-control-sm aiz-selectpicker rounded-0" name="sort_by" onchange="filter()">
                                            <option value="">{{ translate('Sort by')}}</option>
                                            <option value="newest" @isset($sort_by) @if ($sort_by == 'newest') selected @endif @endisset>{{ translate('Newest')}}</option>
                                            <option value="oldest" @isset($sort_by) @if ($sort_by == 'oldest') selected @endif @endisset>{{ translate('Oldest')}}</option>
                                            <option value="price-asc" @isset($sort_by) @if ($sort_by == 'price-asc') selected @endif @endisset>{{ translate('Price low to high')}}</option>
                                            <option value="price-desc" @isset($sort_by) @if ($sort_by == 'price-desc') selected @endif @endisset>{{ translate('Price high to low')}}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Products -->
                            <div class="px-3">
                                <div class="row gutters-16 row-cols-xxl-4 row-cols-xl-3 row-cols-lg-4 row-cols-md-3 row-cols-2 border-top border-left">
                                    @foreach ($products as $key => $product)
                                        <div class="col border-right border-bottom has-transition hov-shadow-out z-1">
                                            {{-- @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product]) --}}
                                            @include('preorder.frontend.product_box3',['product' => $product])
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="aiz-pagination mt-4">
                                {{ $products->appends(request()->input())->links() }}
                            </div>
                        </div>
                    </div>
                </form>
            @else
            

                <!-- Top Selling Products Section--> 
                <div class="px-3">
                    <div class="row gutters-16 row-cols-xxl-6 row-cols-xl-5 row-cols-lg-4 row-cols-md-3 row-cols-2 border-left border-top">
                        @foreach ($products as $key => $product)
                            <div class="col border-bottom border-right overflow-hidden has-transition hov-shadow-out z-1">
                                @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="aiz-pagination mt-4 mb-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </section>

@endsection

@section('script')
    <script type="text/javascript">
        function filter(){
            $('#search-form').submit();
        }

        function rangefilter(arg){
            $('input[name=min_price]').val(arg[0]);
            $('input[name=max_price]').val(arg[1]);
            filter();
        }
    </script>
@endsection


