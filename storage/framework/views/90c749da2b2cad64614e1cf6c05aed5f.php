<?php
    $zone = $siteZone ?? null;
    $chosenSite = old('work_site_id', $zone?->work_site_id ?? $selectedSiteId ?? null);
?>

<?php if($errors->any()): ?>
    <div class="zone-alert"><ul><?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><li><?php echo e($error); ?></li><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></ul></div>
<?php endif; ?>

<div class="zone-form-grid">
    <div class="form-group full">
        <label>Work Site *</label>
        <select name="work_site_id" required>
            <option value="">Select work site</option>
            <?php $__currentLoopData = $sites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($site->id); ?>" <?php if((string)$chosenSite === (string)$site->id): echo 'selected'; endif; ?>><?php echo e($site->site_name); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="form-group"><label>Work / Zone Name *</label><input name="zone_name" value="<?php echo e(old('zone_name', $zone?->zone_name)); ?>" required placeholder="Example: Main structure"></div>
    <div class="form-group"><label>Work Type *</label><input name="work_type" value="<?php echo e(old('work_type', $zone?->work_type)); ?>" required placeholder="Civil, Electrical, Fabrication..."></div>
    <div class="form-group"><label>Supervisor</label><select name="supervisor_id"><option value="">Not assigned</option><?php $__currentLoopData = $supervisors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $person): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($person->id); ?>" <?php if((string)old('supervisor_id', $zone?->supervisor_id) === (string)$person->id): echo 'selected'; endif; ?>><?php echo e($person->name); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
    <div class="form-group"><label>Status *</label><select name="status" required><?php $__currentLoopData = ['not_started'=>'Not Started','in_progress'=>'In Progress','on_hold'=>'On Hold','completed'=>'Completed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value=>$label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><option value="<?php echo e($value); ?>" <?php if(old('status', $zone?->status ?? 'not_started') === $value): echo 'selected'; endif; ?>><?php echo e($label); ?></option><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?></select></div>
    <div class="form-group"><label>Progress (%) *</label><input type="number" name="progress" min="0" max="100" value="<?php echo e(old('progress', $zone?->progress ?? 0)); ?>" required></div>
    <div class="form-group"><label>Card Color</label><input type="color" name="color" value="<?php echo e(old('color', $zone?->color ?? '#3f6fe0')); ?>"></div>
    <div class="form-group"><label>Start Date</label><input type="date" name="start_date" value="<?php echo e(old('start_date', $zone?->start_date?->format('Y-m-d'))); ?>"></div>
    <div class="form-group"><label>Start Time</label><input type="time" name="start_time" value="<?php echo e(old('start_time', $zone?->start_time ? substr($zone->start_time,0,5) : null)); ?>"></div>
    <div class="form-group"><label>Expected End Date</label><input type="date" name="expected_end_date" value="<?php echo e(old('expected_end_date', $zone?->expected_end_date?->format('Y-m-d'))); ?>"></div>
    <div class="form-group"><label>End Time</label><input type="time" name="end_time" value="<?php echo e(old('end_time', $zone?->end_time ? substr($zone->end_time,0,5) : null)); ?>"></div>
    <div class="form-group full"><label>Description</label><textarea name="description" rows="4" placeholder="Describe the work scope"><?php echo e(old('description', $zone?->description)); ?></textarea></div>
</div>
<div class="form-actions"><a href="<?php echo e($chosenSite ? route('admin.work-sites.show', $chosenSite) : route('admin.site-zones.index')); ?>" class="cancel-btn">Cancel</a><button class="save-btn" type="submit"><?php echo e($submitLabel); ?></button></div>

<style>
.zone-alert{padding:12px 15px;margin-bottom:16px;border:1px solid #7f3340;background:#311a22;color:#ffabb8;border-radius:10px}.zone-alert ul{margin:0;padding-left:20px}.zone-form-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:16px}.form-group{display:flex;flex-direction:column;gap:7px}.form-group.full{grid-column:1/-1}.form-group label{font-size:12px;font-weight:800;color:#b9c4d8}.form-group input,.form-group select,.form-group textarea{width:100%;box-sizing:border-box;border:1px solid #303b55;border-radius:10px;background:#101624;color:#fff;padding:11px 12px;outline:none}.form-group input:focus,.form-group select:focus,.form-group textarea:focus{border-color:#4a79e8}.form-actions{display:flex;justify-content:flex-end;gap:10px;margin-top:20px}.cancel-btn,.save-btn{border:0;border-radius:9px;padding:10px 17px;font-weight:800;text-decoration:none;cursor:pointer}.cancel-btn{background:#263047;color:#d8e0ef}.save-btn{background:#3f6fe0;color:#fff}@media(max-width:700px){.zone-form-grid{grid-template-columns:1fr}.form-group.full{grid-column:auto}.form-actions>*{flex:1;text-align:center}}
</style>
<?php /**PATH C:\xampp\htdocs\ageless-admin-panel\resources\views\admin\site_zones\_form.blade.php ENDPATH**/ ?>