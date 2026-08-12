
<?php $__env->startSection('title','Edit Office Staff'); ?>
<?php $__env->startSection('page-title','Edit Office Staff'); ?>
<?php $__env->startSection('content'); ?>
<div class="card card-dark p-4"><form method="POST" action="<?php echo e(route('admin.users.update',$user)); ?>" enctype="multipart/form-data"><?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?> <?php echo $__env->make('admin.users._form', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><div class="mt-4"><a class="btn btn-outline-light" href="<?php echo e(route('admin.users.index')); ?>">Cancel</a><button class="btn btn-primary">Update Staff</button></div></form></div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>