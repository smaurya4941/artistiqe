@if (count(get_featured_products()) > 0)
    <section class="mb-2 mb-md-3 mt-2 mt-md-3">
        <div class="container">
            <!-- Top Section -->
            <div class="d-flex mb-2 mb-md-3 align-items-baseline justify-content-between">
                <!-- Title -->
               <!--  <h3 class="section-title mb-2 mb-sm-0">
                    <span class="">{{ translate('Art for Sale') }}</span>
                </h3> -->
                <!-- Links -->
<!--                 <div class="d-flex">
                    <a type="button" class="arrow-prev slide-arrow link-disable text-secondary mr-2" onclick="clickToSlide('slick-prev','section_featured')"><i class="las la-angle-left fs-20 fw-600" style="color:#74747c;"></i></a>
                    <a type="button" class="arrow-next slide-arrow text-secondary ml-2" onclick="clickToSlide('slick-next','section_featured')"><i class="las la-angle-right fs-20 fw-600" style="color:#74747c;"></i></a>
                </div> -->
            </div>
            <!-- Products Section -->
            <div class="px-sm-3">
                <div class="aiz-carousel art-sale-carousel"
     data-items="3"
     data-lg-items="3"
     data-md-items="2"
     data-sm-items="1"
     data-xs-items="1"
     data-arrows="true"
     data-dots="false">

                    @foreach (get_featured_products() as $key => $product)
                    <div class="carousel-box position-relative px-3 has-transition hov-animate-outline border-right border-top border-bottom @if($key == 0) border-left @endif">
                        <div class="px-3">
                            @include('frontend.'.get_setting('homepage_select').'.partials.product_box_1',['product' => $product])
                        </div>
                    </div>

                    @endforeach
                </div>
            </div>
            <div class="text-center mt-4">
    <a href="{{ route('search') }}" class="view-all-products">
        View All Artworks
    </a>
</div>

        </div>
    </section>   
@endif
<style>
    /* ART FOR SALE arrows */
/* ================= ART FOR SALE – SIDE ARROWS ================= */
/* ================= VIEW ALL PRODUCTS ================= */
/*.aiz-carousel art-sale-carousel{*/
/*    height:1280px;*/
/*    width: 541px;*/
/*}*/
.view-all-products {
    font-family: 'Inter', sans-serif;
    font-size: 22px;
    color: #111;
    text-decoration: none;
    gap: 30px;
    /*border-bottom: 1px solid #111;*/
    padding-bottom: 2px;
    
}

.view-all-products:hover {
    opacity: 0.7;
}

/* ================= ART FOR SALE SLIDER ARROWS FIX ================= */

/* parent relative */
.art-sale-carousel {
    position: relative;
}

/* slick arrows common */
.art-sale-carousel .slick-arrow {
    position: absolute;
    top: 45%;                 /* vertically center */
    transform: translateY(-50%);
    z-index: 10;

    background: transparent !important;
    border: none !important;
    font-size: 30px !important;
    color: #999 !important;
}

/* LEFT ARROW – bahar le jao */
.art-sale-carousel .slick-prev {
    left: -45px !important;   /* 👈 image se bahar */
}

/* RIGHT ARROW – bahar le jao */
.art-sale-carousel .slick-next {
    right: -45px !important;  /* 👈 image se bahar */
}

/* hover effect */
.art-sale-carousel .slick-arrow:hover {
    color: #111 !important;
}

/* mobile me arrows andar rakho (space kam hota hai) */
@media (max-width: 768px) {
    .art-sale-carousel .slick-prev {
        left: -10px !important;
    }
    .art-sale-carousel .slick-next {
        right: -10px !important;
    }
}

</style>