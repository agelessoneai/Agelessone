@extends('layouts.admin')

@section('title', 'Inventory Items')

@section('content')

<div class="page-head">
    <div>
        <h2>Smart Inventory</h2>
        <p class="muted mb-0">Manage category-wise stock, warehouse, rack, suppliers and item value.</p>
    </div>

    <a href="{{ route('admin.inventory-items.create') }}" class="btn-blue">
        + Add Inventory Item
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@endif

<div class="summary-grid">

    <div class="summary-card">
        <span>Total Items</span>
        <strong>{{ $summary['total_items'] }}</strong>
        <small>Registered inventory items</small>
    </div>

    <div class="summary-card">
        <span>Total Stock</span>
        <strong>{{ $summary['total_stock'] }}</strong>
        <small>Combined item quantity</small>
    </div>

    <div class="summary-card warning">
        <span>Low Stock</span>
        <strong>{{ $summary['low_stock'] }}</strong>
        <small>Items below minimum level</small>
    </div>

    <div class="summary-card danger">
        <span>Out of Stock</span>
        <strong>{{ $summary['out_of_stock'] }}</strong>
        <small>Items requiring purchase</small>
    </div>

    <div class="summary-card value-card">
        <span>Inventory Value</span>
        <strong>₹{{ number_format($summary['inventory_value'], 2) }}</strong>
        <small>Based on purchase price</small>
    </div>

</div>

<div class="card-dark filter-card">

    <form method="GET" action="{{ route('admin.inventory-items') }}">

        <div class="filter-grid">

            <div>
                <label class="form-label">Search</label>

                <input
                    type="search"
                    name="search"
                    class="form-control"
                    value="{{ request('search') }}"
                    placeholder="Name, code, brand, model, warehouse..."
                >
            </div>

            <div>
                <label class="form-label">Category</label>

                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ request('category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="form-label">Stock Status</label>

                <select name="stock_status" class="form-select">
                    <option value="">All Stock Status</option>

                    <option value="in_stock" {{ request('stock_status') === 'in_stock' ? 'selected' : '' }}>
                        In Stock
                    </option>

                    <option value="low_stock" {{ request('stock_status') === 'low_stock' ? 'selected' : '' }}>
                        Low Stock
                    </option>

                    <option value="out_of_stock" {{ request('stock_status') === 'out_of_stock' ? 'selected' : '' }}>
                        Out of Stock
                    </option>
                </select>
            </div>

            <div class="filter-actions">
                <button type="submit" class="btn-blue">
                    Filter
                </button>

                <a href="{{ route('admin.inventory-items') }}" class="btn-secondary">
                    Reset
                </a>
            </div>

        </div>

    </form>

</div>

<div class="card-dark">

    <div class="table-responsive">

        <table class="table inventory-table">

            <thead>
                <tr>
                    <th>Photo</th>
                    <th>Item</th>
                    <th>Category</th>
                    <th>Brand / Model</th>
                    <th>Warehouse</th>
                    <th>Rack</th>
                    <th>Stock</th>
                    <th>Value</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                @forelse($items as $item)

                    <tr>

                        <td>
                            @if($item->image)
                                <a href="{{ asset('storage/'.$item->image) }}" target="_blank">
                                    <img
                                        src="{{ asset('storage/'.$item->image) }}"
                                        alt="<a href="{{ route('admin.inventory-items.show', $item) }}" style="color:inherit;text-decoration:none;font-weight:700">{{ $item->item_name }}</a>"
                                        class="item-photo"
                                    >
                                </a>
                            @else
                                <div class="item-photo placeholder-photo">
                                    📦
                                </div>
                            @endif
                        </td>

                        <td>
                            <strong><a href="{{ route('admin.inventory-items.show', $item) }}" style="color:inherit;text-decoration:none;font-weight:700">{{ $item->item_name }}</a></strong>

                            <div class="small-muted">
                                {{ $item->item_code }}
                            </div>

                            @if($item->barcode)
                                <div class="small-muted">
                                    Barcode: {{ $item->barcode }}
                                </div>
                            @endif
                        </td>

                        <td>
                            <span class="category-pill">
                                {{ $item->category->name ?? '-' }}
                            </span>
                        </td>

                        <td>
                            <div>{{ $item->brand ?? '-' }}</div>

                            <div class="small-muted">
                                {{ $item->model ?? '-' }}
                            </div>
                        </td>

                        <td>{{ $item->warehouse }}</td>

                        <td>{{ $item->rack ?? '-' }}</td>

                        <td>
                            <strong>
                                {{ $item->stock }} {{ strtoupper($item->unit) }}
                            </strong>

                            <div class="small-muted">
                                Min: {{ $item->minimum_stock }}
                                · Max: {{ $item->maximum_stock }}
                            </div>
                        </td>

                        <td>
                            ₹{{ number_format($item->stock * $item->purchase_price, 2) }}
                        </td>

                        <td>
                            @if(!$item->active)
                                <span class="status-badge status-inactive">
                                    Inactive
                                </span>
                            @elseif($item->stock <= 0)
                                <span class="status-badge status-out">
                                    Out of Stock
                                </span>
                            @elseif($item->stock <= $item->minimum_stock)
                                <span class="status-badge status-low">
                                    Low Stock
                                </span>
                            @else
                                <span class="status-badge status-ok">
                                    In Stock
                                </span>
                            @endif
                        </td>

                        <td>
                            <div class="action-group">

                                <a
                                    href="{{ route('admin.inventory-items.edit', $item->id) }}"
                                    class="action-button action-edit"
                                >
                                    ✏ Edit
                                </a>

                                <form
                                    method="POST"
                                    action="{{ route('admin.inventory-items.destroy', $item->id) }}"
                                    onsubmit="return confirm('Delete this inventory item?')"
                                >
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="action-button action-delete"
                                    >
                                        🗑 Delete
                                    </button>
                                </form>

                            </div>
                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-icon">📦</div>

                                <h3>No Inventory Items Found</h3>

                                <p>
                                    Add your first inventory item or change the filters.
                                </p>

                                <a href="{{ route('admin.inventory-items.create') }}" class="btn-blue">
                                    + Add Inventory Item
                                </a>
                            </div>
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <div class="pagination-wrap">
        {{ $items->links() }}
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

.summary-grid{
    display:grid;
    grid-template-columns:repeat(5,minmax(0,1fr));
    gap:15px;
    margin-bottom:20px;
}

.summary-card{
    padding:18px;
    border:1px solid #262f47;
    border-radius:16px;
    background:linear-gradient(145deg,#151b29,#111725);
}

.summary-card span{
    display:block;
    color:#8794ac;
    font-size:12px;
    font-weight:700;
    text-transform:uppercase;
    letter-spacing:.6px;
}

.summary-card strong{
    display:block;
    margin:8px 0 4px;
    color:#fff;
    font-size:27px;
}

.summary-card small{
    color:#73819b;
    font-size:11px;
}

.summary-card.warning{
    border-left:4px solid #f2b53b;
}

.summary-card.danger{
    border-left:4px solid #ff5a6e;
}

.summary-card.value-card{
    border-left:4px solid #37c281;
}

.card-dark{
    background:#151b29;
    border:1px solid #262f47;
    border-radius:18px;
    padding:24px;
    margin-bottom:20px;
}

.filter-card{
    padding-bottom:20px;
}

.filter-grid{
    display:grid;
    grid-template-columns:2fr 1fr 1fr auto;
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
    align-items:center;
    gap:10px;
}

.btn-blue,
.btn-secondary{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:44px;
    padding:10px 17px;
    border:0;
    border-radius:10px;
    text-decoration:none;
    font-size:13px;
    font-weight:700;
    cursor:pointer;
}

.btn-blue{
    color:#fff;
    background:linear-gradient(135deg,#3f6fe0,#315ac2);
}

.btn-secondary{
    color:#dbe4f3;
    border:1px solid #334155;
    background:#1c2436;
}

.inventory-table{
    width:100%;
    color:#fff;
    margin:0;
}

.inventory-table thead th{
    padding:14px;
    color:#8fa3c7!important;
    border-color:#262f47!important;
    background:#0e1320;
    font-size:11px;
    text-transform:uppercase;
    letter-spacing:.6px;
    white-space:nowrap;
}

.inventory-table tbody td{
    padding:14px;
    color:#fff!important;
    border-color:#262f47!important;
    background:#151b29;
    vertical-align:middle;
    font-size:13px;
}

.inventory-table tbody tr:hover td{
    background:#1c2436;
}

.item-photo{
    width:62px;
    height:62px;
    display:grid;
    place-items:center;
    object-fit:cover;
    border:1px solid #334155;
    border-radius:12px;
    background:#0e1320;
}

.placeholder-photo{
    font-size:25px;
}

.small-muted{
    margin-top:4px;
    color:#8794ac;
    font-size:11px;
}

.category-pill{
    display:inline-block;
    padding:6px 10px;
    border-radius:999px;
    color:#a9c0ff;
    background:rgba(63,111,224,.14);
    font-size:11px;
    font-weight:700;
}

.status-badge{
    display:inline-block;
    padding:7px 11px;
    border-radius:999px;
    font-size:11px;
    font-weight:800;
    white-space:nowrap;
}

.status-ok{
    color:#71dea8;
    background:rgba(55,194,129,.14);
}

.status-low{
    color:#f5c763;
    background:rgba(242,181,59,.15);
}

.status-out{
    color:#ff91a0;
    background:rgba(255,90,110,.14);
}

.status-inactive{
    color:#b2bdd1;
    background:rgba(135,148,172,.14);
}

.action-group{
    display:flex;
    align-items:center;
    gap:8px;
}

.action-group form{
    margin:0;
}

.action-button{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    padding:8px 12px;
    border:0;
    border-radius:9px;
    text-decoration:none;
    font-size:12px;
    font-weight:700;
    white-space:nowrap;
    cursor:pointer;
}

.action-edit{
    color:#fff;
    background:#3f6fe0;
}

.action-delete{
    color:#fff;
    background:#ff5a6e;
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
    margin:0 0 6px;
}

.empty-state p{
    margin:0 0 20px;
    color:#8794ac;
}

@media(max-width:1200px){
    .summary-grid{
        grid-template-columns:repeat(3,minmax(0,1fr));
    }

    .filter-grid{
        grid-template-columns:repeat(2,minmax(0,1fr));
    }
}

@media(max-width:700px){
    .page-head{
        flex-direction:column;
    }

    .summary-grid{
        grid-template-columns:1fr;
    }

    .filter-grid{
        grid-template-columns:1fr;
    }

    .filter-actions{
        align-items:stretch;
        flex-direction:column;
    }

    .filter-actions .btn-blue,
    .filter-actions .btn-secondary{
        width:100%;
    }
}
</style>

@endsection