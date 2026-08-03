<?php $__env->startSection('content'); ?>
<style>
:root{
    --bg:#0e1320;
    --card:#151b29;
    --card2:#1c2436;
    --line:#262f47;
    --text:#e8edf6;
    --muted:#8794ac;
    --blue:#3f6fe0;
    --purple:#9b6bff;
    --green:#37c281;
    --red:#ff5a6e;
    --orange:#f2b53b;
}

body{margin:0;background:var(--bg);color:var(--text);font-family:'Segoe UI',system-ui,sans-serif}
.navbar,header{display:none!important}
.mobile-app-shell { max-width: 100% !important; margin: 0 !important; border-radius: 0 !important; border: 0 !important; min-height: 100vh !important; }
.app-content { padding: 0 !important; }
.container{max-width:100%!important;padding:0!important;margin:0!important}

.full-wrapper {
    min-height: 100vh;
    padding: 18px;
    padding-bottom: 92px;
    background: var(--bg);
}

.left-panel {
    background: radial-gradient(circle at top right,rgba(91,140,255,.25),transparent 30%),radial-gradient(circle at bottom left,rgba(155,107,255,.22),transparent 30%),var(--bg);
    border-radius: 24px;
    padding: 18px;
}

.right-panel {
    margin-top: 24px;
}

.desktop-title { display: none; }

.app-head, .row-between { display: flex; justify-content: space-between; align-items: center; gap: 12px; }
.app-head { margin-bottom: 22px; }
.profile { display: flex; align-items: center; gap: 12px; }
.avatar { width: 48px; height: 48px; border-radius: 16px; background: linear-gradient(135deg,var(--blue),var(--purple)); display: grid; place-items: center; font-weight: 800; font-size: 18px; }
.profile h3 { font-size: 18px; margin: 0; }
.profile p { margin: 2px 0 0; color: var(--muted); font-size: 12px; }

.logout { background: var(--card); border: 1px solid var(--line); color: var(--text); border-radius: 14px; padding: 10px 14px; font-size: 13px; transition: .2s; cursor: pointer; }
.logout:hover { background: var(--card2); }

.panel { background: var(--card); border: 1px solid var(--line); border-radius: 22px; padding: 20px; margin-bottom: 18px; }
.site-banner { background: linear-gradient(135deg, var(--blue), var(--purple)); border: none; }
.site-banner h3 { margin: 4px 0; color: #fff; font-size: 20px; }
.site-banner .muted { color: rgba(255,255,255,0.8); font-size: 12px; }

.muted { color: var(--muted); font-size: 12px; }

.stats { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 18px; }
.stat { background: var(--card); border: 1px solid var(--line); border-radius: 18px; padding: 16px; text-align: center; }
.stat b { display: block; font-size: 22px; color: #fff; }

.btn-app { width: 100%; border: 0; border-radius: 16px; padding: 15px; font-size: 15px; font-weight: 800; color: white; cursor: pointer; transition: .2s; }
.btn-in { background: linear-gradient(135deg, var(--green), #22c55e); }
.btn-out { background: linear-gradient(135deg, var(--red), #ef4444); }
.btn-primary { background: linear-gradient(135deg, var(--blue), var(--purple)); }

.camera { display: block; width: 100%; border: 1px dashed var(--line); border-radius: 14px; padding: 12px; background: var(--card2); color: var(--text); margin: 12px 0; box-sizing: border-box; }
.camera::file-selector-button { background: var(--blue); color: #fff; border: 0; border-radius: 10px; padding: 6px 14px; font-size: 12px; font-weight: 700; cursor: pointer; margin-right: 10px; }

.form-control { background: var(--card2) !important; border: 1px solid var(--line) !important; color: white !important; border-radius: 14px !important; padding: 12px !important; }

.worker { border-top: 1px solid var(--line); padding: 16px 0; }
.worker:first-of-type { border-top: 0; padding-top: 8px; }

.badge-app { padding: 6px 12px; border-radius: 999px; font-size: 11px; font-weight: 700; }
.pending { background: rgba(242,181,59,.18); color: var(--orange); }
.inside { background: rgba(55,194,129,.18); color: var(--green); }
.done { background: rgba(91,140,255,.18); color: #8fb0ff; }

.photo { width: 48px; height: 48px; object-fit: cover; border-radius: 14px; border: 1px solid var(--line); }

.bottom-nav { position: fixed; left: 12px; right: 12px; bottom: 12px; background: rgba(21,27,41,.95); border: 1px solid var(--line); border-radius: 24px; display: grid; grid-template-columns: repeat(4, 1fr); padding: 10px 6px; backdrop-filter: blur(16px); z-index: 100; }
.bottom-nav a { text-align: center; color: var(--muted); text-decoration: none; font-size: 11px; }
.bottom-nav a.active { color: #fff; }
.bottom-nav i { display: block; font-style: normal; font-size: 20px; margin-bottom: 3px; }

@media(min-width:1024px){
    .full-wrapper {
        display: grid;
        grid-template-columns: 450px 1fr;
        gap: 24px;
        padding: 24px;
        align-items: start;
        min-height: 100vh;
    }
    .left-panel {
        padding: 24px;
        border: 1px solid var(--line);
        border-radius: 24px;
        min-height: calc(100vh - 48px);
    }
    .right-panel {
        background: radial-gradient(circle at top left,rgba(91,140,255,.05),transparent 40%), var(--bg);
        border: 1px solid var(--line);
        border-radius: 24px;
        padding: 32px;
        margin-top: 0;
        min-height: calc(100vh - 48px);
    }
    .desktop-title {
        display: block;
        font-size: 20px;
        font-weight: 800;
        margin-bottom: 24px;
    }
    .bottom-nav {
        max-width: 500px;
        margin: auto;
        left: 0;
        right: 0;
        bottom: 24px;
    }
}
</style>

<div class="full-wrapper">
    <!-- Left Panel -->
    <div class="left-panel">
        <div class="app-head">
            <div class="profile">
                <div class="avatar"><?php echo e(strtoupper(substr(auth()->user()->display_name ?? 'S', 0, 1))); ?></div>
                <div>
                    <h3><?php echo e(auth()->user()->display_name); ?></h3>
                    <p>SECURITY PORTAL</p>
                </div>
            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="logout">Logout</button>
            </form>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success" style="background:rgba(55,194,129,.12);border:1px solid rgba(55,194,129,.3);color:#c9ffe2;border-radius:16px;padding:12px;margin-bottom:15px;font-size:13px;">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->any()): ?>
            <div class="alert alert-danger" style="background:rgba(255,90,110,.12);border:1px solid rgba(255,90,110,.3);color:#ffc9d0;border-radius:16px;padding:12px;margin-bottom:15px;font-size:13px;">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <!-- Assigned Site Banner -->
        <div class="panel site-banner">
            <div class="muted">ASSIGNED SITE</div>
            <h3><?php echo e($site->site_name); ?></h3>
            <div style="font-size:13px;color:rgba(255,255,255,0.9);"><?php echo e($site->location ?: 'Location not added'); ?></div>
        </div>

        <!-- Security Attendance Panel -->
        <div class="panel">
            <div class="row-between">
                <h5 class="m-0" style="font-size:16px;font-weight:700;">My Attendance</h5>
                <span class="badge-app <?php echo e(!$attendance?'pending':(!$attendance->punch_out?'inside':'done')); ?>">
                    <?php echo e(!$attendance?'Not punched':(!$attendance->punch_out?'Inside':'Completed')); ?>

                </span>
            </div>

            <?php if(!$attendance): ?>
                <form method="POST" action="<?php echo e(route('attendance.punchin')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="location" value="<?php echo e($site->site_name); ?>">
                    <input class="camera mobile-photo" type="file" name="photo" accept="image/*,.heic,.heif" capture="user" required>
                    <button class="btn-app btn-in">📷 Photo + Punch In</button>
                </form>
            <?php elseif(!$attendance->punch_out): ?>
                <p class="muted mt-3">Punched in <?php echo e($attendance->punch_in->format('h:i A')); ?></p>
                <form method="POST" action="<?php echo e(route('attendance.punchout')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="location" value="<?php echo e($site->site_name); ?>">
                    <input class="camera mobile-photo" type="file" name="photo" accept="image/*,.heic,.heif" capture="user" required>
                    <button class="btn-app btn-out">📷 Photo + Punch Out</button>
                </form>
            <?php else: ?>
                <div class="mt-3" style="font-size:14px;font-weight:600;color:var(--green);">
                    Punched: <?php echo e($attendance->punch_in->format('h:i A')); ?> — <?php echo e($attendance->punch_out->format('h:i A')); ?>

                </div>
            <?php endif; ?>
        </div>

        <!-- Overview Stats -->
        <div class="stats mb-3">
            <div class="stat">
                <b><?php echo e($workers->count()); ?></b>
                <span class="muted">Workers</span>
            </div>
            <div class="stat">
                <b><?php echo e($workerAttendances->whereNull('punch_out')->count()); ?></b>
                <span class="muted">Inside</span>
            </div>
            <div class="stat">
                <b><?php echo e($visitors->whereNull('check_out_at')->count()); ?></b>
                <span class="muted">Visitors</span>
            </div>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
        <div class="desktop-title">Security Operations</div>

        <!-- Visitor Check-in -->
        <div class="panel" id="visitors">
            <h5 style="font-size:17px;font-weight:700;margin-bottom:4px;">Visitor Check-in</h5>
            <p class="muted" style="margin-bottom:14px;">Photo, name and phone number only.</p>
            <form method="POST" action="<?php echo e(route('security.visitors.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row g-2">
                    <div class="col-12 col-md-6 mb-2">
                        <input class="form-control" name="name" placeholder="Visitor name" required>
                    </div>
                    <div class="col-12 col-md-6 mb-2">
                        <input class="form-control" name="mobile" inputmode="tel" placeholder="Phone number" required>
                    </div>
                </div>
                <input class="camera" type="file" name="photo" accept="image/*" capture="environment" required>
                <button class="btn-app btn-primary">📷 Save Visitor</button>
            </form>

            <div class="mt-3">
                <?php $__empty_1 = true; $__currentLoopData = $visitors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $visitor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="worker">
                        <div class="row-between">
                            <div class="d-flex align-items-center gap-2">
                                <img class="photo" src="<?php echo e(asset('storage/'.$visitor->photo)); ?>">
                                <div>
                                    <strong><?php echo e($visitor->name); ?></strong>
                                    <div class="muted"><?php echo e($visitor->mobile); ?> · <?php echo e($visitor->check_in_at?->format('h:i A')); ?></div>
                                </div>
                            </div>
                            <?php if(!$visitor->check_out_at): ?>
                                <form method="POST" action="<?php echo e(route('security.visitors.checkout',$visitor)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button class="btn btn-sm btn-outline-light" style="border-radius:12px;padding:6px 14px;font-size:12px;">Check Out</button>
                                </form>
                            <?php else: ?>
                                <span class="badge-app done">Out</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="muted mb-0 mt-2">No visitors today.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Add Worker -->
        <div class="panel" id="add-worker">
            <div class="row-between">
                <h5 class="m-0" style="font-size:17px;font-weight:700;">Add Worker</h5>
                <span class="muted"><?php echo e($site->site_name); ?></span>
            </div>
            <p class="muted mt-2" style="margin-bottom:14px;">Name and photo only. Worker code is created automatically.</p>
            <form method="POST" action="<?php echo e(route('security.workers.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <input class="form-control mb-2" name="name" value="<?php echo e(old('name')); ?>" placeholder="Worker name" required>
                <input class="camera" type="file" name="photo" accept="image/*" capture="environment" required>
                <button class="btn-app btn-primary">📷 Add Worker</button>
            </form>
        </div>

        <!-- Worker Attendance -->
        <div class="panel" id="workers">
            <div class="row-between" style="margin-bottom:14px;">
                <h5 class="m-0" style="font-size:17px;font-weight:700;">Worker Attendance</h5>
                <span class="muted">Supervisor approval required</span>
            </div>

            <?php $__empty_1 = true; $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php ($record=$workerAttendances->get($worker->id)); ?>
                <div class="worker">
                    <div class="row-between">
                        <div class="d-flex align-items-center gap-2">
                            <?php if($worker->photo): ?>
                                <img class="photo" src="<?php echo e(asset('storage/'.$worker->photo)); ?>">
                            <?php endif; ?>
                            <div>
                                <strong><?php echo e($worker->name); ?></strong>
                                <div class="muted"><?php echo e($worker->worker_code); ?></div>
                            </div>
                        </div>
                        <span class="badge-app <?php echo e(!$record?'pending':(!$record->punch_out?'inside':'done')); ?>">
                            <?php echo e(!$record?'Not marked':(!$record->punch_out?'Inside':ucfirst($record->status))); ?>

                        </span>
                    </div>
                    <?php if(!$record): ?>
                        <form method="POST" action="<?php echo e(route('security.workers.punch-in',$worker)); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="btn-app btn-in mt-2">Punch In</button>
                        </form>
                    <?php elseif(!$record->punch_out): ?>
                        <form method="POST" action="<?php echo e(route('security.workers.punch-out',$worker)); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="btn-app btn-out mt-2">Punch Out</button>
                        </form>
                    <?php else: ?>
                        <div class="muted mt-2">
                            <?php echo e($record->punch_in); ?> — <?php echo e($record->punch_out); ?> · <?php echo e(number_format(($record->working_minutes ?? 0)/60,2)); ?> hrs · <?php echo e($record->work_description); ?> · <?php echo e(ucfirst($record->status)); ?>

                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="muted mt-3">No active workers assigned.</p>
            <?php endif; ?>
        </div>

        <!-- Site Inventory Shortcut -->
        <div class="panel">
            <div class="row-between">
                <div>
                    <h5 class="m-0" style="font-size:17px;font-weight:700;">Site Inventory</h5>
                    <div class="muted mt-1">Add tools and mark who is using them.</div>
                </div>
                <a class="btn-app btn-primary" style="width:auto;padding:10px 20px;text-decoration:none;" href="<?php echo e(route('security.inventory')); ?>">Open Inventory</a>
            </div>
        </div>
    </div>
</div>

<div class="bottom-nav">
    <a href="<?php echo e(route('security.dashboard')); ?>" class="active"><i>🏠</i>Home</a>
    <a href="<?php echo e(route('security.inventory')); ?>"><i>📦</i>Inventory</a>
    <a href="#workers"><i>⏱</i>Punch</a>
    <a href="<?php echo e(route('security.history')); ?>"><i>📜</i>History</a>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views\security\dashboard.blade.php ENDPATH**/ ?>