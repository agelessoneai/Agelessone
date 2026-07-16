<?php $__env->startSection('content'); ?>

<?php
    $user = Auth::user();

    $words = explode(' ', trim($user->name));
    $initials = '';

    foreach ($words as $word) {
        if ($word !== '') {
            $initials .= strtoupper(substr($word, 0, 1));
        }
    }

    $initials = substr($initials, 0, 2);

    $roleLabels = [
        'admin' => 'Administrator',
        'inventory_manager' => 'Inventory Manager',
        'site_security' => 'Site Security',
        'site_supervisor' => 'Site Supervisor',
        'site_manager' => 'Site Manager',
        'project_manager' => 'Project Manager',
        'user' => 'Staff User',
    ];

    $roleName = $roleLabels[$user->role] ?? ucfirst(str_replace('_', ' ', $user->role));

    $safeUsersCount = $usersCount ?? 0;
?>

<style>
:root{
    --bg:#0e1320;
    --bg2:#0b101b;
    --panel:#151b29;
    --panel2:#1c2436;
    --line:#262f47;
    --txt:#e8edf6;
    --mut:#8794ac;
    --brand:#5b8cff;
    --brand2:#3f6fe0;
    --brand3:#9b6bff;
    --ok:#37c281;
    --crit:#ff5a6e;
    --warn:#f2b53b;
}

*{
    box-sizing:border-box;
}

html,
body{
    width:100%;
    height:100%;
    margin:0;
    padding:0;
}

body{
    background:var(--bg);
    color:var(--txt);
    font-size:14px;
    overflow:hidden;
    font-family:'Segoe UI',system-ui,-apple-system,sans-serif;
}

.navbar,
header{
    display:none!important;
}

.container,
.container-fluid{
    max-width:100%!important;
    width:100%!important;
    margin:0!important;
    padding:0!important;
}

.app{
    display:grid;
    grid-template-columns:262px minmax(0,1fr);
    height:100vh;
}

.side{
    background:linear-gradient(180deg,var(--panel),var(--bg2));
    border-right:1px solid var(--line);
    overflow-y:auto;
    overflow-x:hidden;
    scrollbar-width:thin;
}

.brand{
    position:sticky;
    top:0;
    z-index:5;
    padding:18px;
    display:flex;
    gap:11px;
    align-items:center;
    border-bottom:1px solid var(--line);
    background:var(--panel);
}

.logo{
    width:40px;
    height:40px;
    flex:0 0 40px;
    border-radius:11px;
    background:linear-gradient(135deg,var(--brand),var(--brand3));
    display:grid;
    place-items:center;
    font-weight:800;
    font-size:18px;
    color:#fff;
}

.brand h1{
    font-size:15.5px;
    margin:0;
    font-weight:700;
}

.brand p{
    font-size:10px;
    color:var(--mut);
    margin:1px 0 0;
    letter-spacing:.8px;
}

.nav-title{
    padding:18px 23px 8px;
    color:var(--mut);
    font-size:9.5px;
    font-weight:700;
    letter-spacing:1.2px;
    text-transform:uppercase;
}

.nav a{
    display:flex;
    gap:11px;
    align-items:center;
    color:var(--mut);
    padding:9px 12px;
    margin:1px 10px;
    border-radius:8px;
    text-decoration:none;
    font-size:13.3px;
    transition:.2s ease;
}

.nav a:hover{
    background:var(--panel2);
    color:var(--txt);
}

.nav a.active{
    background:linear-gradient(90deg,var(--brand2),#3360c8);
    color:#fff;
    font-weight:600;
}

.main{
    min-width:0;
    display:flex;
    flex-direction:column;
    overflow:hidden;
}

.top{
    height:62px;
    flex:0 0 62px;
    background:var(--panel);
    border-bottom:1px solid var(--line);
    display:flex;
    align-items:center;
    padding:0 24px;
    gap:16px;
}

.search{
    width:min(440px,45vw);
    background:var(--bg);
    border:1px solid var(--line);
    border-radius:9px;
    color:var(--txt);
    padding:10px 14px;
    font-size:13px;
    outline:none;
}

.search:focus{
    border-color:var(--brand2);
}

.user{
    margin-left:auto;
    display:flex;
    align-items:center;
    gap:10px;
}

.avatar{
    width:36px;
    height:36px;
    flex:0 0 36px;
    border-radius:50%;
    background:linear-gradient(135deg,var(--brand),var(--ok));
    display:grid;
    place-items:center;
    font-weight:700;
    color:#fff;
    font-size:14px;
}

.user strong{
    font-size:14px;
}

.user small{
    font-size:11px;
}

.muted{
    color:var(--mut);
}

.logout{
    color:#cbd5e1;
    border:1px solid var(--line);
    padding:8px 14px;
    border-radius:8px;
    background:transparent;
    font-size:13px;
    cursor:pointer;
}

.logout:hover{
    color:#fff;
    border-color:var(--brand2);
}

.content{
    flex:1;
    overflow-y:auto;
    padding:24px 26px 40px;
}

.page-head{
    display:flex;
    justify-content:space-between;
    align-items:flex-start;
    gap:20px;
}

.page-head h2{
    font-size:23px;
    font-weight:750;
    margin:0;
}

.page-head p{
    color:var(--mut);
    font-size:13px;
    margin:5px 0 0;
}

.live-pill{
    display:inline-flex;
    align-items:center;
    gap:8px;
    padding:8px 13px;
    border-radius:999px;
    border:1px solid rgba(55,194,129,.25);
    background:rgba(55,194,129,.10);
    color:#83e7b6;
    font-size:12px;
    font-weight:700;
}

.live-dot{
    width:8px;
    height:8px;
    border-radius:50%;
    background:var(--ok);
    box-shadow:0 0 12px rgba(55,194,129,.8);
}

.kpis{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:15px;
    margin-top:20px;
}

.kpi{
    background:linear-gradient(145deg,var(--panel),#131a28);
    border:1px solid var(--line);
    border-radius:14px;
    padding:18px;
    position:relative;
    overflow:hidden;
}

.kpi::after{
    content:"";
    position:absolute;
    right:-28px;
    top:-28px;
    width:90px;
    height:90px;
    border-radius:50%;
    background:rgba(91,140,255,.08);
}

.kpi small{
    color:var(--mut);
    font-size:11.5px;
}

.kpi h1{
    font-size:28px;
    font-weight:800;
    margin:8px 0 3px;
}

.kpi p{
    color:var(--mut);
    font-size:11.5px;
    margin:0;
}

.btn-blue{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    background:linear-gradient(135deg,var(--brand2),#3360c8);
    color:#fff;
    padding:8px 14px;
    border:0;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    font-size:13px;
    margin-top:10px;
}

.section-head{
    margin:26px 0 13px;
}

.section-head h3{
    margin:0;
    font-size:17px;
    color:#fff;
}

.section-head p{
    margin:4px 0 0;
    color:var(--mut);
    font-size:12px;
}

.module-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:16px;
}

.module-card{
    display:flex;
    align-items:center;
    gap:15px;
    padding:20px;
    min-height:105px;
    background:linear-gradient(145deg,var(--panel),#131a28);
    border:1px solid var(--line);
    border-radius:15px;
    text-decoration:none;
    transition:.22s ease;
}

.module-card:hover{
    transform:translateY(-3px);
    border-color:var(--brand2);
    background:var(--panel2);
}

.module-icon{
    width:52px;
    height:52px;
    flex:0 0 52px;
    display:grid;
    place-items:center;
    border-radius:15px;
    background:linear-gradient(135deg,var(--brand2),var(--brand3));
    font-size:24px;
}

.module-card h3{
    margin:0 0 5px;
    color:#fff;
    font-size:16px;
}

.module-card p{
    margin:0;
    color:var(--mut);
    font-size:12px;
    line-height:1.5;
}

.route-disabled{
    opacity:.55;
    cursor:not-allowed;
}

.route-disabled:hover{
    transform:none;
    border-color:var(--line);
    background:linear-gradient(145deg,var(--panel),#131a28);
}

@media(max-width:1100px){
    .kpis{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
}

@media(max-width:800px){
    body{
        overflow:auto;
    }

    .app{
        display:block;
        height:auto;
        min-height:100vh;
    }

    .side{
        display:none;
    }

    .main{
        min-height:100vh;
    }

    .top{
        padding:0 15px;
    }

    .search{
        width:100%;
    }

    .user > div:not(.avatar),
    .logout{
        display:none;
    }

    .content{
        overflow:visible;
        padding:20px 15px 35px;
    }
}

@media(max-width:560px){
    .page-head{
        flex-direction:column;
    }

    .kpis{
        grid-template-columns:1fr;
    }

    .module-grid{
        grid-template-columns:1fr;
    }
}
</style>

<div class="app">

    <aside class="side">

        <div class="brand">
            <div class="logo">A1</div>

            <div>
                <h1>Ageless One</h1>
                <p>AI BUSINESS SUITE · v1.1</p>
            </div>
        </div>

        <div class="nav-title">Overview</div>

        <div class="nav">
            <a
                href="<?php echo e(route('admin.dashboard')); ?>"
                class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>"
            >
                🏠 Executive Dashboard
            </a>
        </div>

        <div class="nav-title">Service Management</div>

        <div class="nav">
            <a
                href="<?php echo e(route('admin.parks')); ?>"
                class="<?php echo e(request()->routeIs('admin.parks') ? 'active' : ''); ?>"
            >
                🏢 Parks / Clients
            </a>

            <a
                href="<?php echo e(route('admin.parks.create')); ?>"
                class="<?php echo e(request()->routeIs('admin.parks.create') ? 'active' : ''); ?>"
            >
                ➕ Add Park
            </a>

            <a
                href="<?php echo e(route('admin.tickets')); ?>"
                class="<?php echo e(request()->routeIs('admin.tickets') || request()->routeIs('admin.tickets.show') ? 'active' : ''); ?>"
            >
                🎫 Complaint Tickets
            </a>

            <a
                href="<?php echo e(route('admin.tickets.create')); ?>"
                class="<?php echo e(request()->routeIs('admin.tickets.create') ? 'active' : ''); ?>"
            >
                ➕ Create Ticket
            </a>
        </div>

        <div class="nav-title">Inventory</div>

        <div class="nav">
            <a
                href="<?php echo e(route('admin.spare-parts')); ?>"
                class="<?php echo e(request()->routeIs('admin.spare-parts') || request()->routeIs('admin.spare-parts.edit') ? 'active' : ''); ?>"
            >
                📦 Spare Parts
            </a>

            <a
                href="<?php echo e(route('admin.spare-parts.create')); ?>"
                class="<?php echo e(request()->routeIs('admin.spare-parts.create') ? 'active' : ''); ?>"
            >
                ➕ Add Spare Part
            </a>

            <?php if(Route::has('admin.inventory-categories')): ?>
                <a
                    href="<?php echo e(route('admin.inventory-categories')); ?>"
                    class="<?php echo e(request()->routeIs('admin.inventory-categories*') ? 'active' : ''); ?>"
                >
                    🗂 Inventory Categories
                </a>
            <?php endif; ?>

            <a href="#">🔄 Stock In</a>
            <a href="#">📤 Stock Out</a>
        </div>

        <div class="nav-title">Site Management</div>

        <div class="nav">
            <a
                href="<?php echo e(route('admin.work-sites')); ?>"
                class="<?php echo e(request()->routeIs('admin.work-sites') || request()->routeIs('admin.work-sites.edit') ? 'active' : ''); ?>"
            >
                🏗 Work Sites
            </a>

            <a
                href="<?php echo e(route('admin.work-sites.create')); ?>"
                class="<?php echo e(request()->routeIs('admin.work-sites.create') ? 'active' : ''); ?>"
            >
                ➕ Add Work Site
            </a>

            <?php if(Route::has('admin.site-zones.index')): ?>
                <a
                    href="<?php echo e(route('admin.site-zones.index')); ?>"
                    class="<?php echo e(request()->routeIs('admin.site-zones*') ? 'active' : ''); ?>"
                >
                    🗺 Site Zones
                </a>
            <?php endif; ?>

            <?php if(Route::has('admin.site-assets')): ?>
                <a
                    href="<?php echo e(route('admin.site-assets')); ?>"
                    class="<?php echo e(request()->routeIs('admin.site-assets') || request()->routeIs('admin.site-assets.edit') ? 'active' : ''); ?>"
                >
                    🚜 Machinery & Assets
                </a>
            <?php endif; ?>

            <?php if(Route::has('admin.site-assets.create')): ?>
                <a
                    href="<?php echo e(route('admin.site-assets.create')); ?>"
                    class="<?php echo e(request()->routeIs('admin.site-assets.create') ? 'active' : ''); ?>"
                >
                    ➕ Add Asset
                </a>
            <?php endif; ?>
        </div>

        <div class="nav-title">HR & Staff</div>

        <div class="nav">
            <a
                href="<?php echo e(route('admin.attendance')); ?>"
                class="<?php echo e(request()->routeIs('admin.attendance') ? 'active' : ''); ?>"
            >
                🕒 Attendance
            </a>

            <a
                href="<?php echo e(route('admin.users')); ?>"
                class="<?php echo e(request()->routeIs('admin.users') ? 'active' : ''); ?>"
            >
                👥 Employees
            </a>

            <a href="#">🏖 Leave Management</a>
        </div>

        <div class="nav-title">Sales & CRM</div>

        <div class="nav">
            <a href="#">🤝 Customers</a>
            <a href="#">📞 Leads</a>
            <a href="#">📋 Quotations</a>
            <a href="#">📄 Contracts</a>
        </div>

        <div class="nav-title">System</div>

        <div class="nav">
            <a href="#">⚙ Settings</a>
        </div>

    </aside>

    <main class="main">

        <div class="top">
            <input
                class="search"
                type="search"
                placeholder="Search tickets, clients, projects, inventory..."
            >

            <div class="user">
                <div class="avatar"><?php echo e($initials); ?></div>

                <div>
                    <strong><?php echo e($user->name); ?></strong><br>
                    <small class="muted"><?php echo e($roleName); ?></small>
                </div>

                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>

                    <button class="logout" type="submit">
                        Logout
                    </button>
                </form>
            </div>
        </div>

        <div class="content">

            <div class="page-head">
                <div>
                    <h2>Executive Dashboard</h2>

                    <p>
                        <?php echo e(now()->format('l, d F Y')); ?>

                        · Live across service, inventory, workforce and projects
                    </p>
                </div>

                <div class="live-pill">
                    <span class="live-dot"></span>
                    System Online
                </div>
            </div>

            <div class="kpis">

                <div class="kpi">
                    <small>Total Users</small>
                    <h1><?php echo e($safeUsersCount); ?></h1>
                    <p>Registered Ageless One users</p>

                    <a href="<?php echo e(route('admin.users')); ?>" class="btn-blue">
                        View Users
                    </a>
                </div>

                <div class="kpi">
                    <small>Staff Attendance</small>
                    <h1><?php echo e($safeUsersCount); ?></h1>
                    <p>View punch-in and punch-out records</p>

                    <a href="<?php echo e(route('admin.attendance')); ?>" class="btn-blue">
                        View Attendance
                    </a>
                </div>

                <div class="kpi">
                    <small>Work Sites</small>
                    <h1>—</h1>
                    <p>Active project and site operations</p>

                    <a href="<?php echo e(route('admin.work-sites')); ?>" class="btn-blue">
                        View Sites
                    </a>
                </div>

                <div class="kpi">
                    <small>Service Tickets</small>
                    <h1>—</h1>
                    <p>Complaint and engineer workflow</p>

                    <a href="<?php echo e(route('admin.tickets')); ?>" class="btn-blue">
                        View Tickets
                    </a>
                </div>

            </div>

            <div class="section-head">
                <h3>Business Modules</h3>
                <p>Quick access to recently added Ageless One modules</p>
            </div>

            <div class="module-grid">

                <a href="<?php echo e(route('admin.work-sites')); ?>" class="module-card">
                    <div class="module-icon">🏗️</div>

                    <div>
                        <h3>Work Sites</h3>
                        <p>Manage projects, managers, supervisors and security.</p>
                    </div>
                </a>

                <?php if(Route::has('admin.site-zones.index')): ?>
                    <a href="<?php echo e(route('admin.site-zones.index')); ?>" class="module-card">
                        <div class="module-icon">🗺️</div>

                        <div>
                            <h3>Site Zones</h3>
                            <p>Manage civil, electrical, carpentry and project zones.</p>
                        </div>
                    </a>
                <?php else: ?>
                    <div class="module-card route-disabled">
                        <div class="module-icon">🗺️</div>

                        <div>
                            <h3>Site Zones</h3>
                            <p>Route is not registered yet.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if(Route::has('admin.site-assets')): ?>
                    <a href="<?php echo e(route('admin.site-assets')); ?>" class="module-card">
                        <div class="module-icon">🚜</div>

                        <div>
                            <h3>Machinery & Assets</h3>
                            <p>Track machines, vehicles, operators and services.</p>
                        </div>
                    </a>
                <?php else: ?>
                    <div class="module-card route-disabled">
                        <div class="module-icon">🚜</div>

                        <div>
                            <h3>Machinery & Assets</h3>
                            <p>Route is not registered yet.</p>
                        </div>
                    </div>
                <?php endif; ?>

                <a href="<?php echo e(route('admin.spare-parts')); ?>" class="module-card">
                    <div class="module-icon">📦</div>

                    <div>
                        <h3>Spare Parts</h3>
                        <p>Manage inventory, images, stock and low-stock alerts.</p>
                    </div>
                </a>

                <a href="<?php echo e(route('admin.tickets')); ?>" class="module-card">
                    <div class="module-icon">🎫</div>

                    <div>
                        <h3>Complaint Tickets</h3>
                        <p>Assign engineers and monitor service work progress.</p>
                    </div>
                </a>

                <a href="<?php echo e(route('admin.attendance')); ?>" class="module-card">
                    <div class="module-icon">🕒</div>

                    <div>
                        <h3>Staff Attendance</h3>
                        <p>View punch-in, punch-out, work time and location.</p>
                    </div>
                </a>

                <a href="<?php echo e(route('admin.inventory-items')); ?>" class="module-card">
                    <div class="module-icon">📦</div>

                    <div>
                        <h3>Smart Inventory</h3>
                        <p>Manage category-wise stock, warehouse, rack and item value.</p>
                    </div>
                </a>

            </div>

        </div>

    </main>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>