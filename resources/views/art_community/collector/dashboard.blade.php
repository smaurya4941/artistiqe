@extends('art_community.layouts.app', ['role' => 'collector'])

@section('content')
    <div class="ac-head">
        <div>
            <h1>Welcome, {{ $user->name }}</h1>
            <p>Your collector account on Artistiqe.</p>
        </div>
        <a href="{{ route('home') }}" class="btn ghost">Browse Artworks</a>
    </div>

    @include('art_community._buyer_body')

    <div class="ac-panel">
        <h3>Collector profile</h3>
        <table class="ac-table">
            <tbody>
                <tr><th>Name</th><td>{{ $profile->full_name }}</td></tr>
                <tr><th>Location</th><td>{{ collect([$profile->city, $profile->state, $profile->country])->filter()->join(', ') ?: '—' }}</td></tr>
                <tr><th>Interested in selling</th><td>{{ $profile->sell_interest ? ucfirst($profile->sell_interest) : '—' }}</td></tr>
                <tr><th>Status</th><td><span class="badge {{ $profile->status }}">{{ ucfirst($profile->status) }}</span></td></tr>
            </tbody>
        </table>
        <p style="margin:14px 0 0;"><a href="{{ route('collector.profile') }}" style="color:#c0392b;font-weight:600;">Edit profile &rarr;</a></p>
    </div>
@endsection
