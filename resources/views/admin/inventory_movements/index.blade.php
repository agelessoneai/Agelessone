@extends('layouts.admin')

@section('title', 'Inventory Movements')

@section('content')

<div class="page-head">
    <div>
        <h2>Inventory Movement History</h2>
        <p class="muted mb-0">
            Track every stock-in, stock-out, return, transfer and adjustment.
        </p>
    </div>

    <div class="head-actions">
        <a href="{{ route('admin.inventory.stock-in') }}" class="btn-green">
            📥 Stock In
        </a>

        <a href="{{ route('admin.inventory.stock-out') }}" class="btn-red">
            📤 Stock Out
        </a>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card-dark filter-card">

    <form method="GET" action="{{ route('admin.inventory-movements') }}">

        <div class="filter-grid">

            <div>
                <label class="form-label">Search</label>

                <input
                    type="search"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Item, code, reference, warehouse..."
                >
            </div>

            <div>
                <label class="form-label">Movement Type</label>

                <select name="type" class="form-select">
                    <option value="">All Types</option>

                    <option value="stock_in" {{ request('type') === 'stock_in' ? 'selected' : '' }}>
                        Stock In
                    </option>

                    <option value="stock_out" {{ request('type') === 'stock_out' ? 'selected' : '' }}>
                        Stock Out
                    </option>

                    <option value="adjustment" {{ request('type') === 'adjustment' ? 'selected' : '' }}>
                        Adjustment
                    </option>

                    <option value="return" {{ request('type') === 'return' ? 'selected' : '' }}>
                        Return
                    </option>

                    <option value="transfer" {{ request('type') === 'transfer' ? 'selected' : '' }}>
                        Transfer
                    </option>
                </select>
            </div>

            <div>
                <label class="form-label">Inventory Item</label>

                <select name="item_id" class="form-select">
                    <option value="">All Items</option>

                    @foreach($items as $item)
                        <option
                            value="{{ $item->id }}"
                            {{ request('item_id') == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->item_name }} ({{ $item->item_code }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-blue">
                    Filter
                </button>

                <a href="{{ route('admin.inventory-movements') }}" class="btn-back">
                    Reset
                </a>
            </div>

        </div>

    </form>

</div>

<div class="card-dark">

    <div class="table-responsive">

        <table class="table movement-table">

            <thead>
                <tr>
                    <th>Date</th>
                    <th>Item</th>
                    <th>Type</th>
                    <th>Quantity</th>
                    <th>Previous</th>
                    <th>New Stock</th>
                    <th>Reference</th>
                    <th>Warehouse</th>
                    <th>Entered By</th>
                    <th>Note</th>
                </tr>
            </thead>

            <tbody>

                @forelse($movements as $movement)

                    <tr>

                        <td>
                            <strong>
                                {{ $movement->created_at->format('d M Y') }}
                            </strong>

                            <div class="small-muted">
                                {{ $movement->created_at->format('h:i A') }}
                            </div>
                        </td>

                        <td>
                            <strong>{{ $movement->item->item_name ?? '-' }}</strong>

                            <div class="small-muted">
                                {{ $movement->item->item_code ?? '-' }}
                            </div>

                            <div class="small-muted">
                                {{ $movement->item->category->name ?? '-' }}
                            </div>
                        </td>

                        <td>
                            @php
                                $typeClasses = [
                                    'stock_in' => 'type-in',
                                    'stock_out' => 'type-out',
                                    'adjustment' => 'type-adjustment',
                                    'return' => 'type-return',
                                    'transfer' => 'type-transfer',
                                ];

                                $typeClass = $typeClasses[$movement->type] ?? 'type-default';
                            @endphp

                            <span class="type-badge {{ $typeClass }}">
                                {{ ucfirst(str_replace('_', ' ', $movement->type)) }}
                            </span>
                        </td>

                        <td>
                            <strong>
                                @if(in_array($movement->type, ['stock_in', 'return']))
                                    +
                                @elseif($movement->type === 'stock_out')
                                    -
                                @endif

                                {{ $movement->quantity }}
                            </strong>

                            <div class="small-muted">
                                {{ strtoupper($movement->item->unit ?? '') }}
                            </div>
                        </td>

                        <td>{{ $movement->previous_stock }}</td>

                        <td>
                            <strong>{{ $movement->new_stock }}</strong>
                        </td>

                        <td>{{ $movement->reference_no ?? '-' }}</td>

                        <td>{{ $movement->warehouse ?? '-' }}</td>

                        <td>
                            {{ $movement->user->name ?? 'System' }}
                        </td>

                        <td>
                            <div class="note-text">
                                {{ $movement->note ?? '-' }}
                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="10">

                            <div class="empty-state">
                                <div class="empty-icon">📊</div>

                                <h3>No Stock Movements</h3>

                                <p>
                                    Add stock or issue an inventory item to create movement history.
                                </p>

                                <div class="empty-actions">
                                    <a href="{{ route('admin.inventory.stock-in') }}" class="btn-green">
                                        📥 Stock In
                                    </a>

                                    <a href="{{ route('admin.inventory.stock-out') }}" class="btn-red">
                                        📤 Stock Out
                                    </a>
                                </div>
                            </div>

                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="pagination-wrap">
        {{ $movements->links() }}
    </div>

</div>

<style>
.page-head{
    display:flex;
    align-items:flex-start;
    justify-content:space-between;
    gap:20px;
    margin-bottom:20px;
}

.page-head h2{
    margin:0;
    color:#fff;
    font-size:24px;
}

.head-actions{
    display:flex;
    align-items:center;
    gap:10px;
}

.card-dark{
    margin-bottom:20px;
    padding:24px;
    border:1px solid #262f47;
    border-radius:18px;
    background:#151b29;
}

.filter-grid{
    display:grid;
    grid-template-columns:2fr 1fr 1.4fr auto;
    gap:15px;
    align-items:end;
}

.form-label{
    display:block;
    margin-bottom:7px;
    color:#9fb3d9;
    font-size:12px;
    font-weight:700;
}

.form-control,
.form-select{
    width:100%;
    min-height:46px;
    padding:11px 13px;
    border:1px solid #2b3854;
    border-radius:11px;
    outline:none;
    color:#fff;
    background:#0e1320;
}

.form-control:focus,
.form-select:focus{
    border-color:#3f6fe0;
    box-shadow:0 0 0 4px rgba(63,111,224,.12);
}

.form-select option{
    color:#fff;
    background:#151b29;
}

.filter-actions{
    display:flex;
    gap:9px;
}

.btn-blue,
.btn-green,
.btn-red,
.btn-back{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:44px;
    padding:10px 17px;
    border:0;
    border-radius:10px;
    color:#fff;
    text-decoration:none;
    font-size:13px;
    font-weight:700;
    cursor:pointer;
}

.btn-blue{
    background:#3f6fe0;
}

.btn-green{
    background:#37c281;
}

.btn-red{
    background:#ff5a6e;
}

.btn-back{
    color:#dbe4f3;
    border:1px solid #334155;
    background:#1c2436;
}

.movement-table{
    width:100%;
    margin:0;
    color:#fff;
}

.movement-table thead th{
    padding:14px;
    color:#8fa3c7!important;
    border-color:#262f47!important;
    background:#0e1320;
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:.6px;
    white-space:nowrap;
}

.movement-table tbody td{
    padding:14px;
    color:#fff!important;
    border-color:#262f47!important;
    background:#151b29;
    vertical-align:middle;
    font-size:13px;
}

.movement-table tbody tr:hover td{
    background:#1c2436;
}

.small-muted{
    margin-top:4px;
    color:#8794ac;
    font-size:11px;
}

.type-badge{
    display:inline-block;
    padding:7px 11px;
    border-radius:999px;
    font-size:11px;
    font-weight:800;
    white-space:nowrap;
}

.type-in{
    color:#71dea8;
    background:rgba(55,194,129,.14);
}

.type-out{
    color:#ff91a0;
    background:rgba(255,90,110,.14);
}

.type-adjustment{
    color:#f5c763;
    background:rgba(242,181,59,.15);
}

.type-return{
    color:#9fc3ff;
    background:rgba(63,111,224,.15);
}

.type-transfer{
    color:#c1a7ff;
    background:rgba(155,107,255,.15);
}

.type-default{
    color:#cbd5e1;
    background:rgba(135,148,172,.14);
}

.note-text{
    max-width:220px;
    color:#cbd5e1;
    line-height:1.5;
}

.pagination-wrap{
    margin-top:20px;
}

.empty-state{
    padding:55px 20px;
    text-align:center;
}

.empty-icon{
    margin-bottom:12px;
    font-size:48px;
}

.empty-state h3{
    margin:0 0 7px;
}

.empty-state p{
    margin:0 0 20px;
    color:#8794ac;
}

.empty-actions{
    display:flex;
    justify-content:center;
    gap:10px;
}

.alert-success{
    margin-bottom:20px;
    padding:14px 17px;
    border:1px solid rgba(55,194,129,.32);
    border-radius:13px;
    color:#bff3d8;
    background:rgba(55,194,129,.11);
}

@media(max-width:1150px){
    .filter-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
}

@media(max-width:720px){
    .page-head{
        flex-direction:column;
    }

    .head-actions{
        width:100%;
        align-items:stretch;
        flex-direction:column;
    }

    .filter-grid{
        grid-template-columns:1fr;
    }

    .filter-actions{
        align-items:stretch;
        flex-direction:column;
    }

    .filter-actions > *,
    .head-actions > *{
        width:100%;
    }

    .empty-actions{
        flex-direction:column;
    }
}
</style>

@endsection