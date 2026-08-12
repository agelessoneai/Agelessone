<?php $__env->startSection('page-title', 'Add Wage Entry'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .wage-form-card { background: var(--panel, #151b29); border: 1px solid var(--line, #262f47); border-radius: 16px; padding: 28px; max-width: 700px; margin: 0 auto; }
    .wage-form-card h4 { margin: 0 0 6px; color: #fff; font-weight: 700; }
    .wage-form-card .sub { color: #8794ac; font-size: 13px; margin-bottom: 22px; }
    .wage-form-card label { color: #c0cce0; font-size: 13px; font-weight: 600; margin-bottom: 6px; display: block; }
    .wage-form-card .form-control { background: #0e1320; border: 1px solid #262f47; color: #e8edf6; border-radius: 10px; padding: 10px 14px; }
    .wage-form-card .form-control:focus { border-color: #3f6fe0; box-shadow: 0 0 0 2px rgba(63,111,224,.15); }
    .calc-preview { background: linear-gradient(135deg, #1c2436, #131a28); border: 1px solid #262f47; border-radius: 12px; padding: 18px; margin-top: 18px; }
    .calc-row { display: flex; justify-content: space-between; padding: 6px 0; font-size: 13px; }
    .calc-row .lbl { color: #8794ac; }
    .calc-row .val { color: #e8edf6; font-weight: 700; }
    .calc-row.total { border-top: 1px solid #262f47; padding-top: 10px; margin-top: 6px; }
    .calc-row.total .val { color: #37c281; font-size: 18px; }
    .calc-row.ot .val { color: #f2b53b; }
</style>

<div class="wage-form-card">
    <h4>💰 Add Wage Entry</h4>
    <p class="sub">Select a work site and worker to enter wage details.</p>

    <form method="POST" action="<?php echo e(route('admin.wages.store')); ?>" id="wageForm">
        <?php echo csrf_field(); ?>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="work_site_id">Work Site <span class="text-danger">*</span></label>
                <select class="form-control" id="work_site_id" name="work_site_id" required onchange="filterWorkers()">
                    <option value="">— Select Work Site —</option>
                    <?php $__currentLoopData = $workSites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $site): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($site->id); ?>" <?php echo e(old('work_site_id') == $site->id ? 'selected' : ''); ?>><?php echo e($site->site_name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['work_site_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6 mb-3">
                <label for="worker_id">Worker <span class="text-danger">*</span></label>
                <select class="form-control" id="worker_id" name="worker_id" required onchange="updateWorkerInfo()" disabled>
                    <option value="">— Select Worker —</option>
                    <?php $__currentLoopData = $workers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $w): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($w->id); ?>"
                            data-site-id="<?php echo e($w->work_site_id); ?>"
                            data-daily="<?php echo e($w->daily_wage); ?>"
                            data-ot-rate="<?php echo e($w->overtime_rate); ?>"
                            data-std-hours="<?php echo e($w->standard_hours ?? 8); ?>"
                            <?php echo e(old('worker_id') == $w->id ? 'selected' : ''); ?>

                            style="display:none;">
                            <?php echo e($w->name); ?> (<?php echo e($w->worker_code); ?>) — Daily: ₹<?php echo e(number_format($w->daily_wage, 2)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php $__errorArgs = ['worker_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date">Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="date" name="date" value="<?php echo e(old('date', now()->format('Y-m-d'))); ?>" required>
                <?php $__errorArgs = ['date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6 mb-3">
                <label for="hours_worked">Hours Worked <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="hours_worked" name="hours_worked" value="<?php echo e(old('hours_worked', 8)); ?>" min="0" max="24" step="0.5" required oninput="calculateWage()">
                <?php $__errorArgs = ['hours_worked'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="base_wage">Base Daily Wage (₹)</label>
                <input type="number" class="form-control" id="base_wage" name="base_wage" placeholder="e.g. 8000" value="<?php echo e(old('base_wage')); ?>" min="0" step="0.01" oninput="calculateWage()">
                <?php $__errorArgs = ['base_wage'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
            <div class="col-md-6 mb-3">
                <label for="overtime_rate">Overtime Rate (₹/hr)</label>
                <input type="number" class="form-control" id="overtime_rate" name="overtime_rate" placeholder="e.g. 1000" value="<?php echo e(old('overtime_rate')); ?>" min="0" step="0.01" oninput="calculateWage()">
                <?php $__errorArgs = ['overtime_rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="text-danger small mt-1"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>
        </div>

        <div class="mb-3">
            <label for="notes">Notes (optional)</label>
            <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Any remarks about this wage entry"><?php echo e(old('notes')); ?></textarea>
        </div>

        
        <div class="calc-preview" id="calcPreview" style="display:none;">
            <div class="calc-row"><span class="lbl">Standard Hours</span><span class="val" id="pvStdHrs">8h</span></div>
            <div class="calc-row"><span class="lbl">Hours Worked</span><span class="val" id="pvHrsWorked">8h</span></div>
            <div class="calc-row"><span class="lbl">Base Wage (daily)</span><span class="val" id="pvBase">₹0</span></div>
            <div class="calc-row ot"><span class="lbl">Overtime Hours</span><span class="val" id="pvOtHrs">0h</span></div>
            <div class="calc-row ot"><span class="lbl">Overtime Pay</span><span class="val" id="pvOtPay">₹0</span></div>
            <div class="calc-row total"><span class="lbl">💰 Total Wage</span><span class="val" id="pvTotal">₹0</span></div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="<?php echo e(route('admin.wages.index')); ?>" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary px-5">Save Wage Entry</button>
        </div>
    </form>
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let currentStdHours = 8;

function updateWorkerInfo() {
    const sel = document.getElementById('worker_id');
    const opt = sel.options[sel.selectedIndex];

    if (opt && opt.value) {
        const daily = parseFloat(opt.dataset.daily) || 0;
        const otRate = parseFloat(opt.dataset.otRate) || 0;
        currentStdHours = parseFloat(opt.dataset.stdHours) || 8;

        document.getElementById('base_wage').value = daily;
        document.getElementById('overtime_rate').value = otRate;
    }
    calculateWage();
}

function calculateWage() {
    const sel = document.getElementById('worker_id');
    const opt = sel.options[sel.selectedIndex];
    const preview = document.getElementById('calcPreview');

    if (!opt || !opt.value) { preview.style.display = 'none'; return; }

    preview.style.display = 'block';

    const daily    = parseFloat(document.getElementById('base_wage').value) || 0;
    const otRate   = parseFloat(document.getElementById('overtime_rate').value) || 0;
    const stdHrs   = currentStdHours;
    const hrsInput = parseFloat(document.getElementById('hours_worked').value) || 0;

    const otHrs  = Math.max(0, hrsInput - stdHrs);
    const otPay  = otHrs * otRate;
    const total  = daily + otPay;

    document.getElementById('pvStdHrs').textContent     = stdHrs + 'h';
    document.getElementById('pvHrsWorked').textContent   = hrsInput + 'h';
    document.getElementById('pvBase').textContent        = '₹' + daily.toLocaleString('en-IN', {minimumFractionDigits: 2});
    document.getElementById('pvOtHrs').textContent       = otHrs > 0 ? '+' + otHrs + 'h' : '0h';
    document.getElementById('pvOtPay').textContent       = otHrs > 0 ? '+₹' + otPay.toLocaleString('en-IN', {minimumFractionDigits: 2}) : '₹0.00';
    document.getElementById('pvTotal').textContent       = '₹' + total.toLocaleString('en-IN', {minimumFractionDigits: 2});
}

function filterWorkers() {
    const siteId = document.getElementById('work_site_id').value;
    const workerSelect = document.getElementById('worker_id');
    const options = workerSelect.querySelectorAll('option');

    workerSelect.value = '';
    workerSelect.disabled = !siteId;

    options.forEach(opt => {
        if (!opt.value) return; // Keep "Select Worker" always hidden or just default
        opt.style.display = opt.dataset.siteId === siteId ? 'block' : 'none';
    });
    updateWorkerInfo();
}

document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('work_site_id').value) {
        filterWorkers();
        if ("<?php echo e(old('worker_id')); ?>") {
            document.getElementById('worker_id').value = "<?php echo e(old('worker_id')); ?>";
        }
        updateWorkerInfo();
    }
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Agelessone\resources\views/admin/wages/global-create.blade.php ENDPATH**/ ?>