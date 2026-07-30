<?php $__env->startSection('title','Add Office Staff'); ?>
<?php $__env->startSection('page-title','Add Office Staff'); ?>
<?php $__env->startSection('content'); ?>
<div class="card card-dark p-4"><form method="POST" action="<?php echo e(route('admin.users.store')); ?>" enctype="multipart/form-data"><?php echo csrf_field(); ?> <?php echo $__env->make('admin.users._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><div class="mt-4"><a class="btn btn-outline-light" href="<?php echo e(route('admin.users.index')); ?>">Cancel</a><button class="btn btn-primary">Create Staff</button></div></form></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views\admin\users\create.blade.php ENDPATH**/ ?>