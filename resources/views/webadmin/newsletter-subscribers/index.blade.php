@extends('webadmin.layouts.app')
@section('title', 'Newsletter Subscribers')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Newsletter Subscribers" :home-url="route('admin.dashboard')" />
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body table-responsive">
		<table class="table"><thead><tr><th>Mobile Number</th><th>Email</th><th>Subscribed</th></tr></thead><tbody>
		@forelse($subscribers as $subscriber)
		<tr>
			<td>{{ $subscriber->mobile_number ?: '-' }}</td>
			<td>{{ $subscriber->email }}</td>
			<td>{{ $subscriber->subscribed_at?->format('d M Y, h:i A') ?? $subscriber->created_at->format('d M Y, h:i A') }}</td>
		</tr>
		@empty
		<tr><td colspan="3" class="text-muted">No subscribers yet.</td></tr>
		@endforelse</tbody></table>
	</div></div>
</div>
@endsection
