<?php $__env->startSection('title', $machine->name . ' - Machine Details'); ?>

<?php $__env->startSection('content'); ?>
<div class="container py-3">
    <!-- Machine Card -->
    <div class="card bg-dark border-secondary mb-4 shadow-lg">
        <div class="card-header bg-gradient py-3" style="background: linear-gradient(135deg, #1f2a44, #121824); border-bottom: 1px solid #2d3c5c;">
            <div class="d-flex align-items-center justify-content-between">
                <span class="text-info font-monospace uppercase small">Equipment Tag</span>
                <?php if($machine->warranty_ending_date): ?>
                    <?php if($machine->warranty_ending_date->isPast()): ?>
                        <span class="badge bg-danger px-3 py-2">Warranty Expired</span>
                    <?php else: ?>
                        <span class="badge bg-success px-3 py-2">Under Warranty</span>
                    <?php endif; ?>
                <?php else: ?>
                    <span class="badge bg-secondary px-3 py-2">No Warranty Info</span>
                <?php endif; ?>
            </div>
            <h2 class="mt-2 text-white h4 mb-0"><?php echo e($machine->name); ?></h2>
        </div>
        <div class="card-body p-4">
            
            <!-- Quick Stats -->
            <div class="row g-3 mb-4">
                <div class="col-6">
                    <div class="p-3 rounded bg-black bg-opacity-20 border border-secondary text-center">
                        <small class="text-muted d-block uppercase mb-1">Purchase Date</small>
                        <strong class="text-light"><?php echo e($machine->purchase_date ? $machine->purchase_date->format('M d, Y') : 'N/A'); ?></strong>
                    </div>
                </div>
                <div class="col-6">
                    <div class="p-3 rounded bg-black bg-opacity-20 border border-secondary text-center">
                        <small class="text-muted d-block uppercase mb-1">Warranty Term</small>
                        <strong class="text-light"><?php echo e($machine->warranty ?? 'N/A'); ?></strong>
                    </div>
                </div>
            </div>

            <!-- Detailed Fields -->
            <div class="mb-4">
                <h5 class="text-info border-bottom border-secondary pb-2 mb-3">Warranty Information</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Warranty Expiry:</span>
                    <strong class="text-white">
                        <?php echo e($machine->warranty_ending_date ? $machine->warranty_ending_date->format('F d, Y') : 'N/A'); ?>

                    </strong>
                </div>
                <?php if($machine->warranty_ending_date && !$machine->warranty_ending_date->isPast()): ?>
                    <div class="text-muted small">
                        ⏳ Days remaining: <?php echo e(now()->diffInDays($machine->warranty_ending_date, false)); ?> days
                    </div>
                <?php endif; ?>
            </div>

            <!-- Components -->
            <div class="mb-2">
                <h5 class="text-info border-bottom border-secondary pb-2 mb-3">System Components</h5>
                <?php if($machine->components): ?>
                    <div class="p-3 rounded bg-black bg-opacity-25 border border-secondary text-light">
                        <?php echo nl2br(e($machine->components)); ?>

                    </div>
                <?php else: ?>
                    <p class="text-muted italic">No sub-components or assemblies listed for this machine.</p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card-footer bg-transparent border-secondary text-center py-3">
            <small class="text-muted">Ageless One Equipment Identification Protocol</small>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views/machines/show.blade.php ENDPATH**/ ?>