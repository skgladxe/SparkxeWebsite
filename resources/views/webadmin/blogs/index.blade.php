@extends('webadmin.layouts.app')
@section('title', 'Blog Posts')
@section('content')
<div class="container-fluid">
	<div class="d-flex justify-content-between mb-4">
		<x-webadmin::page-breadcrumb title="Blog Posts" :home-url="route('admin.dashboard')" />
		<a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">Add Post</a>
	</div>
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body table-responsive">
		<table class="table">
			<thead><tr><th>S.No</th><th>Title</th><th>Category</th><th>Published</th><th></th></tr></thead>
			<tbody>
			@forelse($blogs as $blog)
			<tr>
				<td>{{ $blogs->firstItem() + $loop->index }}</td>
				<td>{{ $blog->title }}</td>
				<td>{{ $blog->category?->name ?? '—' }}</td>
				<td><span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-secondary' }}">{{ $blog->is_published ? 'Yes' : 'Draft' }}</span></td>
				<td class="text-end">
					<div class="table-actions">
						<a href="{{ route('website.blog.show', $blog->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
						<a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-primary">Edit</a>
						<form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
					</div>
				</td>
			</tr>
			@empty
			<tr><td colspan="5" class="text-muted">No blog posts yet.</td></tr>
			@endforelse
			</tbody>
		</table>
		@include('webadmin.partials.table-pagination', ['paginator' => $blogs])
	</div></div>
</div>
@endsection
