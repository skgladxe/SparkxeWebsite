@extends('webadmin.layouts.app')
@section('title', 'FAQs')
@section('content')
<div class="container-fluid">
	<div class="d-flex justify-content-between mb-4">
		<x-webadmin::page-breadcrumb title="FAQs" :home-url="route('admin.dashboard')" />
		<a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">Add FAQ</a>
	</div>
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body table-responsive">
		<table class="table">
			<thead><tr><th>S.No</th><th>Question</th><th>Active</th><th>Open</th><th></th></tr></thead>
			<tbody>
			@forelse($faqs as $faq)
			<tr>
				<td>{{ $faqs->firstItem() + $loop->index }}</td>
				<td>{{ Str::limit($faq->question, 80) }}</td>
				<td>{{ $faq->is_active ? 'Yes' : 'No' }}</td>
				<td>{{ $faq->is_open_default ? 'Yes' : 'No' }}</td>
				<td class="text-end">
					<div class="table-actions">
						<a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-outline-primary">Edit</a>
						<form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
					</div>
				</td>
			</tr>
			@empty
			<tr><td colspan="5" class="text-muted">No FAQs yet.</td></tr>
			@endforelse
			</tbody>
		</table>
		@include('webadmin.partials.table-pagination', ['paginator' => $faqs])
	</div></div>
</div>
@endsection
