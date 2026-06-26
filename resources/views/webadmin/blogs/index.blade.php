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
		<table class="table"><thead><tr><th>Title</th><th>Category</th><th>Published</th><th></th></tr></thead><tbody>
		@foreach($blogs as $blog)
		<tr>
			<td>{{ $blog->title }}</td>
			<td>{{ $blog->category?->name ?? '—' }}</td>
			<td><span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-secondary' }}">{{ $blog->is_published ? 'Yes' : 'Draft' }}</span></td>
			<td class="text-end">
				<a href="{{ route('website.blog.show', $blog->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
				<a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-primary">Edit</a>
				<form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form>
			</td>
		</tr>
		@endforeach</tbody></table>
	</div></div>
</div>
@endsection
