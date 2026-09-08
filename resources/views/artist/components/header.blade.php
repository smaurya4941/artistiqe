<div class="dashboard-header">
        <h2>Overview</h2>

        <div class="dashboard-user">
            <i class="fa-regular fa-bell"></i>
            <div class="user-info">
                <strong>{{ auth('artist')->user()->name ?? 'Artist' }}</strong>
                <span>Premium Artist</span>
            </div>
            <img src="{{ asset('assets/img/avatar.png') }}" alt="Artist">
        </div>
    </div>