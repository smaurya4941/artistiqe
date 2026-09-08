@php $wishlistCount = get_wishlists()->count(); @endphp

<a href="{{ route('wishlists.index') }}" class="d-flex align-items-center text-dark" 
   data-toggle="tooltip" data-title="{{ translate('Wishlist') }}" data-placement="top">
  <span class="position-relative d-inline-block">
    <svg class="icon-heart {{ $wishlistCount > 0 ? 'filled' : '' }}" 
         xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="22" height="22">
      <path d="M12 21s-6.5-4.35-9-7.5C1 10 3 5 7.5 5
               9.8 5 12 7 12 7s2.2-2 4.5-2
               C21 5 23 10 21 13.5
               18.5 16.65 12 21 12 21z"/>
    </svg>

    @if($wishlistCount > 0)
      <span class="badge badge-primary badge-inline badge-pill absolute-top-right--10px">
        {{ $wishlistCount }}
      </span>
    @endif
  </span>
</a>
<style>
/* base heart: black outline only */
.icon-heart path {
  fill: none;
  stroke: #000;
  stroke-width: 1.8;
  stroke-linejoin: round;
  stroke-linecap: round;
  transition: fill .18s ease, stroke .18s ease, transform .18s ease;
  transform-origin: center;
}

/* filled heart (when wishlist has items) */
.icon-heart.filled path {
  fill: #e62e04;
  stroke: #e62e04;
}

/* optional: subtle animation */
.icon-heart.filled {
  transform: scale(1.05);
}
</style>