@extends('layouts.app')

@section('content')
<style>
    :root { --bg:#0e1320; --card:#151b29; --line:#262f47; --text:#e8edf6; --muted:#8794ac; --blue:#3f6fe0; --green:#37c281; --orange:#f2b53b; }
    body { margin:0; background:var(--bg); color:var(--text); font-family:'Segoe UI',system-ui,sans-serif; }
    .navbar,header { display:none!important; }
    .mobile-app-shell { max-width:100%!important; margin:0!important; border-radius:0!important; border:0!important; min-height:100vh!important; }
    .app-content { padding:0!important; }
    .container { max-width:100%!important; padding:0!important; margin:0!important; }
    .wage-wrap { min-height:100vh; padding:18px; padding-bottom:92px; background:var(--bg); }
    .wage-form-card { background:var(--card); border:1px solid var(--line); border-radius:16px; padding:22px; }
    .wage-form-card h4 { margin:0 0 6px; color:#fff; font-weight:700; }
    .wage-form-card .sub { color:var(--muted); font-size:13px; margin-bottom:18px; }
    .wage-form-card label { color:#c0cce0; font-size:13px; font-weight:600; margin-bottom:5px; display:block; }
    .wage-form-card .form-control { background:#0e1320; border:1px solid var(--line); color:var(--text); border-radius:10px; padding:10px 14px; }
    .wage-form-card .form-control:focus { border-color:var(--blue); box-shadow:0 0 0 2px rgba(63,111,224,.15); }
    .calc-preview { background:linear-gradient(135deg,#1c2436,#131a28); border:1px solid var(--line); border-radius:12px; padding:16px; margin-top:16px; }
    .calc-row { display:flex; justify-content:space-between; padding:5px 0; font-size:13px; }
    .calc-row .lbl { color:var(--muted); }
    .calc-row .val { color:var(--text); font-weight:700; }
    .calc-row.total { border-top:1px solid var(--line); padding-top:10px; margin-top:6px; }
    .calc-row.total .val { color:var(--green); font-size:18px; }
    .calc-row.ot .val { color:var(--orange); }
</style>

<div class="wage-wrap">
    <h5 class="text-white mb-3">💰 Edit Worker Wage</h5>
    <div class="wage-form-card">
    <h4>✏️ Edit Wage Entry</h4>
    <p class="sub">Worker: <strong>{{ $wage->worker->name }}</strong> ({{ $wage->workSite->site_name ?? 'N/A' }})</p>

    <form method="POST" action="{{ route('supervisor.wages.update', $wage) }}">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="date">Date <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="date" name="date" value="{{ old('date', $wage->date->format('Y-m-d')) }}" required>
                @error('date') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="hours_worked">Hours Worked <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="hours_worked" name="hours_worked" value="{{ old('hours_worked', $wage->hours_worked) }}" min="0" max="24" step="0.5" required oninput="calculateWage()">
                @error('hours_worked') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label for="base_wage">Base Daily Wage (₹) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="base_wage" name="base_wage" value="{{ old('base_wage', $wage->base_wage) }}" min="0" step="0.01" required oninput="calculateWage()">
                @error('base_wage') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
            <div class="col-md-6 mb-3">
                <label for="overtime_rate">Overtime Rate (₹/hr) <span class="text-danger">*</span></label>
                <input type="number" class="form-control" id="overtime_rate" name="overtime_rate" value="{{ old('overtime_rate', $wage->overtime_rate) }}" min="0" step="0.01" required oninput="calculateWage()">
                @error('overtime_rate') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="mb-3">
            <label for="notes">Notes (optional)</label>
            <textarea class="form-control" id="notes" name="notes" rows="2">{{ old('notes', $wage->notes) }}</textarea>
        </div>

        {{-- Live Calculation Preview --}}
        <div class="calc-preview" id="calcPreview">
            <div class="calc-row"><span class="lbl">Standard Hours</span><span class="val" id="pvStdHrs">{{ $wage->worker->standard_hours ?? 8 }}h</span></div>
            <div class="calc-row"><span class="lbl">Hours Worked</span><span class="val" id="pvHrsWorked">0h</span></div>
            <div class="calc-row"><span class="lbl">Base Wage (daily)</span><span class="val" id="pvBase">₹0</span></div>
            <div class="calc-row ot"><span class="lbl">Overtime Hours</span><span class="val" id="pvOtHrs">0h</span></div>
            <div class="calc-row ot"><span class="lbl">Overtime Pay</span><span class="val" id="pvOtPay">₹0</span></div>
            <div class="calc-row total"><span class="lbl">💰 Total Wage</span><span class="val" id="pvTotal">₹0</span></div>
        </div>

        <button type="submit" class="btn btn-primary w-100 mt-4 py-2">Update Wage Entry</button>
    </form>
</div>
<a href="{{ route('supervisor.wages.create') }}" class="btn btn-outline-secondary w-100 mt-3">← Back to Wage Entries</a>
</div>

<script>
function calculateWage() {
    const stdHrs   = {{ $wage->worker->standard_hours ?? 8 }};
    const daily    = parseFloat(document.getElementById('base_wage').value) || 0;
    const otRate   = parseFloat(document.getElementById('overtime_rate').value) || 0;
    const hrsInput = parseFloat(document.getElementById('hours_worked').value) || 0;

    const otHrs  = Math.max(0, hrsInput - stdHrs);
    const otPay  = otHrs * otRate;
    const total  = daily + otPay;

    document.getElementById('pvStdHrs').textContent      = stdHrs + 'h';
    document.getElementById('pvHrsWorked').textContent   = hrsInput + 'h';
    document.getElementById('pvBase').textContent        = '₹' + daily.toLocaleString('en-IN', {minimumFractionDigits: 2});
    document.getElementById('pvOtHrs').textContent       = otHrs > 0 ? '+' + otHrs + 'h' : '0h';
    document.getElementById('pvOtPay').textContent       = otHrs > 0 ? '+₹' + otPay.toLocaleString('en-IN', {minimumFractionDigits: 2}) : '₹0.00';
    document.getElementById('pvTotal').textContent       = '₹' + total.toLocaleString('en-IN', {minimumFractionDigits: 2});
}

document.addEventListener('DOMContentLoaded', calculateWage);
</script>
@endsection
