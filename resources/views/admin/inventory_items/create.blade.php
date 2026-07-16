@extends('layouts.admin')

@section('title', 'Add Inventory Item')

@section('content')

<div class="page-head">
    <div>
        <h2>Add Inventory Item</h2>
        <p class="muted mb-0">
            Add item image, category, model, stock, warehouse and pricing details.
        </p>
    </div>

    <a href="{{ route('admin.inventory-items') }}" class="btn-back">
        ← Back
    </a>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <strong>Please fix the following errors:</strong>

        <ul class="mb-0 mt-2">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card-dark">

    <form
        method="POST"
        action="{{ route('admin.inventory-items.store') }}"
        enctype="multipart/form-data"
    >
        @csrf

        <div class="form-grid">

            <div class="field image-field">
                <label class="form-label">Item Image</label>

                <input
                    type="file"
                    name="image"
                    id="image"
                    class="form-control"
                    accept="image/*"
                >

                <div class="preview-box">
                    <img id="preview" alt="Item preview">

                    <div id="previewPlaceholder" class="preview-placeholder">
                        <div>📦</div>
                        <span>Image preview</span>
                    </div>
                </div>
            </div>

            <div class="field">
                <label class="form-label">Category *</label>

                <select
                    name="inventory_category_id"
                    class="form-select"
                    required
                >
                    <option value="">Select Category</option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            {{ old('inventory_category_id') == $category->id ? 'selected' : '' }}
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label class="form-label">Item Name *</label>

                <input
                    type="text"
                    name="item_name"
                    class="form-control"
                    value="{{ old('item_name') }}"
                    placeholder="Example: SKF 6205 Bearing"
                    required
                >
            </div>

            <div class="field">
                <label class="form-label">Item Code *</label>

                <input
                    type="text"
                    name="item_code"
                    class="form-control"
                    value="{{ old('item_code') }}"
                    placeholder="Example: INV-0001"
                    required
                >
            </div>

            <div class="field">
                <label class="form-label">Brand</label>

                <input
                    type="text"
                    name="brand"
                    class="form-control"
                    value="{{ old('brand') }}"
                    placeholder="SKF"
                >
            </div>

            <div class="field">
                <label class="form-label">Model</label>

                <input
                    type="text"
                    name="model"
                    class="form-control"
                    value="{{ old('model') }}"
                    placeholder="6205"
                >
            </div>

            <div class="field">
                <label class="form-label">Barcode</label>

                <input
                    type="text"
                    name="barcode"
                    class="form-control"
                    value="{{ old('barcode') }}"
                    placeholder="Optional barcode"
                >
            </div>

            <div class="field">
                <label class="form-label">QR Code Value</label>

                <input
                    type="text"
                    name="qr_code"
                    class="form-control"
                    value="{{ old('qr_code') }}"
                    placeholder="Optional QR value"
                >
            </div>

            <div class="field">
                <label class="form-label">Warehouse *</label>

                <input
                    type="text"
                    name="warehouse"
                    class="form-control"
                    value="{{ old('warehouse', 'Main Warehouse') }}"
                    required
                >
            </div>

            <div class="field">
                <label class="form-label">Rack</label>

                <input
                    type="text"
                    name="rack"
                    class="form-control"
                    value="{{ old('rack') }}"
                    placeholder="Rack A-12"
                >
            </div>

            <div class="field">
                <label class="form-label">Current Stock *</label>

                <input
                    type="number"
                    name="stock"
                    class="form-control"
                    value="{{ old('stock', 0) }}"
                    min="0"
                    required
                >
            </div>

            <div class="field">
                <label class="form-label">Unit *</label>

                <input
                    type="text"
                    name="unit"
                    class="form-control"
                    value="{{ old('unit', 'PCS') }}"
                    placeholder="PCS, KG, MTR, BOX"
                    required
                >
            </div>

            <div class="field">
                <label class="form-label">Minimum Stock *</label>

                <input
                    type="number"
                    name="minimum_stock"
                    class="form-control"
                    value="{{ old('minimum_stock', 5) }}"
                    min="0"
                    required
                >
            </div>

            <div class="field">
                <label class="form-label">Maximum Stock *</label>

                <input
                    type="number"
                    name="maximum_stock"
                    class="form-control"
                    value="{{ old('maximum_stock', 100) }}"
                    min="0"
                    required
                >
            </div>

            <div class="field">
                <label class="form-label">Purchase Price</label>

                <input
                    type="number"
                    name="purchase_price"
                    class="form-control"
                    value="{{ old('purchase_price', 0) }}"
                    min="0"
                    step="0.01"
                >
            </div>

            <div class="field">
                <label class="form-label">Selling Price</label>

                <input
                    type="number"
                    name="selling_price"
                    class="form-control"
                    value="{{ old('selling_price', 0) }}"
                    min="0"
                    step="0.01"
                >
            </div>

            <div class="field full-width">
                <label class="form-label">Supplier</label>

                <input
                    type="text"
                    name="supplier"
                    class="form-control"
                    value="{{ old('supplier') }}"
                    placeholder="Supplier or vendor name"
                >
            </div>

            <div class="field full-width">
                <label class="form-label">Description</label>

                <textarea
                    name="description"
                    class="form-control"
                    rows="5"
                    placeholder="Item details, compatibility, specifications..."
                >{{ old('description') }}</textarea>
            </div>

            <div class="field full-width">
                <label class="active-toggle">
                    <input
                        type="checkbox"
                        name="active"
                        value="1"
                        {{ old('active', true) ? 'checked' : '' }}
                    >

                    <span class="toggle-switch"></span>

                    <span>
                        <strong>Active Item</strong>
                        <small>Allow this item to appear in inventory and requests.</small>
                    </span>
                </label>
            </div>

        </div>

        <div class="form-actions">
            <a href="{{ route('admin.inventory-items') }}" class="btn-back">
                Cancel
            </a>

            <button type="submit" class="btn-blue">
                💾 Save Inventory Item
            </button>
        </div>

    </form>

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

.card-dark{
    padding:28px;
    border:1px solid #262f47;
    border-radius:18px;
    background:#151b29;
}

.form-grid{
    display:grid;
    grid-template-columns:repeat(2,minmax(0,1fr));
    gap:20px;
}

.field{
    min-width:0;
}

.full-width{
    grid-column:1/-1;
}

.form-label{
    display:block;
    margin-bottom:8px;
    color:#9fb3d9;
    font-size:13px;
    font-weight:700;
}

.form-control,
.form-select{
    width:100%;
    min-height:50px;
    padding:12px 14px;
    border:1px solid #2b3854;
    border-radius:12px;
    outline:none;
    color:#fff;
    background:#0e1320;
    transition:.2s ease;
}

textarea.form-control{
    min-height:125px;
    resize:vertical;
}

.form-control::placeholder{
    color:#667793;
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

.preview-box{
    position:relative;
    width:100%;
    height:190px;
    margin-top:12px;
    overflow:hidden;
    border:1px dashed #334155;
    border-radius:14px;
    background:#0e1320;
}

#preview{
    display:none;
    width:100%;
    height:100%;
    object-fit:contain;
}

.preview-placeholder{
    position:absolute;
    inset:0;
    display:grid;
    place-content:center;
    gap:6px;
    color:#7181a2;
    text-align:center;
}

.preview-placeholder div{
    font-size:42px;
}

.preview-placeholder span{
    font-size:12px;
}

.active-toggle{
    display:flex;
    align-items:center;
    gap:13px;
    padding:16px;
    border:1px solid #2b3854;
    border-radius:14px;
    background:#0e1320;
    cursor:pointer;
}

.active-toggle input{
    display:none;
}

.toggle-switch{
    position:relative;
    width:46px;
    height:25px;
    flex:0 0 46px;
    border-radius:999px;
    background:#334155;
    transition:.2s;
}

.toggle-switch::after{
    content:"";
    position:absolute;
    top:3px;
    left:3px;
    width:19px;
    height:19px;
    border-radius:50%;
    background:#fff;
    transition:.2s;
}

.active-toggle input:checked + .toggle-switch{
    background:#37c281;
}

.active-toggle input:checked + .toggle-switch::after{
    transform:translateX(21px);
}

.active-toggle strong{
    display:block;
    color:#fff;
    font-size:13px;
}

.active-toggle small{
    display:block;
    margin-top:3px;
    color:#8794ac;
    font-size:11px;
}

.form-actions{
    display:flex;
    justify-content:flex-end;
    gap:12px;
    margin-top:28px;
    padding-top:22px;
    border-top:1px solid #262f47;
}

.btn-blue,
.btn-back{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    min-height:44px;
    padding:10px 18px;
    border-radius:10px;
    text-decoration:none;
    font-size:13px;
    font-weight:700;
}

.btn-blue{
    color:#fff;
    border:0;
    background:linear-gradient(135deg,#3f6fe0,#315ac2);
}

.btn-back{
    color:#dbe4f3;
    border:1px solid #334155;
    background:#1c2436;
}

.alert-danger{
    margin-bottom:20px;
    padding:16px 18px;
    border:1px solid rgba(255,90,110,.35);
    border-radius:14px;
    color:#ffd4da;
    background:rgba(255,90,110,.12);
}

@media(max-width:780px){
    .page-head{
        flex-direction:column;
    }

    .form-grid{
        grid-template-columns:1fr;
    }

    .full-width{
        grid-column:auto;
    }

    .form-actions{
        flex-direction:column-reverse;
    }

    .form-actions .btn-blue,
    .form-actions .btn-back{
        width:100%;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('image');
    const preview = document.getElementById('preview');
    const placeholder = document.getElementById('previewPlaceholder');

    imageInput.addEventListener('change', function () {
        const file = this.files[0];

        if (!file) {
            preview.src = '';
            preview.style.display = 'none';
            placeholder.style.display = 'grid';
            return;
        }

        const reader = new FileReader();

        reader.onload = function (event) {
            preview.src = event.target.result;
            preview.style.display = 'block';
            placeholder.style.display = 'none';
        };

        reader.readAsDataURL(file);
    });
});
</script>

@endsection