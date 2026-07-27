@extends('layouts.mobile')
@section('title', 'My Expenses')
@section('content')
<div class="mobile-head">
    <div><div class="eyebrow">STAFF EXPENSES</div><h1>My Expenses</h1></div>
    <form method="POST" action="{{ route('logout') }}">@csrf<button class="icon-btn">↪</button></form>
</div>

<div class="hero-card">
    <div class="muted">Submit bills and expenses</div>
    <h2>New Expense</h2>
    <p class="mb-0">Accounts and Admin can review every submission.</p>
</div>

<div class="app-card">
    <form method="POST" action="{{ route('expenses.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3"><label class="form-label">Expense Date</label><input type="date" name="expense_date" value="{{ old('expense_date', now()->toDateString()) }}" class="form-control" required></div>
        <div class="mb-3"><label class="form-label">Project / Work Site</label><select name="work_site_id" class="form-select"><option value="">Office / General Expense</option>@foreach($workSites as $site)<option value="{{ $site->id }}" @selected(old('work_site_id') == $site->id)>{{ $site->site_name }}</option>@endforeach</select></div>
        <div class="mb-3"><label class="form-label">What was this expense for?</label><input name="purpose" value="{{ old('purpose') }}" class="form-control" placeholder="Fuel, material, travel, food..." required></div>
        <div class="mb-3"><label class="form-label">Amount</label><input type="number" step="0.01" min="0.01" name="amount" value="{{ old('amount') }}" class="form-control" placeholder="0.00" required></div>
        <div class="mb-3"><label class="form-label">Details</label><textarea name="description" class="form-control" rows="3" placeholder="Vendor, location, reason or other details">{{ old('description') }}</textarea></div>
        <div class="mb-3"><label class="form-label">Bill / Receipt Photo</label><input type="file" name="bill" accept="image/*,.pdf" capture="environment" class="camera-input"><small class="muted">Photo or PDF, maximum 10 MB.</small></div>
        <button class="app-btn primary" type="submit">Submit Expense</button>
    </form>
</div>

<div class="app-card">
    <div class="row-between mb-2"><h3>Submission History</h3><span class="muted">{{ $expenses->total() }} records</span></div>
    @forelse($expenses as $expense)
        <div class="list-row">
            <div class="row-between"><strong>{{ $expense->purpose }}</strong><strong>{{ number_format($expense->amount, 2) }}</strong></div>
            <div class="muted small">{{ $expense->expense_date->format('d M Y') }} · {{ $expense->workSite?->site_name ?? 'Office / General' }}</div>
            <div class="row-between mt-2">
                <span class="status-pill {{ $expense->status === 'approved' ? 'active' : ($expense->status === 'rejected' ? 'rejected' : 'pending') }}">{{ ucfirst($expense->status) }}</span>
                <div class="d-flex gap-2">
                    @if($expense->bill_path)<a class="btn btn-sm btn-outline-light" target="_blank" href="{{ Storage::url($expense->bill_path) }}">Bill</a>@endif
                    @if($expense->status === 'pending')<form method="POST" action="{{ route('expenses.destroy', $expense) }}" onsubmit="return confirm('Delete this pending expense?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form>@endif
                </div>
            </div>
            @if($expense->review_note)<div class="small mt-2">Review: {{ $expense->review_note }}</div>@endif
        </div>
    @empty<div class="muted py-3">No expenses submitted yet.</div>@endforelse
    <div class="mt-3">{{ $expenses->links() }}</div>
</div>
@endsection
