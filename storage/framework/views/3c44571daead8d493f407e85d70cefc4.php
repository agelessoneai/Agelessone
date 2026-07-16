

<?php $__env->startSection('title', 'Work Sites'); ?>

<?php $__env->startSection('content'); ?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2>Site Management</h2>
        <p class="muted mb-0">Manage work sites, supervisors, security and project teams</p>
    </div>

    <a href="<?php echo e(route('admin.work-sites.create')); ?>" class="btn-blue">
        + Add Work Site
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="site-grid">

    <?php $__empty_1 = true; $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

        <div class="site-card">

            <div class="site-card-top">
                <div>
                    <h3><?php echo e($site->site_name); ?></h3>
                    <p><?php echo e($site->client_name ?? 'No client added'); ?></p>
                </div>

                <span class="site-status status-<?php echo e($site->status); ?>">
                    <?php echo e(ucfirst(str_replace('_', ' ', $site->status))); ?>

                </span>
            </div>

            <div class="site-location">
                📍 <?php echo e($site->location ?? 'Location not added'); ?>

            </div>

            <div class="site-info-grid">

                <div class="site-info">
                    <span>Security</span>
                    <strong><?php echo e($site->security->name ?? '-'); ?></strong>
                </div>

                <div class="site-info">
                    <span>Supervisor</span>
                    <strong><?php echo e($site->supervisor->name ?? '-'); ?></strong>
                </div>

                <div class="site-info">
                    <span>Site Manager</span>
                    <strong><?php echo e($site->siteManager->name ?? '-'); ?></strong>
                </div>

                <div class="site-info">
                    <span>Project Manager</span>
                    <strong><?php echo e($site->projectManager->name ?? '-'); ?></strong>
                </div>

                <div class="site-info">
                    <span>Start Date</span>
                    <strong>
                        <?php echo e($site->start_date
                            ? \Carbon\Carbon::parse($site->start_date)->format('d M Y')
                            : '-'); ?>

                    </strong>
                </div>

                <div class="site-info">
                    <span>Expected End</span>
                    <strong>
                        <?php echo e($site->expected_end_date
                            ? \Carbon\Carbon::parse($site->expected_end_date)->format('d M Y')
                            : '-'); ?>

                    </strong>
                </div>

            </div>

            <?php if($site->description): ?>
                <div class="site-description">
                    <?php echo e($site->description); ?>

                </div>
            <?php endif; ?>

            <div class="site-actions">

                <a href="<?php echo e(route('admin.work-sites.edit', $site->id)); ?>"
                   class="btn-blue">
                    ✏ Edit
                </a>

                <form method="POST"
                      action="<?php echo e(route('admin.work-sites.destroy', $site->id)); ?>"
                      onsubmit="return confirm('Delete this work site?')">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>

                    <button type="submit" class="btn-red">
                        🗑 Delete
                    </button>
                </form>

            </div>

        </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

        <div class="card-dark empty-state">
            <div class="empty-icon">🏗️</div>
            <h3>No Work Sites Yet</h3>
            <p class="muted">Create your first project work site.</p>

            <a href="<?php echo e(route('admin.work-sites.create')); ?>" class="btn-blue">
                + Add Work Site
            </a>
        </div>

    <?php endif; ?>

</div>

<div class="mt-4">
    <?php echo e($sites->links()); ?>

</div>

<style>
.site-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(360px,1fr));
    gap:20px;
}

.site-card{
    background:#151b29;
    border:1px solid #262f47;
    border-radius:20px;
    padding:22px;
    transition:.25s ease;
}

.site-card:hover{
    transform:translateY(-3px);
    border-color:#3f6fe0;
}

.site-card-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:15px;
}

.site-card h3{
    margin:0;
    color:#fff;
    font-size:20px;
}

.site-card p{
    margin:5px 0 0;
    color:#8794ac;
    font-size:13px;
}

.site-status{
    padding:7px 12px;
    border-radius:999px;
    font-size:11px;
    font-weight:800;
    white-space:nowrap;
}

.status-active{
    background:rgba(55,194,129,.16);
    color:#55db9c;
}

.status-planning{
    background:rgba(63,111,224,.18);
    color:#8fb0ff;
}

.status-on_hold{
    background:rgba(242,181,59,.18);
    color:#f2b53b;
}

.status-completed{
    background:rgba(155,107,255,.18);
    color:#b99bff;
}

.site-location{
    margin:18px 0;
    padding:12px 14px;
    border-radius:13px;
    background:#0e1320;
    color:#cbd5e1;
    font-size:13px;
}

.site-info-grid{
    display:grid;
    grid-template-columns:repeat(2,1fr);
    gap:12px;
}

.site-info{
    padding:13px;
    background:#1c2436;
    border-radius:13px;
}

.site-info span{
    display:block;
    color:#8794ac;
    font-size:11px;
    margin-bottom:5px;
    text-transform:uppercase;
}

.site-info strong{
    color:#fff;
    font-size:14px;
}

.site-description{
    margin-top:15px;
    color:#b7c2d8;
    font-size:13px;
    line-height:1.6;
}

.site-actions{
    display:flex;
    align-items:center;
    gap:10px;
    margin-top:20px;
}

.site-actions form{
    margin:0;
}

.empty-state{
    text-align:center;
    grid-column:1/-1;
    padding:50px;
}

.empty-icon{
    font-size:48px;
    margin-bottom:15px;
}

@media(max-width:600px){
    .site-grid{
        grid-template-columns:1fr;
    }

    .site-info-grid{
        grid-template-columns:1fr;
    }

    .site-card-top{
        flex-direction:column;
    }
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views/admin/work_sites/index.blade.php ENDPATH**/ ?>