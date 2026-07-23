@extends('webadmin.layouts.app')

@section('title', 'SEO — '.config('webadmin.name'))

@section('content')
<div class="container-fluid">
	<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
		<x-webadmin::page-breadcrumb title="SEO Management" :home-url="route('admin.dashboard')" />
		<a href="{{ route('admin.seo.create') }}" class="btn btn-primary">Add SEO Page</a>
	</div>

	@if (session('success'))
		<div class="alert alert-success">{{ session('success') }}</div>
	@endif

	<div class="card">
		<div class="card-body">
			<div class="table-responsive">
				<table class="table table-hover align-middle mb-0">
					<thead>
						<tr>
							<th>S.No</th>
							<th>Page</th>
							<th>URL Slug</th>
							<th>Route Key</th>
							<th>Meta Title</th>
							<th>Schema</th>
							<th>Updated</th>
							<th class="text-end">Actions</th>
						</tr>
					</thead>
					<tbody>
						@forelse ($seoPages as $seoPage)
							<tr>
								<td>{{ $seoPages->firstItem() + $loop->index }}</td>
								<td>{{ $seoPage->page_label }}</td>
								<td><code>{{ $seoPage->url_slug }}</code></td>
								<td><code>{{ $seoPage->route_key }}</code></td>
								<td>{{ Str::limit($seoPage->meta_title, 50) }}</td>
								<td><span class="badge bg-primary-subtle text-primary">{{ $seoPage->schema_type }}</span></td>
								<td>{{ $seoPage->updated_at?->format('d M Y') }}</td>
								<td class="text-end">
									<div class="table-actions">
										<a href="{{ route('admin.seo.edit', $seoPage) }}" class="btn btn-sm btn-outline-primary">Edit SEO</a>
									</div>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="8" class="text-center text-muted py-4">
									No SEO records yet.
									<a href="{{ route('admin.seo.create') }}">Add a page</a> or run <code>php artisan db:seed --class=SeoSeeder</code>.
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>
			</div>
			@include('webadmin.partials.table-pagination', ['paginator' => $seoPages])
		</div>
	</div>
</div>
@endsection
