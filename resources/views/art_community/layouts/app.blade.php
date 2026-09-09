@php
    $roleLabels = ['artist' => 'Artist', 'collector' => 'Collector', 'gallery' => 'Gallery'];
    $roleLabel = $roleLabels[$role ?? ''] ?? 'Member';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $roleLabel }} Dashboard | {{ env('APP_NAME', 'Artistiqe') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <style>
        :root{ --brand:#c0392b; --ink:#1f2430; --muted:#6b7280; --line:#e6e8ec; --bg:#f5f6f8; }
        *{ box-sizing:border-box; }
        body{ margin:0; font-family:'Inter',system-ui,Arial,sans-serif; background:var(--bg); color:var(--ink); }
        a{ color:inherit; text-decoration:none; }
        .ac-wrap{ display:flex; min-height:100vh; }
        .ac-side{ width:250px; background:#fff; border-right:1px solid var(--line); display:flex; flex-direction:column; position:sticky; top:0; height:100vh; }
        .ac-side .brand{ padding:22px 20px; font-weight:700; font-size:20px; border-bottom:1px solid var(--line); }
        .ac-side .brand span{ color:var(--brand); }
        .ac-side .role{ font-size:11px; letter-spacing:.14em; color:var(--muted); text-transform:uppercase; margin-top:4px; font-weight:600; }
        .ac-menu{ list-style:none; margin:0; padding:12px 0; flex:1; }
        .ac-menu a{ display:flex; align-items:center; gap:12px; padding:11px 22px; font-size:14px; font-weight:500; color:#40454f; }
        .ac-menu a:hover{ background:#faf1f0; color:var(--brand); }
        .ac-menu a.active{ background:#faf1f0; color:var(--brand); box-shadow:inset 3px 0 0 var(--brand); }
        .ac-menu i{ width:18px; text-align:center; }
        .ac-side form{ margin:0; }
        .ac-logout{ padding:14px 22px; border-top:1px solid var(--line); }
        .ac-logout button{ background:none; border:0; color:var(--muted); font:inherit; cursor:pointer; display:flex; gap:10px; align-items:center; }
        .ac-main{ flex:1; padding:28px 32px; max-width:1200px; }
        .ac-head{ display:flex; justify-content:space-between; align-items:flex-start; margin-bottom:22px; }
        .ac-head h1{ font-size:22px; margin:0 0 4px; }
        .ac-head p{ margin:0; color:var(--muted); font-size:13px; }
        .ac-alert{ padding:12px 16px; border-radius:10px; font-size:14px; margin-bottom:18px; }
        .ac-alert.ok{ background:#e7f6ec; color:#1e7e40; }
        .ac-alert.warn{ background:#fdf2e3; color:#9a6a12; }
        .ac-grid{ display:grid; grid-template-columns:repeat(auto-fit,minmax(200px,1fr)); gap:16px; margin-bottom:24px; }
        .ac-card{ background:#fff; border:1px solid var(--line); border-radius:14px; padding:18px 20px; }
        .ac-card .label{ font-size:12px; color:var(--muted); text-transform:uppercase; letter-spacing:.06em; }
        .ac-card .value{ font-size:26px; font-weight:700; margin-top:6px; }
        .ac-panel{ background:#fff; border:1px solid var(--line); border-radius:14px; padding:20px 22px; margin-bottom:20px; }
        .ac-panel h3{ margin:0 0 14px; font-size:15px; }
        .ac-table{ width:100%; border-collapse:collapse; font-size:14px; }
        .ac-table th,.ac-table td{ text-align:left; padding:10px 8px; border-bottom:1px solid var(--line); }
        .ac-table th{ font-size:12px; color:var(--muted); text-transform:uppercase; letter-spacing:.04em; }
        .badge{ display:inline-block; padding:3px 10px; border-radius:999px; font-size:12px; font-weight:600; }
        .badge.published,.badge.approved{ background:#e7f6ec; color:#1e7e40; }
        .badge.draft,.badge.pending{ background:#fdf2e3; color:#9a6a12; }
        .badge.rejected{ background:#fdecec; color:#c0392b; }
        .bar{ height:8px; border-radius:999px; background:var(--line); overflow:hidden; }
        .bar > i{ display:block; height:100%; background:var(--brand); }
        .btn{ display:inline-block; padding:9px 18px; border-radius:10px; background:var(--brand); color:#fff; font-size:14px; font-weight:600; border:0; cursor:pointer; }
        .btn.ghost{ background:#fff; border:1px solid var(--line); color:var(--ink); }
        .form-row{ display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:16px; }
        .form-row label{ display:block; font-size:13px; font-weight:600; margin-bottom:6px; }
        .form-row input,.form-row textarea,.form-row select{ width:100%; padding:10px 12px; border:1px solid var(--line); border-radius:9px; font:inherit; }
        .field-err{ color:var(--brand); font-size:12px; margin-top:4px; }
        @media(max-width:800px){ .ac-side{ display:none; } .ac-main{ padding:20px; } }
    </style>
</head>
<body>
<div class="ac-wrap">
    @include('art_community.components.sidebar', ['role' => $role])
    <main class="ac-main">
        @if(session('success'))
            <div class="ac-alert ok">{{ session('success') }}</div>
        @endif
        @if(session('flash_notification'))
            @foreach(session('flash_notification')->toArray() as $message)
                <div class="ac-alert {{ ($message['level'] ?? '') === 'success' ? 'ok' : 'warn' }}">{{ $message['message'] }}</div>
            @endforeach
        @endif
        @yield('content')
    </main>
</div>
</body>
</html>
