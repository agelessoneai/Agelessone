

<?php $__env->startSection('content'); ?>

<style>
body{background:#0e1320;color:#e8edf6;overflow:hidden}
.navbar,header{display:none!important}
.container{max-width:100%!important;margin:0!important;padding:0!important}
.app{display:grid;grid-template-columns:270px 1fr;height:100vh}
.side{background:#151b29;border-right:1px solid #262f47}
.brand{padding:18px;display:flex;gap:12px;align-items:center;border-bottom:1px solid #262f47}
.logo{width:48px;height:48px;border-radius:14px;background:linear-gradient(135deg,#5b8cff,#9b6bff);display:grid;place-items:center;font-weight:800;font-size:22px;color:#fff}
.brand h1{margin:0;font-size:17px}.brand p{margin:0;font-size:11px;color:#8794ac}
.nav-title{padding:18px 24px 8px;font-size:11px;color:#8794ac;font-weight:700;letter-spacing:1px}
.nav a{display:flex;padding:14px 22px;text-decoration:none;color:#a8b4cc}
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
.table{width:100%;color:#fff!important;margin-bottom:0}
.table thead th{background:#0e1320;color:#8fa3c7!important;border-color:#262f47!important;font-size:13px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;padding:15px}
.table tbody td{background:#151b29;color:#fff!important;border-color:#262f47!important;vertical-align:middle;font-size:15px;font-weight:500;padding:15px}
.table tbody tr:hover td{background:#1c2436}
.badge-low{background:#ff5a6e;color:#fff;padding:6px 12px;border-radius:20px;font-size:12px}
.badge-ok{background:#37c281;color:#062015;padding:6px 12px;border-radius:20px;font-size:12px;font-weight:800}
</style>

<div class="app">

    <aside class="side">
        <div class="brand">
            <div class="logo">A1</div>
            <div>
                <h1>Ageless One</h1>
                <p>AI BUSINESS OS · v1.1</p>
            </div>
        </div>

        <div class="nav-title">OVERVIEW</div>
        <div class="nav">
            <a href="<?php echo e(route('admin.dashboard')); ?>">🏠 Executive Dashboard</a>
        </div>

        <div class="nav-title">SERVICE MANAGEMENT</div>
        <div class="nav">
            <a href="<?php echo e(route('admin.parks')); ?>">🏢 Parks / Clients</a>
            <a href="<?php echo e(route('admin.tickets')); ?>">🎫 Complaint Tickets</a>
            <a class="active" href="<?php echo e(route('admin.spare-parts')); ?>">📦 Spare Parts</a>
        </div>

        <div class="nav-title">ADMIN</div>
        <div class="nav">
            <a href="<?php echo e(route('admin.attendance')); ?>">🕒 Attendance</a>
            <a href="<?php echo e(route('admin.users')); ?>">👥 Users</a>
        </div>
    </aside>

    <main class="main">
        <div class="top">
            <input class="search" placeholder="Search spare parts...">

            <div class="user">
                <div class="avatar"><?php echo e(strtoupper(substr(Auth::user()->name,0,1))); ?></div>
                <div>
                    <strong><?php echo e(Auth::user()->name); ?></strong><br>
                    <small class="muted">Administrator</small>
                </div>
                <form method="POST" action="<?php echo e(route('logout')); ?>">
                    <?php echo csrf_field(); ?>
                    <button class="logout">Logout</button>
                </form>
            </div>
        </div>

        <div class="content">
            <div class="card-dark">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3>Spare Parts Inventory</h3>
                        <p class="muted mb-0">Manage service parts and stock levels</p>
                    </div>

                    <a href="<?php echo e(route('admin.spare-parts.create')); ?>" class="btn-blue">+ Add Spare Part</a>
                </div>

                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Photo</th>
                                <th>Part Name</th>
                                <th>Code</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                      <tbody>
                            <?php $__currentLoopData = $parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                   
                                    <td>
                                        <?php if($part->image): ?>
                                            <img src="<?php echo e(asset('storage/'.$part->image)); ?>"
                                                style="width:60px;
                                                        height:60px;
                                                        border-radius:10px;
                                                        object-fit:cover;
                                                        border:1px solid #333;">
                                        <?php else: ?>
                                            <img src="https://via.placeholder.com/60?text=No+Image"
                                                style="border-radius:10px;">
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <strong><?php echo e($part->part_name); ?></strong>
                                    </td>

                                    <td><?php echo e($part->part_code ?? '-'); ?></td>

                                    <td><?php echo e($part->category ?? '-'); ?></td>

                                    <td><?php echo e($part->stock); ?> PCS</td>


                                    <td>₹<?php echo e(number_format($part->unit_price,2)); ?></td>

                                    <td>
                                        <?php if($part->stock <= $part->minimum_stock): ?>
                                            <span class="badge-low">Low Stock</span>
                                        <?php else: ?>
                                            <span class="badge-ok">Available</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <div style="display:flex;gap:10px;align-items:center;">

                                            <a href="<?php echo e(route('admin.spare-parts.edit', $part->id)); ?>"
                                            class="btn-blue"
                                            style="padding:8px 14px;">
                                                ✏ Edit
                                            </a>

                                            <form method="POST"
                                                action="<?php echo e(route('admin.spare-parts.destroy', $part->id)); ?>"
                                                onsubmit="return confirm('Delete this spare part?')"
                                                style="margin:0;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>

                                                <button type="submit"
                                                        style="background:#ff5a6e;color:#fff;border:none;border-radius:10px;padding:8px 14px;cursor:pointer;">
                                                    🗑 Delete
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php echo e($parts->links()); ?>


            </div>
        </div>
    </main>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views/admin/spare_parts/index.blade.php ENDPATH**/ ?>