@extends('layouts.admin')
@section('title','Add Site Worker')
@section('page-title','Add Site Worker')
@section('content')<div class="mb-3"><a href="{{ route('admin.work-sites.workers.index',$workSite) }}">← {{ $workSite->site_name }} Workers</a></div><div class="card card-dark p-4"><form method="POST" action="{{ route('admin.work-sites.workers.store',$workSite) }}" enctype="multipart/form-data">@csrf @include('admin.workers._form')<div class="mt-4"><a class="btn btn-outline-light" href="{{ route('admin.work-sites.workers.index',$workSite) }}">Cancel</a><button class="btn btn-primary">Add Worker</button></div></form></div>@endsection
