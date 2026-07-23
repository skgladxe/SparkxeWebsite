@extends('webadmin.layouts.app')
@section('title', 'Users')
@section('content')
<div class="container-fluid">
	<div class="d-flex justify-content-between align-items-center mb-4">
		<x-webadmin::page-breadcrumb title="Users" :home-url="route('admin.dashboard')" />
		<a href="{{ route('admin.users.create') }}" class="btn btn-primary">Add User</a>
	</div>
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body table-responsive">
		<table class="table table-hover">
			<thead><tr><th>S.No</th><th>Photo</th><th>Name</th><th>Email</th><th>Role</th><th></th></tr></thead>
			<tbody>
			@forelse($users as $user)
			<tr>
				<td>{{ $users->firstItem() + $loop->index }}</td>
				<td><img src="{{ $user->avatarUrl() }}" width="36" height="36" class="rounded-circle object-fit-cover" alt=""></td>
				<td>{{ $user->name }}</td>
				<td>{{ $user->email }}</td>
				<td>{{ $user->roleLabel() }}</td>
				<td class="text-end">
					<div class="table-actions">
						<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
						@if($user->id !== auth()->id())
						<form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
						<button type="submit" class="btn btn-sm btn-outline-danger">Delete</button></form>
						@endif
					</div>
				</td>
			</tr>
			@empty
			<tr><td colspan="6" class="text-muted">No users yet.</td></tr>
			@endforelse
			</tbody>
		</table>
		@include('webadmin.partials.table-pagination', ['paginator' => $users])
	</div></div>
</div>
@endsection
