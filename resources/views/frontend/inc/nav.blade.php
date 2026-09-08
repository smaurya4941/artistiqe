<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

/* TOP BAR */
.top-bar {
    width:100%;
    height: 100%;
    background: #7b1d0f;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    font-family: Arial, sans-serif;
}


.arrow {
    position: absolute;
    font-size: 18px;
    cursor: pointer;
}

.arrow.left { left: 400px; }
.arrow.right { right: 520px; }

.status {
    position: absolute;
    right: 20px;
    font-size: 20px;
}

/* HEADER */
.main-header {
    background: #fff;
    border-bottom: 1px solid #eee;
    font-family: 'Playfair Display', serif;
}

/* LOGO */
.logo img {
    height: 70px;
    width: 100%;
}

/* NAV */



/* RIGHT */
.header-actions {
    display: flex;
    align-items: center;
    gap: 16px;
}

.header-actions i {
    font-size: 16px;
    cursor: pointer;
}

/* BUTTONS */
.btn-outline {
    padding: 6px 14px;
    border: 1px solid #ccc;
    border-radius: 20px;
    font-size: 13px;
    text-decoration: none;
    color: #111;
}

.btn-dark {
    padding: 6px 14px;
    background: #111;
    color: #fff;
    border-radius: 20px;
    font-size: 13px;
    text-decoration: none;
}

/* RESPONSIVE */
@media (max-width: 992px) {
    .nav-menu {
        display: none;
    }
}
/* =========================
   STICKY HEADER – GLOBAL
========================= */

.sticky-header {
    position: sticky;
    top: 0;
    z-index: 9999;          /* slider, content sab ke upar */
    background: #fff;
}

/* Scroll ke time shadow (premium feel) */
.sticky-header.scrolled {
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

/* Page content header ke niche chipke na */
body {
    padding-top: 0; /* safe default */
}
/* =========================
   USER DROPDOWN (HEADER)
========================= */

.user-dropdown {
    position: relative;
    display: inline-block;
}

/* Dropdown menu */
.user-dropdown-menu {
    position: absolute;
    top: 120%;
    right: 0;
    min-width: 160px;
    background: #fff;
    border: 1px solid #eee;
    border-radius: 8px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    list-style: none;
    padding: 6px 0;
    margin: 0;
    opacity: 0;
    visibility: hidden;
    transform: translateY(8px);
    transition: all 0.2s ease;
    z-index: 9999;
}

/* Hover open (desktop) */
.user-dropdown:hover .user-dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* Menu items */
.user-dropdown-menu li a {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 8px 14px;
    font-size: 13px;
    color: #111;
    text-decoration: none;
}

.user-dropdown-menu li a:hover {
    background: #f5f5f5;
}

/* Icon size */
.user-dropdown-menu i {
    font-size: 13px;
    opacity: 0.8;
}

/* Mobile support (click based) */
.user-dropdown.open .user-dropdown-menu {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}
/* =====================
   SEARCH DROPDOWN
===================== */
/* =====================
   HEADER SEARCH – FINAL
===================== */

.header-search {
    position: relative;
    display: flex;
    align-items: center;
}

/* search icon */
.header-search i {
    font-size: 16px;
    cursor: pointer;
}

/* container */
.search-dropdown {
    position: absolute;
    top: 100%;            /* header ke niche */
    right: 0;
    width: 320px;
    background: #fff;
    border-radius: 12px;
    padding: 10px;
    box-shadow: 0 12px 28px rgba(0,0,0,0.15);
    opacity: 0;
    visibility: hidden;
    transform: translateY(6px);
    transition: all .2s ease;
    z-index: 999;
}

/* active state */
.header-search.active .search-dropdown {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

/* input stays in header line visually */
.search-dropdown input {
    width: 100%;
    height: 36px;
    padding: 0 12px;
    font-size: 13.5px;
    border: 1px solid #ddd;
    border-radius: 8px;
    outline: none;
}

/* results */
.search-results {
    list-style: none;
    padding: 0;
    margin: 8px 0 0;
    max-height: 260px;
    overflow-y: auto;
    display: none;
}

.search-results li a {
    display: flex;
    align-items: center;
    padding: 8px 10px;
    font-size: 13.5px;
    color: #222;
    text-decoration: none;
    border-radius: 6px;
    transition: background .15s ease;
}

.search-results li a:hover {
    background: #f3f3f3;
}


</style>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<div class="topbar">
    <div class="left-text">
    </div>
    <div class="sliding-text">
        <div class="topbar-slider">
            <div class="banner-text">
                <a href="#"><span>Artist applications open. Apply now</span><span class="fa fa-solid fa-link"></span></a>
            </div>
            <div class="banner-text">
                <a href="#"><span>Launching Soon</span><span class="fa fa-solid fa-link"></span></a>
            </div>
        </div>
    </div>
    <div class="launching-soon">
        Launching Soon
    </div>
</div>
<div class="top-bar">
    <!--<span class="arrow left">&lt;</span>-->

    

    <!--<span class="arrow right">&gt;</span>-->
    <!--<span class="status"></span>-->
</div>
<!-- hedear -->
<header class="main-header sticky-header">
    <div class="header-container">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="logo">
            @php $header_logo = get_setting('header_logo'); @endphp
            <img src="{{ $header_logo ? uploaded_asset($header_logo) : static_asset('assets/img/newnewlogo.jpeg') }}"
                 alt="{{ env('APP_NAME') }}">
        </a>

        <!-- Navigation -->
        <nav class="nav-menu">
            <a href="#" class="animate-underline-primary">Collections</a>
            <a href="#" class="animate-underline-primary">Program</a>
            <a href="#" class="animate-underline-primary">Event</a>
            <a href="#" class="animate-underline-primary">Publication</a>
            <a href="#" class="animate-underline-primary">Artists</a>
            <a href="#" class="animate-underline-primary">Support</a>
        </nav>

        <!-- Right Actions -->
        <div class="header-actions">
             <!-- Search -->
<div class="header-search" id="headerSearch">
    <i class="fa-solid fa-magnifying-glass" id="searchToggle"></i>

    <div class="search-dropdown">
        <input type="text" id="searchInput" placeholder="Search artworks, artists…">

        <!-- Results will come from DB -->
        <ul class="search-results" id="searchResults"></ul>
    </div>
</div>


            <i class="fa-solid fa-bag-shopping"></i>

            @guest
                <a href="{{ route('user.login') }}" class="btn-outline">LOGIN</a>
                <a href="{{ route('user.registration') }}" class="btn-dark">SIGN UP</a>
            @else
                  <div class="user-dropdown">
            <a href="javascript:void(0)" class="btn-outline user-btn">
                DASHBOARD <i class="fa-solid fa-chevron-down"></i>
            </a>

            <ul class="user-dropdown-menu">
                <li>
                    <a href="{{ route('dashboard') }}">
                        <i class="fa-regular fa-user"></i> Profile
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fa-solid fa-right-from-bracket"></i> Logout
                    </a>
                </li>
            </ul>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </div>
            @endguest
        </div>

    </div>
</header>
<script>
window.addEventListener('scroll', function () {
    const header = document.querySelector('.sticky-header');
    if (!header) return;

    if (window.scrollY > 10) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});

// header dashboard

document.addEventListener("DOMContentLoaded", function () {
    const userBtn = document.querySelector(".user-btn");
    const dropdown = document.querySelector(".user-dropdown");

    if (!userBtn || !dropdown) return;

    userBtn.addEventListener("click", function (e) {
        e.preventDefault();
        dropdown.classList.toggle("open");
    });

    document.addEventListener("click", function (e) {
        if (!dropdown.contains(e.target)) {
            dropdown.classList.remove("open");
        }
    });
});


const searchToggle   = document.getElementById('searchToggle');
const headerSearch  = document.getElementById('headerSearch');
const searchInput   = document.getElementById('searchInput');
const searchResults = document.getElementById('searchResults');
const searchDropdown = document.querySelector('.search-dropdown');

/* 🔹 Open on icon click */
searchToggle.addEventListener('click', function (e) {
    e.stopPropagation();
    headerSearch.classList.toggle('active');
    searchInput.focus();
});

/* 🔹 VERY IMPORTANT: stop clicks inside dropdown */
searchDropdown.addEventListener('click', function (e) {
    e.stopPropagation();
});

/* 🔹 Live DB search */
searchInput.addEventListener('keyup', function () {
    let q = this.value.trim();

    if (q.length < 2) {
        searchResults.style.display = 'none';
        searchResults.innerHTML = '';
        return;
    }

    fetch(`{{ route('search.products') }}?q=${q}`)
        .then(res => res.json())
        .then(data => {
            searchResults.innerHTML = '';

            if (data.length === 0) {
                searchResults.innerHTML = `<li>No products found</li>`;
            } else {
                data.forEach(product => {
                    searchResults.innerHTML += `
                        <li>
                            <a href="/product/${product.slug}">
                                ${product.name}
                            </a>
                        </li>
                    `;
                });
            }

            searchResults.style.display = 'block';
        });
});

/* 🔹 Close only when clicking OUTSIDE */
document.addEventListener('click', function () {
    headerSearch.classList.remove('active');
    searchResults.style.display = 'none';
});
</script>




