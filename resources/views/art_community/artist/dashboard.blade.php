@extends('art_community.layouts.app', ['role' => 'artist'])

@section('content')
    <div class="ac-head">
        <div>
            <h1>Welcome back, {{ $user->name }}</h1>
            <p>Here's how your studio is doing on Artistiqe.</p>
        </div>
        <a href="{{ route('artist.artwork.create') }}" class="btn"><i class="fa-solid fa-plus"></i> Upload Artwork</a>
    </div>

    <div class="ac-grid">
        <div class="ac-card">
            <div class="label">Total Artworks</div>
            <div class="value">{{ $stats['artworks_total'] }}</div>
        </div>
        <div class="ac-card">
            <div class="label">Published</div>
            <div class="value">{{ $stats['artworks_published'] }}</div>
        </div>
        <div class="ac-card">
            <div class="label">Drafts</div>
            <div class="value">{{ $stats['artworks_draft'] }}</div>
        </div>
        <div class="ac-card">
            <div class="label">Your Earnings (est.)</div>
            <div class="value">{{ single_price($stats['total_earnings']) }}</div>
        </div>
    </div>

    @if($completeness < 100)
        <div class="ac-panel">
            <h3>Complete your profile</h3>
            <div class="bar"><i style="width: {{ $completeness }}%"></i></div>
            <p style="color:#6b7280;font-size:13px;margin:10px 0 0;">
                Your profile is {{ $completeness }}% complete.
                <a href="{{ route('artist.profile') }}" style="color:#c0392b;font-weight:600;">Finish it &rarr;</a>
            </p>
        </div>
    @endif

    <div class="ac-panel">
        <h3>Recent artworks</h3>
        @if($recentArtworks->isEmpty())
            <p style="color:#6b7280;font-size:14px;margin:0;">No artworks yet. <a href="{{ route('artist.artwork.create') }}" style="color:#c0392b;font-weight:600;">Upload your first piece &rarr;</a></p>
        @else
            <table class="ac-table">
                <thead>
                    <tr><th>Title</th><th>Status</th><th>Category</th><th>Price</th><th>Added</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach($recentArtworks as $artwork)
                        <tr>
                            <td>{{ $artwork->title }}</td>
                            <td><span class="badge {{ $artwork->status }}">{{ ucfirst($artwork->status) }}</span></td>
                            <td>{{ $artwork->category ?: '—' }}</td>
                            <td>{{ $artwork->price ? single_price($artwork->price) : '—' }}</td>
                            <td>{{ $artwork->created_at?->format('d M Y') }}</td>
                            <td><a href="{{ route('artist.artwork.edit', $artwork->id) }}" style="color:#c0392b;font-weight:600;">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p style="margin:14px 0 0;"><a href="{{ route('artist.artworks.index') }}" style="color:#c0392b;font-weight:600;">View all artworks &rarr;</a></p>
        @endif
    </div>
@endsection
