@extends('art_community.layouts.app', ['role' => 'artist'])

@section('content')
    <div class="ac-head">
        <div>
            <h1>My Artworks</h1>
            <p>{{ $artworks->total() }} {{ Str::plural('artwork', $artworks->total()) }} in your studio.</p>
        </div>
        <a href="{{ route('artist.artwork.create') }}" class="btn"><i class="fa-solid fa-plus"></i> Upload Artwork</a>
    </div>

    <div class="ac-panel">
        @if($artworks->isEmpty())
            <p style="color:#6b7280;font-size:14px;margin:0;">
                You haven't added any artworks yet.
                <a href="{{ route('artist.artwork.create') }}" style="color:#c0392b;font-weight:600;">Upload your first piece &rarr;</a>
            </p>
        @else
            <table class="ac-table">
                <thead>
                    <tr><th>Title</th><th>Status</th><th>Category</th><th>Medium</th><th>Price</th><th>Your earning</th><th>Added</th><th></th></tr>
                </thead>
                <tbody>
                    @foreach($artworks as $artwork)
                        <tr>
                            <td>{{ $artwork->title }}</td>
                            <td><span class="badge {{ $artwork->status }}">{{ ucfirst($artwork->status) }}</span></td>
                            <td>{{ $artwork->category ?: '—' }}</td>
                            <td>{{ $artwork->medium ?: '—' }}</td>
                            <td>{{ $artwork->price ? single_price($artwork->price) : '—' }}</td>
                            <td>{{ $artwork->earn ? single_price($artwork->earn) : '—' }}</td>
                            <td>{{ $artwork->created_at?->format('d M Y') }}</td>
                            <td><a href="{{ route('artist.artwork.edit', $artwork->id) }}" style="color:#c0392b;font-weight:600;">Edit</a></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @if($artworks->hasPages())
                <div style="margin-top:16px;display:flex;gap:10px;align-items:center;">
                    @if($artworks->onFirstPage())
                        <span class="btn ghost" style="opacity:.5;">&larr; {{ translate('Prev') }}</span>
                    @else
                        <a href="{{ $artworks->previousPageUrl() }}" class="btn ghost">&larr; {{ translate('Prev') }}</a>
                    @endif
                    <span style="font-size:13px;color:#6b7280;">{{ $artworks->currentPage() }} / {{ $artworks->lastPage() }}</span>
                    @if($artworks->hasMorePages())
                        <a href="{{ $artworks->nextPageUrl() }}" class="btn ghost">{{ translate('Next') }} &rarr;</a>
                    @else
                        <span class="btn ghost" style="opacity:.5;">{{ translate('Next') }} &rarr;</span>
                    @endif
                </div>
            @endif
        @endif
    </div>
@endsection
