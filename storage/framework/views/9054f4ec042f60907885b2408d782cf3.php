<?php $__env->startSection('title','Add Site Work'); ?>
<?php $__env->startSection('content'); ?>
<div class="zone-page"><div class="zone-head"><div><h2>Add Site Work</h2><p>Create a work area/activity under the selected site.</p></div></div><div class="zone-panel"><form method="POST" action="<?php echo e(route('admin.site-zones.store')); ?>"><?php echo csrf_field(); ?> <?php echo $__env->make('admin.site_zones._form',['submitLabel'=>'Add Work'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?></form></div></div>
<style>.zone-head h2{margin:0;color:#fff}.zone-head p{margin:5px 0 16px;color:#8794ac}.zone-panel{padding:20px;border:1px solid #29344d;border-radius:15px;background:#151b29}</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views/admin/site_zones/create.blade.php ENDPATH**/ ?>