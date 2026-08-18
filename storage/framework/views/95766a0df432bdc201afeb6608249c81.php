<?php $__env->startSection('page-title', 'Machine Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="card">
    <div class="card-body p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="mb-1 text-white">Registered Machines</h4>
                <p class="text-muted mb-0">Manage machines, view components, warranty status, and access generated QR codes.</p>
            </div>
            <a href="<?php echo e(route('admin.machines.create')); ?>" class="btn btn-primary d-flex align-items-center gap-2">
                <span>➕</span> Register Machine
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-dark table-striped align-middle">
                <thead>
                    <tr>
                        <th scope="col">Machine Name</th>
                        <th scope="col">Components</th>
                        <th scope="col">Purchase Date</th>
                        <th scope="col">Warranty</th>
                        <th scope="col">Warranty Ending</th>
                        <th scope="col" class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $machines; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $machine): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td><strong><?php echo e($machine->name); ?></strong></td>
                            <td>
                                <span class="text-muted"><?php echo e(Str::limit($machine->components ?? 'N/A', 40)); ?></span>
                            </td>
                            <td><?php echo e($machine->purchase_date ? $machine->purchase_date->format('Y-m-d') : 'N/A'); ?></td>
                            <td><?php echo e($machine->warranty ?? 'N/A'); ?></td>
                            <td>
                                <?php if($machine->warranty_ending_date): ?>
                                    <?php if($machine->warranty_ending_date->isPast()): ?>
                                        <span class="badge bg-danger">Expired (<?php echo e($machine->warranty_ending_date->format('Y-m-d')); ?>)</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Active (<?php echo e($machine->warranty_ending_date->format('Y-m-d')); ?>)</span>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
                            <td class="text-end">
                                <a href="<?php echo e(route('admin.machines.qr', $machine->id)); ?>" class="btn btn-sm btn-outline-info">
                                    🖨️ QR Code
                                </a>
                                <a href="<?php echo e(route('machines.show', $machine->id)); ?>" class="btn btn-sm btn-outline-light ms-1" target="_blank">
                                    👁️ View
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                No machines registered yet. Click "Register Machine" to add one.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <?php echo e($machines->links()); ?>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views/admin/machines/index.blade.php ENDPATH**/ ?>