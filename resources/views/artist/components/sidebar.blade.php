<aside class="artist-sidebar">
    <div class="sidebar-top">
        <h2 class="brand">Artisti<span>Q</span>e</h2>
        <p class="subtitle">ARTIST DASHBOARD</p>
    </div>

    <ul class="sidebar-menu">
        <li class="active">
            <a href="{{ route('artist.dashboard') }}">
                <i class="fa-solid fa-border-all"></i>
                <span>Overview</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-regular fa-image"></i>
                <span>My Artworks</span>
            </a>
        </li>

        <li class="{{ request()->routeIs('artist.artwork.create') ? 'active' : '' }}">
    <a href="{{ route('artist.artwork.create') }}">
        <i class="fa-solid fa-plus"></i>
        <span>Upload Artwork</span>
    </a>
</li>

        <li>
            <a href="#">
                <i class="fa-solid fa-dollar-sign"></i>
                <span>Pricing & Earnings</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-solid fa-cart-shopping"></i>
                <span>Orders & Sales</span>
            </a>
        </li>

        <li>
            <a href="#">
                <i class="fa-regular fa-credit-card"></i>
                <span>Payouts</span>
            </a>
        </li>

        <li>
            <a href="{{ route('artist.profile') }}">
                <i class="fa-regular fa-user"></i>
                <span>Profile</span>
            </a>
        </li>
    </ul>

    <div class="sidebar-bottom">
        <a href="#" class="foundation">
            <i class="fa-regular fa-square"></i>
            <span>Design Foundations</span>
        </a>
    </div>
</aside>
