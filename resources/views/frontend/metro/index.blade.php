@extends('frontend.layouts.app')

@section('content')


    <style>
        #section_featured .slick-slider .slick-list{
            background: #fff;
        }
        #section_featured .slick-slider .slick-list .slick-slide {
            margin-bottom: -5px;
        } 
        @media (max-width: 575px){
            #section_featured .slick-slider .slick-list .slick-slide {
                margin-bottom: -4px;
            }
        }
    </style>

    @php $lang = get_system_language()->code;  @endphp
    
    <!-- ============ HEADER (place BEFORE hero section) ============ -->
<!-- NAV: Buy Art vertical dropdown + Browse Art flyout right (style + blade + script) -->
<style>
  .art-nav__menu { position: relative; z-index: 1200; }
  #navPush { display: none !important; }

  /* Buy Art dropdown */
  .art-dropdown {
    position: absolute;
    top: 100%;
    left: 0;
    width: 240px;
    display: none;
    background: #fff;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    padding: 4px 0;
    font-size: 11px;    /* small text only in dropdowns */
    line-height: 1.3;
  }
  .art-has-dropdown.open > .art-dropdown { display: block !important; }
  @media (hover: hover) and (min-width: 992px) {
    .art-has-dropdown:hover > .art-dropdown { display: block !important; }
  }

  /* Browse Art flyout */
  .art-submenu {
    position: absolute;
    top: 0;
    left: 100%;        /* flyout to the right */
    min-width: 280px;
    display: none;
    background: #fff;
    border: 1px solid rgba(0,0,0,0.06);
    box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    padding: 8px 12px;
    font-size: 11px;
  }
  .art-has-sub.open > .art-submenu { display: block !important; }
  @media (hover: hover) and (min-width: 992px) {
    .art-has-sub:hover > .art-submenu { display: block !important; }
  }

  /* lists compact */
  .art-dropdown__list, .art-submenu__list { list-style: none !important; margin: 0 !important; padding: 0 !important; }
  
  
  .art-dropdown__link,
.art-dropdown__item > a,
.art-submenu__item > a {
  display: block;
  padding: 6px 10px;
  text-decoration: none;
  color: inherit;
  background: transparent;
  border: 0;
  width: 100%;
  text-align: left;
  cursor: pointer;
  font-size: 11px;
}

  .art-dropdown__item > a:hover,
  .art-dropdown__item > button:hover,
  .art-submenu__item > a:hover { background: rgba(0,0,0,0.04); }

  .art-submenu__cols { display: flex; gap: 20px; }
  .art-submenu__cols > div { min-width: 120px; }
  .art-submenu__title { margin: 0 0 6px 0; font-size: 11px; font-weight: 600; }

  /* Mobile: dropdowns stack */
  @media (max-width: 991px) {
    .art-dropdown, .art-submenu {
      position: static;
      box-shadow: none;
      border: none;
      width: 100%;
    }
    .art-dropdown, .art-submenu { display: none; }
    .art-has-dropdown.open > .art-dropdown,
    .art-has-sub.open > .art-submenu { display: block !important; }
  }

  /* normal nav links (Buy, Sell, Artist Registration*) */
  .art-link { background: transparent; border: 0; padding: 10px 12px; cursor: pointer; text-decoration: none; color: inherit; }
  /* ðŸ”¥ Force remove bullets in Buy Art + Browse Art dropdowns */
.art-dropdown ul,
.art-dropdown li,
.art-submenu ul,
.art-submenu li {
  list-style: none !important;
  margin: 0 !important;
  padding: 0 !important;
}
/* Force Browse Art button to look like link (same as Your Order) */
.art-dropdown__item > button.art-dropdown__link {
  all: unset !important;         /* remove default button styles */
  display: block !important;
  width: 100% !important;
  text-align: left !important;
  padding: 6px 10px !important;
  font-size: 11px !important;
  cursor: pointer !important;
  background: transparent !important;
  color: inherit !important;
  text-decoration: none !important;
  line-height: 1.3 !important;
}

.art-dropdown__item > button.art-dropdown__link:hover {
  background: rgba(0,0,0,0.04) !important;
}
.art-nav {
  border-top: 2px solid #000;
}
.art-nav__item {
  position: relative;
}

.art-dropdown {
  display: none;
  position: absolute;
  top: 100%;
  left: 0;
  background: #fff;
  padding: 10px 0;
  min-width: 180px;
  border: 1px solid #ddd;
  z-index: 1000;
}

.art-dropdown li a {
  display: block;
  padding: 8px 15px;
  color: #000;
  white-space: nowrap;
}

.art-dropdown li a:hover {
  background: #f2f2f2;
}

/* hover to show */
.art-has-dropdown:hover > .art-dropdown {
  display: block;
}


</style>




<div id="navPush" class="nav-push" aria-hidden="true"></div>
<div id="artNavStage" class="art-nav__stage"></div>

<script>
(function () {

  document.addEventListener("DOMContentLoaded", function () {

    /* ========= HERO SLIDER ========= */
    let current = 0;
    const slides = document.querySelectorAll(".hero-slider .slide");
    const dots   = document.querySelectorAll(".hero-slider .dot");

    if (!slides.length) return;

    function showSlide(index) {
      slides.forEach((s, i) => s.classList.toggle("active", i === index));
      dots.forEach((d, i) => d.classList.toggle("active", i === index));
      current = index;
    }

    dots.forEach((dot, i) => {
      dot.addEventListener("click", () => showSlide(i));
    });

    setInterval(() => {
      current = (current + 1) % slides.length;
      showSlide(current);
    }, 3000);

    /* ========= OPTIONAL NAV SAFE ========= */
    const burger = document.getElementById("artNavBurger");
    const menu   = document.getElementById("artNavMenu");

    if (burger && menu) {
      burger.addEventListener("click", () => {
        burger.classList.toggle("open");
        menu.classList.toggle("open");
      });
    }

    const searchBtn = document.getElementById("artSearchBtn");
    const searchInput = document.getElementById("artSearchInput");

    if (searchBtn && searchInput) {
      searchBtn.addEventListener("click", () => {
        searchInput.classList.toggle("active");
        if (searchInput.classList.contains("active")) {
          searchInput.focus();
        }
      });
    }

  });

})();
</script>






    <!-- HERO SECTION AND SEARCH BAR -->
  <style>
  
.hero-slider {
    max-width: 1200px;
    height:640;
    margin: 30px auto;
    position: relative;
}

.slides {
     max-width: 1200px;
    height:640;
    border-radius: 12px;
    overflow: hidden;
}

.slide {
    width: 100%;
    height: 640px;
    object-fit: cover;
    display: none;          /* IMPORTANT */
}

.slide.active {
    display: block;        /* IMPORTANT */
}

/* dots */
.slider-dots {
    display: flex;
    justify-content: center;
    gap: 10px;
    margin-top: 14px;
}

.dot {
    width: 8px;
    height: 8px;
    background: #ddd;
    border-radius: 50%;
    cursor: pointer;
}

.dot.active {
    background: #333;
}

@media (max-width: 768px) {
    .slide {
        height: 260px;
    }
}




/* =========================
   ABOUT ARTISTIQE SECTION
========================= */

.about-section {
    background: #f7f3ec;   /* image jaisa soft beige */
    padding: 90px 20px;
}

.about-container {
    max-width: 900px;
    margin: auto;
    text-align: center;
    font-family: 'Playfair Display', serif;
}

.about-container h2 {
    font-size: 30px;
    letter-spacing: 1px;
    margin-bottom: 30px;
    color: #000;
}

.about-container p {
    font-size: 15px;
    line-height: 1.8;
    color: #111;
    margin-bottom: 22px;
    font-family: Arial, sans-serif;
}

.about-container .highlight {
    margin-top: 30px;
    font-weight: 600;
}

/* Button */
.about-btn {
    display: inline-block;
    margin-top: 30px;
    padding: 10px 22px;
    border: 1px solid #c66;
    border-radius: 6px;
    font-size: 13px;
    text-decoration: none;
    color: #000;
    background: transparent;
    transition: all 0.25s ease;
}

.about-btn:hover {
    background: #7b1d0f;
    color: #fff;
    /*border-color: #7b1d0f;*/
}

/* Responsive */
@media (max-width: 768px) {
    .about-section {
        padding: 60px 15px;
    }

    .about-container h2 {
        font-size: 24px;
    }

    .about-container p {
        font-size: 14px;
    }
}

</style>

<section>
  <!-- https://artistiqe.com/public/assets/img/heroimg.png 
  {{ asset('img/logo1.png') }}-->
<div class="hero-slider">
    <div class="slides">
        <img src="{{ static_asset('assets/img/banr1.jpeg') }}" class="slide active">
        <img src="{{ static_asset('assets/img/bnr2.jpeg') }}" class="slide">
        <img src="{{ static_asset('assets/img/bnr3.jpeg') }}" class="slide">
        <img src="{{ static_asset('assets/img/bnr4.jpeg') }}" class="slide">
    </div>

    <!-- Dots -->
    <div class="slider-dots">
        <span class="dot active"></span>
        <span class="dot"></span>
        <span class="dot"></span>
        <span class="dot"></span>
    </div>
</div>

</section>

<section class="about-section">
    <div class="about-container">

        <h2>ABOUT ARTISTIQE</h2>

        <p>
            ArtistiQe is a global space where artists, collectors, and art appreciators
            meet with ease, curiosity, and a shared respect for the quiet joy of engaging
            with art. Shaped by thoughtful curation, honest dialogue, and the belief
            that art becomes truly meaningful when it is held collectively.
        </p>

        <p>
            Our community welcomes every kind of journey—emerging artists finding their
            voice, students discovering their path, collectors beginning their exploration,
            and cultural seekers looking for deeper connection. Each person adds to the
            rhythm of this space, allowing it to grow gently and authentically.
        </p>

        <p>
            We support artists through visibility, guidance, and opportunities, while
            offering collectors a way to discover artworks that feel personal and
            thoughtfully connected. By creating room for learning, stories, and shared
            experiences.
        </p>

        <p>
            ArtistiQe hopes to bridge the gap between artistic journeys and the people who
            appreciate them. ArtistiQe is more than a platform; it is a growing ecosystem
            that honors the artistic process and makes the art world feel open, human,
            and accessible globally.
        </p>

        <p class="highlight">
            Here, every journey finds a place to belong.<br>
            <strong>Curating tomorrow’s art world, together.</strong>
        </p>

        <a href="#" class="about-btn">Discover More</a>

    </div>
</section>

<!-- Featured Products -->
    <div id="section_featured" class="pt-2 pt-md-3" style="background: #ffffff;"></div>

    </div>

    @if (addon_is_activated('preorder'))

        <!-- Preorder Banner 1 -->
        @php $homepreorder_banner_1Images = get_setting('home_preorder_banner_1_images', null, $lang);   @endphp
        @if ($homepreorder_banner_1Images != null)
            <div class="mb-2 mb-md-3 mt-2 mt-md-3">
                <div class="container">
                    @php
                        $banner_2_imags = json_decode($homepreorder_banner_1Images);
                        $data_md = count($banner_2_imags) >= 2 ? 2 : 1;
                        $home_preorder_banner_1_links = get_setting('home_preorder_banner_1_links', null, $lang);
                    @endphp
                    <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                        data-items="{{ count($banner_2_imags) }}" data-xxl-items="{{ count($banner_2_imags) }}"
                        data-xl-items="{{ count($banner_2_imags) }}" data-lg-items="{{ $data_md }}"
                        data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true"
                        data-dots="false">
                        @foreach ($banner_2_imags as $key => $value)
                            <div class="carousel-box overflow-hidden hov-scale-img">
                                <a href="{{ isset(json_decode($home_preorder_banner_1_links, true)[$key]) ? json_decode($home_preorder_banner_1_links, true)[$key] : '' }}"
                                    class="d-block text-reset overflow-hidden">
                                    <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                        data-src="{{ uploaded_asset($value) }}" alt="{{ env('APP_NAME') }} promo"
                                        class="img-fluid lazyload w-100 has-transition"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif


        <!-- Featured Preorder Products (Art for Sale)-->
        <div id="section_featured_preorder_products">

        </div>
    @endif





<!-- =========================
     CATEGORY LINKS SECTION BANNER
========================= -->
<section class="category-links">
    <div class="container text-center">
        <div class="collection-links__description">
            <p>
                Desire the Uncommon?<br> 
                <span class="no-break">Define with precision, refine with grace, and discover art that speaks only to you.
                </span>
                </p>
        </div>
        <div class="category-links-wrapper">
            <a href="https://artistiqe.com/category/landscapes" class="category-link">Landscapes</a>
            <a href="https://artistiqe.com/category/animals" class="category-link">Animals</a>
            <a href="https://artistiqe.com/category/large%20art" class="category-link">Large Art</a>
            <a href="https://artistiqe.com/category/Monuments-qyv2z" class="category-link">Monuments</a>
            
             <a href="https://artistiqe.com/category/oil%20paintings" class="category-link">Oil Paintings</a>
            
            <a href="https://artistiqe.com/category/sculpture" class="category-link">Sculptures</a>
            
            <a href="https://artistiqe.com/category/Abstract-p0pRC" class="category-link">Abstract</a>

             
            
             
            
             
        </div>
       
    </div>
</section>

<!-- ================= SAFE TOP SELLERS ================= -->
@php
    $visibleCount = 6;

    try {
        $best_selers = collect(get_best_sellers($visibleCount));
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
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Merriweather:wght@400;700&display=swap" rel="stylesheet">

<!-- ================= FEATURED ARTIST ================= -->
<style>
/* =========================
   FEATURED ARTIST SECTION
========================= */
/* =========================
   FEATURED ARTIST – FIXED LAYOUT
========================= */

.featured-artist {
    padding: 90px 0;
    border-bottom: 1px solid #E6E6E6;
}

/* LEFT COLUMN */
.fa-left {
    display: flex;
    flex-direction: column;
   
}

/* TITLE */
.fa-title {
    font-size: 48px;
    font-weight: 800;
    margin-bottom: 50px;
}

/* CONTENT AREA (TEXT GROWS HERE) */
.fa-content {
    flex: 1 1 auto;      /* 🔥 text yahin expand hoga */
    font-size: 30px;
     min-height: 520px; /* 🔥 SAME VISUAL HEIGHT AS IMAGE */
    width:476px;
}

/* TEXT BLOCKS */
.fa-block {
    max-width: 520px;
    margin-bottom: 24px;
    
}

.fa-sub {
    font-size: 24px;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.6px;
    margin-bottom: 6px;
}

.fa-block p {
    color: #777;
    line-height: 1.6;
    margin-bottom: 0;
    
}

/* ACTIONS – ALWAYS AT BOTTOM */
.fa-actions {
    margin-top: auto;   /* 🔥 MAGIC LINE */
    display: flex;
    align-items: center;
    gap: 12px;
}
/* BUTTON GROUP */
.fa-actions .btn {
    border-radius: 10px;
    font-size: 20px;
    font-weight: 600;
    padding: 0;                 /* padding hata di – size control */
    line-height: 1;
    display: inline-flex;       /* 🔥 center trick */
    align-items: center;        /* vertical center */
    justify-content: center;    /* horizontal center */
}

/* VIEW PROFILE */
#fa-profile {
    background-color: #BC1224;
    border-color: #c90000;
    color: #fff;
    width: 185px;
    height: 60px;
}

/* SHOP */


#fa-profile:hover {
    background-color: #a80000;
    border-color: #a80000;
}

/* SHOP (LIGHT TAG STYLE) */
#fa-shop {
    background-color: #E6E6E6;
    border-color: #f1f1f1;
    color: #111;
    width: 108px;
    height: 60px;
}

#fa-shop:hover {
    background-color: #e5e5e5;
    border-color: #e5e5e5;
}

/* IMAGE COLUMN */
.fa-image-wrap {
   width: 623px;
    height: 623px;
    aspect-ratio: 1 / 1;
    margin-left: auto;
    border-radius: 14px;
    overflow: hidden;
    background: #f3f3f3;
}

/* IMAGE */
#fa-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

/* ARROWS */
.fa-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    font-size: 60px;
    color: #aaa;
    cursor: pointer;
    z-index: 10;
   
}

.fa-arrow.left { left: -36px; }
.fa-arrow.right { right: -36px; }

.fa-arrow:hover { color: #111; }

/* MOBILE */
@media (max-width: 991px) {
    .fa-left {
        min-height: auto;
    }

    .fa-image-wrap {
        margin-top: 30px;
    }

    .fa-arrow {
        display: none;
    }
}



</style>

<section class="">
    <div class="container featured-artist">
        <div class="row align-items-stretch">
            <div class="col-lg-12">
                <h2 class="main-title">Featured Artist</h2>
            </div>
            <!-- LEFT -->
            <div class="col-lg-6 position-relative fa-left">

                

                <!-- TEXT AREA -->
                <div class="">

                    <div class="fa-block">
                        <h6 class="sub-title" id="fa-name"></h6>
                        <p id="fa-tagline" class="content"></p>
                    </div>

                    <div class="fa-block">
                        <h6 class="sub-title">About</h6>
                        <p id="fa-about" class="content"></p>
                    </div>

                </div>

                <!-- ACTIONS (FIXED BOTTOM) -->
                <div class="fa-actions">
                    <button class="fa-arrow left" onclick="prevArtist()">‹</button>
                    <a href="#" id="fa-profile" class="btn btn-danger">View Profile</a>
                    <a href="#" id="fa-shop" class="btn btn-light">Shop</a>
                </div>

            </div>

            <!-- RIGHT -->
            <div class="col-lg-6 position-relative">
                <div class="">
                    <img id="fa-image"
                         src=""
                         onerror="this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}'" class="rounded">
                </div>

                <button class="fa-arrow right" onclick="nextArtist()">›</button>
            </div>

        </div>
    </div>
</section>




<script>
   
<!-- ================= PASS DATA TO JS ================= -->

@php
    $featuredArtists = $best_selers->map(function ($s) {
        return [
            'name'    => $s->name,
            'about'   => $s->about ?? 'Artist biography coming soon.',
            'image'   => $s->logo ? uploaded_asset($s->logo) : static_asset('assets/img/placeholder-rect.jpg'),
            'profile' => route('shop.visit', $s->slug),
            'shop'    => route('shop.visit', $s->slug),
        ];
    })->values();
@endphp


    window.featuredArtists = @json($featuredArtists);


let currentIndex = 0;

function renderArtist(index) {
    const a = window.featuredArtists[index];
    document.getElementById('fa-name').innerText = a.name;
    document.getElementById('fa-about').innerText = a.about;
    document.getElementById('fa-tagline').innerText = "Contemporary Visual Artist";
    document.getElementById('fa-image').src = a.image;
    document.getElementById('fa-profile').href = a.profile;
    document.getElementById('fa-shop').href = a.shop;
}

function nextArtist() {
    currentIndex = (currentIndex + 1) % featuredArtists.length;
    renderArtist(currentIndex);
}

function prevArtist() {
    currentIndex = (currentIndex - 1 + featuredArtists.length) % featuredArtists.length;
    renderArtist(currentIndex);
}

document.addEventListener('DOMContentLoaded', () => {
    renderArtist(0);
});
</script>

<!-- ================= ARTISTS GRID ================= -->
<section class="home-artists">
    <div class="container">
        <!-- <h2 class="section-title mb-3">{{ translate('Artists') }}</h2> -->

        <div class="artists-grid">
            @foreach ($best_selers->take($visibleCount) as $seller)

                @php
                    $logoUrl = static_asset('assets/img/placeholder-rect.jpg');

                    if (!empty($seller->logo)) {
                        try {
                            $logoUrl = uploaded_asset($seller->logo) ?: $logoUrl;
                        } catch (\Throwable $e) {}
                    }
                @endphp

                <a href="{{ route('shop.visit', $seller->slug) }}" class="artist-card">
                    <div class="artist-avatar">
                        <img src="{{ $logoUrl }}"
     alt="{{ $seller->name }}"
     loading="lazy"
     decoding="async"
     onerror="this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}'">

                    </div>

                    <div class="artist-name">{{ strtoupper($seller->name) }}</div>

                    @if(!empty($seller->country))
                        <div class="artist-country">
                            {{ ucfirst(strtolower($seller->country)) }}
                        </div>
                    @endif
                </a>

            @endforeach

            <a href="{{ route('sellers') }}" class="artist-card">
                <div class="artist-avatar viewall">VIEW ALL</div>
            </a>
        </div>
    </div>
</section>

@else
<div class="container">
    <div class="text-muted py-2">No sellers available right now.</div>
</div>
@endif
<style>

/* ================= ARTIST GRID ================= */
.home-artists {
    font-family: 'Inter', sans-serif;
}

.artist-name {
    font-family: 'Inter', sans-serif;
    font-weight: 600;
    margin-top: 10px;
    margin-bottom: 4px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    font-size: 13px;
    width: 100%;
    text-transform: uppercase;
}

.artist-country {
    font-family: 'Inter', sans-serif;
    color: #6c757d;
    margin-bottom: 6px;
    font-size: 12px;
}


</style>



<section class="events-section">
    <div class="container position-relative">

        <h2 class="section-title">Events &amp; Open Call</h2>

        <!-- ARROWS -->
        <button class="event-arrow left" onclick="prevEvent()">‹</button>
        <button class="event-arrow right" onclick="nextEvent()">›</button>

        <div class="row" id="events-wrapper">

            <!-- EVENT 1 -->
            <div class="col-md-6 event-item">
                <div class="event-card">
                    <img src="{{ static_asset('assets/img/Image (1).svg') }}">
                    <h6>Subheading</h6>
                    <p>Body text for whatever you'd like to add more to the subheading.</p>
                </div>
            </div>

            <!-- EVENT 2 -->
            <div class="col-md-6 event-item">
                <div class="event-card">
                    <img src="{{ static_asset('assets/img/Image.svg') }}">
                    <h6>Subheading</h6>
                    <p>Body text for whatever you'd like to expand on the main point.</p>
                </div>
            </div>

            <!-- EVENT 3 -->
            <div class="col-md-6 event-item">
                <div class="event-card">
                    <img src="{{ static_asset('assets/img/event-3.jpg') }}">
                    <h6>Subheading</h6>
                    <p>Another event description text here.</p>
                </div>
            </div>

            <!-- EVENT 4 -->
            <div class="col-md-6 event-item">
                <div class="event-card">
                    <img src="{{ static_asset('assets/img/event-4.jpg') }}">
                    <h6>Subheading</h6>
                    <p>Another event description text here.</p>
                </div>
            </div>

        </div>
    </div>
</section>

<style>
    /* ================= EVENTS SECTION ================= */
.events-section {
    padding: 80px 0;
    background: #f7f3ee;
    font-family: 'Inter', sans-serif;
}

.events-section .section-title,
.main-title{
    font-family: 'Merriweather', serif;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 40px;
}

.event-card img {
    width: 100%;
    height: 260px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 16px;
}

.event-card h6 {
    font-family: 'Merriweather', serif;
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 6px;
}

.event-card p {
    font-size: 14px;
    color: #6c6c6c;
    line-height: 1.6;
}

/* ARROWS */
.event-arrow {
    position: absolute;
    top: 130px;
    background: transparent;
    border: none;
    font-size: 34px;
    color: #999;
    cursor: pointer;
}

.event-arrow.left { left: -30px; }
.event-arrow.right { right: -30px; }

.event-arrow:hover {
    color: #111;
}


</style>

<script>
let eventIndex = 0;
const events = document.querySelectorAll('.event-item');
const visibleCount = 2;

function renderEvents() {
    events.forEach((el, i) => {
        el.style.display =
            (i === eventIndex || i === eventIndex + 1) ? 'block' : 'none';
    });
}

function nextEvent() {
    eventIndex += visibleCount;
    if (eventIndex >= events.length) {
        eventIndex = 0;
    }
    renderEvents();
}

function prevEvent() {
    eventIndex -= visibleCount;
    if (eventIndex < 0) {
        eventIndex = Math.max(events.length - visibleCount, 0);
    }
    renderEvents();
}

document.addEventListener('DOMContentLoaded', () => {
    renderEvents();
});
</script>



<section class="artist-invite">
    <div class="invite-wrapper">
        <h3>Are you an artist looking to be part of a curated ecosystem?</h3>

        <p>
            We are always looking for authentic voices and dedicated practitioners.
            ArtistiQe works on an invitation basis but welcomes registrations for portfolio review.
        </p>

        <a href="{{ route('artist.register.store') }}">Join ArtistiQe as an Artist</a>
    </div>
</section>
<style>
    /* ================= ARTIST INVITE ================= */
.artist-invite {
    background: url('{{ static_asset("assets/img/Rectangle 26.svg") }}') repeat;
    padding: 90px 15px;
    text-align: center;
    font-family: 'Inter', sans-serif;
}

.invite-wrapper {
    max-width: 720px;
    margin: auto;
    background: #f7f3ee;
    padding: 50px 40px;
}

.invite-wrapper h3 {
    font-family: 'Merriweather', serif;
    font-size: 24px;
    font-weight: 700;
    margin-bottom: 18px;
    color: #111;
}

.invite-wrapper p {
    font-size: 14px;
    line-height: 1.7;
    color: #555;
    margin-bottom: 22px;
}

.invite-wrapper a {
    font-size: 14px;
    color: #111;
    text-decoration: underline;
    font-weight: 500;
}

</style>
<section class="programs-section">
    <div class="container text-center">
        <h2 class="programs-title">Programs &amp; Initiative</h2>

        <p class="programs-desc">
            ArtistiQe is committed to the long-term health of the creative ecosystem through
            thoughtfully designed support for every stage of an artist’s career.
        </p>
    </div>
</section>
<style>
    /* ================= PROGRAMS SECTION ================= */
.programs-section {
    padding: 110px 0 140px;
    background: #f7f3ee;          /* same off-white background */
    text-align: center;
}

/* MAIN TITLE */
.programs-title {
    font-family: 'Merriweather', serif;
    font-size: 34px;
    font-weight: 700;
    color: #111;
    margin-bottom: 14px;
}

/* DESCRIPTION */
.programs-desc {
    font-family: 'Inter', sans-serif;
    font-size: 14.5px;
    line-height: 1.7;
    color: #6c6c6c;
    max-width: 640px;
    margin: 0 auto;
}

</style>

<section class="blogs-section">
    <div class="container">
        <h2 class="section-title text-center">Blogs and Publication</h2>

        <div class="row mt-5">
            @foreach($homeBlogs as $blog)
                <div class="col-md-6 mb-4">
                    <a href="{{ url('blog/'.$blog->slug) }}" class="text-reset">
                        <div class="blog-card">
                            <img
                                src="{{ uploaded_asset($blog->banner) }}"
                                alt="{{ $blog->title }}"
                            >

                            @if($blog->category)
                                <h6 class="text-uppercase text-muted">
                                    {{ $blog->category->category_name }}
                                </h6>
                            @endif

                            <h6>{{ $blog->title }}</h6>

                            <p>
                                {{ Str::limit($blog->short_description, 110) }}
                            </p>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>


<style>
    /* ================= BLOGS SECTION ================= */
.blogs-section {
    padding: 90px 0;
    background: #ffffff;
}

.blogs-section .section-title {
    font-family: 'Merriweather', serif;
    font-size: 30px;
    font-weight: 700;
    color: #111;
    border-bottom: 1px solid #E6E6E6;
}
.blog-card {
    width: 625px;
    height: 489px;
}
.blog-card img {
    width: 100%;
    height: 260px;
    object-fit: cover;
    border-radius: 12px;
    margin-bottom: 18px;
}

.blog-card h6 {
    font-family: 'Merriweather', serif;
    font-size: 16px;
    font-weight: 700;
    margin-bottom: 6px;
}

.blog-card p {
    font-family: 'Inter', sans-serif;
    font-size: 14px;
    line-height: 1.6;
    color: #6c6c6c;
    max-width: 420px;
}

</style>
<section class="ledger-section">
    <div class="container">
        <div class="ledger-box text-center">

            <h3>The ArtistiQe Ledger</h3>

            <p class="ledger-tagline">
                “Thoughtful writing on art, artists, and the cultural ecosystem.”
            </p>

            <p class="ledger-sub">Subscribe</p>

            <form class="ledger-form">
                <input type="email" placeholder="you@example.com">
                <button type="submit">Submit</button>
            </form>

            <small>
                No spam. Only essential cultural and artistic discourse.
            </small>

        </div>
    </div>
</section>
<style>
    /* ================= LEDGER SECTION ================= */
/* ================= LEDGER SECTION (IMPROVED) ================= */

.ledger-section {
    background: #1c1c1c;
    padding: 110px 15px;   /* thoda zyada breathing space */
}

.ledger-box {
    max-width: 760px;
    margin: auto;
    color: #fff;
}

/* TITLE */
.ledger-box h3 {
    font-family: 'Merriweather', serif;
    font-size: 48px;      /* 🔼 bigger */
    font-weight: 300;
    margin-bottom: 14px;
}

/* TAGLINE */
.ledger-tagline {
    font-family: 'Inter', sans-serif;
    font-size: 16px;      /* 🔼 bigger */
    color: #d6d6d6;
    margin-bottom: 22px;
    line-height: 1.6;
}

/* SUB TEXT */
.ledger-sub {
    font-family: 'Inter', sans-serif;
    font-size: 16px;      /* 🔼 bigger */
    margin-bottom: 20px;
    letter-spacing: .5px;
}

/* FORM */
.ledger-form {
    display: flex;
    justify-content: center;
    gap: 14px;
    margin-bottom: 18px;
}

.ledger-form input {
    width: 340px;         /* 🔼 wider */
    padding: 14px 16px;   /* 🔼 taller */
    border-radius: 8px;
    border: none;
    font-size: 15px;      /* 🔼 readable */
    font-family: 'Inter', sans-serif;
}

.ledger-form button {
    background: #b30000;
    color: #fff;
    border: none;
    padding: 14px 26px;   /* 🔼 button size */
    border-radius: 8px;
    font-size: 15px;
    font-family: 'Inter', sans-serif;
    cursor: pointer;
}

/* FOOT NOTE */
.ledger-box small {
    font-family: 'Inter', sans-serif;
    font-size: 13px;      /* 🔼 slightly bigger */
    color: #bdbdbd;
}

</style>
@if(!empty($featuredBlogs) && count($featuredBlogs))
<section class="featured-blogs">
    <div class="container">
        <div class="row align-items-center">

            <!-- LEFT CONTENT -->
            <div class="col-lg-5">
                <h2 class="fb-title">Featured Blogs</h2>

                <div class="fb-block">
                    <button class="fb-arrow left" onclick="prevBlog()">‹</button>

                    <h6 class="fb-sub" id="fb-subheading"></h6>
                    <p id="fb-desc"></p>
                </div>

                <div class="fb-actions mt-3">
                    <a href="#" id="fb-read" class="btn btn-danger">Read</a>
                    <a href="{{ url('blogs') }}" class="btn btn-light">View More</a>
                </div>
            </div>

            <!-- RIGHT IMAGE -->
            <div class="col-lg-7 position-relative">
                <div class="fb-image-wrap">
                    <img id="fb-image"
                         src=""
                         alt=""
                         onerror="this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}'">
                </div>

                <button class="fb-arrow right" onclick="nextBlog()">›</button>
            </div>

        </div>
    </div>
</section>
@endif
<script>
     document.addEventListener("DOMContentLoaded", function () {

        const blogs = @json($featuredBlogs ?? []);
        let currentIndex = 0;

        if (!blogs.length) return;

        const imageBase = "{{ uploaded_asset('') }}";

        function loadBlog(index) {
            const blog = blogs[index];

            document.getElementById('fb-subheading').innerText = blog.title;
            document.getElementById('fb-desc').innerText =
                blog.short_description
                    ? blog.short_description.substring(0, 140) + '...'
                    : '';

            document.getElementById('fb-image').src =
                imageBase + blog.banner;

            document.getElementById('fb-read').href =
                "{{ url('blog') }}/" + blog.slug;
        }

        window.nextBlog = function () {
            currentIndex = (currentIndex + 1) % blogs.length;
            loadBlog(currentIndex);
        };

        window.prevBlog = function () {
            currentIndex = (currentIndex - 1 + blogs.length) % blogs.length;
            loadBlog(currentIndex);
        };

        // 🔥 THIS IS THE KEY LINE
        loadBlog(0);

        // Optional auto slide
        // setInterval(nextBlog, 5000);
    });


</script>

<style>
    /* ================= FEATURED BLOGS ================= */
.featured-blogs {
    padding: 80px 0;
}

.fb-title {
   margin-top: 0;
    font-size: 32px;
    font-weight: 700;
 
}

.fb-block {
    position: relative;
    padding-left: 40px;
}

.fb-sub {
    font-size: 18px;
    font-weight: 600;
    margin-bottom: 10px;
}

#fb-desc {
    font-size: 15px;
    color: #666;
    line-height: 1.6;
}

.fb-image-wrap img {
    width: 100%;
    height: 420px;
    object-fit: cover;
    border-radius: 16px;
    transition: opacity 0.4s ease;
}

.fb-arrow {
    position: absolute;
    background: none;
    border: none;
    font-size: 34px;
    cursor: pointer;
    color: #111;
}

.fb-arrow.left {
    left: 0;
    top: 0;
}

.fb-arrow.right {
    right: -20px;
    top: 50%;
    transform: translateY(-50%);
}

/* RESPONSIVE */
@media (max-width: 991px) {
    .fb-image-wrap img {
        height: 300px;
        margin-top: 30px;
    }
}

</style>

<section class="faq-section">
    <div class="container">

        <div class="faq-header">
            <h2>Frequently Asked Questions</h2>
            <p class="faq-sub">Assistance</p>
        </div>

        <!-- FAQ LIST -->
        <div class="faq-list">

            <!-- ITEM -->
            <div class="faq-item active">
                <button class="faq-title" onclick="toggleFaq(this)">
                    Title
                    <span class="faq-icon">⌃</span>
                </button>
                <div class="faq-content">
                    Answer the frequently asked question in a simple sentence, a longish paragraph,
                    or even in a list.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-title" onclick="toggleFaq(this)">
                    Title
                    <span class="faq-icon">⌄</span>
                </button>
                <div class="faq-content">
                    Answer text goes here.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-title" onclick="toggleFaq(this)">
                    Title
                    <span class="faq-icon">⌄</span>
                </button>
                <div class="faq-content">
                    Answer text goes here.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-title" onclick="toggleFaq(this)">
                    Title
                    <span class="faq-icon">⌄</span>
                </button>
                <div class="faq-content">
                    Answer text goes here.
                </div>
            </div>

            <div class="faq-item">
                <button class="faq-title" onclick="toggleFaq(this)">
                    Title
                    <span class="faq-icon">⌄</span>
                </button>
                <div class="faq-content">
                    Answer text goes here.
                </div>
            </div>

        </div>

        <!-- SUPPORT BOX -->
        <div class="faq-support">
            <div>
                <h5>Still have questions?</h5>
                <p>Our concierge team is here to help you with any inquiries.</p>
            </div>
            <a href="#" class="btn-support">Contact Support</a>
        </div>

    </div>
</section>
<script>
document.addEventListener("DOMContentLoaded", function () {

    const blogs = @json($featuredBlogs);
    let index = 0;

    if (!blogs.length) return;

    const imgEl = document.getElementById('fb-image');

    function renderBlog(i) {
        const blog = blogs[i];

        document.getElementById('fb-subheading').innerText = blog.title ?? '';
        document.getElementById('fb-desc').innerText =
            blog.short_description
                ? blog.short_description.substring(0, 150) + '...'
                : '';

        // ✅ IMAGE FIX
        imgEl.src = blog.banner_url;

        document.getElementById('fb-read').href =
            "{{ url('blog') }}/" + blog.slug;
    }

    window.nextBlog = function () {
        index = (index + 1) % blogs.length;
        renderBlog(index);
    };

    window.prevBlog = function () {
        index = (index - 1 + blogs.length) % blogs.length;
        renderBlog(index);
    };

    // FIRST BLOG
    renderBlog(0);
});



function toggleFaq(btn) {
    const item = btn.parentElement;
    const isActive = item.classList.contains('active');

    document.querySelectorAll('.faq-item').forEach(el => {
        el.classList.remove('active');
        el.querySelector('.faq-icon').innerText = '⌄';
    });

    if (!isActive) {
        item.classList.add('active');
        btn.querySelector('.faq-icon').innerText = '⌃';
    }
}
</script>
<style>
    /* ================= FAQ SECTION ================= */
.faq-section {
    padding: 100px 0;
    background: #ffffff;
    font-family: 'Inter', sans-serif;
}

/* HEADER */
.faq-header h2 {
    font-family: 'Merriweather', serif;
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 6px;
}

.faq-sub {
    font-size: 14px;
    color: #6c6c6c;
    margin-bottom: 40px;
}

/* FAQ ITEMS */
.faq-item {
    border-radius: 6px;
    margin-bottom: 12px;
    overflow: hidden;
    border: 1px solid #eee;
}

.faq-title {
    width: 100%;
    text-align: left;
    padding: 14px 18px;
    background: #f6f2ed;
    border: none;
    font-size: 14px;
    font-weight: 600;
    display: flex;
    justify-content: space-between;
    align-items: center;
    cursor: pointer;
}

.faq-content {
    padding: 16px 18px;
    font-size: 14px;
    line-height: 1.6;
    color: #555;
    display: none;
    background: #fff;
}

/* ACTIVE STATE */
.faq-item.active .faq-content {
    display: block;
}

.faq-icon {
    font-size: 12px;
    color: #555;
}

/* SUPPORT BOX */
.faq-support {
    margin-top: 60px;
    padding: 30px 36px;
    background: #f7f3ee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.faq-support h5 {
    font-family: 'Merriweather', serif;
    font-size: 18px;
    margin-bottom: 6px;
}

.faq-support p {
    font-size: 14px;
    color: #6c6c6c;
}

/* SUPPORT BUTTON */
.btn-support {
    background: #111;
    color: #fff;
    padding: 10px 18px;
    border-radius: 6px;
    font-size: 14px;
    text-decoration: none;
}

</style>

<section class="join-community">
    <div class="join-overlay">
        <div class="join-card">
            <h2>Join the ArtistiQe Community</h2>
            <p>
                A global art space for artists, collectors, students, and patrons
                dedicated to the preservation and growth of art culture.
            </p>
        </div>
    </div>
</section>
<style>
    /* ================= JOIN COMMUNITY ================= */
.join-community {
    background: url('{{ static_asset("assets/img/Rectangle 30.svg") }}') center/cover no-repeat;
    padding: 120px 15px;
}

.join-overlay {
    display: flex;
    justify-content: center;
}

.join-card {
    background: #f7f3ee;
    padding: 46px 60px;
    max-width: 760px;
    text-align: center;
    border-radius: 12px;
}

.join-card h2 {
    font-family: 'Merriweather', serif;
    font-size: 30px;
    font-weight: 700;
    margin-bottom: 12px;
    color: #111;
}

.join-card p {
    font-family: 'Inter', sans-serif;
    font-size: 14.5px;
    line-height: 1.7;
    color: #555;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .join-card {
        padding: 36px 28px;
    }
}

</style>
<section class="testimonials">
    <div class="container">

        <div class="testimonial-slider">
            <div class="testimonial-track">

                <!-- CARD 1 -->
                <div class="testimonial-item">
                    <div class="testimonial-card">
                        <p class="quote">“A terrific piece of praise”</p>
                        <div class="author">
                            <img src="{{ static_asset('assets/img/Avatar.svg') }}">
                            <div>
                                <strong>Name</strong>
                                <span>Description</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 2 -->
                <div class="testimonial-item">
                    <div class="testimonial-card">
                        <p class="quote">“A fantastic bit of feedback”</p>
                        <div class="author">
                            <img src="{{ static_asset('assets/img/Avatar.svg') }}">
                            <div>
                                <strong>Name</strong>
                                <span>Description</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 3 -->
                <div class="testimonial-item">
                    <div class="testimonial-card">
                        <p class="quote">“A genuinely glowing review”</p>
                        <div class="author">
                            <img src="{{ static_asset('assets/img/Avatar.svg') }}">
                            <div>
                                <strong>vk</strong>
                                <span>Description</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 4 -->
                <div class="testimonial-item">
                    <div class="testimonial-card">
                        <p class="quote">“Outstanding experience overall”</p>
                        <div class="author">
                            <img src="{{ static_asset('assets/img/Avatar.svg') }}">
                            <div>
                                <strong>rk</strong>
                                <span>Description</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 5 -->
                <div class="testimonial-item">
                    <div class="testimonial-card">
                        <p class="quote">“Elegant and inspiring platform”</p>
                        <div class="author">
                            <img src="{{ static_asset('assets/img/Avatar.svg') }}">
                            <div>
                                <strong>pk</strong>
                                <span>Description</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- CARD 6 -->
                <div class="testimonial-item">
                    <div class="testimonial-card">
                        <p class="quote">“A beautifully curated experience”</p>
                        <div class="author">
                            <img src="{{ static_asset('assets/img/Avatar.svg') }}">
                            <div>
                                <strong>nk</strong>
                                <span>Description</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<style>
    /* ================= TESTIMONIALS ================= */
/* ================= TESTIMONIALS ================= */

.testimonials {
    padding: 80px 0;
    background: #fafafa;
}

.testimonial-slider {
    overflow: hidden;
}

.testimonial-track {
    display: flex;
    transition: transform 0.6s ease;
}

/* 3 cards visible */
.testimonial-item {
    flex: 0 0 33.3333%;
    padding: 0 12px;
}

.testimonial-card {
    background: #fff;
    padding: 28px;
    border-radius: 12px;
    height: 100%;
}

.quote {
    font-size: 16px;
    line-height: 1.6;
    color: #333;
    margin-bottom: 20px;
}

.author {
    display: flex;
    align-items: center;
    gap: 12px;
}

.author img {
    width: 42px;
    height: 42px;
    border-radius: 50%;
}

.author strong {
    display: block;
    font-size: 14px;
    color: #111;
}

.author span {
    font-size: 13px;
    color: #777;
}

/* MOBILE */
@media (max-width: 768px) {
    .testimonial-item {
        flex: 0 0 100%;
    }
}


</style>
<script>
    const track = document.querySelector('.testimonial-track');
    const items = document.querySelectorAll('.testimonial-item');
    let index = 0;

    function slideTestimonials() {
        const visibleCards = window.innerWidth <= 768 ? 1 : 3;
        const maxIndex = items.length - visibleCards;

        index++;
        if (index > maxIndex) {
            index = 0;
        }

        track.style.transform = `translateX(-${index * (100 / visibleCards)}%)`;
    }

    setInterval(slideTestimonials, 3000);
</script>
@push('scripts')


<script>
document.addEventListener("DOMContentLoaded", function () {
  const viewport = document.querySelector(".fc-viewport");
  const track = document.querySelector(".fc-track");
  const prevBtn = document.querySelector(".fc-prev");
  const nextBtn = document.querySelector(".fc-next");

  // Scroll by one full viewport width (i.e., one "page")
  function pageScroll(dir){
    const step = viewport.clientWidth; // width of visible grid
    viewport.scrollBy({ left: dir * step, behavior: 'smooth' });
  }

  prevBtn.addEventListener("click", () => pageScroll(-1));
  nextBtn.addEventListener("click", () => pageScroll(1));

  // Optional: hide/show arrows at ends
  function updateArrows(){
    const maxScroll = track.scrollWidth - viewport.clientWidth;
    const x = viewport.scrollLeft;
    prevBtn.style.visibility = x <= 1 ? "hidden" : "visible";
    nextBtn.style.visibility = x >= maxScroll - 1 ? "hidden" : "visible";
  }
  viewport.addEventListener('scroll', updateArrows);
  window.addEventListener('resize', updateArrows);
  updateArrows();
});
</script>
@endpush

@endsection 

