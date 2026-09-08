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
    max-width: 1400px;
    margin: 30px auto;
    position: relative;
}

.slides {
    border-radius: 12px;
    overflow: hidden;
}

.slide {
    width: 100%;
    height: 420px;
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
    border-color: #7b1d0f;
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
        <img src="https://artistiqe.com/public/assets/img/logo.png" class="slide active">
        <img src="https://artistiqe.com/public/assets/img/logo1.jpeg" class="slide">
        <img src="https://artistiqe.com/public/assets/img/logo2.jpeg" class="slide">
        <img src="https://artistiqe.com/public/assets/img/logologo.jpeg" class="slide">
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







<!-- ============== Sculptures: With Proper Left/Right Margin ============== -->
<section class="sculptures-block">
  <div class="container">   <!-- âœ… container added for left/right margin -->
    <div class="sculptures-grid">
      
      <!-- Left: Heading + text -->
      <div class="sculptures-copy">
        <h2 class="sculptures-title">Sculptures</h2>
        <p>Sculptures has long been a timeless medium in contemporary art, celebrated for its strength, detail, and evolving patina. From figurative to abstract forms, artists use it to explore texture, proportion, and expression with unmatched precision.</p>
        <p>At Artistiqe.com discover curated Sculptures works by renowned creators, each piece blending durability, beauty, and lasting value for collectors.Each sculpture tells a story whether carved from stone, cast in metal, or shaped in modern materials, it carries the vision and soul of the artist.
Our collection ranges from bold statement pieces to subtle accents, perfect for enhancing homes, galleries, and personal art spaces.
With every work, you invest not just in art, but in a legacy of creativity that endures through time.</p>
      </div>

      <!-- Right: Linkable image -->
      <div class="sculptures-media">
           <a href="https://artistiqe.com/category/sculpture" aria-label="Browse Sculptures">
        
          <img
            src="{{ static_asset('assets/img/sculpture_2-removebg-preview.png') }}"
            alt="Bronze sculpture"
            loading="lazy">
        </a>
      </div>

    </div>
  </div>
</section>

<style>
/* Section with margins */
.sculptures-block { padding: 20px 0; }

.container {
  max-width: 1200px;    /* âœ… page center width */
  margin: 0 auto;       /* âœ… center align */
  padding: 0 20px;      /* âœ… left & right margin */
}

.sculptures-grid {
  display: grid;
  grid-template-columns: 2.0fr 0.5fr;
  align-items: start;
  gap: 24px;
}

/* Text */
.sculptures-title {
  margin: 0 0 12px;
  font: 700 28px/1.2 system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
  color:#222;
}
.sculptures-copy p {
  margin: 0 0 12px;
  font: 16px/1.6 system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
  color:#555;
}

/* Image */
.sculptures-media img {
  display: block;
  max-width: 100%;
  max-height: 280px;
  object-fit: contain;
  border-radius: 6px;
  box-shadow: 0 3px 12px rgba(0,0,0,.08);
  transition: transform .25s ease;
}
.sculptures-media img:hover { transform: scale(1.02); }

/* Responsive */
@media (max-width: 767.98px){
  .sculptures-grid { grid-template-columns: 1fr; text-align: center; }
  .sculptures-media { order: 2; }
}

@media (max-width: 767.98px){
  .sculptures-grid { 
    grid-template-columns: 1fr; 
    text-align: center; 
  }

  .sculptures-media { 
    order: 2; 
    display: flex; 
    justify-content: center; 
  }

  .sculptures-media img {
    margin: 0 auto;  /* ensures image is centered */
  }
}
/* Default (desktop) */
.sculptures-grid {
  display: grid;
  grid-template-columns: 2fr 0.5fr;
  align-items: start;
  gap: 24px;
}

/* Tablet (768px - 991px) */
@media (max-width: 991.98px) and (min-width: 768px) {
  .sculptures-grid {
    grid-template-columns: 1.2fr 0.8fr; /* more space for image */
    align-items: center;
  }
  .sculptures-media img {
    max-height: 340px; /* bigger image */
  }
}

/* Mobile (<=767px) */
@media (max-width: 767.98px){
  .sculptures-grid { 
    grid-template-columns: 1fr; 
    text-align: center; 
  }
  .sculptures-media { 
    order: 2; 
    display: flex; 
    justify-content: center; 
  }
  .sculptures-media img {
    margin: 0 auto;
    max-height: 300px; /* bigger on mobile too */
  }
}

</style>





<!-- ======= ART GALLERY CARD SECTION (40/60 split) ======= -->
<!-- ======= ART GALLERY CARD SECTION (40/60 split) ======= -->
<!-- <section id="container_home">
  <div class="home-card">
    <div class="container-home">
     <p class="eyebrow" style="color:#e62e04;">COMING SOON...</p>

      <h2 class="section-title">Art Gallery</h2>

      <div class="gallery-split"> -->
        <!-- Left (40%) -->
      <!--  <a href="#" class="gallery-block" onclick="return false;">
          <img src="{{ static_asset('assets/img/Art gallery 1.jpg') }}" alt="Left Artwork" class="gallery-img">
          <div class="overlay-caption">
            <h3>Suzanne Tarasieve</h3>
            <p>France</p>
          </div>
        </a> -->

        <!-- Right (60%) -->
         <!-- <a href="#" class="gallery-block" onclick="return false;"> -->
         <!--  <img src="{{ static_asset('assets/img/art gallery 2.jpg') }}" alt="Right Artwork" class="gallery-img">
          <div class="overlay-caption">
            <h3>Maya-InÃ¨s Touam</h3>
            <p>Art-O-Rama Â· Aug 29â€“31, 2025</p>
          </div>
        </a>
      </div>
    </div>
  </div>
</section> -->


<style>
/* ===== wrapper rules ===== */
@media (max-width: 1400px) {
  #container_home .home-card {
    max-width: 96%;
    padding-left: 40px;
    padding-right: 40px;
    width: 96%;
  }
}
#container_home .home-card {
  background-color: #fff;
  border-radius: 28px;
  margin-left: auto;
  margin-right: auto;
  max-width: 1560px;
  padding: 10px 50px;
  width: calc(100% - 60px);
}
#container_home .container-home {
  margin-bottom: 20px;
}
#container_home .eyebrow {
  letter-spacing: .06em;
  font-size: 12px;
  font-weight: 700;
  opacity: .7;
  margin: 0 0 8px;
}
#container_home .section-title {
  margin: 0 0 22px;

  font: 700 28px/1.2 system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;
  line-height: 1.15;
}

/* ===== split images ===== */
#container_home .gallery-split {
  display: flex;
  gap: 14px;
}
#container_home .gallery-block {
  position: relative;
  display: block;
  overflow: hidden;
  border-radius: 20px;
  text-decoration: none;
  color: inherit;
}
#container_home .gallery-block:first-child {
  flex: 0 0 40%; /* left takes 40% */
}
#container_home .gallery-block:last-child {
  flex: 0 0 60%; /* right takes 60% */
}
#container_home .gallery-img {
  width: 100%;
  height: clamp(240px, 40vw, 520px);
  object-fit: cover;
  display: block;
  transition: transform .35s ease;
}
#container_home .gallery-block:hover .gallery-img {
  transform: scale(1.05);
}

/* ===== overlay caption ===== */
#container_home .overlay-caption {
  position: absolute;
  bottom: 14px;
  left: 14px;
  right: 14px;
  color: #fff;
  font-size: 14px;
  background: rgba(0,0,0,0.35);
  padding: 10px 14px;
  border-radius: 12px;
}
#container_home .overlay-caption h3 {
  margin: 0 0 4px;
  font-size: 16px;
}
#container_home .overlay-caption p {
  margin: 0;
  font-size: 13px;
  opacity: .85;
}

/* ===== responsive: stack on mobile ===== */
@media (max-width: 768px) {
  #container_home .gallery-split {
    flex-direction: column;
  }
  #container_home .gallery-block:first-child,
  #container_home .gallery-block:last-child {
    flex: 0 0 100%;
  }
}
</style>










    <!-- Sliders -->
    <div class="home-banner-area mb-3">
        <div class="p-0">
            <!-- Sliders -->
            <div class="home-slider slider-full">
                @if (get_setting('home_slider_images', null, $lang) != null)
                    <div class="aiz-carousel dots-inside-bottom mobile-img-auto-height" data-autoplay="true" data-infinite="true">
                        @php
                            $decoded_slider_images = json_decode(get_setting('home_slider_images', null, $lang), true);
                            $sliders = get_slider_images($decoded_slider_images);
                            $home_slider_links = get_setting('home_slider_links', null, $lang);
                        @endphp
                        @foreach ($sliders as $key => $slider)
                            <div class="carousel-box">
                                <a href="{{ isset(json_decode($home_slider_links, true)[$key]) ? json_decode($home_slider_links, true)[$key] : '' }}">
                                    <!-- Image -->
                                    <div class="d-block mw-100 img-fit overflow-hidden h-180px h-md-320px h-lg-460px h-xl-553px overflow-hidden">
                                        <img class="img-fit h-100 m-auto has-transition ls-is-cached lazyloaded"
                                        src="{{ $slider ? my_asset($slider->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                        alt="{{ env('APP_NAME') }} promo"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Flash Deal -->
    @php
        $flash_deal = get_featured_flash_deal();
        $flash_deal_bg = get_setting('flash_deal_bg_color');
        $flash_deal_bg_full_width = (get_setting('flash_deal_bg_full_width') == 1) ? true : false;
        $flash_deal_banner_menu_text = ((get_setting('flash_deal_banner_menu_text') == 'dark') ||  (get_setting('flash_deal_banner_menu_text') == null)) ? 'text-dark' : 'text-white';

    @endphp
    @if ($flash_deal != null)
        <section class="mb-2 mb-md-3 mt-2 mt-md-3" style="background: {{ ($flash_deal_bg_full_width && $flash_deal_bg != null) ? $flash_deal_bg : '' }};" id="flash_deal">
            <div class="container">
                <!-- Top Section sm to lg -->
                <div class="d-flex d-lg-none flex-wrap mb-2 mb-md-3 @if ($flash_deal_bg_full_width && $flash_deal_bg != null) pt-2 pt-md-3 @endif align-items-baseline justify-content-between">
                    <!-- Title -->
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span class="d-inline-block {{ ($flash_deal_bg_full_width && $flash_deal_bg != null) ? $flash_deal_banner_menu_text : 'text-dark'}}">{{ translate('Flash Sale') }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="24" viewBox="0 0 16 24"
                            class="ml-3">
                            <path id="Path_28795" data-name="Path 28795"
                                d="M30.953,13.695a.474.474,0,0,0-.424-.25h-4.9l3.917-7.81a.423.423,0,0,0-.028-.428.477.477,0,0,0-.4-.207H21.588a.473.473,0,0,0-.429.263L15.041,18.151a.423.423,0,0,0,.034.423.478.478,0,0,0,.4.2h4.593l-2.229,9.683a.438.438,0,0,0,.259.5.489.489,0,0,0,.571-.127L30.9,14.164a.425.425,0,0,0,.054-.469Z"
                                transform="translate(-15 -5)" fill="#fcc201" />
                        </svg>
                    </h3>
                    <!-- Links -->
                    <div>
                        <div class="text-dark d-flex align-items-center mb-0">
                            <a href="{{ route('flash-deals') }}"
                                class="fs-10 fs-md-12 fw-700 has-transition @if ((get_setting('flash_deal_banner_menu_text') == 'light') && $flash_deal_bg_full_width && $flash_deal_bg != null) text-white opacity-60 hov-opacity-100 animate-underline-white @else text-reset opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary @endif mr-3">{{ translate('View All Flash Sale') }}</a>
                            <span class=" border-left border-soft-light border-width-2 pl-3">
                                <a href="{{ route('flash-deal-details', $flash_deal->slug) }}"
                                    class="fs-10 fs-md-12 fw-700 has-transition @if ((get_setting('flash_deal_banner_menu_text') == 'light') && $flash_deal_bg_full_width && $flash_deal_bg != null) == 'light') text-white opacity-60 hov-opacity-100 animate-underline-white @else text-reset opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary @endif">{{ translate('View All Products from This Flash Sale') }}</a>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Countdown for small device -->
                <div class="bg-white mb-3 d-md-none">
                    <div class="aiz-count-down-circle" end-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                </div>

                <div class="row no-gutters align-items-center" style="background: {{ $flash_deal_bg }};">
                    <!-- Flash Deals Baner & Countdown -->
                    <div class="col-xxl-4 col-lg-5 col-6 h-200px h-md-400px h-lg-475px">
                        <a href="{{ route('flash-deal-details', $flash_deal->slug) }}">
                            <div class="h-100 w-100 w-xl-auto"
                                style="background-image: url('{{ uploaded_asset($flash_deal->banner) }}'); background-size: cover; background-position: center center;">
                                <div class="py-5 px-md-3 px-xl-5 d-none d-md-block">
                                    <div class="bg-white">
                                        <div class="aiz-count-down-circle"
                                            end-date="{{ date('Y/m/d H:i:s', $flash_deal->end_date) }}"></div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-xxl-8 col-lg-7 col-6">
                        <div class="pl-3 pr-lg-3 pl-xl-2rem pr-xl-2rem">
                            <!-- Top Section from lg device -->
                            <div class="d-none d-lg-flex flex-wrap mb-2 mb-md-3 align-items-baseline justify-content-between">
                                <!-- Title -->
                                <h3 class="fs-16 fs-md-20 fw-700 mb-2">
                                    <span class="d-inline-block {{ $flash_deal_banner_menu_text }}">{{ translate('Flash Sale') }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="24" viewBox="0 0 16 24"
                                        class="ml-3">
                                        <path id="Path_28795" data-name="Path 28795"
                                            d="M30.953,13.695a.474.474,0,0,0-.424-.25h-4.9l3.917-7.81a.423.423,0,0,0-.028-.428.477.477,0,0,0-.4-.207H21.588a.473.473,0,0,0-.429.263L15.041,18.151a.423.423,0,0,0,.034.423.478.478,0,0,0,.4.2h4.593l-2.229,9.683a.438.438,0,0,0,.259.5.489.489,0,0,0,.571-.127L30.9,14.164a.425.425,0,0,0,.054-.469Z"
                                            transform="translate(-15 -5)" fill="#fcc201" />
                                    </svg>
                                </h3>
                                <!-- Links -->
                                <div>
                                    <div class="text-dark d-flex align-items-center mb-0">
                                        <a href="{{ route('flash-deals') }}"
                                            class="fs-10 fs-md-12 fw-700 has-transition {{ $flash_deal_banner_menu_text }} @if (get_setting('flash_deal_banner_menu_text') == 'light') text-white opacity-60 hov-opacity-100 animate-underline-white @else text-reset opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary @endif mr-3">
                                            {{ translate('View All Flash Sale') }}
                                        </a>
                                        <span class=" border-left border-soft-light border-width-2 pl-3">
                                            <a href="{{ route('flash-deal-details', $flash_deal->slug) }}"
                                                class="fs-10 fs-md-12 fw-700 has-transition {{ $flash_deal_banner_menu_text }} @if (get_setting('flash_deal_banner_menu_text') == 'light') text-white opacity-60 hov-opacity-100 animate-underline-white @else text-reset opacity-60 hov-opacity-100 hov-text-primary animate-underline-primary @endif">{{ translate('View All Products from This Flash Sale') }}</a>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <!-- Flash Deals Products -->
                            @php
                                $flash_deal_products = get_flash_deal_products($flash_deal->id);
                            @endphp
                            <div class="aiz-carousel border-top @if (count($flash_deal_products) > 8) border-right @endif arrow-inactive-none arrow-x-0"
                                data-rows="2" data-items="5" data-xxl-items="5" data-xl-items="3.5" data-lg-items="3" data-md-items="2"
                                data-sm-items="2.5" data-xs-items="1.7" data-arrows="true" data-dots="false">
                                @foreach ($flash_deal_products as $key => $flash_deal_product)
                                    <div class="carousel-box bg-white border-left border-bottom">
                                        @if ($flash_deal_product->product != null && $flash_deal_product->product->published != 0)
                                            @php
                                                $product_url = route('product', $flash_deal_product->product->slug);
                                                if ($flash_deal_product->product->auction_product == 1) {
                                                    $product_url = route('auction-product', $flash_deal_product->product->slug);
                                                }
                                            @endphp
                                            <div
                                                class="h-100px h-md-200px h-lg-auto flash-deal-item position-relative text-center has-transition hov-shadow-out z-1">
                                                <a href="{{ $product_url }}"
                                                    class="d-block py-md-2 overflow-hidden hov-scale-img"
                                                    title="{{ $flash_deal_product->product->getTranslation('name') }}">
                                                    <!-- Image -->
                                                    <img src="{{ get_image($flash_deal_product->product->thumbnail) }}"
                                                        class="lazyload h-60px h-md-100px h-lg-120px mw-100 mx-auto has-transition"
                                                        alt="{{ $flash_deal_product->product->getTranslation('name') }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                    <!-- Price -->
                                                    <div
                                                        class="fs-10 fs-md-14 mt-md-2 text-center h-md-48px has-transition overflow-hidden pt-md-4 flash-deal-price lh-1-5">
                                                        <span
                                                            class="d-block text-primary fw-700">{{ home_discounted_base_price($flash_deal_product->product) }}</span>
                                                        @if (home_base_price($flash_deal_product->product) != home_discounted_base_price($flash_deal_product->product))
                                                            <del
                                                                class="d-block fw-400 text-secondary">{{ home_base_price($flash_deal_product->product) }}</del>
                                                        @endif
                                                    </div>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- Today's deal 
    @php
        $todays_deal_section_bg = get_setting('todays_deal_section_bg_color');
    @endphp
    <div id="todays_deal" class="mb-2rem mt-2 mt-md-3" @if(get_setting('todays_deal_section_bg') == 1) style="background: {{ $todays_deal_section_bg }};" @endif>

    </div>-->
    



    <!-- Featured Categories 
    @if (count($featured_categories) > 0)
        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                <div class="bg-white">
                    <!-- Top Section 
                    <div class="d-flex mt-2 mt-md-3 mb-2 mb-md-3 align-items-baseline justify-content-between">
                        <!-- Title 
                        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                            <span class="">{{ translate('Featured Categories') }}</span>
                        </h3>
                    </div>
                </div>
                <!-- Categories 
                <div class="bg-white px-sm-3">
                    <div class="aiz-carousel sm-gutters-17" data-items="4" data-xxl-items="4" data-xl-items="3.5"
                        data-lg-items="3" data-md-items="2" data-sm-items="2" data-xs-items="1" data-arrows="true"
                        data-dots="false" data-autoplay="false" data-infinite="true">
                        @foreach ($featured_categories as $key => $category)
                            @php
                                $category_name = $category->getTranslation('name');
                            @endphp
                            <div class="carousel-box position-relative p-0 has-transition border-right border-top border-bottom @if ($key == 0) border-left @endif">
                                <div class="h-200px h-sm-250px h-md-340px">
                                    <div class="h-100 w-100 w-xl-auto position-relative hov-scale-img overflow-hidden">
                                        <div class="position-absolute h-100 w-100 overflow-hidden">
                                            <img src="{{ isset($category->coverImage->file_name) ? my_asset($category->coverImage->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                                alt="{{ $category_name }}"
                                                class="img-fit h-100 has-transition"
                                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                        </div>
                                        <div class="pb-4 px-4 absolute-bottom-left has-transition h-50 w-100 d-flex flex-column align-items-center justify-content-end"
                                            style="background: linear-gradient(to top, rgba(0,0,0,0.5) 50%,rgba(0,0,0,0) 100%) !important;">
                                            <div class="w-100">
                                                <a class="fs-16 fw-700 text-white animate-underline-white home-category-name d-flex align-items-center hov-column-gap-1"
                                                    href="{{ route('products.category', $category->slug) }}"
                                                    style="width: max-content;">
                                                    {{ $category_name }}&nbsp;
                                                    <i class="las la-angle-right"></i>
                                                </a>
                                                <div class="d-flex flex-wrap h-50px overflow-hidden mt-2">
                                                    @foreach ($category->childrenCategories->take(6) as $key => $child_category)
                                                    <a href="{{ route('products.category', $child_category->slug) }}" class="fs-13 fw-300 text-soft-light hov-text-white pr-3 pt-1">
                                                        {{ $child_category->getTranslation('name') }}
                                                    </a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif-->

    <!-- Banner section 1 
    @php $homeBanner1Images = get_setting('home_banner1_images', null, $lang);   @endphp
    @if ($homeBanner1Images != null)
        <div class="pb-2 pb-md-3 pt-2 pt-md-3" style="background: #ffffff;">
            <div class="container mb-2 mb-md-3">
                @php
                    $banner_1_imags = json_decode($homeBanner1Images);
                    $data_md = count($banner_1_imags) >= 2 ? 2 : 1;
                    $home_banner1_links = get_setting('home_banner1_links', null, $lang);
                @endphp
                <div class="w-100">
                    <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                        data-items="{{ count($banner_1_imags) }}" data-xxl-items="{{ count($banner_1_imags) }}"
                        data-xl-items="{{ count($banner_1_imags) }}" data-lg-items="{{ $data_md }}"
                        data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true"
                        data-dots="false">
                        @foreach ($banner_1_imags as $key => $value)
                            <div class="carousel-box overflow-hidden hov-scale-img">
                                <a href="{{ isset(json_decode($home_banner1_links, true)[$key]) ? json_decode($home_banner1_links, true)[$key] : '' }}"
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
        </div>
    @endif-->
    
   <!-- Banner section 1 -->
@php $homeBanner1Images = get_setting('home_banner1_images', null, $lang); @endphp
@if ($homeBanner1Images != null)
    <div class="pb-2 pb-md-3 pt-2 pt-md-3" style="background: #ffffff;">
        @php
            $banner_1_imags = json_decode($homeBanner1Images);
            $data_md = count($banner_1_imags) >= 2 ? 2 : 1;
            $home_banner1_links = get_setting('home_banner1_links', null, $lang);
        @endphp
        <div class="registration-placeholder" aria-hidden="false" ></div>

        <div class="w-100">
            <div class="aiz-carousel gutters-0 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                data-items="{{ count($banner_1_imags) }}" 
                data-xxl-items="{{ count($banner_1_imags) }}"
                data-xl-items="{{ count($banner_1_imags) }}" 
                data-lg-items="{{ $data_md }}"
                data-md-items="{{ $data_md }}" 
                data-sm-items="1" 
                data-xs-items="1" 
                data-arrows="true"
                data-dots="false">
                @foreach ($banner_1_imags as $key => $value)
                    @php 
                        $banner_link = isset(json_decode($home_banner1_links, true)[$key]) 
                            ? json_decode($home_banner1_links, true)[$key] 
                            : ''; 
                    @endphp
                    <div class="carousel-box overflow-hidden hov-scale-img position-relative">
    <a href="{{ $banner_link }}" class="d-block text-reset overflow-hidden">
        <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
            data-src="{{ uploaded_asset($value) }}" 
            alt="{{ env('APP_NAME') }} promo"
            class="img-fluid lazyload w-100 has-transition"
            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
    </a>
  <!--@if($banner_link != '')
    <a href="https://artistiqe.com/shop/registration/verification"
       class="btn btn-primary free-registration-btn"
       aria-label="Free Registration">
       Free Registration*
    </a>
@endif -->


</div>

                @endforeach
            </div>
        </div>
    </div>
@endif

<!--<style>
  /* ensure carousel-box is positioned relative (you already have that) */
.carousel-box { position: relative; }

/* default (desktop/tablet) - button inside banner: absolute top-right */
.carousel-box .free-registration-btn {
  position: absolute;
  top: 12px;
  right: 12px;
  z-index: 10;
  border-radius: 20px;
  padding: 7px 16px;
  font-size: clamp(13px, 1.6vw, 15px);
  background: rgba(255,255,255,0.95);
  color: #111;
  border: 1px solid rgba(0,0,0,0.08);
  box-shadow: 0 6px 18px rgba(2,6,23,0.12);
  white-space: nowrap;
  transform: none;
}

/* When the JS moves the single button into the placeholder it adds .mobile-outside */
/* Mobile/outside style: full width container above banner; align label to right */
.registration-placeholder {
  width: 100%;
  display: block;            /* becomes a block container above carousel */
  padding: 8px 18px;        /* horizontal breathing room */
  box-sizing: border-box;
}

/* The moved state: full-width button with text aligned to right */
.registration-placeholder .free-registration-btn.mobile-outside {
  position: static !important;   /* remove absolute positioning */
  display: block;
  width: 100%;
  max-width: 100%;
  padding: 10px 14px;
  border-radius: 8px;
  text-align: right;            /* label sits on the right side of the full-width button */
  font-size: 14px;
  white-space: normal;          /* allow it to wrap if needed */
  box-shadow: 0 6px 18px rgba(2,6,23,0.09);
}

/* if you prefer the button shorter on very narrow screens, limit max-width instead:
   .registration-placeholder .free-registration-btn.mobile-outside { max-width: 420px; margin-left: auto; }
*/

/* Optional: small tweak when button is back inside carousel (keep hover look) */
.carousel-box .free-registration-btn:hover,
.registration-placeholder .free-registration-btn.mobile-outside:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 24px rgba(2,6,23,0.14);
}

/* Keep accessibility focus ring */
.free-registration-btn:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(0,123,255,0.12), 0 6px 18px rgba(2,6,23,0.12);
}
/* default (desktop/tablet) - inside banner */
.carousel-box .free-registration-btn {
  position: absolute;
  top: 12px;
  right: 12px;
  z-index: 10;
  border-radius: 20px;
  padding: 7px 16px;
  font-size: clamp(13px, 1.6vw, 15px);
  background: rgba(255,255,255,0.95);
  color: #111;
  border: 1px solid rgba(0,0,0,0.08);
  box-shadow: 0 6px 18px rgba(2,6,23,0.12);
  white-space: nowrap;
}

/* placeholder wrapper (used only on mobile) */
.registration-placeholder {
  width: 100%;
  display: flex;              /* flex use for right alignment */
  justify-content: flex-end;  /* push button to right side */
  padding: 4px 12px;          /* thoda margin from edges */
  box-sizing: border-box;
}

/* mobile (<768px) - when moved outside */
.registration-placeholder .free-registration-btn.mobile-outside {
  position: static !important; 
  border-radius: 18px;
  padding: 6px 14px;
  font-size: 13px;
  width: auto;               /* shrink to content */
  max-width: none;
  white-space: nowrap;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}


</style>
<script>
    
(function() {
  // breakpoint where we "pull" button out
  var MOBILE_BREAKPOINT = 768;

  function moveRegistrationButton() {
    var btn = document.querySelector('.free-registration-btn');
    var placeholder = document.querySelector('.registration-placeholder');
    // choose the first carousel-box available (if multiple banners, you can refine)
    var firstCarouselBox = document.querySelector('.carousel-box');

    if (!btn || !placeholder || !firstCarouselBox) return;

    if (window.innerWidth < MOBILE_BREAKPOINT) {
      // move to placeholder (if not there already)
      if (!placeholder.contains(btn)) {
        placeholder.appendChild(btn);
      }
      // add mobile class for styling
      btn.classList.add('mobile-outside');
    } else {
      // move back inside the banner (if not there already)
      if (!firstCarouselBox.contains(btn)) {
        // append to the first carousel-box (you can pick a specific index if needed)
        firstCarouselBox.appendChild(btn);
      }
      btn.classList.remove('mobile-outside');
    }
  }

  // run on load
  document.addEventListener('DOMContentLoaded', moveRegistrationButton);
  // run on resize, debounce for performance
  var resizeTimer;
  window.addEventListener('resize', function() {
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(moveRegistrationButton, 120);
  });
})();
</script>-->





<!-- =========================
     SEARCH BY PRICE
========================= 

<section id="container_home">
  <div class="home-card">

    <!-- 1) SEARCH 
    <p class="eyebrow" style="color:#e62e04;">COMING SOON...</p>

    <!-- 2) Content columns 
    <div class="row g-4 align-items-stretch content-row">
      
      <!-- LEFT: BY PRICE + buttons 
      <div class="col-12 col-md-3">
        <h2 class="section-title">By Price</h2>
        <nav class="price-filters">
          <!--<a class="price-btn" href="#" onclick="return false;">Under ₹5000 </a>
          <a class="price-btn" href="#" onclick="return false;">₹5000 - ₹10000 </a>
          <a class="price-btn" href="#" onclick="return false;">₹10000 - ₹20000 </a>
          <a class="price-btn" href="#" onclick="return false;">₹20000 - ₹50000 </a>
          <a class="price-btn" href="#" onclick="return false;">More than ₹50000 </a>
          <a class="price-btn price-btn--last" href="#" onclick="return false;">Discounted Price</a>-->
         

          <!--<style>
          .price-btn--last {
              background-color: #000;  
               color: #fff;     
              border: #000; 
          }
.price-btn--last:hover {
  background-color: #e62e04; /* red fill */
  color: #fff;               /* white text */
  border-color: #e62e04;;     /* red border on hover */
}

/* keyboard focus for accessibility */
.price-btn--last:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(255, 0, 0, 0.15);
}

          </style>
        </nav>
      </div>

      <!-- RIGHT: CURRENTLY... + images 
      <div class="col-12 col-md-9">
        <h2 class="section-title">Currently on Artistiqe</h2>
        <div class="art-grid">
          <a class="art-card" href="#" onclick="return false;"><img class="art-img" src="{{ static_asset('assets/img/price1.jpg') }}" alt=""><span class="art-title">New Artworks</span></a>
          <a class="art-card" href="#" onclick="return false;"><img class="art-img" src="{{ static_asset('assets/img/price2.jpg') }}" alt=""><span class="art-title">New Artists</span></a>
          <a class="art-card" href="#" onclick="return false;"><img class="art-img" src="{{ static_asset('assets/img/price3.jpg') }}" alt=""><span class="art-title">Affordable Artworks</span></a>
        </div>
      </div>

    </div>
  </div>
</section>-->
<!-- =========================
     SEARCH BY PRICE
========================= -->
<section id="container_home">
  <div class="home-card">
    <p class="eyebrow" style="color:#e62e04;">COMING SOON...</p>

    <div class="row g-4 align-items-stretch content-row">
      <!-- LEFT: BY PRICE + buttons -->
      <div class="col-12 col-md-3">
        <h2 class="section-title">By Price</h2>

        @php
            // Base amounts in your DEFAULT currency (e.g., INR)
            $priceRanges = [
                ['min' => 0,     'max' => 5000],
                ['min' => 5000,  'max' => 10000],
                ['min' => 10000, 'max' => 20000],
                ['min' => 20000, 'max' => 50000],
            ];
            $lastMax = $priceRanges[count($priceRanges)-1]['max'];
        @endphp

        <nav class="price-filters">
          {{-- Under first range --}}
          <a class="price-btn"
             href="{{ route('search', ['min_price' => $priceRanges[0]['min'], 'max_price' => $priceRanges[0]['max']]) }}" style="font-size:12.4px;" onclick="return false;">
            {{ translate('Under') }} {{ single_price($priceRanges[0]['max']) }}
          </a>

          {{-- Middle ranges --}}
          @foreach(array_slice($priceRanges, 1) as $range)
            <a class="price-btn"
               href="{{ route('search', ['min_price' => $range['min'], 'max_price' => $range['max']]) }}" style="font-size:12.4px;" onclick="return false;">
              {{ single_price($range['min']) }} – {{ single_price($range['max']) }}
            </a>
          @endforeach

          {{-- More than last range --}}
          <a class="price-btn"
             href="{{ route('search', ['min_price' => $lastMax]) }}" style="font-size:12.4px;" onclick="return false;">
            {{ translate('More than') }} {{ single_price($lastMax) }}
          </a>

         {{-- Discounted Price --}}
         <a class="price-btn price-btn--last"
         href="{{ route('search', ['discounted' => 1]) }}" onclick="return false;"
         style="font-size:12.4px;">
        {{ translate('Discounted Price') }}
         </a>

        </nav>
      </div>

      <!-- RIGHT: CURRENTLY... + images -->
      <div class="col-12 col-md-9">
        <h2 class="section-title">Currently on Artistiqe</h2>
        <div class="art-grid">
          <a class="art-card" href="#" onclick="return false;">
            <img class="art-img" src="{{ static_asset('assets/img/price1.jpg') }}" alt="">
            <span class="art-title">New Artworks</span>
          </a>
          <a class="art-card" href="#" onclick="return false;">
            <img class="art-img" src="{{ static_asset('assets/img/price2.jpg') }}" alt="">
            <span class="art-title">New Artists</span>
          </a>
          <a class="art-card" href="#" onclick="return false;">
            <img class="art-img" src="{{ static_asset('assets/img/price3.jpg') }}" alt="">
            <span class="art-title">Affordable Artworks</span>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>



<!-- =========================
     ARTISTS SECTION
========================= -->
<!-- =========================
     ARTISTS SECTION
========================= 
<section class="home-artists">
  <div class="container">
    <h2 class="section-title mb-3">Artist</h2>

    <div class="artists-grid">
      <!-- Artist 1 
      <a href="artist-banksy.html" class="artist-card">
        <div class="artist-avatar">
          <img src="{{ static_asset('assets/img/a1.jpg') }}" alt=""Banksy"" class="gallery-img">
        </div>
        <div class="artist-name">BANKSY</div>
        <div class="artist-count">269 works</div>
      </a>

      <!-- Artist 2 
      <a href="artist-andy-warhol.html" class="artist-card">
        <div class="artist-avatar">
          <img src="{{ static_asset('assets/img/a2.jpg') }}"alt="Andy Warhol">
        </div>
        <div class="artist-name">ANDY WARHOL</div>
        <div class="artist-count">480 works</div>
      </a>

      <!-- Artist 3 
      <a href="artist-david-hockney.html" class="artist-card">
        <div class="artist-avatar">
          <img src="{{ static_asset('assets/img/a3.jpg') }}"alt="David Hockney">
        </div>
        <div class="artist-name">DAVID HOCKNEY</div>
        <div class="artist-count">650 works</div>
      </a>
      
       <!-- Artist 4 
      <a href="artist-david-hockney.html" class="artist-card">
        <div class="artist-avatar">
          <img src="{{ static_asset('assets/img/a1.jpg') }}" alt="David Hockney">
        </div>
        <div class="artist-name">DAVID HOCKNEY</div>
        <div class="artist-count">650 works</div>
      </a>
      
       <!-- Artist 5 
      <a href="artist-david-hockney.html" class="artist-card">
        <div class="artist-avatar">
          <img src="{{ static_asset('assets/img/a2.jpg') }}" alt="David Hockney">
        </div>
        <div class="artist-name">DAVID HOCKNEY</div>
        <div class="artist-count">650 works</div>
      </a>
      
       <!-- Artist 6 
      <a href="artist-david-hockney.html" class="artist-card">
        <div class="artist-avatar">
           <img src="{{ static_asset('assets/img/a3.jpg') }}" alt="David Hockney">
        </div>
        <div class="artist-name">DAVID HOCKNEY</div>
        <div class="artist-count">650 works</div>
      </a>

      <!-- More artists... 

      <!-- "View All" 
      <a href="artists.html" class="artist-card">
        <div class="artist-avatar viewall">VIEW ALL</div>
      </a>
    </div>
  </div>
</section>

<style>
  .home-artists { padding: 40px 0; background:#fff; }
  .home-artists h2 { margin-bottom: 24px; }

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
    text-decoration:none; /* no underline */
    transition: transform .2s ease;
  }
  .artist-card:hover{ transform:translateY(-3px); }

  .artist-avatar{
    width:120px; height:120px;
    border-radius:50%;
    overflow:hidden;
    display:flex; align-items:center; justify-content:center;
    background:#f2f2f2;
  }
  .artist-avatar img{
    width:100%; height:100%; object-fit:cover; display:block;
    filter:grayscale(100%);
  }

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

<style>
  .home-artists { padding: 40px 0; background:#fff; }
  .home-artists h2 { margin-bottom: 24px; }

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

  .artist-card{ text-align:center; display:flex; flex-direction:column; align-items:center; gap:8px; color:#000; }

  .artist-avatar{
    width:120px; height:120px;
    border-radius:50%;
    overflow:hidden;
    display:flex; align-items:center; justify-content:center;
    background:#f2f2f2;
    transition: transform .2s ease;
  }
  .artist-avatar img{ width:100%; height:100%; object-fit:cover; display:block; filter:grayscale(100%); }
  .artist-card:hover .artist-avatar{ transform:translateY(-2px); }

  .artist-name{ font-weight:800; font-size:.82rem; letter-spacing:.5px; text-transform:uppercase; }
  .artist-count{ font-size:.8rem; color:#7a7a7a; font-style:italic; }

  .artist-avatar.viewall{
    background:#111; color:#fff;
    font-weight:800; font-size:.9rem;
    display:flex; align-items:center; justify-content:center;
  }
</style>-->



    <!-- Banner Section 2 -->
    @php $homeBanner2Images = get_setting('home_banner2_images', null, $lang);   @endphp
    @if ($homeBanner2Images != null)
        <div class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                @php
                    $banner_2_imags = json_decode($homeBanner2Images);
                    $data_md = count($banner_2_imags) >= 2 ? 2 : 1;
                    $home_banner2_links = get_setting('home_banner2_links', null, $lang);
                @endphp
                <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                    data-items="{{ count($banner_2_imags) }}" data-xxl-items="{{ count($banner_2_imags) }}"
                    data-xl-items="{{ count($banner_2_imags) }}" data-lg-items="{{ $data_md }}"
                    data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true"
                    data-dots="false">
                    @foreach ($banner_2_imags as $key => $value)
                        <div class="carousel-box overflow-hidden hov-scale-img">
                            <a href="{{ isset(json_decode($home_banner2_links, true)[$key]) ? json_decode($home_banner2_links, true)[$key] : '' }}"
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

  

    <!-- Banner Section 3 -->
    @php $homeBanner3Images = get_setting('home_banner3_images', null, $lang);   @endphp
    @if ($homeBanner3Images != null)
        <div class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                @php
                    $banner_3_imags = json_decode($homeBanner3Images);
                    $data_md = count($banner_3_imags) >= 2 ? 2 : 1;
                    $home_banner3_links = get_setting('home_banner3_links', null, $lang);
                @endphp
                <div class="aiz-carousel gutters-16 overflow-hidden arrow-inactive-none arrow-dark arrow-x-15"
                    data-items="{{ count($banner_3_imags) }}" data-xxl-items="{{ count($banner_3_imags) }}"
                    data-xl-items="{{ count($banner_3_imags) }}" data-lg-items="{{ $data_md }}"
                    data-md-items="{{ $data_md }}" data-sm-items="1" data-xs-items="1" data-arrows="true"
                    data-dots="false">
                    @foreach ($banner_3_imags as $key => $value)
                        <div class="carousel-box overflow-hidden hov-scale-img">
                            <a href="{{ isset(json_decode($home_banner3_links, true)[$key]) ? json_decode($home_banner3_links, true)[$key] : '' }}"
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

    <!-- Auction Product -->
    @if (addon_is_activated('auction'))
        <div id="auction_products">

        </div>
    @endif

    <!-- Cupon -->
    @if (get_setting('coupon_system') == 1)
        <div class=" mt-2 mt-md-3"
            style="background-color: {{ get_setting('cupon_background_color', '#292933') }}">
            <div class="container">
                <div class="position-relative py-5">
                    <div class="text-center text-xl-left position-relative z-5">
                        <div class="d-lg-flex">
                            <div class="mb-3 mb-lg-0">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="109.602" height="93.34" viewBox="0 0 109.602 93.34">
                                    <defs>
                                        <clipPath id="clip-pathcup">
                                            <path id="Union_10" data-name="Union 10" d="M12263,13778v-15h64v-41h12v56Z"
                                                transform="translate(-11966 -8442.865)" fill="none" stroke="#fff"
                                                stroke-width="2" />
                                        </clipPath>
                                    </defs>
                                    <g id="Group_24326" data-name="Group 24326"
                                        transform="translate(-274.201 -5254.611)">
                                        <g id="Mask_Group_23" data-name="Mask Group 23"
                                            transform="translate(-3652.459 1785.452) rotate(-45)"
                                            clip-path="url(#clip-pathcup)">
                                            <g id="Group_24322" data-name="Group 24322"
                                                transform="translate(207 18.136)">
                                                <g id="Subtraction_167" data-name="Subtraction 167"
                                                    transform="translate(-12177 -8458)" fill="none">
                                                    <path
                                                        d="M12335,13770h-56a8.009,8.009,0,0,1-8-8v-8a8,8,0,0,0,0-16v-8a8.009,8.009,0,0,1,8-8h56a8.009,8.009,0,0,1,8,8v8a8,8,0,0,0,0,16v8A8.009,8.009,0,0,1,12335,13770Z"
                                                        stroke="none" />
                                                    <path
                                                        d="M 12335.0009765625 13768.0009765625 C 12338.3095703125 13768.0009765625 12341.0009765625 13765.30859375 12341.0009765625 13762 L 12341.0009765625 13755.798828125 C 12336.4423828125 13754.8701171875 12333.0009765625 13750.8291015625 12333.0009765625 13746 C 12333.0009765625 13741.171875 12336.4423828125 13737.130859375 12341.0009765625 13736.201171875 L 12341.0009765625 13729.9990234375 C 12341.0009765625 13726.6904296875 12338.3095703125 13723.9990234375 12335.0009765625 13723.9990234375 L 12278.9990234375 13723.9990234375 C 12275.6904296875 13723.9990234375 12272.9990234375 13726.6904296875 12272.9990234375 13729.9990234375 L 12272.9990234375 13736.201171875 C 12277.5576171875 13737.1298828125 12280.9990234375 13741.1708984375 12280.9990234375 13746 C 12280.9990234375 13750.828125 12277.5576171875 13754.869140625 12272.9990234375 13755.798828125 L 12272.9990234375 13762 C 12272.9990234375 13765.30859375 12275.6904296875 13768.0009765625 12278.9990234375 13768.0009765625 L 12335.0009765625 13768.0009765625 M 12335.0009765625 13770.0009765625 L 12278.9990234375 13770.0009765625 C 12274.587890625 13770.0009765625 12270.9990234375 13766.412109375 12270.9990234375 13762 L 12270.9990234375 13754 C 12275.4111328125 13753.9990234375 12278.9990234375 13750.4111328125 12278.9990234375 13746 C 12278.9990234375 13741.5888671875 12275.41015625 13738 12270.9990234375 13738 L 12270.9990234375 13729.9990234375 C 12270.9990234375 13725.587890625 12274.587890625 13721.9990234375 12278.9990234375 13721.9990234375 L 12335.0009765625 13721.9990234375 C 12339.412109375 13721.9990234375 12343.0009765625 13725.587890625 12343.0009765625 13729.9990234375 L 12343.0009765625 13738 C 12338.5888671875 13738.0009765625 12335.0009765625 13741.5888671875 12335.0009765625 13746 C 12335.0009765625 13750.4111328125 12338.58984375 13754 12343.0009765625 13754 L 12343.0009765625 13762 C 12343.0009765625 13766.412109375 12339.412109375 13770.0009765625 12335.0009765625 13770.0009765625 Z"
                                                        stroke="none" fill="#fff" />
                                                </g>
                                            </g>
                                        </g>
                                        <g id="Group_24321" data-name="Group 24321"
                                            transform="translate(-3514.477 1653.317) rotate(-45)">
                                            <g id="Subtraction_167-2" data-name="Subtraction 167"
                                                transform="translate(-12177 -8458)" fill="none">
                                                <path
                                                    d="M12335,13770h-56a8.009,8.009,0,0,1-8-8v-8a8,8,0,0,0,0-16v-8a8.009,8.009,0,0,1,8-8h56a8.009,8.009,0,0,1,8,8v8a8,8,0,0,0,0,16v8A8.009,8.009,0,0,1,12335,13770Z"
                                                    stroke="none" />
                                                <path
                                                    d="M 12335.0009765625 13768.0009765625 C 12338.3095703125 13768.0009765625 12341.0009765625 13765.30859375 12341.0009765625 13762 L 12341.0009765625 13755.798828125 C 12336.4423828125 13754.8701171875 12333.0009765625 13750.8291015625 12333.0009765625 13746 C 12333.0009765625 13741.171875 12336.4423828125 13737.130859375 12341.0009765625 13736.201171875 L 12341.0009765625 13729.9990234375 C 12341.0009765625 13726.6904296875 12338.3095703125 13723.9990234375 12335.0009765625 13723.9990234375 L 12278.9990234375 13723.9990234375 C 12275.6904296875 13723.9990234375 12272.9990234375 13726.6904296875 12272.9990234375 13729.9990234375 L 12272.9990234375 13736.201171875 C 12277.5576171875 13737.1298828125 12280.9990234375 13741.1708984375 12280.9990234375 13746 C 12280.9990234375 13750.828125 12277.5576171875 13754.869140625 12272.9990234375 13755.798828125 L 12272.9990234375 13762 C 12272.9990234375 13765.30859375 12275.6904296875 13768.0009765625 12278.9990234375 13768.0009765625 L 12335.0009765625 13768.0009765625 M 12335.0009765625 13770.0009765625 L 12278.9990234375 13770.0009765625 C 12274.587890625 13770.0009765625 12270.9990234375 13766.412109375 12270.9990234375 13762 L 12270.9990234375 13754 C 12275.4111328125 13753.9990234375 12278.9990234375 13750.4111328125 12278.9990234375 13746 C 12278.9990234375 13741.5888671875 12275.41015625 13738 12270.9990234375 13738 L 12270.9990234375 13729.9990234375 C 12270.9990234375 13725.587890625 12274.587890625 13721.9990234375 12278.9990234375 13721.9990234375 L 12335.0009765625 13721.9990234375 C 12339.412109375 13721.9990234375 12343.0009765625 13725.587890625 12343.0009765625 13729.9990234375 L 12343.0009765625 13738 C 12338.5888671875 13738.0009765625 12335.0009765625 13741.5888671875 12335.0009765625 13746 C 12335.0009765625 13750.4111328125 12338.58984375 13754 12343.0009765625 13754 L 12343.0009765625 13762 C 12343.0009765625 13766.412109375 12339.412109375 13770.0009765625 12335.0009765625 13770.0009765625 Z"
                                                    stroke="none" fill="#fff" />
                                            </g>
                                            <g id="Group_24325" data-name="Group 24325">
                                                <rect id="Rectangle_18578" data-name="Rectangle 18578" width="8"
                                                    height="2" transform="translate(120 5287)" fill="#fff" />
                                                <rect id="Rectangle_18579" data-name="Rectangle 18579" width="8"
                                                    height="2" transform="translate(132 5287)" fill="#fff" />
                                                <rect id="Rectangle_18581" data-name="Rectangle 18581" width="8"
                                                    height="2" transform="translate(144 5287)" fill="#fff" />
                                                <rect id="Rectangle_18580" data-name="Rectangle 18580" width="8"
                                                    height="2" transform="translate(108 5287)" fill="#fff" />
                                            </g>
                                        </g>
                                    </g>
                                </svg>
                            </div>
                            <div class="ml-lg-3">
                                <h5 class="fs-36 fw-400 text-white mb-3">{{ translate(get_setting('cupon_title')) }}</h5>
                                <h5 class="fs-20 fw-400 text-gray">{{ translate(get_setting('cupon_subtitle')) }}</h5>
                                <div class="mt-5 pt-5">
                                    <a href="{{ route('coupons.all') }}"
                                        class="btn text-white hov-bg-white hov-text-dark border border-width-2 fs-16 px-5"
                                        style="border-radius: 28px;background: rgba(255, 255, 255, 0.2);box-shadow: 0px 20px 30px rgba(0, 0, 0, 0.16);">{{ translate('View All Coupons') }}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute right-0 bottom-0 h-100">
                        <img class="img-fit h-100" src="{{ uploaded_asset(get_setting('coupon_background_image', null, $lang)) }}"
                            onerror="this.onerror=null;this.src='{{ static_asset('assets/img/coupon.svg') }}';"
                            alt="{{ env('APP_NAME') }} promo">
                    </div>
                </div>
            </div>
        </div>
    @endif

<!-- Category wise Products 
    <div id="section_home_categories" style="background: #f5f5fa;">
        

    </div>

    @if (addon_is_activated('preorder'))
        <!-- Newest Preorder Products 
        @include('preorder.frontend.home_page.newest_preorder')
    @endif

    <!-- Classified Product 
    @if (get_setting('classified_product') == 1)
        @php
            $classified_products = get_home_page_classified_products(6);
        @endphp
        @if (count($classified_products) > 0)
            <section class="mb-2 mb-md-3 mt-3 mt-md-5">
                <div class="container">
                    <!-- Top Section 
                    <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                        <!-- Title 
                        <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                            <span class="">{{ translate('Classified Ads') }}</span>
                        </h3>
                        <!-- Links 
                        <div class="d-flex">
                            <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                                href="{{ route('customer.products') }}">{{ translate('View All Products') }}</a>
                        </div>
                    </div>
                    <!-- Banner 
                    @php
                        $classifiedBannerImage = get_setting('classified_banner_image', null, $lang);
                        $classifiedBannerImageSmall = get_setting('classified_banner_image_small', null, $lang);
                    @endphp
                    @if ($classifiedBannerImage != null || $classifiedBannerImageSmall != null)
                        <div class="mb-3 overflow-hidden hov-scale-img d-none d-md-block">
                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                data-src="{{ uploaded_asset($classifiedBannerImage) }}"
                                alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                        </div>
                        <div class="mb-3 overflow-hidden hov-scale-img d-md-none">
                            <img src="{{ static_asset('assets/img/placeholder-rect.jpg') }}"
                                data-src="{{ $classifiedBannerImageSmall != null ? uploaded_asset($classifiedBannerImageSmall) : uploaded_asset($classifiedBannerImage) }}"
                                alt="{{ env('APP_NAME') }} promo" class="lazyload img-fit h-100 has-transition"
                                onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
                        </div>
                    @endif
                    <!-- Products Section 
                    <div class="bg-white pt-3">
                        <div class="row no-gutters border-top border-left">
                            @foreach ($classified_products as $key => $classified_product)
                                <div
                                    class="col-xl-4 col-md-6 border-right border-bottom has-transition hov-shadow-out z-1">
                                    <div class="aiz-card-box p-2 has-transition bg-white">
                                        <div class="row hov-scale-img">
                                            <div class="col-4 col-md-5 mb-3 mb-md-0">
                                                <a href="{{ route('customer.product', $classified_product->slug) }}"
                                                    class="d-block overflow-hidden h-auto h-md-150px text-center">
                                                    <img class="img-fluid lazyload mx-auto has-transition"
                                                        src="{{ static_asset('assets/img/placeholder.jpg') }}"
                                                        data-src="{{ isset($classified_product->thumbnail->file_name) ? my_asset($classified_product->thumbnail->file_name) : static_asset('assets/img/placeholder.jpg') }}"
                                                        alt="{{ $classified_product->getTranslation('name') }}"
                                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                                </a>
                                            </div>
                                            <div class="col">
                                                <h3
                                                    class="fw-400 fs-14 text-dark text-truncate-2 lh-1-4 mb-3 h-35px d-none d-sm-block">
                                                    <a href="{{ route('customer.product', $classified_product->slug) }}"
                                                        class="d-block text-reset hov-text-primary">{{ $classified_product->getTranslation('name') }}</a>
                                                </h3>
                                                <div class="fs-14 mb-3">
                                                    <span
                                                        class="text-secondary">{{ $classified_product->user ? $classified_product->user->name : '' }}</span><br>
                                                    <span
                                                        class="fw-700 text-primary">{{ single_price($classified_product->unit_price) }}</span>
                                                </div>
                                                @if ($classified_product->conditon == 'new')
                                                    <span
                                                        class="badge badge-inline badge-soft-info fs-13 fw-700 px-3 py-2 text-info"
                                                        style="border-radius: 20px;">{{ translate('New') }}</span>
                                                @elseif($classified_product->conditon == 'used')
                                                    <span
                                                        class="badge badge-inline badge-soft-secondary-base fs-13 fw-700 px-3 py-2 text-danger"
                                                        style="border-radius: 20px;">{{ translate('Used') }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif
    @endif-->




   
 <!-- Top Sellers 
    @if (get_setting('vendor_system_activation') == 1)
        @php
            $best_selers = get_best_sellers(10);
        @endphp
        @if (count($best_selers) > 0)
        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                <!-- Top Section 
                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                    <!-- Title 
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">
                        <span class="pb-3">{{ translate('Top Sellers') }}</span>
                    </h3>
                    <!-- Links 
                    <div class="d-flex">
                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                            href="{{ route('sellers') }}">{{ translate('View All Sellers') }}</a>
                    </div>
                </div>
                <!-- Sellers Section 
                <div class="aiz-carousel arrow-x-0 arrow-inactive-none" data-items="5" data-xxl-items="5"
                    data-xl-items="4" data-lg-items="3.4" data-md-items="2.5" data-sm-items="2" data-xs-items="1.4"
                    data-arrows="true" data-dots="false">
                    @foreach ($best_selers as $key => $seller)
                        @if ($seller->user != null)
                            <div
                                class="carousel-box h-100 position-relative text-center border-right border-top border-bottom @if ($key == 0) border-left @endif has-transition hov-animate-outline">
                                <div class="position-relative px-3" style="padding-top: 2rem; padding-bottom:2rem;">
                                    <!-- Shop logo & Verification Status 
                         
                                    <div class="position-relative mx-auto size-100px size-md-120px">
                                           @php
    // get actual logo URL if exists, otherwise fallback
    $logo = $seller->logo ? uploaded_asset($seller->logo) : static_asset('assets/img/placeholder-rect.jpg');
@endphp

<a href="{{ route('shop.visit', $seller->slug) }}" class="d-flex mx-auto justify-content-center align-item-center size-100px size-md-120px border overflow-hidden hov-scale-img" tabindex="0" style="border: 1px solid #e5e5e5; border-radius: 50%; box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.06);">
    <img src="{{ $logo }}"
         alt="{{ $seller->name }}"
         loading="lazy"
         class="img-fit has-transition"
         onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">



                                        </a>
                                        <div class="absolute-top-right z-1 mr-md-2 mt-1 rounded-content bg-white">
                                            @if ($seller->verification_status == 1)
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001" height="24"
                                                    viewBox="0 0 24.001 24">
                                                    <g id="Group_25929" data-name="Group 25929"
                                                        transform="translate(-480 -345)">
                                                        <circle id="Ellipse_637" data-name="Ellipse 637" cx="12"
                                                            cy="12" r="12" transform="translate(480 345)"
                                                            fill="#fff" />
                                                        <g id="Group_25927" data-name="Group 25927"
                                                            transform="translate(480 345)">
                                                            <path id="Union_5" data-name="Union 5"
                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                transform="translate(0 0)" fill="#3490f3" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            @else
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24.001" height="24"
                                                    viewBox="0 0 24.001 24">
                                                    <g id="Group_25929" data-name="Group 25929"
                                                        transform="translate(-480 -345)">
                                                        <circle id="Ellipse_637" data-name="Ellipse 637" cx="12"
                                                            cy="12" r="12" transform="translate(480 345)"
                                                            fill="#fff" />
                                                        <g id="Group_25927" data-name="Group 25927"
                                                            transform="translate(480 345)">
                                                            <path id="Union_5" data-name="Union 5"
                                                                d="M0,12A12,12,0,1,1,12,24,12,12,0,0,1,0,12Zm1.2,0A10.8,10.8,0,1,0,12,1.2,10.812,10.812,0,0,0,1.2,12Zm1.2,0A9.6,9.6,0,1,1,12,21.6,9.611,9.611,0,0,1,2.4,12Zm5.115-1.244a1.083,1.083,0,0,0,0,1.529l3.059,3.059a1.081,1.081,0,0,0,1.529,0l5.1-5.1a1.084,1.084,0,0,0,0-1.53,1.081,1.081,0,0,0-1.529,0L11.339,13.05,9.045,10.756a1.082,1.082,0,0,0-1.53,0Z"
                                                                transform="translate(0 0)" fill="red" />
                                                        </g>
                                                    </g>
                                                </svg>
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Shop name 
                                    <h2 class="fs-14 fw-700 text-dark text-truncate-2 h-40px mt-3 mt-md-4 mb-0 mb-md-3">
                                        <a href="{{ route('shop.visit', $seller->slug) }}"
                                            class="text-reset hov-text-primary" tabindex="0">{{ $seller->name }}</a>
                                    </h2>
                                    <!-- Shop Rating 
                                    <div class="rating rating-mr-2 text-dark mb-3">
                                        {{ renderStarRating($seller->rating) }}
                                        <span class="opacity-60 fs-14">({{ $seller->num_of_reviews }}
                                            {{ translate('Reviews') }})</span>
                                    </div>
                                    <!-- Visit Button 
                                    <a href="{{ route('shop.visit', $seller->slug) }}" class="btn-visit">
                                        <span class="circle" aria-hidden="true">
                                            <span class="icon arrow"></span>
                                        </span>
                                        <span class="button-text">{{ translate('Visit Store') }}</span>
                                    </a>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </section>
        @endif
    @endif-->
  





<!-- Safe Top Sellers (minimal backend change) -->
@php
    $visibleCount = 6;
    try {
        $best_selers = get_best_sellers($visibleCount);
        $best_selers = collect($best_selers);
    } catch (\Throwable $e) {
        \Log::error('get_best_sellers error: ' . $e->getMessage());
        $best_selers = collect();
    }

    // If empty, fallback to DB query (minimal assumptions)
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
    <h2 class="section-title mb-3">{{ translate('Artists') }}</h2>
    <div class="artists-grid">
      @foreach ($best_selers->take($visibleCount) as $seller)
        @php
          $works = $seller->products_count ?? $seller->works_count ?? 0;
          $logo = $seller->logo ? uploaded_asset($seller->logo) : static_asset('assets/img/placeholder-rect.jpg');
        @endphp
        <a href="{{ route('shop.visit', $seller->slug ?? route('sellers')) }}" class="artist-card" aria-label="{{ $seller->name ?? '' }}">
          <div class="artist-avatar">
              @php
  $logoUrl = static_asset('assets/img/placeholder-rect.jpg');

  if (!empty($seller->logo)) {
      // prefer uploaded_asset() if it returns a URL
      try {
          $ua = uploaded_asset($seller->logo);
          if (!empty($ua)) {
              $logoUrl = $ua;
          } elseif (filter_var($seller->logo, FILTER_VALIDATE_URL)) {
              $logoUrl = $seller->logo;
          } else {
              // try asset() then Storage::url()
              if (file_exists(public_path($seller->logo))) {
                  $logoUrl = asset($seller->logo);
              } else {
                  try { $logoUrl = \Illuminate\Support\Facades\Storage::url($seller->logo); } catch (\Throwable $ex) {}
              }
          }
      } catch (\Throwable $e) {
          if (filter_var($seller->logo, FILTER_VALIDATE_URL)) { $logoUrl = $seller->logo; }
          else { try { $logoUrl = asset($seller->logo); } catch (\Throwable $ex) {} }
      }
  }
@endphp

<img
  src="{{ $logoUrl }}"
  alt="{{ e($seller->name ?? 'Seller') }}"
  style="width:120px;height:120px;object-fit:cover;border-radius:50%;"
  onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder-rect.jpg') }}';">
  </div>

          <div class="artist-name">{{ strtoupper($seller->name ?? 'â€”') }}</div>
          <!--<div class="artist-count">{{ $works }} {{ translate('works') }}</div>-->
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
  {{-- Optional: show nothing or a small message --}}
  <div class="container"><div class="text-muted py-2">No sellers available right now.</div></div>
@endif
<style>

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
</style>







    <!-- Top Brands 
    @if (get_setting('top_brands') != null)
        <section class="mb-2 mb-md-3 mt-2 mt-md-3">
            <div class="container">
                <!-- Top Section 
                <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                    <!-- Title 
                    <h3 class="fs-16 fs-md-20 fw-700 mb-2 mb-sm-0">{{ translate('Top Brands') }}</h3>
                    <!-- Links 
                    <div class="d-flex">
                        <a class="text-blue fs-10 fs-md-12 fw-700 hov-text-primary animate-underline-primary"
                            href="{{ route('brands.all') }}">{{ translate('View All Brands') }}</a>
                    </div>
                </div>
                <!-- Brands Section 
                <div class="bg-white px-3">
                    <div
                        class="row row-cols-xxl-6 row-cols-xl-6 row-cols-lg-4 row-cols-md-4 row-cols-3 gutters-16 border-top border-left">
                        @php
                            $top_brands = json_decode(get_setting('top_brands'));
                            $brands = get_brands($top_brands);
                        @endphp
                        @foreach ($brands as $brand)
                            <div
                                class="col text-center border-right border-bottom hov-scale-img has-transition hov-shadow-out z-1">
                                <a href="{{ route('products.brand', $brand->slug) }}" class="d-block p-sm-3">
                                    <img src="{{ $brand->logo != null ? uploaded_asset($brand->logo)  : static_asset('assets/img/placeholder.jpg') }}"
                                        class="lazyload h-100 h-md-100px mx-auto has-transition p-2 p-sm-4 mw-100"
                                        alt="{{ $brand->getTranslation('name') }}"
                                        onerror="this.onerror=null;this.src='{{ static_asset('assets/img/placeholder.jpg') }}';">
                                    <p class="text-center text-dark fs-12 fs-md-14 fw-700 mt-2">
                                        {{ $brand->getTranslation('name') }}
                                    </p>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif-->
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

