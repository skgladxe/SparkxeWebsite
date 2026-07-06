@extends('webadmin.layouts.app')
@section('title', 'Add Product')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Add Product" :home-url="route('admin.products.index')" />
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">@csrf
			@include('webadmin.products._form')
			<button class="btn btn-primary mt-3">Save</button>
		</form>
	</div></div>
</div>
@endsection
@include('webadmin.partials.rich-editor')
