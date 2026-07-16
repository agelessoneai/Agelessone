@extends('layouts.admin')

@section('title', 'Stock Out')

@section('content')

<div class="page-head">
    <div>
        <h2>Stock Out</h2>
        <p class="muted mb-0">Issue inventory and reduce available stock.</p>
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

    <form method="POST" action="{{ route('admin.inventory.stock-out.store') }}">
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
                            — Available: {{ $item->stock }} {{ strtoupper($item->unit) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="form-label">Available Stock</label>
                <input id="currentStock" class="form-control" value="-" readonly>
            </div>

            <div class="field">
                <label class="form-label">Quantity Issued *</label>
                <input
                    type="number"
                    name="quantity"
                    id="quantity"
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
                    placeholder="Request or issue number"
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
                >
            </div>

            <div class="field full-width">
                <label class="form-label">Issue Note</label>
                <textarea
                    name="note"
                    class="form-control"
                    rows="4"
                    placeholder="Site, zone, employee or purpose"
                >{{ old('note') }}</textarea>
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ route('admin.inventory-items') }}" class="btn-back">
                Cancel
            </a>

            <button type="submit" class="btn-red">
                📤 Issue Stock
            </button>
        </div>

    </form>

</div>

@include('admin.inventory_movements.partials.styles')

<script>
document.addEventListener('DOMContentLoaded', function () {
    const select = document.getElementById('inventoryItem');
    const currentStock = document.getElementById('currentStock');
    const quantity = document.getElementById('quantity');
    const warehouse = document.getElementById('warehouse');

    function updateItemDetails() {
        const option = select.options[select.selectedIndex];

        if (!option || !option.value) {
            currentStock.value = '-';
            quantity.removeAttribute('max');
            return;
        }

        const stock = parseInt(option.dataset.stock || '0');

        currentStock.value =
            stock + ' ' + option.dataset.unit.toUpperCase();

        quantity.max = stock;

        if (!warehouse.value) {
            warehouse.value = option.dataset.warehouse || '';
        }
    }

    select.addEventListener('change', updateItemDetails);
    updateItemDetails();
});
</script>

@endsection