@extends('layouts.admin')

@section('page-title', 'Add Wage Entry')

@section('content')
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

    <form method="POST" action="{{ route('admin.wages.store') }}" id="wageForm">
        @csrf

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="work_site_id">Work Site <span class="text-danger">*</span></label>
                <select class="form-control" id="work_site_id" name="work_site_id" required onchange="filterWorkers()">
                    <option value="">— Select Work Site —</option>
                    @foreach($workSites as $site)
                        <option value="{{ $site->id }}" {{ old('work_site_id') == $site->id ? 'selected' : '' }}>{{ $site->site_name }}</option>
                    @endforeach
                </select>
                @error('work_site_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="worker_id">Worker <span class="text-danger">*</span></label>
                <select class="form-control" id="worker_id" name="worker_id" required onchange="updateWorkerInfo()" disabled>
                    <option value="">— Select Worker —</option>
                    @foreach($workers as $w)
                        <option value="{{ $w->id }}"
                            data-site-id="{{ $w->work_site_id }}"
                            data-daily="{{ $w->daily_wage }}"
                            data-ot-rate="{{ $w->overtime_rate }}"
                            data-std-hours="{{ $w->standard_hours ?? 8 }}"
                            {{ old('worker_id') == $w->id ? 'selected' : '' }}
                            style="display:none;">
                            {{ $w->name }} ({{ $w->worker_code }}) — Daily: ₹{{ number_format($w->daily_wage, 2) }}
                        </option>
                    @endforeach
                </select>
                @error('worker_id') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date">Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="date" name="date" value="{{ old('date', now()->format('Y-m-d')) }}" required>
                @error('date') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="hours_worked">Hours Worked <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="hours_worked" name="hours_worked" value="{{ old('hours_worked', 8) }}" min="0" max="24" step="0.5" required oninput="calculateWage()">
                @error('hours_worked') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="base_wage">Base Daily Wage (₹)</label>
                <input type="number" class="form-control" id="base_wage" name="base_wage" placeholder="e.g. 8000" value="{{ old('base_wage') }}" min="0" step="0.01" oninput="calculateWage()">
                @error('base_wage') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="overtime_rate">Overtime Rate (₹/hr)</label>
                <input type="number" class="form-control" id="overtime_rate" name="overtime_rate" placeholder="e.g. 1000" value="{{ old('overtime_rate') }}" min="0" step="0.01" oninput="calculateWage()">
                @error('overtime_rate') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="notes">Notes (optional)</label>
            <textarea class="form-control" id="notes" name="notes" rows="2" placeholder="Any remarks about this wage entry">{{ old('notes') }}</textarea>
        </div>

        {{-- Live Calculation Preview --}}
        <div class="calc-preview" id="calcPreview" style="display:none;">
            <div class="calc-row"><span class="lbl">Standard Hours</span><span class="val" id="pvStdHrs">8h</span></div>
            <div class="calc-row"><span class="lbl">Hours Worked</span><span class="val" id="pvHrsWorked">8h</span></div>
            <div class="calc-row"><span class="lbl">Base Wage (daily)</span><span class="val" id="pvBase">₹0</span></div>
            <div class="calc-row ot"><span class="lbl">Overtime Hours</span><span class="val" id="pvOtHrs">0h</span></div>
            <div class="calc-row ot"><span class="lbl">Overtime Pay</span><span class="val" id="pvOtPay">₹0</span></div>
            <div class="calc-row total"><span class="lbl">💰 Total Wage</span><span class="val" id="pvTotal">₹0</span></div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('admin.wages.index') }}" class="btn btn-outline-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary px-5">Save Wage Entry</button>
        </div>
    </form>
</div>

@endsection

@push('scripts')
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
        if ("{{ old('worker_id') }}") {
            document.getElementById('worker_id').value = "{{ old('worker_id') }}";
        }
        updateWorkerInfo();
    }
});
</script>
@endpush
