@extends('webadmin.layouts.app')
@section('title', 'Edit Product')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Edit Product" :home-url="route('admin.products.index')" />
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">@csrf @method('PUT')
			@include('webadmin.products._form', ['product' => $product])
			<button class="btn btn-primary mt-3">Update</button>
		</form>
	</div></div>
</div>
@endsection
@include('webadmin.partials.rich-editor')
