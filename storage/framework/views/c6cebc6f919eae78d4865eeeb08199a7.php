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
.hero-banner { background: linear-gradient(135deg, #2448a8, #5c42c9); border: none; border-radius: 22px; padding: 22px; margin-bottom: 18px; color: white; }
.hero-banner h2 { margin: 4px 0; font-size: 24px; font-weight: 800; }
.hero-banner small { text-transform: uppercase; letter-spacing: 1px; opacity: 0.8; font-weight: 700; font-size: 11px; }

.stat-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 18px; }
.stat { background: var(--card); border: 1px solid var(--line); border-radius: 18px; padding: 16px; text-align: center; }
.stat strong { display: block; font-size: 22px; color: #fff; }
.stat div { font-size: 12px; color: var(--muted); margin-top: 2px; }

.btn-app { width: 100%; border: 0; border-radius: 16px; padding: 14px; font-size: 14px; font-weight: 800; color: white; cursor: pointer; transition: .2s; }
.btn-in, .btn-success { background: linear-gradient(135deg, var(--green), #22c55e); border: 0; color: #fff; font-weight: 700; }
.btn-out, .btn-danger { background: linear-gradient(135deg, var(--red), #ef4444); border: 0; color: #fff; font-weight: 700; }
.btn-primary { background: linear-gradient(135deg, var(--blue), var(--purple)); border: 0; color: #fff; font-weight: 700; }

.form-control, .form-select { background: var(--card2) !important; border: 1px solid var(--line) !important; color: white !important; border-radius: 14px !important; padding: 12px !important; font-size: 14px !important; }
.form-control::placeholder { color: var(--muted) !important; }

.worker-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 14px; }
@media(max-width:768px){ .worker-grid { grid-template-columns: 1fr; } }

.worker-card { background: var(--card2); border: 1px solid var(--line); border-radius: 18px; padding: 16px; margin-top: 12px; }
.photo { width: 52px; height: 52px; border-radius: 14px; object-fit: cover; border: 1px solid var(--line); }
.timeline { border-left: 2px solid var(--blue); padding-left: 12px; margin: 12px 0; }
.timeline-item { padding: 4px 0; }

.att-row { border-top: 1px solid var(--line); padding: 16px 0; }
.att-row:first-of-type { border-top: 0; }

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
                <div class="avatar"><?php echo e(strtoupper(substr(auth()->user()->name ?? 'S', 0, 1))); ?></div>
                <div>
                    <h3><?php echo e(auth()->user()->name); ?></h3>
                    <p>Site supervisor · Edit Profile</p>
                </div>
            </div>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button class="logout">Logout</button>
            </form>
        </div>

        <?php if(session('success')): ?>
            <div class="alert alert-success mt-2 mb-3" style="background:rgba(55,194,129,.12);border:1px solid rgba(55,194,129,.3);color:#c9ffe2;border-radius:16px;padding:12px;font-size:13px;">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if($errors->any()): ?>
            <div class="alert alert-danger mt-2 mb-3" style="background:rgba(255,90,110,.12);border:1px solid rgba(255,90,110,.3);color:#ffc9d0;border-radius:16px;padding:12px;font-size:13px;">
                <?php echo e($errors->first()); ?>

            </div>
        <?php endif; ?>

        <!-- Hero Site Banner -->
        <div class="hero-banner">
            <small>SITE SUPERVISOR</small>
            <h2><?php echo e($site->site_name); ?></h2>
            <div><?php echo e($site->location); ?></div>
        </div>

        <!-- Quick Stats -->
        <div class="stat-grid">
            <div class="stat">
                <strong><?php echo e($site->zones->count()); ?></strong>
                <div>Work Cases</div>
            </div>
            <div class="stat">
                <strong><?php echo e($pending->count()); ?></strong>
                <div>Pending Approvals</div>
            </div>
            <div class="stat">
                <strong><?php echo e($today->where('status','approved')->count()); ?></strong>
                <div>Approved Today</div>
            </div>
        </div>

        <div class="mb-3">
            <a href="<?php echo e(route('supervisor.wages.create')); ?>" class="btn-app d-block text-center text-decoration-none" style="background: linear-gradient(135deg, #10b981, #059669); color: white;">
                💰 Record Worker Wage
            </a>
        </div>

        <!-- My Attendance -->
        <div class="panel">
            <h4 style="font-size:17px;font-weight:700;margin-top:0;margin-bottom:14px;">My Attendance</h4>
            <?php if(!$attendance): ?>
                <form method="POST" action="<?php echo e(route('attendance.punchin')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="location" value="<?php echo e($site->site_name); ?>">
                    <input class="form-control mb-2" type="file" name="photo" accept="image/*" capture="user" required>
                    <button class="btn btn-success w-100 btn-app">Photo + Punch In</button>
                </form>
            <?php elseif(!$attendance->punch_out): ?>
                <form method="POST" action="<?php echo e(route('attendance.punchout')); ?>" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="location" value="<?php echo e($site->site_name); ?>">
                    <p style="color:var(--muted);font-size:13px;" class="mb-2">Punched in: <?php echo e($attendance->punch_in->format('h:i A')); ?></p>
                    <input class="form-control mb-2" type="file" name="photo" accept="image/*" capture="user" required>
                    <button class="btn btn-danger w-100 btn-app">Photo + Punch Out</button>
                </form>
            <?php else: ?>
                <div class="alert alert-success mb-0" style="background:rgba(55,194,129,.12);border:1px solid rgba(55,194,129,.3);color:#c9ffe2;border-radius:14px;padding:12px;font-size:13px;">
                    Completed <?php echo e($attendance->punch_in->format('h:i A')); ?> - <?php echo e($attendance->punch_out->format('h:i A')); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Right Panel -->
    <div class="right-panel">
        <div class="desktop-title">Site Supervisor Operations</div>

        <!-- Add Worker -->
        <div class="panel">
            <h4 style="font-size:17px;font-weight:700;margin-top:0;margin-bottom:14px;">Add Worker</h4>
            <form method="POST" action="<?php echo e(route('supervisor.workers.store')); ?>" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <div class="row g-2">
                    <div class="col-md-3 mb-2"><input class="form-control" name="name" placeholder="Worker name" required></div>
                    <div class="col-md-3 mb-2"><input class="form-control" name="mobile" placeholder="Mobile"></div>
                    <div class="col-md-3 mb-2"><input class="form-control" name="trade" placeholder="Trade/skill" required></div>
                    <div class="col-md-3 mb-2"><input class="form-control" type="file" name="photo" accept="image/*" capture="user" required></div>
                    <div class="col-md-4 mb-2"><input class="form-control" type="number" step="0.01" min="0" name="daily_wage" placeholder="Daily Wage (₹)"></div>
                    <div class="col-md-4 mb-2"><input class="form-control" type="number" step="0.5" min="0" name="standard_hours" placeholder="Standard Hrs (e.g. 8)" value="8"></div>
                    <div class="col-md-4 mb-2"><input class="form-control" type="number" step="0.01" min="0" name="overtime_rate" placeholder="OT Rate (₹/hr)"></div>
                </div>
                <button class="btn btn-primary mt-2 btn-app" style="width:auto;padding:10px 24px;">Add Worker</button>
            </form>
        </div>

        <!-- Workers Today -->
        <div class="panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 style="font-size:17px;font-weight:700;margin:0;">Workers Today</h4>
                <span class="badge" style="background:var(--blue);border-radius:12px;padding:6px 12px;font-size:12px;"><?php echo e($site->workers->count()); ?> workers</span>
            </div>
            <div class="worker-grid">
                <?php $__empty_1 = true; $__currentLoopData = $site->workers->where('active',true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $worker): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php ($record = $today->get($worker->id)); ?>
                    <div class="worker-card">
                        <div class="d-flex gap-3 align-items-center">
                            <?php if($worker->photo): ?>
                                <img class="photo" src="<?php echo e(asset('storage/'.$worker->photo)); ?>">
                            <?php endif; ?>
                            <div>
                                <strong><?php echo e($worker->name); ?></strong>
                                <div style="color:var(--muted);font-size:12px;"><?php echo e($worker->worker_code); ?> · <?php echo e($worker->trade); ?></div>
                            </div>
                        </div>

                        <?php if(!$record): ?>
                            <form class="mt-3" method="POST" action="<?php echo e(route('supervisor.workers.start',$worker)); ?>" enctype="multipart/form-data">
                                <?php echo csrf_field(); ?>
                                <select class="form-select mb-2" name="site_zone_id">
                                    <option value="">General / no work case</option>
                                    <?php $__currentLoopData = $site->zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($zone->id); ?>"><?php echo e($zone->zone_name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                                <input class="form-control mb-2" name="work_name" placeholder="Starting work" required>
                                <input class="form-control mb-2" name="notes" placeholder="Notes (optional)">
                                <label class="small style='color:var(--muted);'">Starting photo</label>
                                <input class="form-control mb-2" type="file" name="photo" accept="image/*" capture="environment" required>
                                <button class="btn btn-success w-100 btn-app">Start Work</button>
                            </form>
                        <?php else: ?>
                            <div class="mt-2 small" style="color:var(--text);">
                                <strong>Started:</strong> <?php echo e(date('h:i A',strtotime($record->punch_in))); ?>

                                <?php if($record->punch_out): ?> · <strong>Ended:</strong> <?php echo e(date('h:i A',strtotime($record->punch_out))); ?> <?php endif; ?>
                            </div>
                            <div class="timeline">
                                <?php $__currentLoopData = $record->workSessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="timeline-item">
                                        <strong><?php echo e($session->work_name); ?></strong>
                                        <div class="small" style="color:var(--muted);">
                                            <?php echo e($session->started_at->format('h:i A')); ?> – <?php echo e($session->ended_at?->format('h:i A') ?? 'Now'); ?> · <?php echo e($session->minutes); ?> min
                                            <?php if($session->siteZone): ?> · <?php echo e($session->siteZone->zone_name); ?> <?php endif; ?>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>

                            <?php if(!$record->punch_out): ?>
                                <details class="mb-2">
                                    <summary class="btn btn-outline-primary btn-sm w-100" style="border-radius:12px;color:var(--blue);border-color:var(--line);">Change Work</summary>
                                    <form class="mt-2" method="POST" action="<?php echo e(route('supervisor.workers.change-work',$record)); ?>">
                                        <?php echo csrf_field(); ?>
                                        <select class="form-select mb-2" name="site_zone_id">
                                            <option value="">General / no work case</option>
                                            <?php $__currentLoopData = $site->zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($zone->id); ?>"><?php echo e($zone->zone_name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                        <input class="form-control mb-2" name="work_name" placeholder="New work" required>
                                        <input class="form-control mb-2" name="notes" placeholder="Reason / notes">
                                        <button class="btn btn-primary w-100 btn-app">Move Worker</button>
                                    </form>
                                </details>

                                <form method="POST" action="<?php echo e(route('supervisor.workers.end',$record)); ?>" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <label class="small style='color:var(--muted);'">Ending photo</label>
                                    <input class="form-control mb-2" type="file" name="photo" accept="image/*" capture="environment" required>
                                    <button class="btn btn-danger w-100 btn-app">End Work</button>
                                </form>
                            <?php else: ?>
                                <div class="alert alert-success py-2 mb-0 mt-2" style="background:rgba(55,194,129,.12);border:1px solid rgba(55,194,129,.3);color:#c9ffe2;border-radius:12px;font-size:13px;">
                                    Completed: <?php echo e(intdiv($record->working_minutes ?? 0,60)); ?>h <?php echo e(($record->working_minutes ?? 0)%60); ?>m
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p style="color:var(--muted);">No workers added yet.</p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Add Work Case -->
        <div class="panel">
            <h4 style="font-size:17px;font-weight:700;margin-top:0;margin-bottom:14px;">Add Work Case</h4>
            <form method="POST" action="<?php echo e(route('supervisor.work-cases.store')); ?>">
                <?php echo csrf_field(); ?>
                <div class="row g-2">
                    <div class="col-md-4 mb-2"><input class="form-control" name="zone_name" placeholder="Work case name" required></div>
                    <div class="col-md-4 mb-2"><input class="form-control" name="work_type" placeholder="Work type" required></div>
                    <div class="col-md-4 mb-2">
                        <select class="form-select" name="supervisor_id">
                            <option value="">Assign supervisor</option>
                            <?php $__currentLoopData = $assignableSupervisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($person->id); ?>"><?php echo e($person->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <select class="form-select" name="status">
                            <option value="not_started">Not Started</option>
                            <option value="in_progress">In Progress</option>
                            <option value="on_hold">On Hold</option>
                            <option value="completed">Completed</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-2"><input class="form-control" type="number" name="progress" value="0" min="0" max="100" placeholder="Progress %"></div>
                    <div class="col-md-3 mb-2"><input class="form-control" type="date" name="start_date"></div>
                    <div class="col-md-3 mb-2"><input class="form-control" type="date" name="expected_end_date"></div>
                    <div class="col-12 mb-2"><textarea class="form-control" name="description" placeholder="Description"></textarea></div>
                </div>
                <button class="btn btn-primary mt-2 btn-app" style="width:auto;padding:10px 24px;">Add Work Case</button>
            </form>
        </div>

        <!-- Manage Work Cases -->
        <div class="panel">
            <h4 style="font-size:17px;font-weight:700;margin-top:0;margin-bottom:14px;">Work Cases</h4>
            <?php $__empty_1 = true; $__currentLoopData = $site->zones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $zone): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <form method="POST" action="<?php echo e(route('supervisor.work-cases.update',$zone)); ?>" class="att-row">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="row g-2 align-items-center">
                        <div class="col-md-3 mb-2">
                            <strong><?php echo e($zone->zone_name); ?></strong>
                            <div style="color:var(--muted);font-size:12px;"><?php echo e($zone->work_type); ?></div>
                        </div>
                        <div class="col-md-3 mb-2">
                            <select class="form-select" name="supervisor_id">
                                <option value="">Unassigned</option>
                                <?php $__currentLoopData = $assignableSupervisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($person->id); ?>" <?php if($zone->supervisor_id==$person->id): echo 'selected'; endif; ?>><?php echo e($person->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <select class="form-select" name="status">
                                <?php $__currentLoopData = ['not_started','in_progress','on_hold','completed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($s); ?>" <?php if($zone->status==$s): echo 'selected'; endif; ?>><?php echo e(ucfirst(str_replace('_',' ',$s))); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <input class="form-control" type="number" name="progress" value="<?php echo e($zone->progress); ?>" min="0" max="100">
                        </div>
                        <div class="col-md-2 mb-2">
                            <button class="btn btn-outline-primary w-100 btn-app" style="background:var(--card2);border:1px solid var(--line);color:var(--text);">Update</button>
                        </div>
                    </div>
                </form>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p style="color:var(--muted);">No work cases.</p>
            <?php endif; ?>
        </div>

        <!-- Pending Worker Attendance -->
        <div class="panel">
            <h4 style="font-size:17px;font-weight:700;margin-top:0;margin-bottom:14px;">Pending Worker Attendance</h4>
            <?php $__empty_1 = true; $__currentLoopData = $pending; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="att-row">
                    <div class="d-flex gap-3 align-items-center">
                        <?php if($record->punch_in_photo): ?>
                            <img class="photo" src="<?php echo e(asset('storage/'.$record->punch_in_photo)); ?>">
                        <?php endif; ?>
                        <div class="flex-grow-1">
                            <strong><?php echo e($record->worker->name); ?></strong>
                            <div style="color:var(--muted);font-size:12px;">
                                <?php echo e($record->attendance_date->format('d M Y')); ?> · <?php echo e($record->punch_in); ?> - <?php echo e($record->punch_out ?: 'Inside'); ?> · Recorded by <?php echo e($record->recordedBy->name ?? '-'); ?>

                            </div>
                        </div>
                    </div>
                    <div class="d-flex gap-2 mt-3">
                        <form method="POST" action="<?php echo e(route('supervisor.attendance.approve',$record)); ?>">
                            <?php echo csrf_field(); ?>
                            <button class="btn btn-success btn-sm btn-app" style="width:auto;padding:8px 20px;">Approve</button>
                        </form>
                        <form method="POST" action="<?php echo e(route('supervisor.attendance.reject',$record)); ?>" class="d-flex gap-2 flex-grow-1">
                            <?php echo csrf_field(); ?>
                            <input class="form-control form-control-sm" name="rejection_reason" placeholder="Reason for rejection" required>
                            <button class="btn btn-danger btn-sm btn-app" style="width:auto;padding:8px 20px;">Reject</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p style="color:var(--muted);">No pending attendance.</p>
            <?php endif; ?>
        </div>

    </div>
</div>

<div class="bottom-nav">
    <a href="<?php echo e(route('supervisor.dashboard')); ?>" class="active"><i>🏠</i>Home</a>
    <a href="#workers"><i>👷</i>Workers</a>
    <a href="#cases"><i>📂</i>Cases</a>
    <a href="#daily-update"><i>📸</i>Update</a>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views/supervisor/dashboard.blade.php ENDPATH**/ ?>