

<?php $__env->startSection('content'); ?>

<?php
$user = Auth::user();
$initials = strtoupper(substr($user->name,0,1));
?>

<style>
:root{--bg:#0e1320;--card:#151b29;--card2:#1c2436;--line:#262f47;--text:#e8edf6;--muted:#8794ac;--blue:#3f6fe0;--purple:#9b6bff;--green:#37c281;--red:#ff5a6e;--orange:#f2b53b}
body{margin:0;background:var(--bg);color:var(--text);font-family:'Segoe UI',system-ui,sans-serif}
.navbar,header{display:none!important}
.mobile-app-shell { max-width: 100% !important; margin: 0 !important; border-radius: 0 !important; border: 0 !important; min-height: 100vh !important; }
.app-content { padding: 0 !important; }
.container{max-width:100%!important;padding:0!important;margin:0!important}
.full-wrapper {
    min-height: 100vh;
    padding: 18px;
    padding-bottom: 90px;
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
.app-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:22px}
.profile{display:flex;align-items:center;gap:12px}
.avatar{width:48px;height:48px;border-radius:16px;background:linear-gradient(135deg,var(--blue),var(--purple));display:grid;place-items:center;font-weight:800;font-size:18px}
.profile h3{font-size:18px;margin:0}.profile p{margin:2px 0 0;color:var(--muted);font-size:12px}
.logout{background:var(--card);border:1px solid var(--line);color:var(--text);border-radius:14px;padding:10px 14px;font-size:13px;transition:.2s}
.logout:hover{background:var(--card2)}
.title{font-size:24px;font-weight:800;margin:8px 0 4px}.sub{color:var(--muted);font-size:13px;margin-bottom:18px}

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
    .bottom-nav {
        max-width: 500px;
        margin: auto;
        left: 0;
        right: 0;
        bottom: 24px;
    }
}

.alert-success{background:rgba(55,194,129,.12);border:1px solid rgba(55,194,129,.3);color:#c9ffe2;border-radius:16px;padding:12px;margin-bottom:15px;font-size:13px}
.update-card{background:var(--card);border:1px solid var(--line);border-radius:24px;padding:18px;margin-bottom:16px}
.update-top{display:flex;justify-content:space-between;gap:10px;margin-bottom:12px;align-items:flex-start}
.update-date{font-weight:800;color:#fff;font-size:15px}
.update-meta{color:var(--muted);font-size:12px;text-align:right}
.update-site{color:var(--blue);font-size:13px;font-weight:600;margin-bottom:8px}
.update-note{font-size:14px;color:#bdcbea;line-height:1.6;word-break:break-word;margin:8px 0}
.update-photo{width:100%;max-width:200px;border-radius:14px;border:1px solid var(--line);margin-top:10px}
.empty{background:var(--card);border:1px solid var(--line);border-radius:24px;padding:28px;text-align:center;color:var(--muted)}
.bottom-nav{position:fixed;left:12px;right:12px;bottom:12px;background:rgba(21,27,41,.95);border:1px solid var(--line);border-radius:24px;display:grid;grid-template-columns:repeat(4,1fr);padding:10px 6px;backdrop-filter:blur(16px);z-index:100}
.bottom-nav a{text-align:center;color:var(--muted);text-decoration:none;font-size:11px}.bottom-nav a.active{color:#fff}.bottom-nav i{display:block;font-style:normal;font-size:20px;margin-bottom:3px}

/* Form styles */
.form-card{background:var(--card);border:1px solid var(--line);border-radius:24px;padding:20px;margin-bottom:20px}
.form-label{font-size:12px;font-weight:700;color:var(--muted);letter-spacing:.5px;margin-bottom:8px;display:block}
.mobile-input{width:100%;background:var(--card2);border:1px solid var(--line);color:#fff;border-radius:16px;padding:13px;margin-bottom:12px;font-size:14px;box-sizing:border-box}
.mobile-input::placeholder{color:var(--muted)}
.mobile-input:focus{outline:none;border-color:var(--blue)}
.mobile-input::file-selector-button{background:var(--blue);color:#fff;border:0;border-radius:10px;padding:6px 14px;font-size:12px;font-weight:700;cursor:pointer;margin-right:10px}
textarea.mobile-input{resize:vertical;min-height:80px}
.btn-blue{border:0;border-radius:16px;padding:14px;color:#fff;font-weight:800;width:100%;cursor:pointer;background:linear-gradient(135deg,var(--blue),var(--purple))}
.btn-blue:hover{opacity:.9}
.photo-hint{font-size:11px;color:var(--muted);margin-bottom:14px}
.no-site-box{background:rgba(242,181,59,.1);border:1px solid rgba(242,181,59,.3);color:#fff1bd;border-radius:16px;padding:16px;margin-bottom:15px;font-size:13px}
</style>

<div class="full-wrapper">

    <div class="left-panel">
        <div class="app-header">
            <div class="profile">
                <div class="avatar"><?php echo e($initials); ?></div>
                <div>
                    <h3><?php echo e($user->name); ?></h3>
                    <p>Staff Service Panel</p>
                </div>
            </div>

            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="logout">Logout</button>
            </form>
        </div>

        <div class="title">Daily Work Updates</div>
        <div class="sub">Post progress photos and notes from your assigned sites</div>

        <?php if(session('success')): ?>
            <div class="alert-success"><?php echo e(session('success')); ?></div>
        <?php endif; ?>

        
        <div class="form-card">
            <?php if($workSites->count() > 0): ?>
                <form method="POST" action="<?php echo e(route('staff.daily-updates.store')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>

                    <label class="form-label">🏗️ Work Site</label>
                    <select name="work_site_id" class="mobile-input" required>
                        <option value="">Select a work site</option>
                        <?php $__currentLoopData = $workSites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($site->id); ?>"><?php echo e($site->site_name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <label class="form-label">📅 Date</label>
                    <input type="date" name="date" class="mobile-input" value="<?php echo e(date('Y-m-d')); ?>" required>

                    <label class="form-label">📷 Site Photo <span style="color:var(--muted)">(optional)</span></label>
                    <input type="file" name="photo" class="mobile-input" accept="image/*" capture="environment">
                    <div class="photo-hint">Max 10MB · JPG/PNG</div>

                    <label class="form-label">📝 Note <span style="color:var(--muted)">(optional)</span></label>
                    <textarea name="note" class="mobile-input" rows="3" placeholder="Progress, issues, observations…" maxlength="5000"></textarea>

                    <button class="btn-blue" type="submit">📤 Post Update</button>
                </form>
            <?php else: ?>
                <div class="no-site-box">
                    ⚠️ You are not assigned to any work site yet. Please contact your administrator to be assigned to a site before posting daily updates.
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="right-panel">
        <div class="title" style="font-size:24px;">My Updates History</div>
        <div class="sub">All daily work updates you have posted</div>

        <?php $__empty_1 = true; $__currentLoopData = $updates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $upd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="update-card">
                <div class="update-top">
                    <div>
                        <div class="update-date"><?php echo e($upd->date->format('d M Y')); ?></div>
                        <div class="update-site"><?php echo e($upd->workSite?->site_name ?? 'Unknown site'); ?></div>
                    </div>
                    <div class="update-meta">
                        <?php echo e($upd->created_at->diffForHumans()); ?>

                    </div>
                </div>

                <?php if($upd->photo): ?>
                    <a href="<?php echo e(asset('storage/'.$upd->photo)); ?>" target="_blank">
                        <img src="<?php echo e(asset('storage/'.$upd->photo)); ?>" class="update-photo" alt="Site photo">
                    </a>
                <?php endif; ?>

                <?php if($upd->note): ?>
                    <p class="update-note"><?php echo e($upd->note); ?></p>
                <?php else: ?>
                    <p class="update-note" style="color:var(--muted);font-style:italic;font-size:12px;">No note added.</p>
                <?php endif; ?>

                <div style="margin-top:10px;">
                    <?php if($upd->approval_status === 'pending'): ?>
                        <span style="background:rgba(242,181,59,.15);border:1px solid rgba(242,181,59,.4);color:#fff1bd;border-radius:10px;padding:4px 12px;font-size:12px;font-weight:600;">⏳ Pending Approval</span>
                    <?php elseif($upd->approval_status === 'approved'): ?>
                        <span style="background:rgba(55,194,129,.15);border:1px solid rgba(55,194,129,.4);color:#c9ffe2;border-radius:10px;padding:4px 12px;font-size:12px;font-weight:600;">✅ Approved</span>
                    <?php elseif($upd->approval_status === 'rejected'): ?>
                        <span style="background:rgba(255,90,110,.15);border:1px solid rgba(255,90,110,.4);color:#ffdce2;border-radius:10px;padding:4px 12px;font-size:12px;font-weight:600;">❌ Rejected</span>
                    <?php endif; ?>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty">
                📋 No daily updates posted yet.<br><br>
                Use the form on the left to post your first update.
            </div>
        <?php endif; ?>

        <?php echo e($updates->links()); ?>

    </div>

</div>

<div class="bottom-nav">
    <a href="<?php echo e(route('user.dashboard')); ?>"><i>🏠</i>Home</a>
    <a href="<?php echo e(route('staff.tickets')); ?>"><i>🎫</i>Tickets</a>
    <a href="<?php echo e(route('staff.daily-updates')); ?>" class="active"><i>📋</i>Updates</a>
    <a href="<?php echo e(route('expenses.my')); ?>"><i>🧾</i>Expenses</a>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views/user/daily_updates/index.blade.php ENDPATH**/ ?>