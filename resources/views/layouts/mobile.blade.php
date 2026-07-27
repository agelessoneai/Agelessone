<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Ageless One')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root{--bg:#080d19;--panel:#121a2b;--panel2:#182238;--line:#26324c;--text:#f5f7ff;--muted:#96a3bb;--brand:#4169e1;--brand2:#744fe0;--success:#22b77a;--danger:#ed5a6b;--warning:#e3ad38}
        *{box-sizing:border-box}html,body{margin:0;min-height:100%;background:var(--bg);color:var(--text);font-family:Inter,Segoe UI,system-ui,-apple-system,sans-serif}
        body{background:radial-gradient(circle at top,#17213a 0,#080d19 42%);padding:0}
        .mobile-shell{width:min(100%,520px);min-height:100vh;margin:auto;background:linear-gradient(180deg,rgba(18,26,43,.98),rgba(8,13,25,.98));box-shadow:0 0 60px rgba(0,0,0,.45);padding:18px 16px calc(90px + env(safe-area-inset-bottom))}
        .mobile-head{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:16px}.mobile-head h1{font-size:21px;margin:2px 0 0}.eyebrow{font-size:10px;letter-spacing:1.35px;font-weight:800;color:#9eabe0}.muted{color:var(--muted)!important}.icon-btn{width:40px;height:40px;border:1px solid var(--line);border-radius:13px;background:var(--panel2);color:#fff}
        .hero-card{padding:19px;border-radius:22px;background:linear-gradient(135deg,var(--brand),var(--brand2));box-shadow:0 16px 40px rgba(42,73,177,.32);margin-bottom:14px}.hero-card h2{font-size:22px;margin:3px 0}.hero-card .muted{color:#e1e7ff!important}
        .app-card{background:linear-gradient(180deg,var(--panel2),var(--panel));border:1px solid var(--line);border-radius:20px;padding:16px;margin-bottom:14px;box-shadow:0 14px 34px rgba(0,0,0,.18)}
        .app-card h3,.app-card h4,.app-card h5{margin:0}.row-between{display:flex;align-items:center;justify-content:space-between;gap:12px}.stat-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:9px;margin-bottom:14px}.stat-card{background:var(--panel);border:1px solid var(--line);border-radius:16px;padding:12px;text-align:center}.stat-card strong{font-size:21px;display:block}.stat-card span{font-size:11px;color:var(--muted)}
        .app-btn{border:0;border-radius:14px;padding:13px 16px;width:100%;font-weight:800;color:#fff}.app-btn.success{background:var(--success)}.app-btn.danger{background:var(--danger)}.app-btn.primary{background:linear-gradient(135deg,var(--brand),var(--brand2))}.app-btn.secondary{background:#26324b}.app-btn.warning{background:var(--warning);color:#17120a}
        .form-control,.form-select{background:#0d1423!important;border:1px solid #33415f!important;color:#fff!important;border-radius:13px!important;min-height:46px}.form-control::placeholder{color:#77849d}.camera-input{display:block;width:100%;margin:10px 0;padding:12px;border:1px dashed #64718c;border-radius:13px;background:#0d1423;color:#dce5fb}
        .status-pill{display:inline-flex;align-items:center;padding:6px 10px;border-radius:999px;font-size:11px;font-weight:800}.status-pill.pending{background:#594821;color:#ffdc7d}.status-pill.active{background:#174c39;color:#8cebc1}.status-pill.complete{background:#203f72;color:#b9d0ff}.status-pill.rejected{background:#562935;color:#ffadb7}
        .list-row{padding:14px 0;border-top:1px solid var(--line)}.list-row:first-child{border-top:0}.thumb{width:52px;height:52px;border-radius:14px;object-fit:cover;background:#0d1423}
        .mobile-tabs{position:fixed;z-index:20;left:50%;bottom:max(10px,env(safe-area-inset-bottom));transform:translateX(-50%);width:min(488px,calc(100% - 24px));display:grid;grid-template-columns:repeat(4,1fr);gap:4px;padding:8px;background:rgba(18,26,43,.96);border:1px solid var(--line);border-radius:19px;backdrop-filter:blur(18px);box-shadow:0 16px 40px rgba(0,0,0,.35)}.mobile-tabs a{padding:9px 4px;border-radius:12px;color:#9faec8;text-decoration:none;text-align:center;font-size:10px}.mobile-tabs a.active,.mobile-tabs a:hover{background:#24314c;color:#fff}.mobile-tabs b{display:block;font-size:17px;margin-bottom:2px}
        .profile-fab{position:fixed;right:18px;top:14px;z-index:40;width:44px;height:44px;border-radius:50%;display:grid;place-items:center;background:#24314c;border:1px solid var(--line);color:#fff;text-decoration:none;box-shadow:0 8px 24px rgba(0,0,0,.3)}.alert{border:0;border-radius:14px}.table{--bs-table-bg:transparent;--bs-table-color:var(--text);--bs-table-border-color:var(--line)}
        @media(min-width:760px){body{padding:24px}.mobile-shell{border-radius:28px;min-height:calc(100vh - 48px)}.mobile-tabs{bottom:20px}}
    </style>
    @stack('styles')
</head>
<body>
<div class="mobile-shell">
@auth<a class="profile-fab" href="{{ route('profile.edit') }}" aria-label="My Profile">👤</a>@endauth
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-danger">{{ session('error') }}</div>@endif
    @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif
    @yield('content')
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
