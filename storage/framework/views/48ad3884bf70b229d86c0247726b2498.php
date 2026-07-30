<<<<<<< HEAD
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
.table{
    width:100%;
    color:#fff!important;
    margin-bottom:0;
}

.table thead th{
    background:#0e1320;
    color:#8fa3c7!important;
    border-color:#262f47!important;
    font-size:13px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.6px;
    padding:15px;
}

.table tbody td{
    background:#151b29;
    color:#ffffff!important;
    border-color:#262f47!important;
    vertical-align:middle;
    font-size:15px;
    font-weight:500;
    padding:15px;
}

.table tbody tr:hover td{
    background:#1c2436;
}

.table td strong{
    color:#ffffff!important;
    font-weight:800;
}
.btn-blue{background:#3f6fe0;color:#fff;border:0;border-radius:10px;padding:10px 16px;text-decoration:none}
.muted{color:#8794ac}
</style>

<div class="card-dark">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3>Parks / Clients</h3>
                        <p class="muted mb-0">All customer park list</p>
                    </div>

                    <a href="<?php echo e(route('admin.parks.create')); ?>" class="btn-blue">+ Add Park</a>
                </div>

                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Park Name</th>
                                <th>Contact Person</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Created</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $parks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $park): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>#<?php echo e($park->id); ?></td>
                                <td><strong><?php echo e($park->name); ?></strong></td>
                                <td><?php echo e($park->contact_person ?? '-'); ?></td>
                                <td><?php echo e($park->phone ?? '-'); ?></td>
                                <td><?php echo e($park->location ?? '-'); ?></td>
                                <td><?php echo e($park->created_at->format('d M Y')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php echo e($parks->links()); ?>


=======
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
.table{
    width:100%;
    color:#fff!important;
    margin-bottom:0;
}

.table thead th{
    background:#0e1320;
    color:#8fa3c7!important;
    border-color:#262f47!important;
    font-size:13px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.6px;
    padding:15px;
}

.table tbody td{
    background:#151b29;
    color:#ffffff!important;
    border-color:#262f47!important;
    vertical-align:middle;
    font-size:15px;
    font-weight:500;
    padding:15px;
}

.table tbody tr:hover td{
    background:#1c2436;
}

.table td strong{
    color:#ffffff!important;
    font-weight:800;
}
.btn-blue{background:#3f6fe0;color:#fff;border:0;border-radius:10px;padding:10px 16px;text-decoration:none}
.muted{color:#8794ac}
</style>

<div class="card-dark">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div>
                        <h3>Parks / Clients</h3>
                        <p class="muted mb-0">All customer park list</p>
                    </div>

                    <a href="<?php echo e(route('admin.parks.create')); ?>" class="btn-blue">+ Add Park</a>
                </div>

                <?php if(session('success')): ?>
                    <div class="alert alert-success"><?php echo e(session('success')); ?></div>
                <?php endif; ?>

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Park Name</th>
                                <th>Contact Person</th>
                                <th>Phone</th>
                                <th>Location</th>
                                <th>Created</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php $__currentLoopData = $parks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $park): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>#<?php echo e($park->id); ?></td>
                                <td><strong><?php echo e($park->name); ?></strong></td>
                                <td><?php echo e($park->contact_person ?? '-'); ?></td>
                                <td><?php echo e($park->phone ?? '-'); ?></td>
                                <td><?php echo e($park->location ?? '-'); ?></td>
                                <td><?php echo e($park->created_at->format('d M Y')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <?php echo e($parks->links()); ?>


>>>>>>> 353115acd2f12e033eed9c0c3cba0304f0b467b5
            </div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views\admin\parks\index.blade.php ENDPATH**/ ?>