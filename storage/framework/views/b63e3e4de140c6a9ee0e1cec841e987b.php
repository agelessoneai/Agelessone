
<?php $__env->startSection('title','Add Site Asset'); ?>
<?php $__env->startSection('page-title','Add Site Asset'); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('admin.site_assets.partials.form',['siteAsset'=>null,'action'=>route('admin.site-assets.store'),'method'=>'POST'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views\admin\site_assets\create.blade.php ENDPATH**/ ?>