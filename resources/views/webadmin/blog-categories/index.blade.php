@extends('webadmin.layouts.app')
@section('title', 'Blog Categories')
@section('content')
<div class="container-fluid">
	<div class="d-flex justify-content-between mb-4">
		<x-webadmin::page-breadcrumb title="Blog Categories" :home-url="route('admin.dashboard')" />
		<a href="{{ route('admin.blog-categories.create') }}" class="btn btn-primary">Add Category</a>
	</div>
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body table-responsive">
		<table class="table"><thead><tr><th>Name</th><th>Slug</th><th>Active</th><th></th></tr></thead><tbody>
		@foreach($categories as $cat)
		<tr><td>{{ $cat->name }}</td><td><code>{{ $cat->slug }}</code></td><td>{{ $cat->is_active ? 'Yes' : 'No' }}</td>
		<td class="text-end"><a href="{{ route('admin.blog-categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary">Edit</a>
		<form action="{{ route('admin.blog-categories.destroy', $cat) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td></tr>
		@endforeach</tbody></table>
	</div></div>
</div>
@endsection
