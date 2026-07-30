<?php $__env->startSection('content'); ?>
<style>
body{background:#0e1320}.navbar{display:none!important}.security-app{max-width:520px;margin:auto;min-height:100vh;padding:18px 16px 90px;color:#edf2ff;background:linear-gradient(180deg,#11182a,#0e1320)}
.row-between{display:flex;justify-content:space-between;align-items:center;gap:12px}.muted{color:#93a0b8;font-size:12px}.panel{background:#171f31;border:1px solid #28334b;border-radius:20px;padding:16px;margin-bottom:14px}.form-control,.form-select{background:#101725!important;border-color:#36415a!important;color:white!important}.form-select option{color:#111}.btn-app{width:100%;border:0;border-radius:13px;padding:12px;font-weight:700;color:white;background:#4169e1}.inventory-cards{display:grid;grid-template-columns:1fr;gap:10px;margin-top:14px}.item{background:#111827;border:1px solid #2a3650;border-radius:16px;padding:12px}.item summary{list-style:none;cursor:pointer}.item summary::-webkit-details-marker{display:none}.item-icon{width:42px;height:42px;border-radius:12px;background:#253454;display:grid;place-items:center;font-size:20px;flex:0 0 42px}.item-head{display:flex;align-items:center;gap:10px}.item-main{min-width:0;flex:1}.item-chevron{font-size:18px;transition:.2s}.item details[open] .item-chevron{transform:rotate(180deg)}.item-body{padding-top:12px;margin-top:12px;border-top:1px solid #28334b}.badge-app{padding:5px 9px;border-radius:999px;font-size:11px}.available{background:#174c39;color:#79e6b9}.inuse{background:#594b21;color:#ffd971}.tabs{position:fixed;bottom:10px;left:50%;transform:translateX(-50%);width:min(488px,calc(100% - 24px));background:#171f31;border:1px solid #28334b;border-radius:20px;padding:11px;display:flex;justify-content:space-around}.tabs a{color:#dbe5f7;text-decoration:none;font-size:12px}@media(max-width:520px){.security-app{padding-left:10px;padding-right:10px}.panel{padding:12px;border-radius:16px}.inventory-cards{grid-template-columns:repeat(2,minmax(0,1fr));gap:9px}.item{padding:10px}.item-head{display:block}.item-icon{margin-bottom:8px}.item-main strong{font-size:13px;line-height:1.2;display:block}.item-main .muted{font-size:10px}.badge-app{display:inline-block;margin-top:7px;padding:4px 7px}.item-chevron{position:absolute;right:10px;top:8px}.item details{position:relative}.item-body{font-size:12px}.item-body .form-control,.item-body .form-select,.item-body .btn{font-size:12px}.item-body textarea{min-height:58px}}
</style>
<div class="security-app">
 <div class="row-between mb-3"><div><div class="muted">SITE INVENTORY</div><h3 class="m-0"><?php echo e($site->site_name); ?></h3></div><a href="<?php echo e(auth()->user()->role === 'admin' ? route('admin.dashboard') : route('security.dashboard')); ?>" class="btn btn-sm btn-outline-light">Back</a></div>
 <?php if(auth()->user()->role === 'admin'): ?>
 <div class="panel"><form method="GET" action="<?php echo e(route('security.inventory')); ?>"><label class="muted mb-1">Select Work Site</label><div class="d-flex gap-2"><select name="site_id" class="form-select" onchange="this.form.submit()"><?php $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $workSite): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($workSite->id); ?>" <?php if($workSite->id === $site->id): echo 'selected'; endif; ?>><?php echo e($workSite->site_name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div></form></div>
 <?php endif; ?>
 <?php if(session('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?>
 <?php if($errors->any()): ?><div class="alert alert-danger"><?php echo e($errors->first()); ?></div><?php endif; ?>

 <div class="panel" id="add-item">
  <h5>Add Item to Inventory</h5>
  <p class="muted">Choose an existing item or enter a new item name.</p>
  <form method="POST" action="<?php echo e(route('security.inventory.store')); ?>"><?php echo csrf_field(); ?>
   <input type="hidden" name="site_id" value="<?php echo e($site->id); ?>">
   <label class="muted mb-1">Existing item (optional)</label>
   <select class="form-select mb-2" name="inventory_item_id">
    <option value="">-- Add as new item --</option>
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($item->id); ?>"><?php echo e($item->item_name); ?> (<?php echo e($item->item_code); ?>)</option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </select>
   <input class="form-control mb-2" name="item_name" value="<?php echo e(old('item_name')); ?>" placeholder="New item name">
   <input class="form-control mb-2" name="item_code" value="<?php echo e(old('item_code')); ?>" placeholder="Item code (optional)">
   <div class="row g-2 mb-2"><div class="col-4"><input class="form-control" type="number" min="1" name="quantity" value="<?php echo e(old('quantity',1)); ?>" required></div><div class="col-8"><input class="form-control" name="used_for" value="<?php echo e(old('used_for')); ?>" placeholder="Used for / purpose"></div></div>
   <textarea class="form-control mb-2" name="note" rows="2" placeholder="Condition or note"></textarea>
   <button class="btn-app">+ Add to Site Inventory</button>
  </form>
 </div>

 <div class="panel" id="items">
  <div class="row-between"><h5 class="m-0">Inventory Items</h5><span class="muted"><?php echo e($movements->count()); ?> records</span></div>
  <div class="inventory-cards">
  <?php $__empty_1 = true; $__currentLoopData = $movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
   <div class="item">
    <details>
     <summary>
      <div class="item-head">
       <div class="item-icon">🧰</div>
       <div class="item-main"><strong class="text-truncate"><?php echo e($movement->item->item_name ?? '-'); ?></strong><div class="muted text-truncate"><?php echo e($movement->item->item_code ?? ''); ?> · Qty <?php echo e($movement->quantity); ?></div><span class="badge-app <?php echo e(($movement->assignment_status === 'using' || $movement->issued_to) ? 'inuse':'available'); ?>"><?php echo e(($movement->assignment_status === 'using' || $movement->issued_to) ? 'Using' : ($movement->assignment_status === 'returned' ? 'Returned' : 'Available')); ?></span></div>
       <span class="item-chevron">⌄</span>
      </div>
     </summary>
     <div class="item-body">
      <div class="muted">Purpose: <?php echo e($movement->used_for ?: '-'); ?></div>
      <?php if($movement->assignment_status === 'using' || $movement->issued_to): ?>
        <div class="mt-2"><strong>Using:</strong> <?php echo e($movement->issued_to); ?></div>
        <form method="POST" action="<?php echo e(route('security.inventory.return',$movement)); ?>" class="mt-2"><?php echo csrf_field(); ?><input type="hidden" name="site_id" value="<?php echo e($site->id); ?>">
         <select class="form-select mb-2" name="return_condition"><option value="good">Good condition</option><option value="damaged">Damaged</option><option value="repair">Needs repair</option></select>
         <textarea class="form-control mb-2" name="return_note" rows="2" placeholder="Return note (optional)"></textarea>
         <button class="btn btn-sm btn-outline-success w-100">Mark Returned</button></form>
      <?php else: ?>
        <?php if($movement->assignment_status === 'returned'): ?><div class="mt-2"><strong>Returned:</strong> <?php echo e(optional($movement->returned_at)->format('d M Y h:i A') ?: '-'); ?><br><span class="muted">By <?php echo e($movement->returnedBy->name ?? '-'); ?> · <?php echo e(ucfirst($movement->return_condition ?: 'good')); ?></span></div><?php endif; ?>
        <form method="POST" action="<?php echo e(route('security.inventory.assign',$movement)); ?>" class="mt-3"><?php echo csrf_field(); ?><input type="hidden" name="site_id" value="<?php echo e($site->id); ?>">
         <select class="form-select mb-2" name="worker_id"><option value="">-- Select worker --</option><?php $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($worker->id); ?>"><?php echo e($worker->name); ?> (<?php echo e($worker->worker_code); ?>)</option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select>
         <input class="form-control mb-2" name="assigned_to" placeholder="Or enter other person's name">
         <input class="form-control mb-2" name="used_for" value="<?php echo e($movement->used_for); ?>" placeholder="What are they using it for?">
         <button class="btn btn-sm btn-warning w-100">Assign / Mark User</button>
        </form>
      <?php endif; ?>
     </div>
    </details>
   </div>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?> <p class="muted mt-3 mb-0" style="grid-column:1/-1">No items added to this site inventory.</p><?php endif; ?>
  </div>
 </div>
 <div class="tabs"><a href="<?php echo e(auth()->user()->role === 'admin' ? route('admin.dashboard') : route('security.dashboard')); ?>">Home</a><a href="#add-item">Add Item</a><a href="#items">Inventory</a><a href="<?php echo e(route('security.history')); ?>">History</a></div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views\security\inventory.blade.php ENDPATH**/ ?>