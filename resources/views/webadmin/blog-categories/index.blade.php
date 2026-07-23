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
		<table class="table">
			<thead><tr><th>S.No</th><th>Name</th><th>Slug</th><th>Active</th><th></th></tr></thead>
			<tbody>
			@forelse($categories as $cat)
			<tr>
				<td>{{ $categories->firstItem() + $loop->index }}</td>
				<td>{{ $cat->name }}</td>
				<td><code>{{ $cat->slug }}</code></td>
				<td>{{ $cat->is_active ? 'Yes' : 'No' }}</td>
				<td class="text-end">
					<div class="table-actions">
						<a href="{{ route('admin.blog-categories.edit', $cat) }}" class="btn btn-sm btn-outline-primary">Edit</a>
						<form action="{{ route('admin.blog-categories.destroy', $cat) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
					</div>
				</td>
			</tr>
			@empty
			<tr><td colspan="5" class="text-muted">No categories yet.</td></tr>
			@endforelse
			</tbody>
		</table>
		@include('webadmin.partials.table-pagination', ['paginator' => $categories])
	</div></div>
</div>
@endsection
