@extends('webadmin.layouts.app')
@section('title', 'Services')
@section('content')
<div class="container-fluid">
	<div class="d-flex justify-content-between mb-4">
		<x-webadmin::page-breadcrumb title="Our Services" :home-url="route('admin.dashboard')" />
		<a href="{{ route('admin.services.create') }}" class="btn btn-primary">Add Service</a>
	</div>
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body table-responsive">
		<table class="table">
			<thead><tr><th>S.No</th><th>Icon</th><th>Title</th><th>Slug</th><th>Order</th><th>Active</th><th></th></tr></thead>
			<tbody>
			@forelse($services as $service)
			<tr>
				<td>{{ $services->firstItem() + $loop->index }}</td>
				<td>@if($service->iconClass())<i class="{{ $service->iconClass() }}"></i>@endif</td>
				<td>{{ Str::limit($service->title, 50) }}</td>
				<td>{{ $service->slug }}</td>
				<td>{{ $service->sort_order }}</td>
				<td>{{ $service->is_active ? 'Yes' : 'No' }}</td>
				<td class="text-end">
					<div class="table-actions">
						<a href="{{ route('website.services.show', $service->slug) }}" class="btn btn-sm btn-outline-secondary" target="_blank">View</a>
						<a href="{{ route('admin.services.edit', $service) }}" class="btn btn-sm btn-outline-primary">Edit</a>
						<form action="{{ route('admin.services.destroy', $service) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
					</div>
				</td>
			</tr>
			@empty
			<tr><td colspan="7" class="text-muted">No services yet.</td></tr>
			@endforelse
			</tbody>
		</table>
		@include('webadmin.partials.table-pagination', ['paginator' => $services])
	</div></div>
</div>
@endsection
