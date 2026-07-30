<?php $__env->startSection('title', 'Add Work Site'); ?>

<?php $__env->startSection('content'); ?>

<div class="worksite-create">

    <div class="worksite-header">
        <div>
            <h2>Add Work Site</h2>
            <p>
                Create a site and assign security, supervisor,
                site manager and project manager.
            </p>
        </div>

        <a href="<?php echo e(route('admin.work-sites')); ?>" class="worksite-back">
            ← Back
        </a>
    </div>

    <?php if($errors->any()): ?>
        <div class="worksite-errors">
            <strong>Please correct the following errors:</strong>

            <ul>
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endif; ?>

    <div class="worksite-card">

        <form method="POST" action="<?php echo e(route('admin.work-sites.store')); ?>">
            <?php echo csrf_field(); ?>

            <div class="worksite-grid">

                <div class="worksite-field">
                    <label for="site_name">
                        Site Name <span>*</span>
                    </label>

                    <input
                        id="site_name"
                        type="text"
                        name="site_name"
                        value="<?php echo e(old('site_name')); ?>"
                        placeholder="Example: Wonderla Expansion Project"
                        required
                    >
                </div>

                <div class="worksite-field">
                    <label for="client_name">Client Name</label>

                    <input
                        id="client_name"
                        type="text"
                        name="client_name"
                        value="<?php echo e(old('client_name')); ?>"
                        placeholder="Client or company name"
                    >
                </div>

                <div class="worksite-field worksite-full">
                    <label for="location">Location</label>

                    <input
                        id="location"
                        type="text"
                        name="location"
                        value="<?php echo e(old('location')); ?>"
                        placeholder="Kochi, Kerala"
                    >
                </div>

                <div class="worksite-field">
                    <label for="site_security_id">Site Security</label>

                    <select id="site_security_id" name="site_security_id">
                        <option value="">Select Security</option>

                        <?php $__currentLoopData = $securityUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $security): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($security->id); ?>"
                                <?php echo e(old('site_security_id') == $security->id ? 'selected' : ''); ?>

                            >
                                <?php echo e($security->name); ?> — <?php echo e($security->email); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="worksite-field">
                    <label for="site_supervisor_id">Site Supervisor</label>

                    <select id="site_supervisor_id" name="site_supervisor_id">
                        <option value="">Select Supervisor</option>

                        <?php $__currentLoopData = $supervisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $supervisor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($supervisor->id); ?>"
                                <?php echo e(old('site_supervisor_id') == $supervisor->id ? 'selected' : ''); ?>

                            >
                                <?php echo e($supervisor->name); ?> — <?php echo e($supervisor->email); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="worksite-field">
                    <label for="site_manager_id">Site Manager</label>

                    <select id="site_manager_id" name="site_manager_id">
                        <option value="">Select Site Manager</option>

                        <?php $__currentLoopData = $siteManagers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($manager->id); ?>"
                                <?php echo e(old('site_manager_id') == $manager->id ? 'selected' : ''); ?>

                            >
                                <?php echo e($manager->name); ?> — <?php echo e($manager->email); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="worksite-field">
                    <label for="project_manager_id">Project Manager</label>

                    <select id="project_manager_id" name="project_manager_id">
                        <option value="">Select Project Manager</option>

                        <?php $__currentLoopData = $projectManagers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manager): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option
                                value="<?php echo e($manager->id); ?>"
                                <?php echo e(old('project_manager_id') == $manager->id ? 'selected' : ''); ?>

                            >
                                <?php echo e($manager->name); ?> — <?php echo e($manager->email); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="worksite-field">
                    <label for="project_coordinator_id">Project Coordinator</label>
                    <select id="project_coordinator_id" name="project_coordinator_id">
                        <option value="">Select Project Coordinator</option>
                        <?php $__currentLoopData = $projectCoordinators; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coordinator): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($coordinator->id); ?>" <?php if((string) old('project_coordinator_id', isset($workSite) ? $workSite->project_coordinator_id : '') === (string) $coordinator->id): echo 'selected'; endif; ?>>
                                <?php echo e($coordinator->name); ?> — <?php echo e($coordinator->email); ?>

                            </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>

                <div class="worksite-field">
                    <label for="start_date">Start Date</label>

                    <input
                        id="start_date"
                        type="date"
                        name="start_date"
                        value="<?php echo e(old('start_date')); ?>"
                    >
                </div>

                <div class="worksite-field">
                    <label for="expected_end_date">Expected End Date</label>

                    <input
                        id="expected_end_date"
                        type="date"
                        name="expected_end_date"
                        value="<?php echo e(old('expected_end_date')); ?>"
                    >
                </div>

                <div class="worksite-field">
                    <label for="status">
                        Site Status <span>*</span>
                    </label>

                    <select id="status" name="status" required>
                        <option
                            value="planning"
                            <?php echo e(old('status') === 'planning' ? 'selected' : ''); ?>

                        >
                            Planning
                        </option>

                        <option
                            value="active"
                            <?php echo e(old('status', 'active') === 'active' ? 'selected' : ''); ?>

                        >
                            Active
                        </option>

                        <option
                            value="on_hold"
                            <?php echo e(old('status') === 'on_hold' ? 'selected' : ''); ?>

                        >
                            On Hold
                        </option>

                        <option
                            value="completed"
                            <?php echo e(old('status') === 'completed' ? 'selected' : ''); ?>

                        >
                            Completed
                        </option>
                    </select>
                </div>

                <div class="worksite-field worksite-full">
                    <label for="description">Description</label>

                    <textarea
                        id="description"
                        name="description"
                        rows="3"
                        placeholder="Project description, scope or instructions..."
                    ><?php echo e(old('description')); ?></textarea>
                </div>

            </div>

            <div class="worksite-actions">
                <a href="<?php echo e(route('admin.work-sites')); ?>" class="worksite-cancel">
                    Cancel
                </a>

                <button type="submit" class="worksite-save">
                    💾 Save Work Site
                </button>
            </div>

        </form>

    </div>

</div>

<style>
.worksite-create{
    width:min(900px, 100%) !important;
    max-width:900px !important;
    margin:0 auto !important;
    padding:0 !important;
    zoom:1 !important;
    transform:none !important;
}

.worksite-header{
    display:flex !important;
    justify-content:space-between !important;
    align-items:flex-start !important;
    gap:16px !important;
    margin:0 0 16px !important;
}

.worksite-header h2{
    margin:0 !important;
    color:#ffffff !important;
    font-size:22px !important;
    line-height:1.25 !important;
    font-weight:750 !important;
}

.worksite-header p{
    margin:5px 0 0 !important;
    color:#8794ac !important;
    font-size:12px !important;
    line-height:1.5 !important;
}

.worksite-back,
.worksite-cancel,
.worksite-save{
    width:auto !important;
    min-width:0 !important;
    height:36px !important;
    min-height:36px !important;
    max-height:36px !important;
    padding:0 13px !important;
    margin:0 !important;
    border-radius:8px !important;
    display:inline-flex !important;
    align-items:center !important;
    justify-content:center !important;
    font-size:12px !important;
    font-weight:700 !important;
    line-height:1 !important;
    text-decoration:none !important;
    white-space:nowrap !important;
}

.worksite-back,
.worksite-cancel{
    color:#dbe4f3 !important;
    border:1px solid #334155 !important;
    background:#1c2436 !important;
}

.worksite-save{
    color:#ffffff !important;
    border:0 !important;
    background:#3f6fe0 !important;
    cursor:pointer !important;
}

.worksite-card{
    width:100% !important;
    max-width:900px !important;
    margin:0 !important;
    padding:18px !important;
    border:1px solid #262f47 !important;
    border-radius:14px !important;
    background:#151b29 !important;
    box-shadow:none !important;
    zoom:1 !important;
    transform:none !important;
}

.worksite-grid{
    display:grid !important;
    grid-template-columns:repeat(2, minmax(0, 1fr)) !important;
    gap:13px 16px !important;
    width:100% !important;
}

.worksite-field{
    min-width:0 !important;
    margin:0 !important;
    padding:0 !important;
}

.worksite-full{
    grid-column:1 / -1 !important;
}

.worksite-field label{
    display:block !important;
    margin:0 0 5px !important;
    padding:0 !important;
    color:#9fb3d9 !important;
    font-size:11px !important;
    font-weight:700 !important;
    line-height:1.4 !important;
}

.worksite-field label span{
    color:#ff7889 !important;
}

.worksite-field input,
.worksite-field select,
.worksite-field textarea{
    box-sizing:border-box !important;
    display:block !important;
    width:100% !important;
    min-width:0 !important;
    max-width:100% !important;
    margin:0 !important;
    border:1px solid #2b3854 !important;
    border-radius:9px !important;
    outline:none !important;
    color:#ffffff !important;
    background:#0e1320 !important;
    box-shadow:none !important;
    font-family:'Segoe UI',system-ui,sans-serif !important;
    font-size:12px !important;
    font-weight:400 !important;
}

.worksite-field input,
.worksite-field select{
    height:40px !important;
    min-height:40px !important;
    max-height:40px !important;
    padding:0 11px !important;
    line-height:normal !important;
}

.worksite-field select{
    cursor:pointer !important;
}

.worksite-field select option{
    color:#ffffff !important;
    background:#151b29 !important;
}

.worksite-field textarea{
    height:76px !important;
    min-height:76px !important;
    max-height:110px !important;
    padding:9px 11px !important;
    line-height:1.45 !important;
    resize:vertical !important;
}

.worksite-field input::placeholder,
.worksite-field textarea::placeholder{
    color:#667793 !important;
    opacity:1 !important;
}

.worksite-field input:focus,
.worksite-field select:focus,
.worksite-field textarea:focus{
    border-color:#3f6fe0 !important;
    box-shadow:0 0 0 3px rgba(63,111,224,.10) !important;
}

.worksite-actions{
    display:flex !important;
    align-items:center !important;
    justify-content:flex-end !important;
    gap:9px !important;
    margin:16px 0 0 !important;
    padding:14px 0 0 !important;
    border-top:1px solid #262f47 !important;
}

.worksite-errors{
    margin:0 0 14px !important;
    padding:11px 13px !important;
    border:1px solid rgba(255,90,110,.35) !important;
    border-radius:10px !important;
    color:#ffd4da !important;
    background:rgba(255,90,110,.12) !important;
    font-size:11px !important;
}

.worksite-errors ul{
    margin:6px 0 0 !important;
    padding-left:17px !important;
}

@media(max-width:760px){
    .worksite-create{
        width:100% !important;
        max-width:100% !important;
    }

    .worksite-header{
        flex-direction:column !important;
    }

    .worksite-back{
        width:100% !important;
    }

    .worksite-card{
        padding:14px !important;
    }

    .worksite-grid{
        grid-template-columns:1fr !important;
    }

    .worksite-full{
        grid-column:auto !important;
    }

    .worksite-actions{
        flex-direction:column-reverse !important;
    }

    .worksite-actions > *{
        width:100% !important;
    }
}
</style>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views\admin\work_sites\create.blade.php ENDPATH**/ ?>