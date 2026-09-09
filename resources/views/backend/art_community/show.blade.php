@extends('backend.layouts.app')

@php
    $u = $record->user;
    $fields = match ($slug) {
        'artists' => [
            'College' => $record->college, 'Degree' => $record->degree, 'Portfolio' => $record->portfolio,
            'Address' => trim(($record->address1 ?? '') . ' ' . ($record->address2 ?? '')),
            'City' => $record->city, 'State' => $record->state, 'Country' => $record->country, 'Pincode' => $record->pincode,
            'Journey' => $record->journey,
        ],
        'collectors' => [
            'Address' => trim(($record->address_line1 ?? '') . ' ' . ($record->address_line2 ?? '')),
            'City' => $record->city, 'State' => $record->state, 'Country' => $record->country, 'ZIP' => $record->zip,
            'Interested in selling' => $record->sell_interest, 'Journey' => $record->journey,
        ],
        'galleries' => [
            'Gallery name' => $record->gallery_name, 'Website' => $record->website,
            'Address' => trim(($record->address1 ?? '') . ' ' . ($record->address2 ?? '')),
            'City' => $record->city, 'State' => $record->state, 'Country' => $record->country, 'Pincode' => $record->pincode,
            'Exhibition types' => $record->exhibition_types, 'Past links' => $record->past_links,
            'Interested in selling' => $record->sell_interest, 'Curatorial vision' => $record->curatorial_vision,
        ],
        default => [],
    };
@endphp

@section('content')
    <div class="aiz-titlebar text-left mt-2 mb-3">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="h3">{{ $record->full_name ?: $label }}</h1>
                <a href="{{ route('admin.' . $slug . '.index') }}" class="text-muted"><i class="las la-angle-left"></i> {{ translate('Back to list') }}</a>
            </div>
            <div class="col-md-6 text-md-right">
                <span class="badge badge-{{ $record->status === 'approved' ? 'success' : ($record->status === 'pending' ? 'warning' : 'danger') }} fs-14">
                    {{ translate(ucfirst($record->status)) }}
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header"><h5 class="mb-0 h6">{{ translate($label . ' details') }}</h5></div>
                <div class="card-body">
                    <table class="table">
                        <tr><th style="width:35%">{{ translate('Name') }}</th><td>{{ $record->full_name ?: '—' }}</td></tr>
                        <tr><th>{{ translate('Email') }}</th><td>{{ $record->email ?: '—' }}</td></tr>
                        <tr><th>{{ translate('Phone') }}</th><td>{{ $record->phone ?: '—' }}</td></tr>
                        @foreach($fields as $label2 => $value)
                            <tr><th>{{ translate($label2) }}</th><td>{{ filled($value) ? $value : '—' }}</td></tr>
                        @endforeach
                        <tr><th>{{ translate('Registered') }}</th><td>{{ $record->created_at?->format('d M Y, H:i') }}</td></tr>
                        @if($record->approved_at)
                            <tr><th>{{ translate('Approved at') }}</th><td>{{ $record->approved_at?->format('d M Y, H:i') }} {{ $record->reviewer ? '(' . $record->reviewer->name . ')' : '' }}</td></tr>
                        @endif
                        @if($record->status === 'rejected' && $record->rejection_reason)
                            <tr><th>{{ translate('Rejection reason') }}</th><td>{{ $record->rejection_reason }}</td></tr>
                        @endif
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header"><h5 class="mb-0 h6">{{ translate('Linked account') }}</h5></div>
                <div class="card-body">
                    @if($u)
                        <p class="mb-1"><strong>{{ translate('User ID') }}:</strong> {{ $u->id }}</p>
                        <p class="mb-1"><strong>{{ translate('Type') }}:</strong> {{ $u->user_type }}</p>
                        <p class="mb-1"><strong>{{ translate('Email verified') }}:</strong> {{ $u->email_verified_at ? translate('Yes') : translate('No') }}</p>
                        <p class="mb-3"><strong>{{ translate('Banned') }}:</strong> {{ $u->banned ? translate('Yes') : translate('No') }}</p>
                    @else
                        <p class="text-danger">{{ translate('No linked user account.') }}</p>
                    @endif

                    <div class="d-flex flex-column" style="gap:8px;">
                        @can('approve_art_community')
                            @if($record->status !== 'approved')
                                <form method="POST" action="{{ route('admin.' . $slug . '.approve', $record->id) }}">
                                    @csrf
                                    <button class="btn btn-success btn-block btn-sm">{{ translate('Approve') }}</button>
                                </form>
                            @endif
                            @if($record->status !== 'rejected')
                                <form method="POST" action="{{ route('admin.' . $slug . '.reject', $record->id) }}">
                                    @csrf
                                    <input type="text" name="rejection_reason" class="form-control form-control-sm mb-2" placeholder="{{ translate('Reason (optional)') }}">
                                    <button class="btn btn-outline-danger btn-block btn-sm">{{ translate('Reject') }}</button>
                                </form>
                            @endif
                        @endcan
                        @can('ban_art_community')
                            @if($u)
                                <a href="{{ route('admin.' . $slug . '.ban', $record->id) }}" class="btn btn-outline-warning btn-block btn-sm">
                                    {{ $u->banned ? translate('Unban') : translate('Ban') }}
                                </a>
                            @endif
                        @endcan
                        @can('login_as_art_community')
                            @if($u && $record->status === 'approved')
                                <a href="{{ route('admin.' . $slug . '.login_as', $record->id) }}" class="btn btn-outline-primary btn-block btn-sm">
                                    {{ translate('Log in as this member') }}
                                </a>
                            @endif
                        @endcan
                        @can('delete_art_community')
                            <a href="{{ route('admin.' . $slug . '.destroy', $record->id) }}" class="btn btn-outline-danger btn-block btn-sm confirm-delete"
                               data-href="{{ route('admin.' . $slug . '.destroy', $record->id) }}">
                                {{ translate('Delete') }}
                            </a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
