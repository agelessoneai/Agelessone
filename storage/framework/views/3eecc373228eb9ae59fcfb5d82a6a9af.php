
<?php $__env->startSection('content'); ?>

<style>
body{background:#0e1320;color:#e8edf6}
.navbar,header{display:none!important}
.container{max-width:100%!important;margin:0!important;padding:30px!important}
.card-dark{background:#151b29;border:1px solid #262f47;border-radius:18px;padding:25px}
.form-control,.form-select{
    background:#0e1320;
    border:1px solid #262f47;
    color:#fff;
    border-radius:12px;
    padding:12px;
}
.form-control:focus,.form-select:focus{
    background:#0e1320;
    color:#fff;
    border-color:#3f6fe0;
    box-shadow:none;
}
label{margin-bottom:7px;color:#8794ac}
.btn-blue{background:#3f6fe0;color:#fff;border:0;border-radius:12px;padding:12px 18px}
.btn-back{border:1px solid #334155;color:#cbd5e1;border-radius:12px;padding:12px 18px;text-decoration:none}
</style>

<div class="card-dark">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3>Create Complaint Ticket</h3>
            <p class="text-secondary mb-0">Assign park complaint to staff</p>
        </div>

        <a href="<?php echo e(route('admin.tickets')); ?>" class="btn-back">Back</a>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert alert-danger mb-4">
            <ul class="mb-0">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('admin.tickets.store')); ?>">
        <?php echo csrf_field(); ?>

        <div class="mb-3">
            <label>Park Name</label>
            <select name="park_id" class="form-select" required>
                <option value="">Select Park</option>
                <?php $__currentLoopData = $parks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $park): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($park->id); ?>" <?php if(old('park_id') == $park->id): echo 'selected'; endif; ?>><?php echo e($park->name); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Assign Staff</label>
            <select name="assigned_to" class="form-select" required>
                <option value="">Select Staff</option>
                <?php $__empty_1 = true; $__currentLoopData = $staff; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <option value="<?php echo e($person->id); ?>" <?php if(old('assigned_to') == $person->id): echo 'selected'; endif; ?>>
                        <?php echo e($person->name); ?> - <?php echo e($person->email); ?> (<?php echo e(\App\Models\User::roles()[$person->role] ?? ucfirst(str_replace('_', ' ', $person->role))); ?>)
                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <option value="" disabled>No active staff found</option>
                <?php endif; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Item / Ride Name</label>
            <input type="text" name="item_name" class="form-control" value="<?php echo e(old('item_name')); ?>" placeholder="Example: 12D Theater, Toy Car, Train" required>
        </div>

        <div class="mb-3">
            <label>Complaint Title</label>
            <input type="text" name="complaint_title" class="form-control" value="<?php echo e(old('complaint_title')); ?>" placeholder="Example: Motion seat not working" required>
        </div>

        <div class="mb-3">
            <label>Complaint Details</label>
            <textarea name="complaint_description" class="form-control" rows="4" placeholder="Describe the complaint"><?php echo e(old('complaint_description')); ?></textarea>
        </div>

        <div class="mb-4">
            <label>Priority</label>
            <select name="priority" class="form-select" required>
                <option value="low" <?php if(old('priority') === 'low'): echo 'selected'; endif; ?>>Low</option>
                <option value="normal" <?php if(old('priority', 'normal') === 'normal'): echo 'selected'; endif; ?>>Normal</option>
                <option value="high" <?php if(old('priority') === 'high'): echo 'selected'; endif; ?>>High</option>
                <option value="urgent" <?php if(old('priority') === 'urgent'): echo 'selected'; endif; ?>>Urgent</option>
            </select>
        </div>

        <button class="btn-blue" type="submit">
            Assign Ticket
        </button>

    </form>

</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views\admin\tickets\create.blade.php ENDPATH**/ ?>