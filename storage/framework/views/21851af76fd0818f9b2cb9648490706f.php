<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'Ageless One Admin'); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo e(asset('css/ageless-one-theme.css')); ?>" rel="stylesheet">
    <style>
        :root{--bg:#0e1320;--bg2:#0b101b;--panel:#151b29;--panel2:#1c2436;--line:#262f47;--text:#e8edf6;--muted:#8794ac;--brand:#3f6fe0;--danger:#ff5a6e}
        *{box-sizing:border-box} html,body{margin:0;min-height:100%;background:var(--bg);color:var(--text);font-family:Segoe UI,system-ui,-apple-system,sans-serif}
        body{overflow:hidden}.admin-shell{display:grid;grid-template-columns:270px minmax(0,1fr);height:100vh}.sidebar{overflow-y:auto;background:linear-gradient(180deg,var(--panel),var(--bg2));border-right:1px solid var(--line)}
        .brand{position:sticky;top:0;z-index:2;display:flex;gap:12px;align-items:center;padding:18px;background:var(--panel);border-bottom:1px solid var(--line)}
        .logo{width:46px;height:46px;border-radius:14px;background:linear-gradient(135deg,#5b8cff,#9b6bff);display:grid;place-items:center;font-weight:800;font-size:20px;color:#fff;flex:0 0 auto}.brand h1{font-size:17px;margin:0}.brand p{font-size:10px;color:var(--muted);margin:2px 0 0}
        .nav-title{padding:18px 22px 7px;color:var(--muted);font-size:10px;font-weight:800;letter-spacing:1px}.side-nav{padding:0 10px}.side-nav a{display:flex;gap:10px;align-items:center;padding:10px 12px;margin:2px 0;border-radius:9px;color:#a8b4cc;text-decoration:none;font-size:13px}.side-nav a:hover{background:var(--panel2);color:#fff}.side-nav a.active{background:linear-gradient(90deg,var(--brand),#3360c8);color:#fff;font-weight:700}
        .main-area{min-width:0;display:flex;flex-direction:column;overflow:hidden}.topbar{height:72px;flex:0 0 auto;display:flex;align-items:center;gap:16px;padding:0 26px;background:var(--panel);border-bottom:1px solid var(--line)}.topbar-title{font-weight:700}.topbar-user{margin-left:auto;display:flex;align-items:center;gap:11px}.avatar{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,#5b8cff,#37c281);display:grid;place-items:center;font-weight:800}.muted{color:var(--muted)}.logout{background:transparent;border:1px solid #334155;padding:8px 14px;color:#fff;border-radius:9px}
        .page-content{flex:1;min-height:0;overflow:auto;padding:26px}.alert{border-radius:10px}.card,.card-dark{background:var(--panel);color:var(--text);border-color:var(--line)}
        @media(max-width:900px){body{overflow:auto}.admin-shell{display:block;height:auto}.sidebar{position:relative;max-height:none}.brand{position:relative}.main-area{overflow:visible}.topbar{position:sticky;top:0;z-index:5}.page-content{overflow:visible}.side-nav{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));padding-bottom:15px}.nav-title{padding-top:12px}}
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
<div class="admin-shell">
    <aside class="sidebar">
        <div class="brand"><div class="logo">A1</div><div><h1>Ageless One</h1><p>AI BUSINESS OS · v1.1</p></div></div>

        <?php if(auth()->user()->role === 'inventory_manager'): ?>
        <div class="nav-title">INVENTORY</div>
        <nav class="side-nav"><a class="<?php echo e(request()->routeIs('office-inventory.*') ? 'active' : ''); ?>" href="<?php echo e(route('office-inventory.index')); ?>">📦 Inventory</a><a class="<?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>" href="<?php echo e(route('profile.edit')); ?>">👤 My Profile</a></nav>
        <?php elseif(auth()->user()->role === 'workshop_manager'): ?>
        <div class="nav-title">WORKSHOP</div>
        <nav class="side-nav"><a class="<?php echo e(request()->routeIs('workshops.*') ? 'active' : ''); ?>" href="<?php echo e(route('workshops.index')); ?>">🏭 Workshop</a><a href="<?php echo e(route('expenses.my')); ?>">🧾 My Expenses</a><a class="<?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>" href="<?php echo e(route('profile.edit')); ?>">👤 My Profile</a></nav>
        <?php elseif(auth()->user()->role === 'accounts'): ?>
        <div class="nav-title">ACCOUNTS</div>
        <nav class="side-nav"><a class="<?php echo e(request()->routeIs('accounts.expenses.*') ? 'active' : ''); ?>" href="<?php echo e(route('accounts.expenses.index')); ?>">💳 Expense Approvals</a><a href="<?php echo e(route('expenses.my')); ?>">🧾 My Expenses</a><a class="<?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>" href="<?php echo e(route('profile.edit')); ?>">👤 My Profile</a></nav>
        <?php else: ?>
        <div class="nav-title">OVERVIEW</div>
        <nav class="side-nav">
            <a class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('admin.dashboard')); ?>">🏠 Executive Dashboard</a>
        </nav>

        <div class="nav-title">SALES</div>
        <nav class="side-nav">
            <a class="<?php echo e(request()->routeIs('sales.*') ? 'active' : ''); ?>" href="<?php echo e(route('sales.dashboard')); ?>">📈 Sales CRM</a>
        </nav>

        <div class="nav-title">SERVICE MANAGEMENT</div>
        <nav class="side-nav">
            <a class="<?php echo e(request()->routeIs('admin.parks*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.parks')); ?>">🏢 Parks / Clients</a>
            <a class="<?php echo e(request()->routeIs('admin.tickets*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.tickets')); ?>">🎫 Complaint Tickets</a>
            <a class="<?php echo e(request()->routeIs('admin.work-sites*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.work-sites')); ?>">📍 Work Sites</a>
            <a class="<?php echo e(request()->routeIs('admin.site-assets*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.site-assets')); ?>">🛠 Site Assets</a>
        </nav>

        <div class="nav-title">INVENTORY</div>
        <nav class="side-nav">
            <a class="<?php echo e(request()->routeIs('office-inventory.*') ? 'active' : ''); ?>" href="<?php echo e(route('office-inventory.index')); ?>">📦 Inventory</a>
            <a class="<?php echo e(request()->routeIs('workshops.*') ? 'active' : ''); ?>" href="<?php echo e(route('workshops.index')); ?>">🏭 Workshop</a>
        </nav>

        <div class="nav-title">HR & STAFF</div>
        <nav class="side-nav">
            <a class="<?php echo e(request()->routeIs('admin.attendance') ? 'active' : ''); ?>" href="<?php echo e(route('admin.attendance')); ?>">🕒 Attendance</a>
            <a class="<?php echo e(request()->routeIs('admin.work-history*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.work-history.index')); ?>">📅 Work History</a>
            <a class="<?php echo e(request()->routeIs('accounts.expenses.*') ? 'active' : ''); ?>" href="<?php echo e(route('accounts.expenses.index')); ?>">💳 Expense Approvals</a>
            <a class="<?php echo e(request()->routeIs('admin.users*') ? 'active' : ''); ?>" href="<?php echo e(route('admin.users.index')); ?>">👥 Office Staff</a>
            <a class="<?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>" href="<?php echo e(route('profile.edit')); ?>">👤 My Profile</a>
        </nav>
        <?php endif; ?>
    </aside>

    <main class="main-area">
        <header class="topbar">
            <div class="topbar-title"><?php echo $__env->yieldContent('page-title', 'Administration'); ?></div>
            <div class="topbar-user">
                <?php if(auth()->user()->photo): ?><img class="avatar" style="object-fit:cover" src="<?php echo e(asset('storage/'.auth()->user()->photo)); ?>" alt="Profile"><?php else: ?><div class="avatar"><?php echo e(strtoupper(substr(auth()->user()->name ?? 'A', 0, 1))); ?></div><?php endif; ?>
                <div><strong><?php echo e(auth()->user()->name ?? 'Administrator'); ?></strong><br><small class="muted"><?php echo e(ucfirst(str_replace('_',' ',auth()->user()->role ?? 'admin'))); ?></small></div>
                <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button class="logout" type="submit">Logout</button></form>
            </div>
        </header>
        <section class="page-content">
            <?php if(session('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?>
            <?php if(session('error')): ?><div class="alert alert-danger"><?php echo e(session('error')); ?></div><?php endif; ?>
            <?php echo $__env->yieldContent('content'); ?>
        </section>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views/layouts/admin.blade.php ENDPATH**/ ?>