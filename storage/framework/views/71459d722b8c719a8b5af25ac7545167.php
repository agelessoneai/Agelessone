

<?php $__env->startSection('title', 'Work Sites'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-header">
    <div>
        <h2>Site Management</h2>
        <p>Manage work sites, supervisors, security and project teams.</p>
    </div>

    <a href="<?php echo e(route('admin.work-sites.create')); ?>" class="btn-add">
        + Add Work Site
    </a>
</div>

<?php if(session('success')): ?>
    <div class="alert-success">
        <?php echo e(session('success')); ?>

    </div>
<?php endif; ?>

<div class="summary-grid">

    <div class="summary-card">
        <span>Total Sites</span>
        <strong><?php echo e($sites->total()); ?></strong>
    </div>

    <div class="summary-card">
        <span>Active</span>
        <strong><?php echo e($sites->where('status', 'active')->count()); ?></strong>
    </div>

    <div class="summary-card">
        <span>Planning</span>
        <strong><?php echo e($sites->where('status', 'planning')->count()); ?></strong>
    </div>

    <div class="summary-card">
        <span>Completed</span>
        <strong><?php echo e($sites->where('status', 'completed')->count()); ?></strong>
    </div>

</div>

<div class="site-grid">

    <?php $__empty_1 = true; $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>

        <div class="site-card" role="link" tabindex="0"
             onclick="if (!event.target.closest('a,button,form,input,select,textarea,label')) window.location='<?php echo e(route('admin.work-sites.show', $site)); ?>'"
             onkeydown="if ((event.key === 'Enter' || event.key === ' ') && !event.target.closest('a,button,form,input,select,textarea,label')) { event.preventDefault(); window.location='<?php echo e(route('admin.work-sites.show', $site)); ?>'; }">

            <div class="site-card-top">

                <div class="site-heading">
                    <div class="site-icon">🏗️</div>

                    <div>
                        <h3><?php echo e($site->site_name); ?></h3>
                        <p><?php echo e($site->client_name ?? 'No client added'); ?></p>
                    </div>
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
                    <?php echo e(\Illuminate\Support\Str::limit($site->description, 100)); ?>

                </div>
            <?php endif; ?>

            <div class="site-actions">

                <a
                    href="<?php echo e(route('admin.work-sites.show', $site)); ?>"
                    class="small-button view-button"
                >
                    👁 View Site
                </a>

                <a
                    href="<?php echo e(route('admin.work-sites.edit', $site->id)); ?>"
                    class="small-button edit-button"
                >
                    ✏ Edit
                </a>

                <form
                    method="POST"
                    action="<?php echo e(route('admin.work-sites.destroy', $site->id)); ?>"
                    onsubmit="return confirm('Delete this work site?')"
                >
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>

                    <button type="submit" class="small-button delete-button">
                        🗑 Delete
                    </button>
                </form>

            </div>

        </div>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>

        <div class="empty-state">
            <div class="empty-icon">🏗️</div>
            <h3>No Work Sites Yet</h3>
            <p>Create your first project work site.</p>

            <a href="<?php echo e(route('admin.work-sites.create')); ?>" class="btn-add">
                + Add Work Site
            </a>
        </div>

    <?php endif; ?>

</div>

<div class="pagination-wrap">
    <?php echo e($sites->links()); ?>

</div>

<style>
.page-header{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:18px;
    margin-bottom:16px;
}

.page-header h2{
    margin:0;
    color:#fff;
    font-size:23px;
    line-height:1.2;
}

.page-header p{
    margin:5px 0 0;
    color:#8794ac;
    font-size:13px;
}

.btn-add{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:38px;
    padding:8px 14px;
    border-radius:9px;
    color:#fff;
    background:#3f6fe0;
    text-decoration:none;
    font-size:13px;
    font-weight:700;
    white-space:nowrap;
}

.alert-success{
    margin-bottom:16px;
    padding:11px 14px;
    border:1px solid rgba(55,194,129,.30);
    border-radius:10px;
    color:#9ce8bf;
    background:rgba(55,194,129,.11);
    font-size:12px;
}

.summary-grid{
    display:grid;
    grid-template-columns:repeat(4,minmax(0,1fr));
    gap:12px;
    margin-bottom:16px;
}

.summary-card{
    padding:13px 15px;
    border:1px solid #262f47;
    border-radius:12px;
    background:#151b29;
}

.summary-card span{
    display:block;
    color:#8794ac;
    font-size:10px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.5px;
}

.summary-card strong{
    display:block;
    margin-top:5px;
    color:#fff;
    font-size:21px;
}

.site-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
    gap:15px;
    align-items:start;
}

.site-card{
    display:flex;
    flex-direction:column;
    min-width:0;
    padding:17px;
    border:1px solid #29344d;
    border-radius:15px;
    background:#151b29;
    transition:.2s ease;
    cursor:pointer;
}

.site-card:hover{
    transform:translateY(-2px);
    border-color:#3f6fe0;
}

.site-card-top{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:12px;
}

.site-heading{
    display:flex;
    align-items:center;
    gap:10px;
    min-width:0;
}

.site-icon{
    width:38px;
    height:38px;
    flex:0 0 38px;
    display:grid;
    place-items:center;
    border-radius:11px;
    background:linear-gradient(135deg,#3f6fe0,#9b6bff);
    font-size:18px;
}

.site-card h3{
    margin:0;
    color:#fff;
    font-size:16px;
    line-height:1.25;
}

.site-card p{
    margin:3px 0 0;
    color:#8794ac;
    font-size:11px;
}

.site-status{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:5px 9px;
    border-radius:999px;
    font-size:10px;
    font-weight:800;
    white-space:nowrap;
}

.status-active{
    color:#5be09f;
    background:rgba(55,194,129,.16);
}

.status-planning{
    color:#96b2ff;
    background:rgba(63,111,224,.17);
}

.status-on_hold{
    color:#f2c15a;
    background:rgba(242,181,59,.16);
}

.status-completed{
    color:#c2a8ff;
    background:rgba(155,107,255,.17);
}

.site-location{
    margin:13px 0;
    padding:10px 12px;
    border-radius:10px;
    color:#d1d9e8;
    background:#0e1320;
    font-size:12px;
}

.site-info-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:8px;
}

.site-info{
    min-width:0;
    min-height:58px;
    padding:10px;
    border-radius:10px;
    background:#1c2436;
}

.site-info span{
    display:block;
    margin-bottom:5px;
    color:#8794ac;
    font-size:9px;
    text-transform:uppercase;
    letter-spacing:.35px;
}

.site-info strong{
    display:block;
    overflow:hidden;
    color:#fff;
    font-size:12px;
    text-overflow:ellipsis;
    white-space:nowrap;
}

.site-description{
    margin-top:11px;
    color:#b9c4d7;
    font-size:11px;
    line-height:1.5;
}

.site-actions{
    display:flex;
    align-items:center;
    gap:8px;
    margin-top:14px;
}

.site-actions form{
    margin:0;
}

.small-button{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:34px;
    padding:7px 12px;
    border:0;
    border-radius:8px;
    color:#fff;
    text-decoration:none;
    font-size:11px;
    font-weight:700;
    cursor:pointer;
}

.view-button{
    background:#24a36a;
}

.edit-button{
    background:#3f6fe0;
}

.delete-button{
    background:#ff5a6e;
}

.empty-state{
    grid-column:1/-1;
    padding:45px 20px;
    border:1px solid #262f47;
    border-radius:15px;
    background:#151b29;
    text-align:center;
}

.empty-icon{
    margin-bottom:10px;
    font-size:42px;
}

.empty-state h3{
    margin:0 0 5px;
    color:#fff;
}

.empty-state p{
    margin:0 0 16px;
    color:#8794ac;
    font-size:12px;
}

.pagination-wrap{
    margin-top:16px;
}

@media(max-width:1100px){
    .summary-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
}

@media(max-width:700px){
    .page-header{
        flex-direction:column;
    }

    .page-header .btn-add{
        width:100%;
    }

    .summary-grid{
        grid-template-columns:1fr;
    }

    .site-grid{
        grid-template-columns:1fr;
    }

    .site-info-grid{
        grid-template-columns:1fr;
    }

    .site-card-top{
        flex-direction:column;
    }

    .site-status{
        align-self:flex-start;
    }
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views\admin\work_sites\index.blade.php ENDPATH**/ ?>