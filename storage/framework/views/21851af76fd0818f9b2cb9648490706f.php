<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $__env->yieldContent('title','Ageless One Admin'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
<style>

    
.page-head{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
    margin-bottom:20px;
}

.page-head h2{
    margin:0;
    color:#fff;
}

.card-dark{
    padding:28px;
    border:1px solid #262f47;
    border-radius:18px;
    background:#151b29;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:20px;
}

.full-width{
    grid-column:1/-1;
}

.form-label{
    display:block;
    margin-bottom:8px;
    color:#9fb3d9;
    font-size:13px;
    font-weight:700;
}

.form-control,
.form-select{
    width:100%;
    min-height:50px;
    padding:12px 14px;
    border:1px solid #2b3854;
    border-radius:12px;
    color:#fff;
    background:#0e1320;
    outline:none;
}

textarea.form-control{
    min-height:120px;
}

.form-control:focus,
.form-select:focus{
    border-color:#3f6fe0;
    box-shadow:0 0 0 4px rgba(63,111,224,.12);
}

.form-select option{
    background:#151b29;
    color:#fff;
}

.form-actions{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:28px;
    padding-top:22px;
    border-top:1px solid #262f47;
}

.btn-green,
.btn-red,
.btn-back{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:44px;
    padding:10px 18px;
    border:0;
    border-radius:10px;
    color:#fff;
    text-decoration:none;
    font-size:13px;
    font-weight:700;
    cursor:pointer;
}

.btn-green{
    background:#37c281;
}

.btn-red{
    background:#ff5a6e;
}

.btn-back{
    color:#dbe4f3;
    border:1px solid #334155;
    background:#1c2436;
}

.alert-danger{
    margin-bottom:20px;
    padding:16px 18px;
    border:1px solid rgba(255,90,110,.35);
    border-radius:14px;
    color:#ffd4da;
    background:rgba(255,90,110,.12);
}

@media(max-width:780px){
    .page-head{
        flex-direction:column;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

    .full-width{
        grid-column:auto;
    }

    .form-actions{
        flex-direction:column-reverse;
    }

    .form-actions > *{
        width:100%;
    }
}
</style>
    <style>
        body{background:#0e1320;color:#e8edf6;overflow:hidden;margin:0;font-family:'Segoe UI',system-ui,sans-serif}
        .navbar,header{display:none!important}
        .container{max-width:100%!important;margin:0!important;padding:0!important}

        .app{display:grid;grid-template-columns:270px 1fr;height:100vh}
        .side{background:#151b29;border-right:1px solid #262f47;overflow:auto}
        .brand{padding:18px;display:flex;gap:12px;align-items:center;border-bottom:1px solid #262f47}
        .logo{width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#5b8cff,#9b6bff);display:grid;place-items:center;font-weight:800;font-size:22px;color:#fff}
        .brand h1{margin:0;font-size:17px}.brand p{margin:0;font-size:11px;color:#8794ac}

        .nav-title{padding:18px 24px 8px;font-size:11px;color:#8794ac;font-weight:700;letter-spacing:1px}
        .nav a{display:flex;padding:13px 22px;text-decoration:none;color:#a8b4cc;font-size:14px}
        .nav a:hover{background:#1c2436;color:#fff}
        .nav a.active{background:#3f6fe0;color:#fff;border-radius:0 12px 12px 0}

        .main{overflow:auto}
        .top{height:76px;background:#151b29;display:flex;align-items:center;padding:0 30px;border-bottom:1px solid #262f47}
        .search{width:450px;padding:13px;background:#0e1320;border:1px solid #262f47;border-radius:12px;color:#fff}
        .user{margin-left:auto;display:flex;align-items:center;gap:12px}
        .avatar{width:46px;height:46px;border-radius:50%;background:linear-gradient(135deg,#5b8cff,#37c281);display:grid;place-items:center;font-weight:700;color:#fff}
        .logout{background:transparent;border:1px solid #334155;padding:10px 18px;color:#fff;border-radius:10px}

        .content{padding:30px}
        .card-dark{background:#151b29;border:1px solid #262f47;border-radius:18px;padding:25px}
        .muted{color:#8794ac}
        .btn-blue{background:#3f6fe0;color:#fff;border:0;border-radius:10px;padding:10px 16px;text-decoration:none}
        .btn-red{background:#ff5a6e;color:#fff;border:0;border-radius:10px;padding:10px 16px;text-decoration:none}

        .table{width:100%;color:#fff!important;margin-bottom:0}
        .table thead th{background:#0e1320;color:#8fa3c7!important;border-color:#262f47!important;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;padding:15px}
        .table tbody td{background:#151b29;color:#fff!important;border-color:#262f47!important;vertical-align:middle;font-size:15px;font-weight:500;padding:15px}
        .table tbody tr:hover td{background:#1c2436}
        .table td strong{color:#fff!important;font-weight:800}

        .form-label{color:#9fb3d9;font-weight:600;margin-bottom:8px}
        .form-control,.form-select{background:#0e1320;border:1px solid #262f47;color:#fff;border-radius:10px;padding:12px}
        .form-control:focus,.form-select:focus{background:#0e1320;color:#fff;border-color:#3f6fe0;box-shadow:none}

        .badge-low{background:#ff5a6e;color:#fff;padding:6px 12px;border-radius:20px;font-size:12px}
        .badge-ok{background:#37c281;color:#062015;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:800}
        .badge-status{padding:6px 12px;border-radius:20px;font-size:12px;font-weight:700}

        @media(max-width:900px){
            .app{grid-template-columns:1fr}
            .side{display:none}
            .search{width:100%}
        }
    </style>
</head>

<body>

<div class="app">

    <aside class="side">

        <div class="brand">
            <div class="logo">A1</div>
            <div>
                <h1>Ageless One</h1>
                <p>AI BUSINESS OS · v1.1</p>
            </div>
        </div>

        <div class="nav-title">DASHBOARD</div>
        <div class="nav">
            <a class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.dashboard')); ?>">
                🏠 Executive Dashboard
            </a>
        </div>

        <div class="nav-title">SERVICE MANAGEMENT</div>
        <div class="nav">
            <a class="<?php echo e(request()->routeIs('admin.parks') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.parks')); ?>">
                🏢 Parks / Clients
            </a>

            <a class="<?php echo e(request()->routeIs('admin.parks.create') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.parks.create')); ?>">
                ➕ Add Park
            </a>

            <a class="<?php echo e(request()->routeIs('admin.tickets') || request()->routeIs('admin.tickets.show') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.tickets')); ?>">
                🎫 Complaint Tickets
            </a>

            <a class="<?php echo e(request()->routeIs('admin.tickets.create') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.tickets.create')); ?>">
                ➕ Create Ticket
            </a>

            <a class="<?php echo e(request()->routeIs('admin.spare-parts') || request()->routeIs('admin.spare-parts.edit') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.spare-parts')); ?>">
                📦 Spare Parts
            </a>

            <a class="<?php echo e(request()->routeIs('admin.spare-parts.create') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.spare-parts.create')); ?>">
                ➕ Add Spare Part
            </a>
        </div>

        <div class="nav-title">HR & STAFF</div>
        <div class="nav">
            <a class="<?php echo e(request()->routeIs('admin.attendance') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.attendance')); ?>">
                🕒 Attendance
            </a>

            <a class="<?php echo e(request()->routeIs('admin.users') ? 'active' : ''); ?>"
               href="<?php echo e(route('admin.users')); ?>">
                👥 Users
            </a>
        </div>
        <div class="nav-title">INVENTORY</div>

<div class="nav">

    <a href="<?php echo e(route('admin.inventory-items')); ?>"
       class="<?php echo e(request()->routeIs('admin.inventory-items') || request()->routeIs('admin.inventory-items.edit') ? 'active' : ''); ?>">
        📦 Inventory Items
    </a>

    <a href="<?php echo e(route('admin.inventory-items.create')); ?>"
       class="<?php echo e(request()->routeIs('admin.inventory-items.create') ? 'active' : ''); ?>">
        ➕ Add Inventory Item
    </a>

    <a href="<?php echo e(route('admin.spare-parts')); ?>"
       class="<?php echo e(request()->routeIs('admin.spare-parts') || request()->routeIs('admin.spare-parts.edit') ? 'active' : ''); ?>">
        🔩 Spare Parts
    </a>

    <a href="<?php echo e(route('admin.spare-parts.create')); ?>"
       class="<?php echo e(request()->routeIs('admin.spare-parts.create') ? 'active' : ''); ?>">
        ➕ Add Spare Part
    </a>

    <?php if(Route::has('admin.inventory-categories')): ?>
        <a href="<?php echo e(route('admin.inventory-categories')); ?>"
           class="<?php echo e(request()->routeIs('admin.inventory-categories*') ? 'active' : ''); ?>">
            🗂 Inventory Categories
        </a>
    <?php endif; ?>

    <a href="#">📥 Stock In</a>
    <a href="#">📤 Stock Out</a>
    <a href="#">🔄 Stock Transfer</a>
    <a href="#">📊 Inventory Reports</a>

</div>
<a href="<?php echo e(route('admin.inventory-movements')); ?>"
   class="<?php echo e(request()->routeIs('admin.inventory-movements') ? 'active' : ''); ?>">
    📊 Stock Movements
</a>

<a href="<?php echo e(route('admin.inventory.stock-in')); ?>"
   class="<?php echo e(request()->routeIs('admin.inventory.stock-in') ? 'active' : ''); ?>">
    📥 Stock In
</a>

<a href="<?php echo e(route('admin.inventory.stock-out')); ?>"
   class="<?php echo e(request()->routeIs('admin.inventory.stock-out') ? 'active' : ''); ?>">
    📤 Stock Out
</a>

        <div class="nav-title">SYSTEM</div>
        <div class="nav">
            <a href="#">⚙ Settings</a>
            <a href="#">🔐 Roles & Permissions</a>
        </div>

    </aside>

    <main class="main">

        <div class="top">
            <input class="search" placeholder="Search Ageless One...">

            <div class="user">
                <div class="avatar">
                    <?php echo e(strtoupper(substr(Auth::user()->name,0,1))); ?>

                </div>

                <div>
                    <strong><?php echo e(Auth::user()->name); ?></strong><br>
                    <small class="muted"><?php echo e(Auth::user()->role == 'admin' ? 'Administrator' : ucfirst(Auth::user()->role)); ?></small>
                </div>

                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="logout">Logout</button>
                </form>
            </div>
        </div>

        <div class="content">
            <?php echo $__env->yieldContent('content'); ?>
        </div>

    </main>

</div>

</body>
</html><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views/layouts/admin.blade.php ENDPATH**/ ?>