
<?php $__env->startSection('title', 'Expense Management'); ?>
<?php $__env->startSection('page-title', 'Expense Management'); ?>
<?php $__env->startSection('content'); ?>
<div class="row g-3 mb-4">
 <?php $__currentLoopData = ['pending'=>'Pending','approved'=>'Approved','rejected'=>'Rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <div class="col-md-4"><div class="card card-dark p-3"><div class="muted"><?php echo e($label); ?> Amount</div><div class="fs-3 fw-bold"><?php echo e(number_format($summary[$key], 2)); ?></div></div></div>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<div class="card card-dark p-3 mb-4">
<form class="row g-2 align-items-end">
 <div class="col-md-3"><label class="form-label">Status</label><select name="status" class="form-select"><option value="">All</option><?php $__currentLoopData = ['pending','approved','rejected']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($s); ?>" <?php if(request('status')===$s): echo 'selected'; endif; ?>><?php echo e(ucfirst($s)); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
 <div class="col-md-3"><label class="form-label">Project / Site</label><select name="work_site_id" class="form-select"><option value="">All</option><?php $__currentLoopData = $workSites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($site->id); ?>" <?php if(request('work_site_id')==$site->id): echo 'selected'; endif; ?>><?php echo e($site->site_name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
 <div class="col-md-2"><label class="form-label">From</label><input type="date" name="from" value="<?php echo e(request('from')); ?>" class="form-control"></div>
 <div class="col-md-2"><label class="form-label">To</label><input type="date" name="to" value="<?php echo e(request('to')); ?>" class="form-control"></div>
 <div class="col-md-2"><button class="btn btn-primary w-100">Filter</button></div>
</form>
</div>
<div class="card card-dark overflow-hidden">
<div class="table-responsive"><table class="table table-dark table-hover align-middle mb-0">
<thead><tr><th>Date / Staff</th><th>Purpose</th><th>Project</th><th>Amount</th><th>Bill</th><th>Status / Review</th></tr></thead>
<tbody><?php $__empty_1 = true; $__currentLoopData = $expenses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $expense): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr>
<td><?php echo e($expense->expense_date->format('d M Y')); ?><br><small class="muted"><?php echo e($expense->user?->name); ?></small></td>
<td><strong><?php echo e($expense->purpose); ?></strong><?php if($expense->description): ?><br><small class="muted"><?php echo e(Str::limit($expense->description, 100)); ?></small><?php endif; ?></td>
<td><?php echo e($expense->workSite?->site_name ?? 'Office / General'); ?></td>
<td class="fw-bold"><?php echo e(number_format($expense->amount, 2)); ?></td>
<td><?php if($expense->bill_path): ?><a target="_blank" class="btn btn-sm btn-outline-light" href="<?php echo e(Storage::url($expense->bill_path)); ?>">View Bill</a><?php else: ?><span class="muted">No bill</span><?php endif; ?></td>
<td style="min-width:240px">
<span class="badge text-bg-<?php echo e($expense->status === 'approved' ? 'success' : ($expense->status === 'rejected' ? 'danger' : 'warning')); ?>"><?php echo e(ucfirst($expense->status)); ?></span>
<?php if($expense->status === 'pending'): ?>
<form method="POST" action="<?php echo e(route('accounts.expenses.review', $expense)); ?>" class="mt-2"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>
<textarea name="review_note" class="form-control form-control-sm mb-2" rows="2" placeholder="Review note"></textarea>
<div class="d-flex gap-2"><button name="status" value="approved" class="btn btn-sm btn-success">Approve</button><button name="status" value="rejected" class="btn btn-sm btn-danger">Reject</button></div>
</form>
<?php else: ?><small class="d-block mt-2 muted"><?php echo e($expense->reviewer?->name); ?> · <?php echo e(optional($expense->reviewed_at)->format('d M Y h:i A')); ?></small><?php if($expense->review_note): ?><small><?php echo e($expense->review_note); ?></small><?php endif; ?>@endif
</td></tr><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="6" class="text-center py-5 muted">No expenses found.</td></tr><?php endif; ?></tbody>
</table></div><div class="p-3"><?php echo e($expenses->links()); ?></div></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views/expenses/index.blade.php ENDPATH**/ ?>