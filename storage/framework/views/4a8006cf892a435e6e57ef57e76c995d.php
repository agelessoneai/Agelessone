<<<<<<< HEAD


<?php $__env->startSection('title', 'Stock In'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-head">
    <div>
        <h2>Stock In</h2>
        <p class="muted mb-0">Receive inventory and increase available stock.</p>
    </div>

    <a href="<?php echo e(route('admin.inventory-movements')); ?>" class="btn-back">
        ← Movement History
    </a>
</div>

<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card-dark movement-card">

    <form method="POST" action="<?php echo e(route('admin.inventory.stock-in.store')); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-grid">

            <div class="field full-width">
                <label class="form-label">Inventory Item *</label>

                <select name="inventory_item_id" id="inventoryItem" class="form-select" required>
                    <option value="">Select Item</option>

                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option
                            value="<?php echo e($item->id); ?>"
                            data-stock="<?php echo e($item->stock); ?>"
                            data-unit="<?php echo e($item->unit); ?>"
                            data-warehouse="<?php echo e($item->warehouse); ?>"
                            <?php echo e(old('inventory_item_id') == $item->id ? 'selected' : ''); ?>

                        >
                            <?php echo e($item->item_name); ?>

                            (<?php echo e($item->item_code); ?>)
                            — <?php echo e($item->category->name ?? 'No Category'); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="field">
                <label class="form-label">Current Stock</label>
                <input id="currentStock" class="form-control" value="-" readonly>
            </div>

            <div class="field">
                <label class="form-label">Quantity Received *</label>
                <input
                    type="number"
                    name="quantity"
                    class="form-control"
                    min="1"
                    value="<?php echo e(old('quantity', 1)); ?>"
                    required
                >
            </div>

            <div class="field">
                <label class="form-label">Reference Number</label>
                <input
                    type="text"
                    name="reference_no"
                    class="form-control"
                    value="<?php echo e(old('reference_no')); ?>"
                    placeholder="PO, GRN or invoice number"
                >
            </div>

            <div class="field">
                <label class="form-label">Warehouse</label>
                <input
                    type="text"
                    name="warehouse"
                    id="warehouse"
                    class="form-control"
                    value="<?php echo e(old('warehouse')); ?>"
                    placeholder="Main Warehouse"
                >
            </div>

            <div class="field full-width">
                <label class="form-label">Note</label>
                <textarea
                    name="note"
                    class="form-control"
                    rows="4"
                    placeholder="Supplier, received condition or other details"
                ><?php echo e(old('note')); ?></textarea>
            </div>

        </div>

        <div class="form-actions">
            <a href="<?php echo e(route('admin.inventory-items')); ?>" class="btn-back">
                Cancel
            </a>

            <button type="submit" class="btn-green">
                📥 Add Stock
            </button>
        </div>

    </form>

</div>

<?php echo $__env->make('admin.inventory_movements.partials.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('inventoryItem');
    const currentStock = document.getElementById('currentStock');
    const warehouse = document.getElementById('warehouse');

    function updateItemDetails() {
        const option = select.options[select.selectedIndex];

        if (!option || !option.value) {
            currentStock.value = '-';
            return;
        }

        currentStock.value =
            option.dataset.stock + ' ' + option.dataset.unit.toUpperCase();

        if (!warehouse.value) {
            warehouse.value = option.dataset.warehouse || '';
        }
    }

    select.addEventListener('change', updateItemDetails);
    updateItemDetails();
});
</script>

=======


<?php $__env->startSection('title', 'Stock In'); ?>

<?php $__env->startSection('content'); ?>

<div class="page-head">
    <div>
        <h2>Stock In</h2>
        <p class="muted mb-0">Receive inventory and increase available stock.</p>
    </div>

    <a href="<?php echo e(route('admin.inventory-movements')); ?>" class="btn-back">
        ← Movement History
    </a>
</div>

<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card-dark movement-card">

    <form method="POST" action="<?php echo e(route('admin.inventory.stock-in.store')); ?>">
        <?php echo csrf_field(); ?>

        <div class="form-grid">

            <div class="field full-width">
                <label class="form-label">Inventory Item *</label>

                <select name="inventory_item_id" id="inventoryItem" class="form-select" required>
                    <option value="">Select Item</option>

                    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option
                            value="<?php echo e($item->id); ?>"
                            data-stock="<?php echo e($item->stock); ?>"
                            data-unit="<?php echo e($item->unit); ?>"
                            data-warehouse="<?php echo e($item->warehouse); ?>"
                            <?php echo e(old('inventory_item_id') == $item->id ? 'selected' : ''); ?>

                        >
                            <?php echo e($item->item_name); ?>

                            (<?php echo e($item->item_code); ?>)
                            — <?php echo e($item->category->name ?? 'No Category'); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <div class="field">
                <label class="form-label">Current Stock</label>
                <input id="currentStock" class="form-control" value="-" readonly>
            </div>

            <div class="field">
                <label class="form-label">Quantity Received *</label>
                <input
                    type="number"
                    name="quantity"
                    class="form-control"
                    min="1"
                    value="<?php echo e(old('quantity', 1)); ?>"
                    required
                >
            </div>

            <div class="field">
                <label class="form-label">Reference Number</label>
                <input
                    type="text"
                    name="reference_no"
                    class="form-control"
                    value="<?php echo e(old('reference_no')); ?>"
                    placeholder="PO, GRN or invoice number"
                >
            </div>

            <div class="field">
                <label class="form-label">Warehouse</label>
                <input
                    type="text"
                    name="warehouse"
                    id="warehouse"
                    class="form-control"
                    value="<?php echo e(old('warehouse')); ?>"
                    placeholder="Main Warehouse"
                >
            </div>

            <div class="field full-width">
                <label class="form-label">Note</label>
                <textarea
                    name="note"
                    class="form-control"
                    rows="4"
                    placeholder="Supplier, received condition or other details"
                ><?php echo e(old('note')); ?></textarea>
            </div>

        </div>

        <div class="form-actions">
            <a href="<?php echo e(route('admin.inventory-items')); ?>" class="btn-back">
                Cancel
            </a>

            <button type="submit" class="btn-green">
                📥 Add Stock
            </button>
        </div>

    </form>

</div>

<?php echo $__env->make('admin.inventory_movements.partials.styles', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('inventoryItem');
    const currentStock = document.getElementById('currentStock');
    const warehouse = document.getElementById('warehouse');

    function updateItemDetails() {
        const option = select.options[select.selectedIndex];

        if (!option || !option.value) {
            currentStock.value = '-';
            return;
        }

        currentStock.value =
            option.dataset.stock + ' ' + option.dataset.unit.toUpperCase();

        if (!warehouse.value) {
            warehouse.value = option.dataset.warehouse || '';
        }
    }

    select.addEventListener('change', updateItemDetails);
    updateItemDetails();
});
</script>

>>>>>>> 353115acd2f12e033eed9c0c3cba0304f0b467b5
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views\admin\inventory_movements\stock_in.blade.php ENDPATH**/ ?>