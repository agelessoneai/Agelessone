@extends('layouts.admin')
@section('title','Edit Site Worker')
@section('page-title','Edit Site Worker')
@section('content')<div class="mb-3"><a href="{{ route('admin.work-sites.workers.index',$workSite) }}">← {{ $workSite->site_name }} Workers</a></div><div class="card card-dark p-4"><form method="POST" action="{{ route('admin.work-sites.workers.update',[$workSite,$worker]) }}" enctype="multipart/form-data">@csrf @method('PUT') @include('admin.workers._form')<div class="mt-4"><a class="btn btn-outline-light" href="{{ route('admin.work-sites.workers.index',$workSite) }}">Cancel</a><button class="btn btn-primary">Update Worker</button></div></form></div>@endsection
