@extends('webadmin.layouts.app')
@section('title', 'Hero Slides')
@section('content')
<div class="container-fluid">
	<div class="d-flex justify-content-between mb-4">
		<x-webadmin::page-breadcrumb title="Hero Slides" :home-url="route('admin.dashboard')" />
		@if($canAdd)
			<a href="{{ route('admin.hero-slides.create') }}" class="btn btn-primary">Add Slide</a>
		@else
			<span class="text-muted small align-self-center">Maximum {{ $maxSlides }} slides reached</span>
		@endif
	</div>
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body table-responsive">
		<table class="table">
			<thead><tr><th>S.No</th><th>Image</th><th>Subtitle</th><th>Title</th><th>Order</th><th>Active</th><th></th></tr></thead>
			<tbody>
			@forelse($slides as $slide)
			<tr>
				<td>{{ $slides->firstItem() + $loop->index }}</td>
				<td>@if($slide->mainImageUrl())<img src="{{ $slide->mainImageUrl() }}" height="40" class="rounded">@endif</td>
				<td>{{ Str::limit($slide->subtitle, 40) }}</td>
				<td>{{ Str::limit($slide->title, 50) }}</td>
				<td>{{ $slide->sort_order }}</td>
				<td>{{ $slide->is_active ? 'Yes' : 'No' }}</td>
				<td class="text-end">
					<div class="table-actions">
						<a href="{{ route('admin.hero-slides.edit', $slide) }}" class="btn btn-sm btn-outline-primary">Edit</a>
						<form action="{{ route('admin.hero-slides.destroy', $slide) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
					</div>
				</td>
			</tr>
			@empty
			<tr><td colspan="7" class="text-muted">No hero slides yet.</td></tr>
			@endforelse
			</tbody>
		</table>
		@include('webadmin.partials.table-pagination', ['paginator' => $slides])
	</div></div>
</div>
@endsection
