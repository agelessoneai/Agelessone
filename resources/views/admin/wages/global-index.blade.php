@extends('layouts.admin')

@section('page-title', 'Worker Wages Management')

@section('content')
<style>
    .wage-card { background: var(--panel, #151b29); border: 1px solid var(--line, #262f47); border-radius: 16px; padding: 22px; }
    .wage-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; margin-bottom: 20px; }
    .wage-header h4 { margin: 0; color: #fff; font-weight: 700; }
    .wage-header p { margin: 4px 0 0; color: #8794ac; font-size: 13px; }
    .wage-filters { display: flex; gap: 12px; flex-wrap: wrap; align-items: end; }
    .wage-filters select, .wage-filters input { background: #0e1320; border: 1px solid #262f47; color: #e8edf6; padding: 8px 12px; border-radius: 8px; font-size: 13px; }
    .wage-table { width: 100%; color: #e8edf6; }
    .wage-table thead th { padding: 12px 14px; background: #0e1320; color: #8794ac; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; border-bottom: 1px solid #262f47; white-space: nowrap; }
    .wage-table tbody td { padding: 12px 14px; border-bottom: 1px solid #1c2436; font-size: 13px; }
    .wage-table tbody tr:hover { background: rgba(63,111,224,.06); }
    .total-bar { display: flex; justify-content: space-between; align-items: center; padding: 14px 18px; background: linear-gradient(135deg, #1c2436, #151b29); border: 1px solid #262f47; border-radius: 12px; margin-top: 16px; }
    .total-bar .label { color: #8794ac; font-size: 13px; font-weight: 600; }
    .total-bar .amount { color: #37c281; font-size: 20px; font-weight: 800; }
    .badge-ot { background: rgba(242,181,59,.15); color: #f2b53b; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 700; }
    .badge-site { background: rgba(63,111,224,.15); color: #6389e5; padding: 3px 8px; border-radius: 6px; font-size: 11px; font-weight: 600; }
</style>

<div class="wage-card">
    <div class="wage-header">
        <div>
            <h4>💰 All Worker Wages</h4>
            <p>View, filter, and track worker wages and overtime across all work sites.</p>
        </div>
        @if($selectedSite)
            <a href="{{ route('admin.work-sites.wages.create', $selectedSite) }}" class="btn btn-primary d-flex align-items-center gap-2">
                <span>➕</span> Add Wage Entry ({{ $selectedSite->site_name }})
            </a>
        @endif
    </div>

    {{-- Filters --}}
    <form method="GET" class="wage-filters mb-4">
        <div>
            <label class="text-muted small d-block mb-1">Work Site</label>
            <select name="work_site_id" onchange="this.form.submit()">
                <option value="">All Work Sites</option>
                @foreach($workSites as $site)
                    <option value="{{ $site->id }}" {{ request('work_site_id') == $site->id ? 'selected' : '' }}>{{ $site->site_name }}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-muted small d-block mb-1">Worker</label>
            <select name="worker_id" onchange="this.form.submit()">
                <option value="">All Workers</option>
                @foreach($workers as $w)
                    <option value="{{ $w->id }}" {{ request('worker_id') == $w->id ? 'selected' : '' }}>{{ $w->name }} ({{ $w->worker_code }})</option>
                @endforeach
            </select>
        </div>
        <div>
            <label class="text-muted small d-block mb-1">Month</label>
            <input type="month" name="month" value="{{ request('month') }}" onchange="this.form.submit()">
        </div>
        @if(request()->anyFilled(['work_site_id', 'worker_id', 'month']))
            <div>
                <label class="d-block mb-1">&nbsp;</label>
                <a href="{{ route('admin.wages.index') }}" class="btn btn-sm btn-outline-secondary">Reset Filters</a>
            </div>
        @endif
    </form>

    <div class="table-responsive">
        <table class="wage-table">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Work Site</th>
                    <th>Worker</th>
                    <th>Hours</th>
                    <th>OT Hours</th>
                    <th>Base Wage</th>
                    <th>OT Pay</th>
                    <th>Total</th>
                    <th>Recorded By</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($wages as $wage)
                    <tr>
                        <td>{{ $wage->date->format('d M Y') }}</td>
                        <td><span class="badge-site">{{ $wage->workSite->site_name ?? 'N/A' }}</span></td>
                        <td><strong>{{ $wage->worker->name ?? 'N/A' }}</strong></td>
                        <td>{{ $wage->hours_worked }}h</td>
                        <td>
                            @if($wage->overtime_hours > 0)
                                <span class="badge-ot">+{{ $wage->overtime_hours }}h OT</span>
                            @else
                                —
                            @endif
                        </td>
                        <td>₹{{ number_format($wage->base_wage, 2) }}</td>
                        <td>
                            @if($wage->overtime_pay > 0)
                                <span class="text-warning">+₹{{ number_format($wage->overtime_pay, 2) }}</span>
                            @else
                                —
                            @endif
                        </td>
                        <td><strong class="text-success">₹{{ number_format($wage->total_wage, 2) }}</strong></td>
                        <td class="text-muted">{{ $wage->recordedBy->name ?? '—' }}</td>
                        <td class="text-end">
                            <div class="d-inline-flex gap-2">
                                <a href="{{ route('admin.wages.edit', $wage) }}" class="btn btn-sm btn-outline-warning py-1 px-2" title="Edit Wage Entry">✏️ Edit</a>
                                <form method="POST" action="{{ route('admin.wages.destroy', $wage) }}" onsubmit="return confirm('Are you sure you want to delete this wage entry?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-2" title="Delete Entry">🗑️</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" class="text-center py-4 text-muted">No wage records found. Filter by work site to add entries.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($wages->count())
        <div class="total-bar">
            <span class="label">Total Wages (filtered)</span>
            <span class="amount">₹{{ number_format($totalWage, 2) }}</span>
        </div>
    @endif

    <div class="mt-3">
        {{ $wages->links() }}
    </div>
</div>
@endsection
