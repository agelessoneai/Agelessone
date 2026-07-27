@extends('layouts.admin')
@section('title','Bulk Add Workers')
@section('page-title','Bulk Add Workers')
@section('content')
<div class="page-head">
    <div>
        <a href="{{ route('admin.work-sites.workers.index',$workSite) }}" class="back-link">← {{ $workSite->site_name }}</a>
        <h2>Add Multiple Workers</h2>
        <p>Add any number of workers. Start with 10 rows and add more when needed.</p>
    </div>
</div>
@if($errors->any())<div class="alert alert-danger"><ul class="mb-0">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
<form method="POST" action="{{ route('admin.work-sites.workers.bulk-store',$workSite) }}">@csrf
<div class="a1-panel p-3">
    <div class="table-responsive">
        <table class="table align-middle" id="workersTable">
            <thead><tr><th style="min-width:140px">Code</th><th style="min-width:180px">Name</th><th style="min-width:150px">Mobile</th><th style="min-width:160px">Work / Trade</th><th style="min-width:140px">Role</th><th></th></tr></thead>
            <tbody></tbody>
        </table>
    </div>
    <div class="d-flex gap-2 flex-wrap mt-3">
        <button type="button" class="btn btn-outline-light" id="addRow">+ Add Row</button>
        <button type="button" class="btn btn-outline-light" id="addTen">+ Add 10 Rows</button>
        <button class="btn btn-primary">Save All Workers</button>
    </div>
</div>
</form>
<template id="rowTemplate"><tr><td><input class="form-control" name="workers[INDEX][worker_code]" required></td><td><input class="form-control" name="workers[INDEX][name]" required></td><td><input class="form-control" name="workers[INDEX][mobile]"></td><td><input class="form-control" name="workers[INDEX][trade]" required placeholder="Electrician / Helper"></td><td><select class="form-select" name="workers[INDEX][role]" required>@foreach($roles as $value=>$label)<option value="{{ $value }}">{{ $label }}</option>@endforeach</select></td><td><button type="button" class="btn btn-sm btn-outline-danger remove-row">×</button></td></tr></template>
<script>
(()=>{
    let i=0;
    const body=document.querySelector('#workersTable tbody');
    const tpl=document.querySelector('#rowTemplate').innerHTML;
    function add(count=1){for(let n=0;n<count;n++){body.insertAdjacentHTML('beforeend',tpl.replaceAll('INDEX',i++));}}
    document.querySelector('#addRow').onclick=()=>add(1);
    document.querySelector('#addTen').onclick=()=>add(10);
    body.addEventListener('click',e=>{if(e.target.classList.contains('remove-row')&&body.children.length>1)e.target.closest('tr').remove();});
    add(10);
})();
</script>
@endsection
