<!-- === Explore Similar Art — match Discover Similar Artists spacing/containers === -->
<div class="bg-white mb-4 position-relative">
  <div class="container"> <!-- same container as artists -->
    <div class="row">
      <div class="col-12">
        <!-- header (mirrors artists header spacing & title style) -->
       <div class="d-flex justify-content-between mb-3">

          <div style="margin:0 0 12px;
                      font:700 22px/1.2 system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
                      line-height:1.05;">
            {{ translate('Explore Similar Art') }}
          </div>

          <div class="top-sellers-controls d-flex align-items-center" style="gap:8px;">
            <button id="topSellersPrev" class="btn-nav" aria-label="Previous" title="Previous">
              <i class="las la-angle-left"></i>
            </button>
            <button id="topSellersNext" class="btn-nav" aria-label="Next" title="Next">
              <i class="las la-angle-right"></i>
            </button>
          </div>
        </div>

        <!-- grid wrapper: uses same left gutter as title (no extra px-3) -->
        <div class="explore-grid-wrapper pb-4">
          <div id="topSellersTrack" class="explore-grid">
            @foreach (get_best_selling_products(6, $detailedProduct->user_id) as $key => $top_product)
              @if($loop->index >= 5) @break @endif

              @php
                $artist_shop_url = route('sellers');
                try {
                  if (!empty($top_product->user) && !empty($top_product->user->shop) && !empty($top_product->user->shop->slug)) {
                    $artist_shop_url = route('shop.visit', $top_product->user->shop->slug);
                  }
                } catch (\Throwable $e) { $artist_shop_url = route('sellers'); }
              @endphp

              <div class="explore-card"> 
                <div class="explore-img">
                  <a href="{{ route('product', $top_product->slug) }}" class="d-block text-reset">
                    <img class="img-fit lazyload"
                         src="{{ static_asset('assets/img/placeholder.jpg') }}"
                         data-src="{{ uploaded_asset($top_product->thumbnail_img) }}"
                         alt="{{ $top_product->getTranslation('name') }}"
                         onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                  </a>
                </div>

                <div class="explore-info p-2">
                  <div class="d-flex align-items-start justify-content-between mb-1">
                    <h6 class="fs-13 fw-600 text-truncate mb-0" title="{{ $top_product->getTranslation('name') }}">
                      {{ $top_product->getTranslation('name') }}
                    </h6>

                    <button class="wishlist-icon ml-2"
                            onclick="this.classList.toggle('active'); addToWishList({{ $top_product->id }});"
                            aria-label="{{ translate('Add to wishlist') }}" title="{{ translate('Add to wishlist') }}">
                      <svg class="heart-outline" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"
                              fill="none" stroke="#000" stroke-width="1.4"/>
                      </svg>
                      <svg class="heart-filled" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24">
                        <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"
                              fill="#e62e04"/>
                      </svg>
                    </button>
                  </div>

                  <div class="d-flex align-items-center mb-1 text-muted fs-12">
                    <svg class="artist-gold-icon mr-1" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" aria-hidden="true">
                      <path fill="#C59D28" d="M12 2l2.6 5.27L20 8.27l-4 3.9.94 5.5L12 15.77 7.06 17.77 8 12.27 4 8.37l5.4-.99L12 2z"/>
                    </svg>

                    @if ($top_product->user && $top_product->user->name)
                      <a href="{{ $artist_shop_url }}" class="ts-artist-link">
                        {{ $top_product->user->name }}
                      </a>
                    @else
                      <span>{{ translate('Unknown Artist') }}</span>
                    @endif
                  </div>

                  <div class="d-flex align-items-center">
                    <span class="fs-14 fw-700 text-primary">{{ home_discounted_base_price($top_product) }}</span>
                    @if(home_price($top_product) != home_discounted_price($top_product))
                      <del class="fs-13 fw-700 opacity-60 ml-2">{{ home_price($top_product) }}</del>
                    @endif
                  </div>
                </div>
              </div><!-- /.explore-card -->
            @endforeach
          </div><!-- /.explore-grid -->
        </div><!-- /.explore-grid-wrapper -->

      </div><!-- /.col-12 -->
    </div><!-- /.row -->
  </div><!-- /.container -->
</div><!-- /.bg-white -->


<style>
/* Grid */
.top-sellers-wrapper { width: 100%; overflow: hidden; position: relative; }
.top-sellers-track {
  display: grid;
  grid-auto-flow: column;
  grid-auto-columns: var(--card-size, 200px);
  gap: 12px;
  overflow-x: auto;
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
}
.top-seller-card { background:#fff; border:none; border-radius:8px; display:flex; flex-direction:column; }
.top-seller-img { width:100%; padding-top:100%; position:relative; overflow:hidden; background:#f8f8f8; }
.top-seller-img img { position:absolute; top:0; left:0; width:100%; height:100%; object-fit:cover; }
.top-seller-info { min-height:90px; }

/* Artist link */
.ts-artist-link { color:#6b7280; text-decoration:none; }
.ts-artist-link:hover { text-decoration:underline; }
.artist-gold-icon { vertical-align:middle; }

.wishlist-icon svg.heart-filled { display:none; }
.wishlist-icon.active .heart-outline { display:none; }
.wishlist-icon.active .heart-filled { display:inline-block; }

/* Wishlist Button Reset */
.wishlist-icon {
  background: none;
  border: none;
  padding: 0;
  margin: 0;
  cursor: pointer;
  line-height: 1;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}


/* Controls */
.btn-nav {
  background:transparent !important;
  border:none;
  color:#777;
  font-size:20px;
  width:36px; height:36px;
  display:inline-flex; align-items:center; justify-content:center;
  cursor:pointer;
}
.btn-nav:hover { color:#000; }

/* Responsive */
@media (max-width:575px){ .top-sellers-track{ --card-size:calc((100% - 12px)/2);} }
@media (min-width:576px) and (max-width:991px){ .top-sellers-track{ --card-size:calc((100% - 24px)/3);} }
@media (min-width:992px){ .top-sellers-track{ --card-size:calc((100% - (12px * 4))/5);} }


/* Explore grid — match artists container/gutter */
.explore-grid {
  display: grid;
  grid-auto-flow: column;
  grid-auto-columns: var(--explore-card-size, 200px);
  gap: 18px;
  overflow-x: auto;
  scroll-behavior: smooth;
  -webkit-overflow-scrolling: touch;
  padding: 0;
}

/* Card */
.explore-card {
  background: #fff;
  border: none;
  border-radius: 8px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  width: 100%;
  box-sizing: border-box;
}

/* Square image like artists layout */
.explore-img { width:100%; padding-top:100%; position:relative; overflow:hidden; background:#f8f8f8; }
.explore-img img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }

/* Info */
.explore-info { min-height: 90px; }

/* artist link styling like artists */
.ts-artist-link { color:#6b7280; text-decoration:none; }
.ts-artist-link:hover { text-decoration: underline; }

/* wishlist toggle (no button square) */
.wishlist-icon { background:none; border:none; padding:0; margin:0; cursor:pointer; display:inline-flex; align-items:center; justify-content:center; }
.wishlist-icon .heart-filled { display:none; }
.wishlist-icon.active .heart-outline { display:none; }
.wishlist-icon.active .heart-filled { display:inline-block; }

/* controls look like earlier */
.btn-nav { background:transparent !important; border:none; color:#777; font-size:20px; width:36px; height:36px; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; }
.btn-nav:hover { color:#000; }

/* Responsive sizing: match your artists grid logic but horizontal */
@media (max-width:575px) { .explore-grid { --explore-card-size: calc((100% - 12px) / 2); } }
@media (min-width:576px) and (max-width:991px) { .explore-grid { --explore-card-size: calc((100% - 24px) / 3); } }
@media (min-width:992px) { .explore-grid { --explore-card-size: calc((100% - (18px * 4)) / 5); } }

/* make sure the grid aligns exactly with .container gutters */
.explore-grid-wrapper { width:100%; box-sizing:border-box; padding-left:0; padding-right:0; }

</style>

<script>
document.addEventListener('DOMContentLoaded', function(){
    const track = document.getElementById('topSellersTrack');
    const prev = document.getElementById('topSellersPrev');
    const next = document.getElementById('topSellersNext');

    function getCardWidth(){
        const first = track.querySelector('.top-seller-card');
        if(!first) return 200;
        const style = window.getComputedStyle(track);
        const gap = parseFloat(style.gap)||12;
        return first.getBoundingClientRect().width + gap;
    }

    prev && prev.addEventListener('click', ()=> track.scrollBy({left:-getCardWidth(), behavior:'smooth'}));
    next && next.addEventListener('click', ()=> track.scrollBy({left:getCardWidth(), behavior:'smooth'}));
});
</script>
