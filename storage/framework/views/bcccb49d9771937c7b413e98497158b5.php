<?php $__env->startSection('title','Bulk Add Workers'); ?>
<?php $__env->startSection('page-title','Bulk Add Workers'); ?>
<?php $__env->startSection('content'); ?>
<div class="page-head">
    <div>
        <a href="<?php echo e(route('admin.work-sites.workers.index',$workSite)); ?>" class="back-link">← <?php echo e($workSite->site_name); ?></a>
        <h2>Add Multiple Workers</h2>
        <p>Add any number of workers. Start with 10 rows and add more when needed.</p>
    </div>
</div>
<?php if($errors->any()): ?><div class="alert alert-danger"><ul class="mb-0"><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div><?php endif; ?>
<form method="POST" action="<?php echo e(route('admin.work-sites.workers.bulk-store',$workSite)); ?>"><?php echo csrf_field(); ?>
<div class="a1-panel p-3">
    <div class="table-responsive">
        <table class="table align-middle" id="workersTable">
            <thead><tr><th style="min-width:140px">Code</th><th style="min-width:180px">Name</th><th style="min-width:150px">Mobile</th><th style="min-width:160px">Work / Trade</th><th style="min-width:140px">Role</th><th></th></tr></thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="d-flex gap-2 flex-wrap mt-3">
        <button type="button" class="btn btn-outline-light" id="addRow">+ Add Row</button>
        <button type="button" class="btn btn-outline-light" id="addTen">+ Add 10 Rows</button>
        <button class="btn btn-primary">Save All Workers</button>
    </div>
</div>
</form>
<template id="rowTemplate"><tr><td><input class="form-control" name="workers[INDEX][worker_code]" required></td><td><input class="form-control" name="workers[INDEX][name]" required></td><td><input class="form-control" name="workers[INDEX][mobile]"></td><td><input class="form-control" name="workers[INDEX][trade]" required placeholder="Electrician / Helper"></td><td><select class="form-select" name="workers[INDEX][role]" required><?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>"><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></td><td><button type="button" class="btn btn-sm btn-outline-danger remove-row">×</button></td></tr></template>
<script>
(()=>{
    let i=0;
    const body=document.querySelector('#workersTable tbody');
    const tpl=document.querySelector('#rowTemplate').innerHTML;
    function add(count=1){for(let n=0;n<count;n++){body.insertAdjacentHTML('beforeend',tpl.replaceAll('INDEX',i++));}}
    document.querySelector('#addRow').onclick=()=>add(1);
    document.querySelector('#addTen').onclick=()=>add(10);
    body.addEventListener('click',e=>{if(e.target.classList.contains('remove-row')&&body.children.length>1)e.target.closest('tr').remove();});
    add(10);
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views\admin\workers\bulk-create.blade.php ENDPATH**/ ?>