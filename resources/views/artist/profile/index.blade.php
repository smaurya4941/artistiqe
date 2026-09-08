@extends('artist.layouts.app')

@section('content')

{{-- Page Title --}}
<div class="mb-4">
    <h2 class="fw-bold mb-1">My Profile</h2>
    <p class="text-muted">Manage your personal information and artist details</p>
</div>

<div class="row g-4">
    {{-- Left: Profile Card --}}
    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-body text-center">
                <img src="{{ asset('assets/img/avatar.png') }}"
                     class="rounded-circle mb-3"
                     width="110" height="110"
                     alt="Artist Avatar">

                <h5 class="fw-semibold mb-0">
                    {{ auth()->user()->name ?? 'Artist Name' }}
                </h5>

                <p class="text-muted mb-3">
                    {{ auth()->user()->email ?? 'artist@email.com' }}
                </p>

                <span class="badge bg-dark">Artist</span>

                <hr>

                <button class="btn btn-outline-dark btn-sm">
                    Change Profile Photo
                </button>
            </div>
        </div>
    </div>

    {{-- Right: Profile Form --}}
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white fw-semibold">
                Profile Information
            </div>

            <div class="card-body">
                <form method="POST" action="#">
                    @csrf

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text"
                                   class="form-control"
                                   value="{{ auth()->user()->name }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email Address</label>
                            <input type="email"
                                   class="form-control"
                                   value="{{ auth()->user()->email }}">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Phone</label>
                            <input type="text"
                                   class="form-control"
                                   placeholder="Enter phone number">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text"
                                   class="form-control"
                                   placeholder="City, Country">
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Bio</label>
                            <textarea class="form-control"
                                      rows="4"
                                      placeholder="Tell something about yourself..."></textarea>
                        </div>
                    </div>

                    <div class="text-end">
                        <button class="btn btn-dark">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
