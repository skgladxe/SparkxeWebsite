@extends('webadmin.layouts.app')
@section('title', 'Products')
@section('content')
<div class="container-fluid">
	<div class="d-flex justify-content-between mb-4">
		<x-webadmin::page-breadcrumb title="Our Products" :home-url="route('admin.dashboard')" />
		<a href="{{ route('admin.products.create') }}" class="btn btn-primary">Add Product</a>
	</div>
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body table-responsive">
		<table class="table">
			<thead><tr><th>Image</th><th>Title</th><th>Order</th><th>Active</th><th></th></tr></thead>
			<tbody>
			@foreach($products as $product)
			<tr>
				<td>@if($product->imageUrl())<img src="{{ $product->imageUrl() }}" height="40" class="rounded">@endif</td>
				<td>{{ Str::limit($product->title, 60) }}</td>
				<td>{{ $product->sort_order }}</td>
				<td>{{ $product->is_active ? 'Yes' : 'No' }}</td>
				<td class="text-end">
					@if($product->slug)
						<a href="{{ route('website.products.show', $product->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
					@endif
					<a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">Edit</a>
					<form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form>
				</td>
			</tr>
			@endforeach
			</tbody>
		</table>
	</div></div>
</div>
@endsection
