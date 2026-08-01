@extends('webadmin.layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="container-fluid">
	<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
		<x-webadmin::page-breadcrumb title="Blog Posts" :home-url="route('admin.dashboard')" />
		<a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">Add Post</a>
	</div>

	@include('webadmin.partials.alerts')

	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Title</th>
							<th>Category</th>
							<th>Published</th>
							<th>Updated</th>
							<th class="text-end">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse ($blogs as $blog)
							<tr>
								<td>{{ $blogs->firstItem() + $loop->index }}</td>
								<td>
									<div class="fw-semibold">{{ $blog->title }}</div>
									<code class="small text-muted">/blog/{{ $blog->slug }}</code>
								</td>
								<td>{{ $blog->category?->name ?? '—' }}</td>
								<td>
									<span class="badge {{ $blog->is_published ? 'bg-success' : 'bg-secondary' }}">
										{{ $blog->is_published ? 'Published' : 'Draft' }}
									</span>
								</td>
								<td>{{ $blog->updated_at?->format('d M Y') }}</td>
								<td class="text-end">
									<div class="table-actions">
										@if ($blog->is_published)
											<a href="{{ route('website.blog.show', $blog->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
										@endif
										<a href="{{ route('admin.blogs.edit', $blog) }}" class="btn btn-sm btn-outline-primary">Edit</a>
										<form action="{{ route('admin.blogs.destroy', $blog) }}" method="POST" onsubmit="return confirm('Delete this post?')">
											@csrf
											@method('DELETE')
											<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
										</form>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6" class="text-center text-muted py-4">No blog posts yet.</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			@include('webadmin.partials.table-pagination', ['paginator' => $blogs])
		</div>
	</div>
</div>
@endsection
