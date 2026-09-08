@extends('artist.layouts.app')

@section('content')
<div class="artist-dashboard">

    {{-- Header --}}
    
@include('artist.components.header')
    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card">
            <p>Total Revenue</p>
            <h3>$42,390</h3>
            <span class="up">▲ 12% vs last month</span>
        </div>

        <div class="stat-card">
            <p>Artworks Sold</p>
            <h3>28</h3>
            <span class="up">▲ 5% vs last month</span>
        </div>

        <div class="stat-card">
            <p>Total Views</p>
            <h3>1,204</h3>
            <span class="down">▼ 2% vs last month</span>
        </div>

        <div class="stat-card">
            <p>Pending Payout</p>
            <h3>$3,150</h3>
        </div>
    </div>

    {{-- Main Grid --}}
    <div class="dashboard-grid">

        {{-- Inventory --}}
        <div class="card">
            <div class="card-header">
                <h4>Inventory</h4>
                <a href="#">View All</a>
            </div>

            <table class="inventory-table">
                <thead>
                    <tr>
                        <th>Artwork</th>
                        <th>Status</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Action</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="artwork">
                            <img src="{{ asset('assets/img/sample1.jpg') }}">
                            Whispering Shadows
                        </td>
                        <td><span class="badge published">Published</span></td>
                        <td>Oil Painting</td>
                        <td>$2,400</td>
                        <td>...</td>
                        <td>⋮</td>
                    </tr>

                    <tr>
                        <td class="artwork">
                            <img src="{{ asset('assets/img/sample2.jpg') }}">
                            Azure Solitude
                        </td>
                        <td><span class="badge sold">Sold</span></td>
                        <td>Digital Illustration</td>
                        <td>$850</td>
                        <td>...</td>
                        <td>⋮</td>
                    </tr>
                </tbody>
            </table>
        </div>

        {{-- Quick Upload --}}
        <div class="card upload-card">
            <div class="upload-box">
                <i class="fa-solid fa-cloud-arrow-up"></i>
                <h4>Quick Upload</h4>
                <p>Drag and drop your latest masterpiece here</p>
                <button>Select Files</button>
            </div>
        </div>

    </div>
</div>
@endsection
