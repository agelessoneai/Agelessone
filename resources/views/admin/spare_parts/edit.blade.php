    @extends('layouts.app')

    @section('content')

    <style>
    body{background:#0e1320;color:#e8edf6;overflow:hidden}
    .navbar,header{display:none!important}
    .container{max-width:100%!important;margin:0!important;padding:0!important}

    .app{display:grid;grid-template-columns:270px 1fr;height:100vh}
    .side{background:#151b29;border-right:1px solid #262f47}
    .brand{padding:18px;display:flex;gap:12px;align-items:center;border-bottom:1px solid #262f47}
    .logo{
    width:48px;
    height:48px;
    border-radius:14px;
    background:linear-gradient(135deg,#5b8cff,#9b6bff);
    display:grid;
    place-items:center;
    font-weight:800;
    font-size:22px;
    color:#fff;
    }
    .brand h1{margin:0;font-size:17px}
    .brand p{margin:0;font-size:11px;color:#8794ac}

    .nav-title{
    padding:18px 24px 8px;
    font-size:11px;
    color:#8794ac;
    font-weight:700;
    letter-spacing:1px;
    }

    .nav a{
    display:flex;
    padding:14px 22px;
    text-decoration:none;
    color:#a8b4cc;
    }

    .nav a.active{
    background:#3f6fe0;
    color:#fff;
    border-radius:0 12px 12px 0;
    }

    .main{overflow:auto}

    .top{
    height:76px;
    background:#151b29;
    display:flex;
    align-items:center;
    padding:0 30px;
    border-bottom:1px solid #262f47;
    }

    .search{
    width:450px;
    padding:13px;
    background:#0e1320;
    border:1px solid #262f47;
    border-radius:12px;
    color:#fff;
    }

    .user{
    margin-left:auto;
    display:flex;
    align-items:center;
    gap:12px;
    }

    .avatar{
    width:46px;
    height:46px;
    border-radius:50%;
    background:linear-gradient(135deg,#5b8cff,#37c281);
    display:grid;
    place-items:center;
    font-weight:700;
    color:#fff;
    }

    .logout{
    background:transparent;
    border:1px solid #334155;
    padding:10px 18px;
    color:#fff;
    border-radius:10px;
    }

    .content{
    padding:30px;
    }

    .card-dark{
    background:#151b29;
    border:1px solid #262f47;
    border-radius:18px;
    padding:30px;
    }

    .form-label{
    color:#9fb3d9;
    font-weight:600;
    margin-bottom:8px;
    }

    .form-control{
    background:#0e1320;
    border:1px solid #262f47;
    color:#fff;
    border-radius:10px;
    padding:12px;
    }

    .form-control:focus{
    background:#0e1320;
    color:#fff;
    border-color:#3f6fe0;
    box-shadow:none;
    }

    .btn-blue{
    background:#3f6fe0;
    color:#fff;
    padding:12px 22px;
    border-radius:10px;
    text-decoration:none;
    border:none;
    font-weight:700;
    }

    .btn-back{
    background:#2b3447;
    color:#fff;
    padding:12px 22px;
    border-radius:10px;
    text-decoration:none;
    margin-right:10px;
    }
    </style>

    <div class="app">

    <aside class="side">

    <div class="brand">
    <div class="logo">A1</div>

    <div>
    <h1>Ageless One</h1>
    <p>AI BUSINESS OS</p>
    </div>

    </div>

    <div class="nav-title">SERVICE</div>

    <div class="nav">
    <a href="{{ route('admin.dashboard') }}">🏠 Dashboard</a>
    <a href="{{ route('admin.parks') }}">🏢 Parks</a>
    <a href="{{ route('admin.tickets') }}">🎫 Tickets</a>
    <a class="active" href="{{ route('admin.spare-parts') }}">📦 Spare Parts</a>
    </div>

    </aside>

    <main class="main">

    <div class="top">

    <input class="search" placeholder="Search...">

    <div class="user">

    <div class="avatar">
    {{ strtoupper(substr(Auth::user()->name,0,1)) }}
    </div>

    <div>
    <strong>{{ Auth::user()->name }}</strong><br>
    <small style="color:#8794ac;">Administrator</small>
    </div>

    <form method="POST" action="{{ route('logout') }}">
    @csrf
    <button class="logout">Logout</button>
    </form>

    </div>

    </div>

    <div class="content">

    <div class="card-dark">

    <h2>Add Spare Part</h2>

  <h2>Edit Spare Part</h2>

<p style="color:#8794ac;">
Update inventory item details.
</p>

<form method="POST" action="{{ route('admin.spare-parts.update', $sparePart->id) }}">
@csrf
@method('PUT')

<div class="row">

<div class="col-md-6 mb-3">
<label class="form-label">Part Name</label>
<input type="text" name="part_name" class="form-control"
value="{{ old('part_name', $sparePart->part_name) }}" required>
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Part Code</label>
<input type="text" name="part_code" class="form-control"
value="{{ old('part_code', $sparePart->part_code) }}">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Category</label>
<input type="text" name="category" class="form-control"
value="{{ old('category', $sparePart->category) }}">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Current Stock</label>
<input type="number" name="stock" class="form-control"
value="{{ old('stock', $sparePart->stock) }}">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Minimum Stock</label>
<input type="number" name="minimum_stock" class="form-control"
value="{{ old('minimum_stock', $sparePart->minimum_stock) }}">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Unit</label>
<input type="text" name="unit" class="form-control"
value="{{ old('unit', $sparePart->unit) }}">
</div>

<div class="col-md-6 mb-3">
<label class="form-label">Unit Price</label>
<input type="number" step="0.01" name="unit_price" class="form-control"
value="{{ old('unit_price', $sparePart->unit_price) }}">
</div>

<div class="col-12 mb-4">
<label class="form-label">Description</label>
<textarea name="description" rows="4" class="form-control">{{ old('description', $sparePart->description) }}</textarea>
</div>

</div>

<a href="{{ route('admin.spare-parts') }}" class="btn-back">Cancel</a>

<button type="submit" class="btn-blue">
💾 Update Spare Part
</button>

</form>

    </div>

    </div>

    </main>

    </div>

    @endsection