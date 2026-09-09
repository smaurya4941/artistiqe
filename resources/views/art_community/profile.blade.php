@extends('art_community.layouts.app', ['role' => $role])

@php
    if (! function_exists('ac_field')) {
        function ac_field($name, $label, $value, $type = 'text', $errors = null) {
            $err = $errors && $errors->has($name) ? $errors->first($name) : null;
            $out = '<div><label>'.e($label).'</label>';
            if ($type === 'textarea') {
                $out .= '<textarea name="'.e($name).'" rows="4">'.e($value).'</textarea>';
            } else {
                $out .= '<input type="'.e($type).'" name="'.e($name).'" value="'.e($value).'">';
            }
            if ($err) { $out .= '<div class="field-err">'.e($err).'</div>'; }
            return $out.'</div>';
        }
    }
@endphp

@section('content')
    <div class="ac-head">
        <div>
            <h1>Edit profile</h1>
            <p>Keep your details up to date. Your profile is {{ $completeness }}% complete.</p>
        </div>
        <span class="badge {{ $profile->status }}">{{ ucfirst($profile->status) }}</span>
    </div>

    @if($errors->any())
        <div class="ac-alert warn">{{ translate('Please correct the highlighted fields.') }}</div>
    @endif

    <form method="POST" action="{{ route($role . '.profile.update') }}" class="ac-panel">
        @csrf

        <h3>Account</h3>
        <div class="form-row">
            {!! ac_field('name', translate('Display name'), old('name', $user->name), 'text', $errors) !!}
            {!! ac_field('phone', translate('Phone'), old('phone', $user->phone), 'text', $errors) !!}
            <div><label>{{ translate('Email') }}</label><input type="text" value="{{ $user->email }}" disabled></div>
        </div>

        @if($role === 'artist')
            <h3 style="margin-top:22px;">Artist details</h3>
            <div class="form-row">
                {!! ac_field('first_name', translate('First name'), old('first_name', $profile->first_name), 'text', $errors) !!}
                {!! ac_field('last_name', translate('Last name'), old('last_name', $profile->last_name), 'text', $errors) !!}
                {!! ac_field('college', translate('College'), old('college', $profile->college), 'text', $errors) !!}
                {!! ac_field('degree', translate('Degree'), old('degree', $profile->degree), 'text', $errors) !!}
                {!! ac_field('portfolio', translate('Portfolio link'), old('portfolio', $profile->portfolio), 'text', $errors) !!}
            </div>
            <div class="form-row" style="margin-top:14px;">
                {!! ac_field('address1', translate('Address line 1'), old('address1', $profile->address1), 'text', $errors) !!}
                {!! ac_field('address2', translate('Address line 2'), old('address2', $profile->address2), 'text', $errors) !!}
                {!! ac_field('city', translate('City'), old('city', $profile->city), 'text', $errors) !!}
                {!! ac_field('state', translate('State'), old('state', $profile->state), 'text', $errors) !!}
                {!! ac_field('country', translate('Country'), old('country', $profile->country), 'text', $errors) !!}
                {!! ac_field('pincode', translate('Pincode'), old('pincode', $profile->pincode), 'text', $errors) !!}
            </div>
            <div style="margin-top:14px;">{!! ac_field('journey', translate('Your journey'), old('journey', $profile->journey), 'textarea', $errors) !!}</div>

        @elseif($role === 'collector')
            <h3 style="margin-top:22px;">Collector details</h3>
            <div class="form-row">
                {!! ac_field('first_name', translate('First name'), old('first_name', $profile->first_name), 'text', $errors) !!}
                {!! ac_field('last_name', translate('Last name'), old('last_name', $profile->last_name), 'text', $errors) !!}
                {!! ac_field('address_line1', translate('Address line 1'), old('address_line1', $profile->address_line1), 'text', $errors) !!}
                {!! ac_field('address_line2', translate('Address line 2'), old('address_line2', $profile->address_line2), 'text', $errors) !!}
                {!! ac_field('city', translate('City'), old('city', $profile->city), 'text', $errors) !!}
                {!! ac_field('state', translate('State'), old('state', $profile->state), 'text', $errors) !!}
                {!! ac_field('country', translate('Country'), old('country', $profile->country), 'text', $errors) !!}
                {!! ac_field('zip', translate('ZIP'), old('zip', $profile->zip), 'text', $errors) !!}
                {!! ac_field('sell_interest', translate('Interested in selling'), old('sell_interest', $profile->sell_interest), 'text', $errors) !!}
            </div>
            <div style="margin-top:14px;">{!! ac_field('journey', translate('Your journey as a collector'), old('journey', $profile->journey), 'textarea', $errors) !!}</div>

        @elseif($role === 'gallery')
            <h3 style="margin-top:22px;">Gallery details</h3>
            <div class="form-row">
                {!! ac_field('owner_name', translate('Owner name'), old('owner_name', $profile->owner_name), 'text', $errors) !!}
                {!! ac_field('owner_surname', translate('Owner surname'), old('owner_surname', $profile->owner_surname), 'text', $errors) !!}
                {!! ac_field('gallery_name', translate('Gallery name'), old('gallery_name', $profile->gallery_name), 'text', $errors) !!}
                {!! ac_field('website', translate('Website'), old('website', $profile->website), 'text', $errors) !!}
            </div>
            <div class="form-row" style="margin-top:14px;">
                {!! ac_field('address1', translate('Address line 1'), old('address1', $profile->address1), 'text', $errors) !!}
                {!! ac_field('address2', translate('Address line 2'), old('address2', $profile->address2), 'text', $errors) !!}
                {!! ac_field('city', translate('City'), old('city', $profile->city), 'text', $errors) !!}
                {!! ac_field('state', translate('State'), old('state', $profile->state), 'text', $errors) !!}
                {!! ac_field('country', translate('Country'), old('country', $profile->country), 'text', $errors) !!}
                {!! ac_field('pincode', translate('Pincode'), old('pincode', $profile->pincode), 'text', $errors) !!}
                {!! ac_field('exhibition_types', translate('Exhibition types'), old('exhibition_types', $profile->exhibition_types), 'text', $errors) !!}
                {!! ac_field('past_links', translate('Past exhibition links'), old('past_links', $profile->past_links), 'text', $errors) !!}
                {!! ac_field('sell_interest', translate('Interested in selling'), old('sell_interest', $profile->sell_interest), 'text', $errors) !!}
            </div>
            <div style="margin-top:14px;">{!! ac_field('curatorial_vision', translate('Curatorial vision'), old('curatorial_vision', $profile->curatorial_vision), 'textarea', $errors) !!}</div>
        @endif

        <div style="margin-top:20px;">
            <button type="submit" class="btn">{{ translate('Save changes') }}</button>
            <a href="{{ route($role . '.dashboard') }}" class="btn ghost">{{ translate('Cancel') }}</a>
        </div>
    </form>
@endsection
