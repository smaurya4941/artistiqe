@php
    $roleLabels = ['artist' => 'Artist Dashboard', 'collector' => 'Collector Dashboard', 'gallery' => 'Gallery Dashboard'];
@endphp
<aside class="ac-side">
    <div class="brand">
        Artisti<span>Q</span>e
        <div class="role">{{ $roleLabels[$role] ?? 'Member' }}</div>
    </div>

    <ul class="ac-menu">
        <li>
            <a href="{{ route($role . '.dashboard') }}" class="{{ request()->routeIs($role . '.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-border-all"></i> <span>Overview</span>
            </a>
        </li>

        @if($role === 'artist')
            <li>
                <a href="{{ route('artist.artworks.index') }}" class="{{ request()->routeIs('artist.artworks.*') ? 'active' : '' }}">
                    <i class="fa-regular fa-image"></i> <span>My Artworks</span>
                </a>
            </li>
            <li>
                <a href="{{ route('artist.artwork.create') }}" class="{{ request()->routeIs('artist.artwork.create') ? 'active' : '' }}">
                    <i class="fa-solid fa-plus"></i> <span>Upload Artwork</span>
                </a>
            </li>
        @else
            <li>
                <a href="{{ route('purchase_history.index') }}">
                    <i class="fa-solid fa-cart-shopping"></i> <span>My Orders</span>
                </a>
            </li>
            <li>
                <a href="{{ route('wishlists.index') }}">
                    <i class="fa-regular fa-heart"></i> <span>Wishlist</span>
                </a>
            </li>
        @endif

        <li>
            <a href="{{ route($role . '.profile') }}" class="{{ request()->routeIs($role . '.profile') ? 'active' : '' }}">
                <i class="fa-regular fa-user"></i> <span>Profile</span>
            </a>
        </li>
        <li>
            <a href="{{ route('home') }}">
                <i class="fa-solid fa-house"></i> <span>Back to Store</span>
            </a>
        </li>
    </ul>

    <div class="ac-logout">
        <a href="{{ url('/logout') }}"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    </div>
</aside>
