@extends('layouts.admin')
@section('title','Edit Office Staff')
@section('page-title','Edit Office Staff')
@section('content')
<div class="card card-dark p-4"><form method="POST" action="{{ route('admin.users.update',$user) }}" enctype="multipart/form-data">@csrf @method('PUT') @include('admin.users._form')<div class="mt-4"><a class="btn btn-outline-light" href="{{ route('admin.users.index') }}">Cancel</a><button class="btn btn-primary">Update Staff</button></div></form></div>
@endsection
