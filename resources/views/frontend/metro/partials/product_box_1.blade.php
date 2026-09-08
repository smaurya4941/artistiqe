@php
    $cart_added = [];
@endphp

<div class="pp-card h-auto bg-white py-3 hov-scale-img">
    <div class="position-relative img-fit overflow-hidden pp-img-wrap">
        @php
            $product_url = route('product', $product->slug);
            if ($product->auction_product == 1) {
                $product_url = route('auction-product', $product->slug);
            }

            // safe shop URL for artist link (fallback)
            $artist_shop_url = route('sellers');
            if (!empty($product->user) && !empty($product->user->shop) && !empty($product->user->shop->slug)) {
                try {
                    $artist_shop_url = route('shop.visit', $product->user->shop->slug);
                } catch (\Throwable $e) {
                    $artist_shop_url = route('sellers');
                }
            }
        @endphp

        <!-- Product Image -->
        <a href="{{ $product_url }}" class="d-block h-100 w-100 pp-img-link">
            <img class="lazyload mx-auto img-fit has-transition pp-img"
                src="{{ get_image($product->thumbnail) }}"
                alt="{{ $product->getTranslation('name') }}"
                title="{{ $product->getTranslation('name') }}"
                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
        </a>

        @if (discount_in_percentage($product) > 0)
            <span class="pp-discount-badge">-{{ discount_in_percentage($product) }}%</span>
        @endif

        @if ($product->wholesale_product)
            <span class="pp-wholesale-badge" style="@if (discount_in_percentage($product) > 0) top:46px; @endif">
                {{ translate('Wholesale') }}
            </span>
        @endif
    </div>

   <div class="p-2 p-md-3 text-left pp-info">
    <!-- Row 1: NAME (left) + WISHLIST (right) -->
    <div class="d-flex align-items-center justify-content-between mb-1 pp-name-row">
        <h3 class="pp-name mb-0">
            <a href="{{ $product_url }}" class="text-reset" title="{{ $product->getTranslation('name') }}">
                {{ $product->getTranslation('name') }}
            </a>
        </h3>

        <button type="button"
                class="pp-wishlist-btn"
                data-product-id="{{ $product->id }}"
                onclick="addToWishList({{ $product->id }}); togglePPWishlist(this);"
                aria-label="Add to wishlist"
                title="{{ translate('Add to wishlist') }}">
            <svg class="pp-heart pp-heart-outline" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                 viewBox="0 0 24 24" role="img" aria-hidden="true">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"
                      fill="none" stroke="#6b7280" stroke-width="1.4"/>
            </svg>
            <svg class="pp-heart pp-heart-filled" xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                 viewBox="0 0 24 24" role="img" aria-hidden="true" style="display:none;">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 0 0 0-7.78z"
                      fill="#e62e04"/>
            </svg>
        </button>
    </div>

    <!-- Row 2: ARTIST -->
    <div class="d-flex align-items-center mb-2 pp-artist-row">
        <svg class="pp-artist-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
             viewBox="0 0 24 24" aria-hidden="true">
            <path fill="#C59D28"
                  d="M12 2l2.6 5.27L20 8.27l-4 3.9.94 5.5L12 15.77 7.06 17.77 8 12.27 4 8.37l5.4-.99L12 2z"/>
        </svg>
        <a href="{{ $artist_shop_url }}" class="pp-artist-link ml-2">
            @if ($product->user && $product->user->name)
                {{ $product->user->name }}
            @else
                {{ translate('Unknown Artist') }}
            @endif
        </a>
    </div>

    <!-- Row 3: PRICE -->
    <div class="pp-price-row">
        @if ($product->auction_product == 0)
            @if (home_base_price($product) != home_discounted_base_price($product))
                <del class="text-secondary mr-2">{{ home_base_price($product) }}</del>
            @endif
            <span class="fw-700 text-primary">{{ home_discounted_base_price($product) }}</span>
        @else
            <span class="fw-700 text-primary">{{ single_price($product->starting_bid) }}</span>
        @endif
    </div>
</div>

</div>

<!-- Scoped styles -->
<style>
.pp-card { border: none; border-radius: 8px; overflow: hidden; background: transparent; display:flex; flex-direction:column; }

/* Image wrapper — consistent square box */
.pp-img-wrap {
    width: 100%;
    padding-top: 100%; /* square */
    position: relative;
    overflow: hidden;
    background: #f8f8f8;
    border-radius: 8px;
}
.pp-img { position:absolute; top:0; left:0; right:0; bottom:0; width:100%; height:100%; object-fit:cover; }

/* badges */
.pp-discount-badge { position:absolute; top:12px; left:12px; background:#e63946; color:#fff; padding:4px 6px; border-radius:4px; font-weight:700; font-size:12px; z-index:6; }
.pp-wholesale-badge { position:absolute; top:12px; left:12px; background:#455a64; color:#fff; padding:4px 6px; border-radius:4px; font-weight:700; font-size:12px; z-index:6; }

/* Info block uses column layout so price can stay consistent at bottom area */
.pp-info { padding-top:12px; padding-bottom:8px; display:flex; flex-direction:column; gap:6px; }

/* Row 1: name + wishlist center aligned vertically */
.pp-name-row { gap: 10px; align-items:center; }

/* Product name */
.pp-name a { color:#111827; font-weight:600; font-size:14px; text-decoration:none; display:block; }

/* Wishlist button */
.pp-wishlist-btn { background:transparent; border:none; padding:4px; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; }
.pp-heart { display:inline-block; vertical-align:middle; }
.pp-wished .pp-heart-outline { display:none !important; }
.pp-wished .pp-heart-filled { display:inline-block !important; }

/* Artist row */
.pp-artist-row { font-size:13px; }
.pp-artist-icon { flex:0 0 16px; width:16px; height:16px; display:inline-block; }
.pp-artist-link { color:#6b7280; text-decoration:none; font-size:13px; }
.pp-artist-link:hover { text-decoration:underline; }

/* Price row: left aligned and not centered vertically */
.pp-price-row { justify-content:flex-start; align-items:center; margin-top:auto; }
.pp-price-left { color:#111827; font-weight:800; font-size:15px; }

/* Defensive: if some templates miss .pp-img-wrap, ensure image sizing won't break layout.
   (We also include a small JS wrapper below to wrap stray images) */
.pp-img-link img { max-width:100%; height:auto; }

/* Small screens */
@media (max-width:575px) {
    .pp-name a { font-size:13px; }
    .pp-artist-link { font-size:12px; }
    .pp-price-left { font-size:14px; }
}
/* Product name: clamp to 1 line with ellipsis */
.pp-name {
  max-width: calc(100% - 28px); /* leave room for wishlist */
}
.pp-name a {
  display: -webkit-box;
  -webkit-line-clamp: 1;    /* show only 1 line */
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: normal;      /* allows ellipsis */
  font-size:14px;
  font-weight:600;
  color:#111827;
}

/* Price row: always left aligned */
.pp-price-row {
  display: flex;
  justify-content: flex-start;
  align-items: center;
  gap: 6px;
  font-size:15px;
  font-weight:700;
  color:#111827;
}
.pp-price-row del {
  font-size:13px;
  color:#6b7280;
}
* 1) Force left alignment for product info area (namespace) */
.pp-card .pp-info,
.pp-card .pp-name-row,
.pp-card .pp-artist-row,
.pp-card .pp-price-row {
  text-align: left !important;
}

/* 2) Info column layout: keep content stacked; price won't float to center */
.pp-info {
  display: flex;
  flex-direction: column;
  align-items: stretch;      /* important: stretch children width so left alignment works */
  justify-content: flex-start;
  min-height: 110px;        /* adjust to your needs; keeps spacing consistent */
  gap: 6px;
  box-sizing: border-box;
}

/* 3) Product name: allow truncation and ensure it starts at left */
.pp-name-row { display:flex; align-items:center; justify-content:space-between; gap:10px; }
.pp-name { flex: 1 1 auto; min-width: 0; } /* min-width:0 lets truncation work inside flex */
.pp-name a {
  display: -webkit-box;
  -webkit-line-clamp: 1;           /* clamp to 1 line */
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: normal;
  text-align: left !important;
  color: #111827;
  font-weight: 600;
  font-size: 14px;
}

/* 4) Wishlist button shouldn't push text; keep it fixed on the right */
.pp-wishlist-btn { flex: 0 0 auto; margin-left: 8px; }

/* 5) Artist row keep left alignment, no uppercase */
.pp-artist-row { display:flex; align-items:center; gap:8px; color:#6b7280; }
.pp-artist-link { color:#6b7280; text-decoration:none; }
.pp-artist-link:hover { text-decoration: underline; }

/* 6) Price row: ALWAYS left aligned and near the artist row (no centering) */
.pp-price-row {
  display:flex;
  justify-content:flex-start;
  align-items:center;
  gap:8px;
  margin-top: 0 !important;
  order: 3;         /* ensure it sits after artist row */
  align-self: stretch;
}
.pp-price-left { font-weight:800; color:#111827; font-size:15px; }

/* 7) Ensure image fills the square wrapper */
.pp-img-wrap { position: relative; overflow: hidden; border-radius: 8px; }
.pp-img-wrap img, .pp-img {
  position: absolute !important;
  top: 0 !important;
  left: 0 !important;
  right: 0 !important;
  bottom: 0 !important;
  width: 100% !important;
  height: 100% !important;
  object-fit: cover !important;
}

/* 8) Defensive: if some parent forces text-center, re-enforce left for the main elements */
.pp-card, .pp-card .pp-info, .pp-card .pp-name, .pp-card .pp-artist-row, .pp-card .pp-price-row {
  text-align: left !important;
}

/* Responsive smaller text */
@media (max-width:575px) {
  .pp-name a { -webkit-line-clamp: 1; font-size:13px; }
  .pp-artist-link { font-size:12px; }
  .pp-price-left { font-size:14px; }
}
</style>

<!-- Small helpers: auto-wrap stray images and wishlist visual toggle -->
<script>
// Auto-wrap images that are not inside .pp-img-wrap (fix templates that missed wrapper)
(function() {
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.pp-card').forEach(function(card) {
            // if card has image not inside pp-img-wrap, wrap it
            const img = card.querySelector('img.pp-img, img');
            if (img) {
                const wrapper = card.querySelector('.pp-img-wrap');
                if (!wrapper) {
                    // create wrapper and move existing image/link inside
                    const newWrap = document.createElement('div');
                    newWrap.className = 'pp-img-wrap';
                    // find nearest link that contains image
                    const link = img.closest('a');
                    if (link) {
                        link.parentNode.insertBefore(newWrap, link);
                        newWrap.appendChild(link);
                    } else {
                        img.parentNode.insertBefore(newWrap, img);
                        newWrap.appendChild(img);
                    }
                } else {
                    // ensure image has class pp-img for consistent CSS
                    img.classList.add('pp-img');
                }
            }
        });
    });
})();

// Visual toggle for wishlist button (fills heart)
(function () {
    window.togglePPWishlist = function(btn) {
        if (!btn) return;
        // toggle visual class on the button
        btn.classList.toggle('pp-wished');
        // also toggle on the card if needed
        const card = btn.closest('.pp-card');
        if (card) card.classList.toggle('pp-wished-card');
    };
})();

// Defensive JS to wrap stray images and ensure absolute positioning + to reflow layout.
// This does not change backend or event handlers - only fixes DOM structure/inline styles.
(function () {
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.pp-card').forEach(function (card) {
      // 1) Ensure there is a .pp-img-wrap and the image is inside it
      let wrap = card.querySelector('.pp-img-wrap');
      const img = card.querySelector('img');
      if (!wrap && img) {
        // Create wrapper and move the image's link (if present) or image itself inside it
        wrap = document.createElement('div');
        wrap.className = 'pp-img-wrap';
        const possibleLink = img.closest('a');
        if (possibleLink && card.contains(possibleLink)) {
          possibleLink.parentNode.insertBefore(wrap, possibleLink);
          wrap.appendChild(possibleLink);
        } else {
          img.parentNode.insertBefore(wrap, img);
          wrap.appendChild(img);
        }
      }
      // 2) Make sure the image has the pp-img class and forced inline styles
      const insideImg = wrap ? wrap.querySelector('img') : img;
      if (insideImg) {
        insideImg.classList.add('pp-img');
        // force object-fit cover positioning if CSS wasn't applied yet
        insideImg.style.position = 'absolute';
        insideImg.style.top = '0';
        insideImg.style.left = '0';
        insideImg.style.width = '100%';
        insideImg.style.height = '100%';
        insideImg.style.objectFit = 'cover';
      }

      // 3) Force name and price left alignment (in case other rules override)
      const nameLink = card.querySelector('.pp-name a');
      if (nameLink) nameLink.style.textAlign = 'left';

      const priceRow = card.querySelector('.pp-price-row');
      if (priceRow) {
        priceRow.style.justifyContent = 'flex-start';
        priceRow.style.textAlign = 'left';
      }
    });
    // small reflow after images load to avoid layout jumps
    window.requestAnimationFrame(function(){ window.dispatchEvent(new Event('resize')); });
  });
})();
</script>
