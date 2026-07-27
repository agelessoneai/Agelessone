@extends('layouts.admin')

@section('title', 'Inventory Item Details')

@section('content')
<div class="page-head">
    <div>
        <h2>{{ $inventoryItem->item_name }}</h2>
        <p class="muted mb-0">{{ $inventoryItem->item_code }} · {{ $inventoryItem->category?->name ?? 'Uncategorised' }}</p>
    </div>
    <div style="display:flex;gap:10px;flex-wrap:wrap">
        <a href="{{ route('admin.inventory-items.edit', $inventoryItem) }}" class="btn-blue">Edit Item</a>
        <a href="{{ route('admin.inventory-items') }}" class="btn-back">← Back</a>
    </div>
</div>

<div class="card-dark" style="margin-bottom:20px">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(210px,1fr));gap:18px">
        <div><span class="muted">Current Stock</span><h3>{{ $inventoryItem->stock }} {{ $inventoryItem->unit }}</h3></div>
        <div><span class="muted">Warehouse / Rack</span><h3>{{ $inventoryItem->warehouse }}{{ $inventoryItem->rack ? ' / '.$inventoryItem->rack : '' }}</h3></div>
        <div><span class="muted">Brand / Model</span><h3>{{ $inventoryItem->brand ?: '-' }} {{ $inventoryItem->model }}</h3></div>
        <div><span class="muted">Supplier</span><h3>{{ $inventoryItem->supplier ?: 'Not specified' }}</h3></div>
    </div>

    <hr style="opacity:.15;margin:22px 0">
    <h4>What this item is used for</h4>
    <p style="white-space:pre-line">{{ $inventoryItem->usage_purpose ?: 'Usage purpose has not been entered.' }}</p>

    @if($inventoryItem->description)
        <h4>Description</h4>
        <p style="white-space:pre-line">{{ $inventoryItem->description }}</p>
    @endif
</div>

<div class="card-dark" style="overflow:auto">
    <h3>Movement & Site Usage History</h3>
    <table class="table" style="min-width:900px">
        <thead><tr><th>Date</th><th>Movement</th><th>Qty</th><th>Stock</th><th>Site</th><th>Used For</th><th>Issued To</th></tr></thead>
        <tbody>
        @forelse($inventoryItem->movements as $movement)
            <tr>
                <td>{{ $movement->created_at?->format('d M Y, h:i A') }}</td>
                <td>{{ ucwords(str_replace('_',' ', $movement->type)) }}</td>
                <td>{{ $movement->quantity }} {{ $inventoryItem->unit }}</td>
                <td>{{ $movement->previous_stock }} → {{ $movement->new_stock }}</td>
                <td>{{ $movement->workSite?->site_name ?? 'Warehouse / General' }}</td>
                <td>{{ $movement->used_for ?: '-' }}</td>
                <td>{{ $movement->issued_to ?: '-' }}</td>
            </tr>
        @empty
            <tr><td colspan="7" class="text-center muted">No movement history available.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
@endsection
