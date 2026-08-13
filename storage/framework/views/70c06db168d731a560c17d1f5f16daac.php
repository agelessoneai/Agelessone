<?php $__env->startSection('page-title', 'Worker Wages — ' . $workSite->name); ?>

<?php $__env->startSection('content'); ?>
<style>
    .wage-card { background: var(--panel, #151b29); border: 1px solid var(--line, #262f47); border-radius: 16px; padding: 22px; }
    .wage-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 20px; }
    .wage-header h4 { margin: 0; color: #fff; font-weight: 700; }
    .wage-header p { margin: 4px 0 0; color: #8794ac; font-size: 13px; }
    .wage-filters { display: flex; gap: 10px; flex-wrap: wrap; align-items: end; }
    .wage-filters select, .wage-filters input { background: #0e1320; border: 1px solid #262f47; color: #e8edf6; padding: 8px 12px; border-radius: 8px; font-size: 13px; }
    .wage-table { width: 100%; color: #e8edf6; }
    .wage-table thead th { padding: 12px 14px; background: #0e1320; color: #8794ac; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; border-bottom: 1px solid #262f47; white-space: nowrap; }
    .wage-table tbody td { padding: 12px 14px; border-bottom: 1px solid #1c2436; font-size: 13px; }
    .wage-table tbody tr:hover { background: rgba(63,111,224,.06); }
    .total-bar { display: flex; justify-content: space-between; align-items: center; padding: 14px 18px; background: linear-gradient(135deg, #1c2436, #151b29); border: 1px solid #262f47; border-radius: 12px; margin-top: 16px; }
    .total-bar .label { color: #8794ac; font-size: 13px; font-weight: 600; }
    .total-bar .amount { color: #37c281; font-size: 20px; font-weight: 800; }
    .badge-ot { background: rgba(242,181,59,.15); color: #f2b53b; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; }
</style>

<div class="wage-card">
    <div class="wage-header">
        <div>
            <h4>💰 Worker Wages</h4>
            <p><?php echo e($workSite->name); ?> — Wage records and overtime calculations</p>
        </div>
        <a href="<?php echo e(route('admin.work-sites.wages.create', $workSite)); ?>" class="btn btn-primary d-flex align-items-center gap-2">
            <span>➕</span> Add Wage Entry
        </a>
    </div>

    
    <form method="GET" class="wage-filters mb-3">
        <div>
            <label class="text-muted small d-block mb-1">Worker</label>
            <select name="worker_id" onchange="this.form.submit()">
                <option value="">All Workers</option>
                <?php $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($w->id); ?>" <?php echo e(request('worker_id') == $w->id ? 'selected' : ''); ?>><?php echo e($w->name); ?> (<?php echo e($w->worker_code); ?>)</option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>
        <div>
            <label class="text-muted small d-block mb-1">Month</label>
            <input type="month" name="month" value="<?php echo e(request('month')); ?>" onchange="this.form.submit()">
        </div>
    </form>

    <div class="table-responsive">
        <table class="wage-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Worker</th>
                    <th>Hours</th>
                    <th>OT Hours</th>
                    <th>Base Wage</th>
                    <th>OT Pay</th>
                    <th>Total</th>
                    <th>Recorded By</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $wages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($wage->date->format('d M Y')); ?></td>
                        <td><strong><?php echo e($wage->worker->name ?? 'N/A'); ?></strong></td>
                        <td><?php echo e($wage->hours_worked); ?>h</td>
                        <td>
                            <?php if($wage->overtime_hours > 0): ?>
                                <span class="badge-ot">+<?php echo e($wage->overtime_hours); ?>h OT</span>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                        <td>₹<?php echo e(number_format($wage->base_wage, 2)); ?></td>
                        <td>
                            <?php if($wage->overtime_pay > 0): ?>
                                <span class="text-warning">+₹<?php echo e(number_format($wage->overtime_pay, 2)); ?></span>
                            <?php else: ?>
                                —
                            <?php endif; ?>
                        </td>
                        <td><strong class="text-success">₹<?php echo e(number_format($wage->total_wage, 2)); ?></strong></td>
                        <td class="text-muted"><?php echo e($wage->recordedBy->name ?? '—'); ?></td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="<?php echo e(route('admin.wages.edit', $wage)); ?>" class="btn btn-sm btn-outline-warning py-1 px-2" title="Edit Wage Entry">✏️ Edit</a>
                                <form method="POST" action="<?php echo e(route('admin.wages.destroy', $wage)); ?>" onsubmit="return confirm('Are you sure you want to delete this wage entry?')">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('DELETE'); ?>
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete Entry">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="9" class="text-center py-4 text-muted">No wage records found. Click "Add Wage Entry" to begin.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php if($wages->count()): ?>
        <div class="total-bar">
            <span class="label">Total Wages (filtered)</span>
            <span class="amount">₹<?php echo e(number_format($totalWage, 2)); ?></span>
        </div>
    <?php endif; ?>

    <div class="mt-3">
        <?php echo e($wages->links()); ?>

    </div>
</div>

<a href="<?php echo e(route('admin.work-sites.show', $workSite)); ?>" class="btn btn-outline-secondary mt-3">← Back to Work Site</a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views/admin/wages/index.blade.php ENDPATH**/ ?>