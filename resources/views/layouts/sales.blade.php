<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ageless One Sales')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/ageless-one-theme.css') }}" rel="stylesheet">
    <style>
        :root{--bg:#0e1320;--bg2:#0b101b;--panel:#151b29;--panel2:#1c2436;--line:#262f47;--text:#e8edf6;--muted:#8794ac;--brand:#3f6fe0;--danger:#ff5a6e}
        *{box-sizing:border-box}html,body{margin:0;min-height:100%;background:var(--bg);color:var(--text);font-family:Segoe UI,system-ui,-apple-system,sans-serif}
        body{overflow:hidden;min-width:1100px}.admin-shell{display:grid;grid-template-columns:270px minmax(0,1fr);height:100vh}.sidebar{overflow-y:auto;background:linear-gradient(180deg,var(--panel),var(--bg2));border-right:1px solid var(--line)}
        .brand{position:sticky;top:0;z-index:2;display:flex;gap:12px;align-items:center;padding:18px;background:var(--panel);border-bottom:1px solid var(--line)}
        .logo{width:46px;height:46px;border-radius:14px;background:linear-gradient(135deg,#5b8cff,#9b6bff);display:grid;place-items:center;font-weight:800;font-size:20px;color:#fff;flex:0 0 auto}.brand h1{font-size:17px;margin:0}.brand p{font-size:10px;color:var(--muted);margin:2px 0 0}
        .nav-title{padding:18px 22px 7px;color:var(--muted);font-size:10px;font-weight:800;letter-spacing:1px}.side-nav{padding:0 10px}.side-nav a{display:flex;gap:10px;align-items:center;padding:10px 12px;margin:2px 0;border-radius:9px;color:#a8b4cc;text-decoration:none;font-size:13px}.side-nav a:hover{background:var(--panel2);color:#fff}.side-nav a.active{background:linear-gradient(90deg,var(--brand),#3360c8);color:#fff;font-weight:700}
        .main-area{min-width:0;display:flex;flex-direction:column;overflow:hidden}.topbar{height:72px;flex:0 0 auto;display:flex;align-items:center;gap:16px;padding:0 26px;background:var(--panel);border-bottom:1px solid var(--line)}.topbar-title{font-weight:700}.topbar-user{margin-left:auto;display:flex;align-items:center;gap:11px}.avatar{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#5b8cff,#37c281);display:grid;place-items:center;font-weight:800}.muted{color:var(--muted)!important}.logout{background:transparent;border:1px solid #334155;padding:8px 14px;color:#fff;border-radius:9px}
        .page-content{flex:1;min-height:0;overflow:auto;padding:26px}.alert{border-radius:10px}.card,.card-dark{background:var(--panel);color:var(--text);border-color:var(--line);box-shadow:none}.card-header,.card-footer,.bg-white,.table-light{background:var(--panel2)!important;color:var(--text)!important;border-color:var(--line)!important}.list-group-item{background:var(--panel);color:var(--text);border-color:var(--line)}.list-group-item-action:hover{background:var(--panel2);color:#fff}
        .table{--bs-table-bg:transparent;--bs-table-color:var(--text);--bs-table-border-color:var(--line);--bs-table-hover-bg:var(--panel2);--bs-table-hover-color:#fff;color:var(--text)}.table a{color:#86a9ff}.form-control,.form-select{min-height:44px;background:#101726;color:var(--text);border-color:#33405d}.form-control:focus,.form-select:focus{background:#101726;color:#fff;border-color:#5b8cff;box-shadow:0 0 0 .2rem rgba(91,140,255,.15)}.form-control::placeholder{color:#69758d}.form-select option{background:#101726;color:#fff}.form-check-input{background-color:#101726;border-color:#465575}.form-label{color:#cbd5e5}.border-bottom{border-color:var(--line)!important}
        .btn{border-radius:9px}.btn-light{background:var(--panel2);border-color:#33405d;color:#dce5f5}.btn-light:hover{background:#273149;color:#fff}.btn-dark{background:#26314a;border-color:#33405d}.btn-outline-secondary{color:#c7d1e4;border-color:#465575}.btn-outline-secondary:hover{background:#33405d;color:#fff}.stat{padding:20px}.stat b{font-size:28px}.badge-hot{background:#55262c;color:#ff9aa7}.badge-warm{background:#4d4021;color:#ffd978}.badge-cold{background:#173e56;color:#8bd5ff}.pagination{--bs-pagination-bg:var(--panel);--bs-pagination-border-color:var(--line);--bs-pagination-color:#9db8ff;--bs-pagination-hover-bg:var(--panel2);--bs-pagination-hover-border-color:var(--line);--bs-pagination-active-bg:var(--brand);--bs-pagination-active-border-color:var(--brand);--bs-pagination-disabled-bg:var(--panel);--bs-pagination-disabled-border-color:var(--line)}
    </style>
    @stack('styles')
</head>
<body>
<div class="admin-shell">
    <aside class="sidebar">
        <div class="brand"><div class="logo">A1</div><div><h1>Ageless One</h1><p>AI BUSINESS OS · v1.1</p></div></div>

        <div class="nav-title">SALES</div>
        <nav class="side-nav">
            <a class="{{ request()->routeIs('sales.dashboard') ? 'active' : '' }}" href="{{ route('sales.dashboard') }}">📈 Sales Dashboard</a>
            <a class="{{ request()->routeIs('sales.leads.index') || request()->routeIs('sales.leads.show') || request()->routeIs('sales.leads.edit') ? 'active' : '' }}" href="{{ route('sales.leads.index') }}">📋 Enquiries & Leads</a>
            <a class="{{ request()->routeIs('sales.leads.create') ? 'active' : '' }}" href="{{ route('sales.leads.create') }}">➕ Add Enquiry</a>
            <a class="{{ request()->routeIs('profile.*') ? 'active' : '' }}" href="{{ route('profile.edit') }}">👤 My Profile</a>
        </nav>

        @if(auth()->user()->role === 'admin')
            <div class="nav-title">ADMINISTRATION</div>
            <nav class="side-nav">
                <a href="{{ route('admin.dashboard') }}">← Back to Admin Panel</a>
            </nav>
        @endif
    </aside>

    <main class="main-area">
        <header class="topbar">
            <div class="topbar-title">@yield('page-title', 'Sales')</div>
            <div class="topbar-user">
                @if(auth()->user()->photo)
                    <img class="avatar" style="object-fit:cover" src="{{ asset('storage/'.auth()->user()->photo) }}" alt="Profile">
                @else
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'S', 0, 1)) }}</div>
                @endif
                <div><strong>{{ auth()->user()->name ?? 'Sales User' }}</strong><br><small class="muted">{{ ucfirst(str_replace('_',' ',auth()->user()->role ?? 'sales')) }}</small></div>
                <form method="POST" action="{{ route('logout') }}">@csrf<button class="logout" type="submit">Logout</button></form>
            </div>
        </header>
        <section class="page-content">
            @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
            @yield('content')
        </section>
    </main>
</div>
@stack('scripts')
</body>
</html>