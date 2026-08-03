
<?php $__env->startSection('title', 'My Expenses'); ?>
<?php $__env->startSection('content'); ?>
<div class="mobile-head">
    <div><div class="eyebrow">STAFF EXPENSES</div><h1>My Expenses</h1></div>
    <form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button class="icon-btn">↪</button></form>
</div>

<div class="hero-card">
    <div class="muted">Submit bills and expenses</div>
    <h2>New Expense</h2>
    <p class="mb-0">Accounts and Admin can review every submission.</p>
</div>

<div class="app-card">
    <form method="POST" action="<?php echo e(route('expenses.store')); ?>" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <div class="mb-3"><label class="form-label">Expense Date</label><input type="date" name="expense_date" value="<?php echo e(old('expense_date', now()->toDateString())); ?>" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Project / Work Site</label><select name="work_site_id" class="form-select"><option value="">Office / General Expense</option><?php $__currentLoopData = $workSites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($site->id); ?>" <?php if(old('work_site_id') == $site->id): echo 'selected'; endif; ?>><?php echo e($site->site_name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
        <div class="mb-3"><label class="form-label">What was this expense for?</label><input name="purpose" value="<?php echo e(old('purpose')); ?>" class="form-control" placeholder="Fuel, material, travel, food..." required></div>
        <div class="mb-3"><label class="form-label">Amount</label><input type="number" step="0.01" min="0.01" name="amount" value="<?php echo e(old('amount')); ?>" class="form-control" placeholder="0.00" required></div>
        <div class="mb-3"><label class="form-label">Details</label><textarea name="description" class="form-control" rows="3" placeholder="Vendor, location, reason or other details"><?php echo e(old('description')); ?></textarea></div>
        <div class="mb-3"><label class="form-label">Bill / Receipt Photo</label><input type="file" name="bill" accept="image/*,.pdf" capture="environment" class="camera-input"><small class="muted">Photo or PDF, maximum 10 MB.</small></div>
        <button class="app-btn primary" type="submit">Submit Expense</button>
    </form>
</div>

<div class="app-card">
    <div class="row-between mb-2"><h3>Submission History</h3><span class="muted"><?php echo e($expenses->total()); ?> records</span></div>
    <?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="list-row">
            <div class="row-between"><strong><?php echo e($expense->purpose); ?></strong><strong><?php echo e(number_format($expense->amount, 2)); ?></strong></div>
            <div class="muted small"><?php echo e($expense->expense_date->format('d M Y')); ?> · <?php echo e($expense->workSite?->site_name ?? 'Office / General'); ?></div>
            <div class="row-between mt-2">
                <span class="status-pill <?php echo e($expense->status === 'approved' ? 'active' : ($expense->status === 'rejected' ? 'rejected' : 'pending')); ?>"><?php echo e(ucfirst($expense->status)); ?></span>
                <div class="d-flex gap-2">
                    <?php if($expense->bill_path): ?><a class="btn btn-sm btn-outline-light" target="_blank" href="<?php echo e(Storage::url($expense->bill_path)); ?>">Bill</a><?php endif; ?>
                    <?php if($expense->status === 'pending'): ?><form method="POST" action="<?php echo e(route('expenses.destroy', $expense)); ?>" onsubmit="return confirm('Delete this pending expense?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger">Delete</button></form><?php endif; ?>
                </div>
            </div>
            <?php if($expense->review_note): ?><div class="small mt-2">Review: <?php echo e($expense->review_note); ?></div><?php endif; ?>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><div class="muted py-3">No expenses submitted yet.</div><?php endif; ?>
    <div class="mt-3"><?php echo e($expenses->links()); ?></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.mobile', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views\expenses\my-expenses.blade.php ENDPATH**/ ?>