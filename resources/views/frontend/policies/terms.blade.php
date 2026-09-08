@extends('frontend.layouts.app')

@section('meta_title'){{ $page->meta_title }}@stop
@section('meta_description'){{ $page->meta_description }}@stop
@section('meta_keywords'){{ $page->tags }}@stop

@section('content')
<section class="pt-4 mb-4">
    <div class="container text-center">
        <div class="row">
            <div class="col-lg-6 text-center text-lg-left">
                <h1 class="cms-page-heading">{{ $page->getTranslation('title') }}</h1>
            </div>

            <div class="col-lg-6">
                <ul class="breadcrumb bg-transparent p-0 justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item has-transition opacity-50 hov-opacity-100">
                        <a class="text-reset" href="{{ route('home') }}">{{ translate('Home')}}</a>
                    </li>
                    <li class="text-dark fw-600 breadcrumb-item">
                        "{{ $page->getTranslation('title') }}"
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="mb-4">
    <div class="container">
        <div class="p-4 bg-white rounded shadow-sm overflow-hidden mw-100 cms-page-content">
            {!! $page->getTranslation('content') !!}
        </div>
    </div>
</section>
@endsection
<style>
    /* ===== CMS PAGE STYLING ===== */
.cms-page-heading {
    font-family: 'Poppins', 'Segoe UI', sans-serif;
    font-weight: 700;
    font-size: 1.5rem;         /* Desktop size */
    line-height: 1.4;
    color: #222;             /* Dark readable color */
    margin-bottom: 0rem;
    text-transform: capitalize;
}

@media (max-width: 768px) {
    .cms-page-heading {
        font-size: 1.6rem;   /* Adjust for tablets/mobiles */
    }
}

.cms-page-content {
    font-family: 'Open Sans', 'Segoe UI', sans-serif;
    font-size: 1.05rem;
    line-height: 1.9;
    color: #444;
}

.cms-page-content h2, 
.cms-page-content h3 {
    font-family: 'Poppins', sans-serif;
    font-weight: 400;
    margin-top: 0.1rem;
    margin-bottom: 0.75rem;
    color: #111;
}

.cms-page-content p {
    margin-bottom: 1.2rem;
}

</style>