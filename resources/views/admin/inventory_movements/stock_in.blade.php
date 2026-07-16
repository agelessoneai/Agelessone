@extends('layouts.admin')

@section('title', 'Stock In')

@section('content')

<div class="page-head">
    <div>
        <h2>Stock In</h2>
        <p class="muted mb-0">Receive inventory and increase available stock.</p>
    </div>

    <a href="{{ route('admin.inventory-movements') }}" class="btn-back">
        ← Movement History
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card-dark movement-card">

    <form method="POST" action="{{ route('admin.inventory.stock-in.store') }}">
        @csrf

        <div class="form-grid">

            <div class="field full-width">
                <label class="form-label">Inventory Item *</label>

                <select name="inventory_item_id" id="inventoryItem" class="form-select" required>
                    <option value="">Select Item</option>

                    @foreach($items as $item)
                        <option
                            value="{{ $item->id }}"
                            data-stock="{{ $item->stock }}"
                            data-unit="{{ $item->unit }}"
                            data-warehouse="{{ $item->warehouse }}"
                            {{ old('inventory_item_id') == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->item_name }}
                            ({{ $item->item_code }})
                            — {{ $item->category->name ?? 'No Category' }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="form-label">Current Stock</label>
                <input id="currentStock" class="form-control" value="-" readonly>
            </div>

            <div class="field">
                <label class="form-label">Quantity Received *</label>
                <input
                    type="number"
                    name="quantity"
                    class="form-control"
                    min="1"
                    value="{{ old('quantity', 1) }}"
                    required
                >
            </div>

            <div class="field">
                <label class="form-label">Reference Number</label>
                <input
                    type="text"
                    name="reference_no"
                    class="form-control"
                    value="{{ old('reference_no') }}"
                    placeholder="PO, GRN or invoice number"
                >
            </div>

            <div class="field">
                <label class="form-label">Warehouse</label>
                <input
                    type="text"
                    name="warehouse"
                    id="warehouse"
                    class="form-control"
                    value="{{ old('warehouse') }}"
                    placeholder="Main Warehouse"
                >
            </div>

            <div class="field full-width">
                <label class="form-label">Note</label>
                <textarea
                    name="note"
                    class="form-control"
                    rows="4"
                    placeholder="Supplier, received condition or other details"
                >{{ old('note') }}</textarea>
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ route('admin.inventory-items') }}" class="btn-back">
                Cancel
            </a>

            <button type="submit" class="btn-green">
                📥 Add Stock
            </button>
        </div>

    </form>

</div>

@include('admin.inventory_movements.partials.styles')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('inventoryItem');
    const currentStock = document.getElementById('currentStock');
    const warehouse = document.getElementById('warehouse');

    function updateItemDetails() {
        const option = select.options[select.selectedIndex];

        if (!option || !option.value) {
            currentStock.value = '-';
            return;
        }

        currentStock.value =
            option.dataset.stock + ' ' + option.dataset.unit.toUpperCase();

        if (!warehouse.value) {
            warehouse.value = option.dataset.warehouse || '';
        }
    }

    select.addEventListener('change', updateItemDetails);
    updateItemDetails();
});
</script>

@endsection