

<?php $__env->startSection('title', 'Inventory Item Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="page-head">
    <div>
        <h2><?php echo e($inventoryItem->item_name); ?></h2>
        <p class="muted mb-0"><?php echo e($inventoryItem->item_code); ?> · <?php echo e($inventoryItem->category?->name ?? 'Uncategorised'); ?></p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="<?php echo e(route('admin.inventory-items.edit', $inventoryItem)); ?>" class="btn-blue">Edit Item</a>
        <a href="<?php echo e(route('admin.inventory-items')); ?>" class="btn-back">← Back</a>
    </div>
</div>

<div class="card-dark" style="margin-bottom:20px">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:18px">
        <div><span class="muted">Current Stock</span><h3><?php echo e($inventoryItem->stock); ?> <?php echo e($inventoryItem->unit); ?></h3></div>
        <div><span class="muted">Warehouse / Rack</span><h3><?php echo e($inventoryItem->warehouse); ?><?php echo e($inventoryItem->rack ? ' / '.$inventoryItem->rack : ''); ?></h3></div>
        <div><span class="muted">Brand / Model</span><h3><?php echo e($inventoryItem->brand ?: '-'); ?> <?php echo e($inventoryItem->model); ?></h3></div>
        <div><span class="muted">Supplier</span><h3><?php echo e($inventoryItem->supplier ?: 'Not specified'); ?></h3></div>
    </div>

    <hr style="opacity:.15;margin:22px 0">
    <h4>What this item is used for</h4>
    <p style="white-space:pre-line"><?php echo e($inventoryItem->usage_purpose ?: 'Usage purpose has not been entered.'); ?></p>

    <?php if($inventoryItem->description): ?>
        <h4>Description</h4>
        <p style="white-space:pre-line"><?php echo e($inventoryItem->description); ?></p>
    <?php endif; ?>
</div>

<div class="card-dark" style="overflow:auto">
    <h3>Movement & Site Usage History</h3>
    <table class="table" style="min-width:900px">
        <thead><tr><th>Date</th><th>Movement</th><th>Qty</th><th>Stock</th><th>Site</th><th>Used For</th><th>Issued To</th></tr></thead>
        <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $inventoryItem->movements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $movement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr>
                <td><?php echo e($movement->created_at?->format('d M Y, h:i A')); ?></td>
                <td><?php echo e(ucwords(str_replace('_',' ', $movement->type))); ?></td>
                <td><?php echo e($movement->quantity); ?> <?php echo e($inventoryItem->unit); ?></td>
                <td><?php echo e($movement->previous_stock); ?> → <?php echo e($movement->new_stock); ?></td>
                <td><?php echo e($movement->workSite?->site_name ?? 'Warehouse / General'); ?></td>
                <td><?php echo e($movement->used_for ?: '-'); ?></td>
                <td><?php echo e($movement->issued_to ?: '-'); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr><td colspan="7" class="text-center muted">No movement history available.</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views\admin\inventory_items\show.blade.php ENDPATH**/ ?>