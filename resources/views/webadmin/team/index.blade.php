@extends('webadmin.layouts.app')
@section('title', 'Team')
@section('content')
<div class="container-fluid">
	<div class="d-flex justify-content-between mb-4">
		<x-webadmin::page-breadcrumb title="Team Members" :home-url="route('admin.dashboard')" />
		<a href="{{ route('admin.team.create') }}" class="btn btn-primary">Add Member</a>
	</div>
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body table-responsive">
		<table class="table">
			<thead><tr><th>S.No</th><th>Photo</th><th>Name</th><th>Role</th><th>Order</th><th>Active</th><th></th></tr></thead>
			<tbody>
			@forelse($members as $member)
			<tr>
				<td>{{ $members->firstItem() + $loop->index }}</td>
				<td>@if($member->photoUrl())<img src="{{ $member->photoUrl() }}" width="48" height="60" class="rounded object-fit-cover">@else<span class="badge bg-secondary">{{ $member->initial() }}</span>@endif</td>
				<td>{{ $member->name }}</td>
				<td>{{ $member->role }}</td>
				<td>{{ $member->sort_order }}</td>
				<td>{{ $member->is_active ? 'Yes' : 'No' }}</td>
				<td class="text-end">
					<div class="table-actions">
						<a href="{{ route('admin.team.edit', $member) }}" class="btn btn-sm btn-outline-primary">Edit</a>
						<form action="{{ route('admin.team.destroy', $member) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
					</div>
				</td>
			</tr>
			@empty
			<tr><td colspan="7" class="text-muted">No team members yet.</td></tr>
			@endforelse
			</tbody>
		</table>
		@include('webadmin.partials.table-pagination', ['paginator' => $members])
	</div></div>
</div>
@endsection
