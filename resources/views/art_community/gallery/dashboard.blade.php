@extends('art_community.layouts.app', ['role' => 'gallery'])

@section('content')
    <div class="ac-head">
        <div>
            <h1>{{ $profile->gallery_name ?: $user->name }}</h1>
            <p>Your gallery account on Artistiqe.</p>
        </div>
        <a href="{{ route('home') }}" class="btn ghost">Browse Artworks</a>
    </div>

    @include('art_community._buyer_body')

    <div class="ac-panel">
        <h3>Gallery profile</h3>
        <table class="ac-table">
            <tbody>
                <tr><th>Gallery name</th><td>{{ $profile->gallery_name ?: '—' }}</td></tr>
                <tr><th>Owner</th><td>{{ $profile->full_name }}</td></tr>
                <tr><th>Website</th><td>{{ $profile->website ?: '—' }}</td></tr>
                <tr><th>Location</th><td>{{ collect([$profile->city, $profile->state, $profile->country])->filter()->join(', ') ?: '—' }}</td></tr>
                <tr><th>Exhibition types</th><td>{{ $profile->exhibition_types ?: '—' }}</td></tr>
                <tr><th>Status</th><td><span class="badge {{ $profile->status }}">{{ ucfirst($profile->status) }}</span></td></tr>
            </tbody>
        </table>
        <p style="margin:14px 0 0;"><a href="{{ route('gallery.profile') }}" style="color:#c0392b;font-weight:600;">Edit profile &rarr;</a></p>
    </div>
@endsection
