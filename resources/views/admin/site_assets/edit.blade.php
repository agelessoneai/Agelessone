@extends('layouts.admin')
@section('title','Edit Site Asset')
@section('page-title','Edit Site Asset')
@section('content')
@include('admin.site_assets.partials.form',['action'=>route('admin.site-assets.update',$siteAsset),'method'=>'PUT'])
@endsection
