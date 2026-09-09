@extends('backend.layouts.app')

@section('content')

@php
    $cdnEnabled   = get_setting('image_cdn_enabled') == 1;
    $cloudName    = get_setting('image_cdn_cloud_name');
    $transform    = get_setting('image_cdn_default_transform') ?: 'f_auto,q_auto,dpr_auto';
    $includeTheme = get_setting('image_cdn_include_theme') == 1;
    $apiKey       = get_setting('cloudinary_api_key');
    $apiSecret    = get_setting('cloudinary_api_secret');
    $sampleOrigin = static_asset('assets/img/placeholder.jpg');
@endphp

<div class="aiz-titlebar text-left mt-2 mb-3">
    <div class="row align-items-center">
        <div class="col-md-6">
            <h1 class="h3">{{ translate('Image CDN') }}</h1>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-7">

        {{-- Activation --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Cloudinary Delivery (Fetch mode)') }}</h5>
            </div>
            <div class="card-body">
                <p class="text-muted fs-13">
                    {{ translate('When enabled, product / artwork / banner images are delivered through Cloudinary — auto-converted to WebP/AVIF, compressed and served from a global CDN. No files are moved; Cloudinary fetches each image from this site once and caches it. Requires a publicly reachable domain (it will not activate on localhost).') }}
                </p>
                <div class="form-group row mb-0 align-items-center">
                    <div class="col-md-8">
                        <label class="control-label mb-0">{{ translate('Enable Image CDN') }}</label>
                    </div>
                    <div class="col-md-4 text-md-right">
                        <label class="aiz-switch aiz-switch-success mb-0">
                            <input type="checkbox" id="image_cdn_enabled" {{ $cdnEnabled ? 'checked' : '' }}
                                   onchange="toggleCdn(this)">
                            <span></span>
                        </label>
                    </div>
                </div>
            </div>
        </div>

        {{-- Credentials + transform --}}
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0 h6">{{ translate('Cloudinary Configuration') }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('business_settings.update') }}" method="POST">
                    @csrf

                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="image_cdn_cloud_name">
                        <div class="col-md-4"><label class="control-label">{{ translate('Cloud name') }}</label></div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="image_cdn_cloud_name"
                                   value="{{ $cloudName }}" placeholder="e.g. dxxxxxxxxx">
                            <small class="text-muted">{{ translate('From Cloudinary dashboard → Product Environment Credentials → "Cloud name" (the part in res.cloudinary.com/<cloud-name>/…).') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="image_cdn_default_transform">
                        <div class="col-md-4"><label class="control-label">{{ translate('Default transformation') }}</label></div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="image_cdn_default_transform"
                                   value="{{ $transform }}" placeholder="f_auto,q_auto,dpr_auto">
                            <small class="text-muted">{{ translate('Applied to every image. Recommended: f_auto,q_auto,dpr_auto (auto format + quality + retina).') }}</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="cloudinary_api_key">
                        <div class="col-md-4"><label class="control-label">{{ translate('API Key') }}</label></div>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cloudinary_api_key" value="{{ $apiKey }}"
                                   placeholder="{{ translate('Optional — only needed for direct uploads (Phase 2)') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="cloudinary_api_secret">
                        <div class="col-md-4"><label class="control-label">{{ translate('API Secret') }}</label></div>
                        <div class="col-md-8">
                            <input type="password" class="form-control" name="cloudinary_api_secret"
                                   value="{{ $apiSecret }}" autocomplete="new-password"
                                   placeholder="{{ translate('Optional — only needed for direct uploads (Phase 2)') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <input type="hidden" name="types[]" value="image_cdn_include_theme">
                        <input type="hidden" name="image_cdn_include_theme" value="0">
                        <div class="col-md-8"><label class="control-label mb-0">{{ translate('Also route theme images') }} (assets/img/*.jpg,png,webp)</label></div>
                        <div class="col-md-4 text-md-right">
                            <label class="aiz-switch mb-0">
                                <input type="checkbox" name="image_cdn_include_theme" value="1" {{ $includeTheme ? 'checked' : '' }}>
                                <span></span>
                            </label>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-12 text-right">
                            <button type="submit" class="btn btn-primary">{{ translate('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-xl-5">
        <div class="card">
            <div class="card-header"><h5 class="mb-0 h6">{{ translate('Status') }}</h5></div>
            <div class="card-body">
                <table class="table table-sm mb-3">
                    <tr>
                        <th>{{ translate('CDN') }}</th>
                        <td>
                            @if($cdnEnabled && $cloudName)
                                <span class="badge badge-success">{{ translate('Active') }}</span>
                            @elseif($cdnEnabled && !$cloudName)
                                <span class="badge badge-warning">{{ translate('Enabled but Cloud name missing') }}</span>
                            @else
                                <span class="badge badge-secondary">{{ translate('Disabled') }}</span>
                            @endif
                        </td>
                    </tr>
                    <tr><th>{{ translate('Cloud name') }}</th><td>{{ $cloudName ?: '—' }}</td></tr>
                    <tr><th>{{ translate('Transform') }}</th><td><code>{{ $transform }}</code></td></tr>
                    <tr><th>{{ translate('Environment') }}</th><td>{{ config('app.env') }} @if(config('app.env') === 'local')<span class="text-warning">({{ translate('CDN inactive on localhost') }})</span>@endif</td></tr>
                </table>

                <p class="fs-13 fw-600 mb-1">{{ translate('Delivery URL preview') }}</p>
                @if($cdnEnabled && $cloudName)
                    <code class="d-block text-wrap fs-11 bg-light p-2 rounded">https://res.cloudinary.com/{{ $cloudName }}/image/fetch/{{ $transform }}/{{ rtrim(config('app.url'),'/') }}/uploads/…</code>
                @else
                    <span class="text-muted fs-12">{{ translate('Enable the CDN and set a Cloud name to see the delivery URL.') }}</span>
                @endif

                <hr>
                <p class="fs-12 text-muted mb-1">{{ translate('Sample image (rendered via uploaded_asset placeholder):') }}</p>
                <img src="{{ cdn_image($sampleOrigin) }}" alt="preview" class="img-fluid border rounded" style="max-height:120px">
                <p class="fs-11 text-muted mt-1 text-break">{{ cdn_image($sampleOrigin) }}</p>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5 class="mb-0 h6">{{ translate('Notes') }}</h5></div>
            <div class="card-body fs-12 text-muted">
                <ul class="pl-3 mb-0">
                    <li>{{ translate('SVG, GIF and video pass through untouched.') }}</li>
                    <li>{{ translate('The oversized theme SVG hero images are NOT fixed by this — re-export them as compressed WebP.') }}</li>
                    <li>{{ translate('Free Cloudinary tier ≈ 25 GB/month. Put Cloudflare in front to cut delivery bandwidth.') }}</li>
                    <li>{{ translate('Turn the toggle off for an instant rollback to origin images.') }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@section('script')
<script>
    function toggleCdn(el) {
        @if(env('DEMO_MODE') == 'On')
            AIZ.plugins.notify('info', '{{ translate('Data can not change in demo mode.') }}');
            el.checked = !el.checked;
            return;
        @endif
        $.post('{{ route('business_settings.update.activation') }}', {
            _token: '{{ csrf_token() }}',
            type: 'image_cdn_enabled',
            value: el.checked ? 1 : 0
        }, function (data) {
            if (data == 1) {
                AIZ.plugins.notify('success', '{{ translate('Settings updated successfully') }}');
                setTimeout(function () { location.reload(); }, 600);
            } else {
                AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
                el.checked = !el.checked;
            }
        }).fail(function () {
            AIZ.plugins.notify('danger', '{{ translate('Something went wrong') }}');
            el.checked = !el.checked;
        });
    }
</script>
@endsection
