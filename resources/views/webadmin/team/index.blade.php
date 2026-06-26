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
		<table class="table"><thead><tr><th>Photo</th><th>Name</th><th>Role</th><th>Active</th><th></th></tr></thead><tbody>
		@foreach($members as $member)
		<tr>
			<td>@if($member->photoUrl())<img src="{{ $member->photoUrl() }}" width="40" height="40" class="rounded-circle object-fit-cover">@else<span class="badge bg-secondary">{{ $member->initial() }}</span>@endif</td>
			<td>{{ $member->name }}</td><td>{{ $member->role }}</td><td>{{ $member->is_active ? 'Yes' : 'No' }}</td>
			<td class="text-end"><a href="{{ route('admin.team.edit', $member) }}" class="btn btn-sm btn-outline-primary">Edit</a>
			<form action="{{ route('admin.team.destroy', $member) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn btn-sm btn-outline-danger">Delete</button></form></td>
		</tr>
		@endforeach</tbody></table>
	</div></div>
</div>
@endsection
