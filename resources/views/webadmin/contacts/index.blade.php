@extends('webadmin.layouts.app')
@section('title', 'Contact Submissions')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Contact Submissions" :home-url="route('admin.dashboard')" />
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body table-responsive">
		<table class="table">
			<thead><tr><th>S.No</th><th>Name</th><th>Email</th><th>Service</th><th>Status</th><th>Date</th><th></th></tr></thead>
			<tbody>
			@forelse($contacts as $contact)
			<tr>
				<td>{{ $contacts->firstItem() + $loop->index }}</td>
				<td>{{ $contact->fullName() }}</td>
				<td>{{ $contact->email }}</td>
				<td>{{ $contact->service ?? '—' }}</td>
				<td>@php $badge = match($contact->status) { 'pending' => 'warning', 'followup' => 'info', 'completed' => 'success', default => 'secondary' }; @endphp
				<span class="badge bg-{{ $badge }}">{{ ucfirst($contact->status) }}</span></td>
				<td>{{ $contact->created_at->format('d M Y') }}</td>
				<td class="text-end">
					<div class="table-actions">
						<a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-outline-primary">View</a>
					</div>
				</td>
			</tr>
			@empty
			<tr><td colspan="7" class="text-muted">No contact submissions yet.</td></tr>
			@endforelse
			</tbody>
		</table>
		@include('webadmin.partials.table-pagination', ['paginator' => $contacts])
	</div></div>
</div>
@endsection
