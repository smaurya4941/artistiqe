<section class="mb-4">
    <div class="container">
<div class="bg-white mb-4 border">
    <div class="container p-3 p-sm-4"> <!-- ✅ added container -->
        <!-- Tabs -->
        <!-- Tabs -->
<div class="nav aiz-nav-tabs">
    <a href="#tab_default_1" data-toggle="tab"
       class="mr-5 pb-2 fs-16 fw-700 text-reset active show"
       style="margin:0 0 12px;
              font:700 22px/1.2 system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
              line-height:1.05;">
        {{ translate('About the Artwork') }}
    </a>

    @if ($detailedProduct->video_link != null)
        <a href="#tab_default_2" data-toggle="tab"
           class="mr-5 pb-2 fs-16 fw-700 text-reset"
           style="margin:0 0 12px;
                  font:700 22px/1.2 system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
                  line-height:1.05;">
            {{ translate('Video') }}
        </a>
    @endif

    @if ($detailedProduct->pdf != null)
        <a href="#tab_default_3" data-toggle="tab"
           class="mr-5 pb-2 fs-16 fw-700 text-reset"
           style="margin:0 0 12px;
                  font:700 22px/1.2 system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
                  line-height:1.05;">
            {{ translate('Downloads') }}
        </a>
    @endif
</div>


        <!-- Description -->
        <div class="tab-content pt-0">
            <!-- Description -->
            <div class="tab-pane fade active show" id="tab_default_1">
                <div class="py-5">
                    <div class="mw-100 overflow-hidden text-left aiz-editor-data">
                        <?php echo $detailedProduct->getTranslation('description'); ?>
                    </div>
                </div>
            </div>

            <!-- Video -->
            <div class="tab-pane fade" id="tab_default_2">
                <div class="py-5">
                    <div class="embed-responsive embed-responsive-16by9">
                        @if ($detailedProduct->video_provider == 'youtube' && isset(explode('=', $detailedProduct->video_link)[1]))
                            <iframe class="embed-responsive-item"
                                src="https://www.youtube.com/embed/{{ get_url_params($detailedProduct->video_link, 'v') }}"></iframe>
                        @elseif ($detailedProduct->video_provider == 'dailymotion' && isset(explode('video/', $detailedProduct->video_link)[1]))
                            <iframe class="embed-responsive-item"
                                src="https://www.dailymotion.com/embed/video/{{ explode('video/', $detailedProduct->video_link)[1] }}"></iframe>
                        @elseif ($detailedProduct->video_provider == 'vimeo' && isset(explode('vimeo.com/', $detailedProduct->video_link)[1]))
                            <iframe
                                src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $detailedProduct->video_link)[1] }}"
                                width="500" height="281" frameborder="0" webkitallowfullscreen
                                mozallowfullscreen allowfullscreen></iframe>
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Download -->
            <div class="tab-pane fade" id="tab_default_3">
                <div class="py-5 text-center ">
                    <a href="{{ uploaded_asset($detailedProduct->pdf) }}"
                        class="btn btn-primary">{{ translate('Download') }}</a>
                </div>
            </div>
        </div>
    </div>
</div>
  </div>
</section>
  <style>
  .aiz-main-wrapper { min-height: auto !important; }
  
/* Make About the Artwork text look uniform */
.aiz-editor-data, 
.aiz-editor-data * {
    all: revert; /* reset everything first */
    font-family: system-ui, -apple-system, 'Segoe UI', Roboto, Arial, sans-serif !important;
    font-size: 1rem !important;
    line-height: 1.6 !important;
    color: #000 !important;
    font-weight: 400 !important;
    text-align: left !important;
}

/* Ensure lists and spacing look consistent */
.aiz-editor-data ul,
.aiz-editor-data ol {
    margin-left: 1.5rem !important;
    padding-left: 0 !important;
}

.aiz-editor-data li {
    margin-bottom: 0.4rem !important;
}

/* Make headings clean and consistent */
.aiz-editor-data h1,
.aiz-editor-data h2,
.aiz-editor-data h3,
.aiz-editor-data h4,
.aiz-editor-data h5 {
    font-weight: 700 !important;
    margin-top: 1rem !important;
    margin-bottom: 0.5rem !important;
    font-size: 1.1rem !important;
}

/* Paragraph styling */
.aiz-editor-data p {
    margin-bottom: 1rem !important;
}
/* 🎨 Override padding only for About the Artwork section */
#tab_default_1 .py-5 {
    padding-top: 0rem !important;   /* reduce from 3rem */
    padding-bottom: 0rem !important; /* reduce from 3rem */
}


</style>
