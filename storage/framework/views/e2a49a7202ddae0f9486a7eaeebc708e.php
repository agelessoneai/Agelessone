<?php $__env->startSection('title','Workshops'); ?>
<?php $__env->startSection('page-title','Workshop Management'); ?>
<?php $__env->startPush('styles'); ?>
<style>
.ws-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(280px,1fr));gap:16px}.ws-card{background:#151b29;border:1px solid #262f47;border-radius:16px;padding:18px;color:#e8edf6}.ws-card a{text-decoration:none;color:inherit}.stat{font-size:26px;font-weight:800}.ws-btn{border:0;border-radius:10px;padding:10px 14px;background:#3f6fe0;color:#fff;font-weight:700}.form-control,.form-select{background:#0f1625;border-color:#33405f;color:#fff}.form-control:focus,.form-select:focus{background:#0f1625;color:#fff}.modal-content{background:#151b29;color:#fff;border:1px solid #33405f}
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startSection('content'); ?>
<?php if($errors->any()): ?>
<div class="alert alert-danger"><strong>Workshop could not be added.</strong><ul class="mb-0 mt-2"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
<?php endif; ?>
<div class="d-flex justify-content-between align-items-center mb-4 gap-2 flex-wrap"><div><h2 class="mb-1">Workshops</h2><div class="muted">In-charge, inventory, workers and project progress</div></div><button class="ws-btn" data-bs-toggle="modal" data-bs-target="#addWorkshop">+ Add Workshop</button></div>
<div class="ws-grid">
<?php $__empty_1 = true; $__currentLoopData = $workshops; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workshop): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
<div class="ws-card"><a href="<?php echo e(route('workshops.show',$workshop)); ?>"><div class="d-flex justify-content-between"><h4><?php echo e($workshop->name); ?></h4><span class="badge bg-<?php echo e($workshop->status==='active'?'success':'secondary'); ?>"><?php echo e(ucfirst($workshop->status)); ?></span></div><p class="muted mb-3">📍 <?php echo e($workshop->location ?: 'Location not set'); ?></p><p class="mb-3">In-charge: <strong><?php echo e($workshop->inCharge?->name ?: 'Not assigned'); ?></strong></p><div class="row text-center"><div class="col"><div class="stat"><?php echo e($workshop->inventory_items_count); ?></div><small class="muted">Inventory Items</small></div><div class="col"><div class="stat"><?php echo e($workshop->projects_count); ?></div><small class="muted">Projects</small></div></div></a></div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
<div class="ws-card"><h4>No workshop added</h4><p class="muted mb-0">Create the first workshop to manage inventory and projects.</p></div>
<?php endif; ?>
</div>
<div class="modal fade" id="addWorkshop"><div class="modal-dialog"><form method="POST" action="<?php echo e(route('workshops.store')); ?>" class="modal-content"><?php echo csrf_field(); ?><div class="modal-header"><h5>Add Workshop</h5><button class="btn-close btn-close-white" data-bs-dismiss="modal"></button></div><div class="modal-body"><div class="mb-3"><label>Name</label><input required name="name" value="<?php echo e(old('name')); ?>" class="form-control"></div><div class="mb-3"><label>Location</label><input name="location" value="<?php echo e(old('location')); ?>" class="form-control"></div><div class="mb-3"><label>In-charge</label><select name="in_charge_user_id" class="form-select"><option value="">Select</option><?php $__currentLoopData = $managers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($manager->id); ?>" <?php if(old('in_charge_user_id') == $manager->id): echo 'selected'; endif; ?>><?php echo e($manager->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div><div class="mb-3"><label>Description</label><textarea name="description" class="form-control"><?php echo e(old('description')); ?></textarea></div><input type="hidden" name="status" value="active"></div><div class="modal-footer"><button class="ws-btn">Save Workshop</button></div></form></div></div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<?php if($errors->any()): ?>
<script>document.addEventListener('DOMContentLoaded',()=>{const el=document.getElementById('addWorkshop');if(el){bootstrap.Modal.getOrCreateInstance(el).show();}});</script>
<?php endif; ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views\workshops\index.blade.php ENDPATH**/ ?>