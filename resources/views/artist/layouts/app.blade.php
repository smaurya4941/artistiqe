<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Artist Dashboard | Artistiqe</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Icons --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    {{-- App CSS (yahan React se nikla hua CSS link hoga) --}}
   <link rel="stylesheet" href="{{ asset('public/assets/artist/css/dashboard.css') }}">


   <!--  <style>
        body{
            font-family: 'Inter', sans-serif;
            background:#f5f6fa;
        }
        .dashboard-wrapper{
            display:flex;
            min-height:100vh;
        }
        .dashboard-content{
            flex:1;
            padding:24px;
        }
    </style> -->
</head>
<body>

<div class="dashboard-wrapper">

    {{-- Sidebar --}}
    @include('artist.components.sidebar')

    {{-- Main Content --}}
    <div class="dashboard-content">

        {{-- Header --}}
        <!-- @include('artist.components.header') -->

        {{-- Page Content --}}
        @if(session('success'))
    <div class="success-alert">
        {{ session('success') }}
    </div>
@endif

        @yield('content')

    </div>
</div>

{{-- JS --}}
<script src="{{ asset('public/assets/artist/js/dashboard.js') }}"></script>
</body>
</html>
