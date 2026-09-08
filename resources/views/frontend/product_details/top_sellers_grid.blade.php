<style>
/* === Artists section clean CSS === */
.home-artists .artists-header{
  display:flex;
  align-items:flex-start;
  justify-content:space-between;
  gap:12px;
  margin-bottom:1rem;
}

/* Top-right link */
.home-artists .all-artists-link{
  font-weight:600;
  text-decoration:none;
  color:#111827;
  display:inline-flex;
  align-items:center;
  gap:6px;
}

/* Grid: try to keep 6 items in a single row on large screens */
.home-artists .artists-grid{
  display:grid;
  grid-template-columns: repeat(6, minmax(0, 1fr)); /* 6 columns if space allows */
  gap: 22px 18px;
  align-items:stretch; /* make each card stretch to same height */
  padding-bottom:6px;
  box-sizing:border-box;
}

/* Responsive */
@media (max-width:1400px){ .home-artists .artists-grid{ grid-template-columns: repeat(5, minmax(0,1fr)); } }
@media (max-width:1200px){ .home-artists .artists-grid{ grid-template-columns: repeat(4, minmax(0,1fr)); } }
@media (max-width:992px){  .home-artists .artists-grid{ grid-template-columns: repeat(3, minmax(0,1fr)); } }
@media (max-width:768px){  .home-artists .artists-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); } }
@media (max-width:480px){  .home-artists .artists-grid{ grid-template-columns: 1fr; } }

/* Card */
.artist-card{
  display:flex;
  flex-direction:column;
  align-items:center;
  text-align:center;
  padding:8px 6px;
  box-sizing:border-box;
  height:100%;
  min-height: 260px; /* adjust if needed */
}

/* Ensure grid children stretch full height so margin-top:auto works */
.home-artists .artists-grid > .artist-card{ align-self:stretch; }

/* Avatar */
.artist-avatar{ width:100%; display:flex; justify-content:center; }
.artist-avatar img{
  width:120px;
  height:120px;
  object-fit:cover;
  border-radius:50%;
  display:block;
  margin:0 auto;
  box-shadow: 0 2px 0 rgba(0,0,0,0.04);
}

/* Name */
.artist-name{
  font-weight:700;
  margin-top:10px;
  margin-bottom:4px;
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
  font-size:1rem;
  width:100%;
}

/* Country: small gap to button */
.artist-country{
  color:#6c757d;
  margin-bottom:8px; /* reduced gap */
  font-size:0.92rem;
}

/* Follow wrapper pinned to bottom of card */
.seller-follow-wrapper{
  margin-top:auto; /* pushes to bottom */
  display:flex;
  justify-content:center;
  width:100%;
  padding-top:4px;
}

/* Smaller follow button */
.seller-follow-btn{
  display:inline-flex;
  align-items:center;
  gap:8px;
  min-width:120px;
  max-width:180px;
  height:34px;
  padding:0 10px;
  border-radius:22px !important;
  background:#ffffff;
  color:#000000;
  border:1px solid #000000;
  font-weight:700;
  text-decoration:none;
  justify-content:center;
  font-size:0.88rem;
  box-sizing:border-box;
}

/* icon follows text color */
.seller-follow-btn i{ color:currentColor; font-size:14px; }

/* hover invert */
.seller-follow-btn:hover,
.seller-follow-btn:focus{
  background:#000000;
  color:#ffffff;
  border-color:#000000;
  text-decoration:none;
}

/* === Strict 6 columns on large screens, responsive downwards === */
.home-artists .artists-grid {
  display: grid;
  grid-template-columns: repeat(6, minmax(0, 1fr)); /* force 6 columns on wide screens */
  gap: 20px 16px;
  align-items: start;
  padding-bottom: 6px;
  box-sizing: border-box;
}

/* keep responsive but desktop will try to show 6 */
@media (max-width: 1400px) { .home-artists .artists-grid { grid-template-columns: repeat(6, minmax(0,1fr)); } }
@media (max-width: 1200px) { .home-artists .artists-grid { grid-template-columns: repeat(5, minmax(0,1fr)); } }
@media (max-width: 992px)  { .home-artists .artists-grid { grid-template-columns: repeat(4, minmax(0,1fr)); } }
@media (max-width: 768px)  { .home-artists .artists-grid { grid-template-columns: repeat(2, minmax(0,1fr)); } }
@media (max-width: 480px)  { .home-artists .artists-grid { grid-template-columns: 1fr; } }

/* card layout */
.artist-card {
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
  padding: 8px 6px;
  box-sizing: border-box;
  height: 100%;
  min-height: 220px; /* smaller so 6 fit in row */
}

/* ensure grid children stretch so content spacing is consistent */
.home-artists .artists-grid > .artist-card { align-self: stretch; }

/* avatar with white background */
.artist-avatar { width:100%; display:flex; justify-content:center; }
.artist-avatar img {
  width:110px;            /* make slightly smaller so 6 fit */
  height:110px;
  object-fit:cover;
  border-radius:50%;
  background:#ffffff;     /* <-- important: white bg */
  display:block;
  margin:0 auto;
  box-shadow: 0 2px 0 rgba(0,0,0,0.04);
}

/* spacing: name -> country -> follow all have same small gaps */
.artist-name {
  font-weight:700;
  margin-top:10px;
  margin-bottom:6px;       /* gap between name and country */
  white-space:nowrap;
  overflow:hidden;
  text-overflow:ellipsis;
  font-size:0.98rem;
  width:100%;
}

.artist-country {
  color:#6c757d;
  margin-bottom:6px;       /* SAME gap between country and follow */
  font-size:0.92rem;
}

/* follow wrapper: remove margin-top:auto so button sits right below country with equal gap */
.seller-follow-wrapper {
  margin-top:6px;          /* equal spacing */
  display:flex;
  justify-content:center;
  width:100%;
  padding-top:0;
  box-sizing:border-box;
}

/* compact follow button */
.seller-follow-btn{
  display:inline-flex;
  align-items:center;
  gap:8px;
  min-width:110px;
  max-width:160px;
  height:32px;
  padding:0 10px;
  border-radius:20px !important;
  background:#ffffff;
  color:#000000;
  border:1px solid #000000;
  font-weight:700;
  text-decoration:none;
  justify-content:center;
  font-size:0.85rem;
}

/* icon inherits text color */
.seller-follow-btn i{ color:currentColor; font-size:14px; }

/* hover invert */
.seller-follow-btn:hover,
.seller-follow-btn:focus {
  background:#000000;
  color:#ffffff;
  border-color:#000000;
  text-decoration:none;
}

</style>

@php
    $visibleCount = 6;
    try {
        $best_selers = get_best_sellers($visibleCount);
        $best_selers = collect($best_selers);
    } catch (\Throwable $e) {
        \Log::error('get_best_sellers error: ' . $e->getMessage());
        $best_selers = collect();
    }

    if ($best_selers->isEmpty()) {
        try {
            $best_selers = \App\Models\Seller::where('status', 1)
                                ->take($visibleCount)
                                ->get();
        } catch (\Throwable $e) {
            \Log::error('Fallback seller query error: ' . $e->getMessage());
            $best_selers = collect();
        }
    }
@endphp

@if($best_selers->isNotEmpty())
<section class="home-artists">
  <div class="container">
    <div class="artists-header">
      <!--<h2 class="section-title mb-0">{{ translate('Discover Similar Artists') }}</h2>-->
       <div 
    style="margin:0 0 12px;
           font:700 22px/1.2 system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
           line-height:1.05;">
    {{ translate('Discover Similar Artists') }}
</div>


      {{-- top-right "All Artists ›" link --}}
      <a href="{{ route('sellers') }}" class="all-artists-link" aria-label="All Artists">
        <span>{{ translate('All Artists') }}</span>
<i class="las la-angle-right" style="color:#000; font-size:14px; margin-left:4px;"></i>

      </a>
    </div>

    <div class="artists-grid">
      @foreach ($best_selers->take($visibleCount) as $seller)
        @php
          $works = $seller->products_count ?? $seller->works_count ?? 0;
          $logoUrl = static_asset('assets/img/placeholder-rect.jpg');
          if (!empty($seller->logo)) {
              try {
                  $ua = uploaded_asset($seller->logo);
                  if (!empty($ua)) { $logoUrl = $ua; }
                  elseif (filter_var($seller->logo, FILTER_VALIDATE_URL)) { $logoUrl = $seller->logo; }
                  else {
                      if (file_exists(public_path($seller->logo))) { $logoUrl = asset($seller->logo); }
                      else { try { $logoUrl = \Illuminate\Support\Facades\Storage::url($seller->logo); } catch (\Throwable $ex) {} }
                  }
              } catch (\Throwable $e) {
                  if (filter_var($seller->logo, FILTER_VALIDATE_URL)) { $logoUrl = $seller->logo; }
                  else { try { $logoUrl = asset($seller->logo); } catch (\Throwable $ex) {} }
              }
          }
        @endphp

        <div class="artist-card" aria-label="{{ $seller->name ?? '' }}">
          {{-- clickable area: avatar + name + country --}}
          <a href="{{ route('shop.visit', $seller->slug ?? route('sellers')) }}" style="text-decoration:none;color:inherit;display:block;width:100%;">
            <div class="artist-avatar">
              <img src="{{ $logoUrl }}"
                   alt="{{ e($seller->name ?? 'Seller') }}"
                   onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
            </div>

            <div class="artist-name">
              {{ ucwords(strtolower($seller->name ?? '—')) }}
            </div>

            @if(!empty($seller->country))
              <div class="artist-country">
                {{ ucfirst(strtolower($seller->country)) }}
              </div>
            @endif
          </a>

          {{-- Follow button (outside main link) --}}
          <!--@php
            $sellerFollowers = 0;
            try {
                if (!empty($seller->followers) && (is_array($seller->followers) || $seller->followers instanceof \Countable)) {
                    $sellerFollowers = count($seller->followers);
                } else {
                    $sellerFollowers = $seller->followers_count ?? 0;
                }
                $sellerFollowers = ($sellerFollowers ?? 0) + ($seller->custom_followers ?? 0);
            } catch (\Throwable $e) {
                $sellerFollowers = $seller->followers_count ?? ($seller->custom_followers ?? 0) ?? 0;
            }
          @endphp-->

          <!--<div class="seller-follow-wrapper">
            @if(in_array($seller->id, $followed_sellers ?? []))
              <a href="{{ route('followed_seller.remove', ['id' => $seller->id]) }}"
                 class="seller-follow-btn"
                 title="{{ translate('Unfollow Seller') }}">
                 <i class="las la-check" aria-hidden="true"></i>
                 <span>{{ translate('Followed') }}</span>&nbsp;({{ $sellerFollowers }})
              </a>
            @else
              <a href="{{ route('followed_seller.store', ['id' => $seller->id]) }}"
                 class="seller-follow-btn"
                 title="{{ translate('Follow Seller') }}">
                 <i class="las la-plus" aria-hidden="true"></i>
                 <span>{{ translate('Follow') }}</span>&nbsp;({{ $sellerFollowers }})
              </a>
            @endif
          </div>-->
        </div>
      @endforeach
    </div> <!-- /.artists-grid -->
  </div> <!-- /.container -->
</section>
@else
  <div class="container"><div class="text-muted py-2">No sellers available right now.</div></div>
@endif
