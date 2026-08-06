<?php $__env->startSection('title','Office Staff'); ?>
<?php $__env->startSection('page-title','Office Staff'); ?>
<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div><h2 class="mb-1">Office Staff</h2><p class="muted mb-0">Total staff: <?php echo e($users->total()); ?>. Site workers are managed inside each Work Site.</p></div>
    <a class="btn btn-primary" href="<?php echo e(route('admin.users.create')); ?>">+ Add Staff</a>
</div>
<form class="row g-2 mb-3" method="GET">
    <div class="col-md-5"><input class="form-control" name="search" value="<?php echo e(request('search')); ?>" placeholder="Search staff"></div>
    <div class="col-md-3"><select class="form-select" name="role"><option value="">All roles</option><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(request('role')===$value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
    <div class="col-md-2"><select class="form-select" name="status"><option value="">All status</option><option value="active" <?php if(request('status')==='active'): echo 'selected'; endif; ?>>Active</option><option value="inactive" <?php if(request('status')==='inactive'): echo 'selected'; endif; ?>>Inactive</option></select></div>
    <div class="col-md-2"><button class="btn btn-outline-light w-100">Filter</button></div>
</form>
<div class="card card-dark"><div class="table-responsive"><table class="table table-dark table-hover mb-0"><thead><tr><th>Staff</th><th>Contact</th><th>Role</th><th>Department</th><th>Status</th><th></th></tr></thead><tbody>
<?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><tr><td><strong><?php echo e($user->name); ?></strong><br><small class="muted">#<?php echo e($user->id); ?></small></td><td><?php echo e($user->email); ?><br><small><?php echo e($user->mobile); ?></small></td><td><?php echo e($roles[$user->role] ?? ucfirst(str_replace('_',' ',$user->role))); ?></td><td><?php echo e($user->department ?: '—'); ?></td><td><span class="badge <?php echo e($user->status==='active'?'text-bg-success':'text-bg-secondary'); ?>"><?php echo e(ucfirst($user->status)); ?></span></td><td class="text-end"><a class="btn btn-sm btn-outline-light" href="<?php echo e(route('admin.users.edit',$user)); ?>">Edit</a><?php if(auth()->id()!==$user->id): ?><form class="d-inline" method="POST" action="<?php echo e(route('admin.users.destroy',$user)); ?>" onsubmit="return confirm('Delete this staff account?')"><?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?><button class="btn btn-sm btn-outline-danger">Delete</button></form><?php endif; ?></td></tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><tr><td colspan="6" class="text-center py-5">No office staff found.</td></tr><?php endif; ?>
</tbody></table></div></div><div class="mt-3"><?php echo e($users->links()); ?></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views/admin/users/index.blade.php ENDPATH**/ ?>