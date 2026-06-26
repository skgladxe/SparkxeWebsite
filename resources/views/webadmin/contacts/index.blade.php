@extends('webadmin.layouts.app')
@section('title', 'Contact Submissions')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Contact Submissions" :home-url="route('admin.dashboard')" />
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body table-responsive">
		<table class="table"><thead><tr><th>Name</th><th>Email</th><th>Service</th><th>Status</th><th>Date</th><th></th></tr></thead><tbody>
		@foreach($contacts as $contact)
		<tr>
			<td>{{ $contact->fullName() }}</td><td>{{ $contact->email }}</td><td>{{ $contact->service ?? '—' }}</td>
			<td>@php $badge = match($contact->status) { 'pending' => 'warning', 'followup' => 'info', 'completed' => 'success', default => 'secondary' }; @endphp
			<span class="badge bg-{{ $badge }}">{{ ucfirst($contact->status) }}</span></td>
			<td>{{ $contact->created_at->format('d M Y') }}</td>
			<td><a href="{{ route('admin.contacts.show', $contact) }}" class="btn btn-sm btn-outline-primary">View</a></td>
		</tr>
		@endforeach</tbody></table>
	</div></div>
</div>
@endsection
