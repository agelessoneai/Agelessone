<?php $__env->startSection('content'); ?>
<style>
body{background:#0e1320}.navbar{display:none!important}.security-app{max-width:480px;margin:auto;min-height:100vh;padding:18px 16px 90px;color:#edf2ff;background:linear-gradient(180deg,#11182a,#0e1320)}
.app-head,.row-between{display:flex;justify-content:space-between;align-items:center;gap:12px}.app-head{margin-bottom:16px}.app-head h2{margin:0;font-size:21px}.muted{color:#93a0b8;font-size:12px}.panel{background:#171f31;border:1px solid #28334b;border-radius:22px;padding:17px;margin-bottom:15px}.site-banner{background:linear-gradient(135deg,#4169e1,#8758e8)}.site-banner h3{margin:4px 0}.stats{display:grid;grid-template-columns:repeat(3,1fr);gap:9px}.stat{background:#202a40;border-radius:15px;padding:12px;text-align:center}.stat b{display:block;font-size:20px}.btn-app{width:100%;border:0;border-radius:14px;padding:14px;font-weight:700;color:white}.btn-in{background:#20ad72}.btn-out{background:#e54f62}.btn-primary{background:#4169e1}.camera{display:block;width:100%;border:1px dashed #66738f;border-radius:12px;padding:11px;background:#101725;color:#dce5f7;margin:10px 0}.form-control{background:#101725!important;border-color:#36415a!important;color:white!important}.worker{border-top:1px solid #28334b;padding:15px 0}.worker:first-of-type{border-top:0}.badge-app{padding:5px 9px;border-radius:999px;font-size:11px}.pending{background:#594b21;color:#ffd971}.inside{background:#174c39;color:#79e6b9}.done{background:#1f3f70;color:#a9c8ff}.photo{width:46px;height:46px;object-fit:cover;border-radius:12px}.tabs{position:fixed;bottom:10px;left:50%;transform:translateX(-50%);width:min(448px,calc(100% - 24px));background:#171f31;border:1px solid #28334b;border-radius:20px;padding:11px;display:flex;justify-content:space-around}.tabs a{color:#dbe5f7;text-decoration:none;font-size:12px}
</style>
<div class="security-app">
 <div class="app-head"><div><div class="muted">SECURITY PORTAL</div><h2><?php echo e(auth()->user()->display_name); ?></h2></div><form method="POST" action="<?php echo e(route('logout')); ?>"><?php echo csrf_field(); ?><button class="btn btn-sm btn-outline-light">Logout</button></form></div>
 <?php if(session('success')): ?><div class="alert alert-success"><?php echo e(session('success')); ?></div><?php endif; ?>
 <?php if($errors->any()): ?><div class="alert alert-danger"><?php echo e($errors->first()); ?></div><?php endif; ?>
 <div class="panel site-banner"><div class="muted" style="color:#e8e8ff">ASSIGNED SITE</div><h3><?php echo e($site->site_name); ?></h3><div><?php echo e($site->location ?: 'Location not added'); ?></div></div>
 <div class="panel"><div class="row-between"><h5 class="m-0">My Attendance</h5><span class="badge-app <?php echo e(!$attendance?'pending':(!$attendance->punch_out?'inside':'done')); ?>"><?php echo e(!$attendance?'Not punched':(!$attendance->punch_out?'Inside':'Completed')); ?></span></div>
 <?php if(!$attendance): ?>
 <form method="POST" action="<?php echo e(route('attendance.punchin')); ?>" enctype="multipart/form-data"><?php echo csrf_field(); ?><input type="hidden" name="location" value="<?php echo e($site->site_name); ?>"><input class="camera mobile-photo" type="file" name="photo" accept="image/*,.heic,.heif" capture="user" required><button class="btn-app btn-in">📷 Photo + Punch In</button></form>
 <?php elseif(!$attendance->punch_out): ?>
 <p class="muted mt-3">Punched in <?php echo e($attendance->punch_in->format('h:i A')); ?></p><form method="POST" action="<?php echo e(route('attendance.punchout')); ?>" enctype="multipart/form-data"><?php echo csrf_field(); ?><input type="hidden" name="location" value="<?php echo e($site->site_name); ?>"><input class="camera mobile-photo" type="file" name="photo" accept="image/*,.heic,.heif" capture="user" required><button class="btn-app btn-out">📷 Photo + Punch Out</button></form>
 <?php else: ?> <div class="mt-3"><?php echo e($attendance->punch_in->format('h:i A')); ?> — <?php echo e($attendance->punch_out->format('h:i A')); ?></div><?php endif; ?>
 </div>
 <div class="stats mb-3"><div class="stat"><b><?php echo e($workers->count()); ?></b><span class="muted">Workers</span></div><div class="stat"><b><?php echo e($workerAttendances->whereNull('punch_out')->count()); ?></b><span class="muted">Inside</span></div><div class="stat"><b><?php echo e($visitors->whereNull('check_out_at')->count()); ?></b><span class="muted">Visitors</span></div></div>
 <div class="panel" id="visitors"><h5>Visitor Check-in</h5><p class="muted">Photo, name and phone number only.</p><form method="POST" action="<?php echo e(route('security.visitors.store')); ?>" enctype="multipart/form-data"><?php echo csrf_field(); ?><div class="row g-2"><div class="col-12"><input class="form-control" name="name" placeholder="Visitor name" required></div><div class="col-12"><input class="form-control" name="mobile" inputmode="tel" placeholder="Phone number" required></div></div><input class="camera" type="file" name="photo" accept="image/*" capture="environment" required><button class="btn-app btn-primary">📷 Save Visitor</button></form>
 <div class="mt-3"><?php $__empty_1 = true; $__currentLoopData = $visitors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visitor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><div class="worker"><div class="row-between"><div class="d-flex align-items-center gap-2"><img class="photo" src="<?php echo e(asset('storage/'.$visitor->photo)); ?>"><div><strong><?php echo e($visitor->name); ?></strong><div class="muted"><?php echo e($visitor->mobile); ?> · <?php echo e($visitor->check_in_at?->format('h:i A')); ?></div></div></div><?php if(!$visitor->check_out_at): ?><form method="POST" action="<?php echo e(route('security.visitors.checkout',$visitor)); ?>"><?php echo csrf_field(); ?><button class="btn btn-sm btn-outline-light">Check Out</button></form><?php else: ?><span class="badge-app done">Out</span><?php endif; ?></div></div><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="muted mb-0">No visitors today.</p><?php endif; ?></div></div>
 <div class="panel" id="add-worker"><div class="row-between"><h5 class="m-0">Add Worker</h5><span class="muted"><?php echo e($site->site_name); ?></span></div><p class="muted mt-2">Name and photo only. Worker code is created automatically.</p><form method="POST" action="<?php echo e(route('security.workers.store')); ?>" enctype="multipart/form-data"><?php echo csrf_field(); ?><input class="form-control" name="name" value="<?php echo e(old('name')); ?>" placeholder="Worker name" required><input class="camera" type="file" name="photo" accept="image/*" capture="environment" required><button class="btn-app btn-primary">📷 Add Worker</button></form></div>
 <div class="panel" id="workers"><div class="row-between"><h5 class="m-0">Worker Attendance</h5><span class="muted">Supervisor approval required</span></div>
 <?php $__empty_1 = true; $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?> <?php ($record=$workerAttendances->get($worker->id)); ?>
 <div class="worker"><div class="row-between"><div class="d-flex align-items-center gap-2"><?php if($worker->photo): ?><img class="photo" src="<?php echo e(asset('storage/'.$worker->photo)); ?>"><?php endif; ?><div><strong><?php echo e($worker->name); ?></strong><div class="muted"><?php echo e($worker->worker_code); ?></div></div></div><span class="badge-app <?php echo e(!$record?'pending':(!$record->punch_out?'inside':'done')); ?>"><?php echo e(!$record?'Not marked':(!$record->punch_out?'Inside':ucfirst($record->status))); ?></span></div>
 <?php if(!$record): ?><form method="POST" action="<?php echo e(route('security.workers.punch-in',$worker)); ?>"><?php echo csrf_field(); ?><button class="btn-app btn-in mt-2">Punch In</button></form>
 <?php elseif(!$record->punch_out): ?><form method="POST" action="<?php echo e(route('security.workers.punch-out',$worker)); ?>"><?php echo csrf_field(); ?><button class="btn-app btn-out mt-2">Punch Out</button></form>
 <?php else: ?><div class="muted mt-2"><?php echo e($record->punch_in); ?> — <?php echo e($record->punch_out); ?> · <?php echo e(number_format(($record->working_minutes ?? 0)/60,2)); ?> hrs · <?php echo e($record->work_description); ?> · <?php echo e(ucfirst($record->status)); ?></div><?php endif; ?></div>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><p class="muted mt-3">No active workers assigned.</p><?php endif; ?></div>
 <div class="panel"><div class="row-between"><div><h5 class="m-0">Site Inventory</h5><div class="muted mt-1">Add tools and mark who is using them.</div></div><a class="btn btn-sm btn-primary" href="<?php echo e(route('security.inventory')); ?>">Open Inventory</a></div></div>
 <div class="tabs"><a href="<?php echo e(route('security.dashboard')); ?>">Home</a><a href="<?php echo e(route('security.inventory')); ?>">Inventory</a><a href="#workers">Punch</a><a href="<?php echo e(route('security.history')); ?>">History</a></div>
</div>
<script>
(function () {
    const MAX_WIDTH = 1600;
    const QUALITY = 0.82;

    document.querySelectorAll('.mobile-photo').forEach(function (input) {
        input.addEventListener('change', async function () {
            const file = input.files && input.files[0];
            if (!file || !file.type.startsWith('image/')) return;

            try {
                const bitmap = await createImageBitmap(file);
                const scale = Math.min(1, MAX_WIDTH / bitmap.width);
                const canvas = document.createElement('canvas');
                canvas.width = Math.max(1, Math.round(bitmap.width * scale));
                canvas.height = Math.max(1, Math.round(bitmap.height * scale));
                canvas.getContext('2d').drawImage(bitmap, 0, 0, canvas.width, canvas.height);

                const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', QUALITY));
                if (!blob) return;

                const converted = new File([blob], 'attendance-' + Date.now() + '.jpg', {type: 'image/jpeg'});
                const transfer = new DataTransfer();
                transfer.items.add(converted);
                input.files = transfer.files;
            } catch (error) {
                // Keep the original camera file; the server also accepts HEIC/HEIF.
            }
        });
    });
})();
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views\security\dashboard.blade.php ENDPATH**/ ?>