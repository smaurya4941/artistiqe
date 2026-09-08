<div class="product-card p-2 border bg-white mb-4">
    <div class="position-relative">
        <!-- Product Image -->
        <a href="{{ route('product', $product->slug) }}">
            <img 
                src="{{ uploaded_asset($product->thumbnail_img) }}" 
                alt="{{ $product->getTranslation('name') }}" 
                class="w-100 img-fluid"
            >
        </a>

        <!-- Wishlist Button -->
        <button 
            class="wishlist-btn position-absolute top-0 end-0 m-2 border-0 bg-transparent" 
            onclick="addToWishList({{ $product->id }})" 
            title="{{ translate('Add to wishlist') }}">
            <i class="la la-heart-o fs-20 text-dark"></i>
        </button>
    </div>

    <!-- Product Info -->
    <div class="mt-2">
        <!-- Title -->
        <h3 class="fs-14 fw-600 mb-1 text-dark">
            <a href="{{ route('product', $product->slug) }}" class="text-reset hov-text-primary">
                {{ $product->getTranslation('name') }}
            </a>
        </h3>

        <!-- Artist / Seller -->
        <p class="artist text-muted mb-1 small">
            @if($product->added_by == 'seller' && $product->user)
                {{ $product->user->name }}
            @else
                Artisqe
            @endif
        </p>

        <!-- Size (optional: static or from attributes) -->
        <p class="size text-muted mb-1 small">
            {{ $product->size ?? '40 x 60 cm' }}
        </p>

        <!-- Price -->
        <p class="price fw-700 text-dark fs-16 mb-0">
            {{ home_discounted_base_price($product) }}
        </p>
    </div>
</div>
