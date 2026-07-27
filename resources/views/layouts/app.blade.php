<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Ageless One'))</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/ageless-one-theme.css') }}" rel="stylesheet">
    <style>
        body{min-height:100vh;background:radial-gradient(circle at top right,rgba(63,111,224,.16),transparent 34%),#0b1120!important;color:#eef4ff!important}
        .mobile-app-shell{width:100%;max-width:520px;min-height:100vh;margin:0 auto;background:#0d1526;border-left:1px solid #243451;border-right:1px solid #243451;box-shadow:0 0 50px rgba(0,0,0,.35)}
        .app-topbar{position:sticky;top:0;z-index:20;display:flex;align-items:center;gap:12px;padding:14px 16px;background:rgba(16,25,44,.96);backdrop-filter:blur(12px);border-bottom:1px solid #263754}
        .app-logo{width:42px;height:42px;border-radius:13px;background:linear-gradient(135deg,#4f78ec,#8d63ef);display:grid;place-items:center;font-weight:900;color:#fff}
        .app-content{padding:16px 14px 90px}.app-user{margin-left:auto;text-align:right}.app-user small{color:#9cabc4}
        @media(min-width:900px){.mobile-app-shell{margin:22px auto;min-height:calc(100vh - 44px);border-radius:24px;overflow:hidden}.app-topbar{border-radius:24px 24px 0 0}}
    </style>
    @stack('styles')
</head>
<body>
<div class="mobile-app-shell">
    <header class="app-topbar">
        <div class="app-logo">A1</div>
        <div><strong>Ageless One</strong><br><small class="text-muted">Site Operations</small></div>
        @auth
        <a class="app-user text-decoration-none text-light" href="{{ route('profile.edit') }}"><strong>{{ auth()->user()->display_name }}</strong><br><small>{{ ucfirst(str_replace('_',' ',auth()->user()->role)) }} · Edit Profile</small></a>
        <form method="POST" action="{{ route('logout') }}">@csrf<button class="btn btn-sm btn-outline-light">Logout</button></form>
        @endauth
    </header>
    <main class="app-content">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
        @yield('content')
    </main>
</div>
@stack('scripts')
</body>
</html>
