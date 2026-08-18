
<?php $__env->startSection('title','Work History'); ?>
<?php $__env->startSection('page-title','Work History'); ?>
<?php $__env->startSection('content'); ?>
<style>
.history-head{display:flex;justify-content:space-between;align-items:flex-start;gap:14px;margin-bottom:20px}.history-head h2{margin:0}.history-head p{margin:5px 0 0;color:#8794ac}.site-history-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:15px}.history-card{display:block;background:#151b29;border:1px solid #262f47;border-radius:16px;padding:18px;text-decoration:none;color:#e8edf6;transition:.2s}.history-card:hover{transform:translateY(-2px);border-color:#517ee8;color:#fff}.history-card h3{font-size:17px;margin:0 0 5px}.stats{display:grid;grid-template-columns:1fr 1fr;gap:9px;margin-top:16px}.stat{background:#1c2436;border-radius:11px;padding:11px}.stat span{display:block;color:#8794ac;font-size:11px}.stat strong{font-size:18px}.open-link{margin-top:15px;color:#8eafff;font-weight:700;font-size:13px}@media(max-width:1000px){.site-history-grid{grid-template-columns:repeat(2,1fr)}}@media(max-width:650px){.site-history-grid{grid-template-columns:1fr}}
</style>
<div class="history-head"><div><h2>Worksite History</h2><p>Select a worksite, choose any past date or date range, and download the report in Excel.</p></div></div>
<div class="site-history-grid">
<?php $__empty_1 = true; $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<a class="history-card" href="<?php echo e(route('admin.work-history.show',$site)); ?>">
 <div style="font-size:28px;margin-bottom:10px">🏗️</div>
 <h3><?php echo e($site->site_name); ?></h3>
 <div class="muted"><?php echo e($site->location ?: 'Location not added'); ?></div>
 <div class="muted mt-1">Supervisor: <?php echo e($site->supervisor?->name ?? 'Not assigned'); ?></div>
 <div class="stats"><div class="stat"><span>Attendance Records</span><strong><?php echo e($site->attendance_records_count); ?></strong></div><div class="stat"><span>Total Hours</span><strong><?php echo e(number_format(($site->total_working_minutes ?? 0)/60,1)); ?></strong></div></div>
 <div class="open-link">Open history →</div>
</a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="card card-dark p-4">No work sites available.</div><?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views/admin/work_history/index.blade.php ENDPATH**/ ?>