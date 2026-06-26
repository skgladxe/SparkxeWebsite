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
		<table class="table table-hover"><thead><tr><th>Name</th><th>Email</th><th></th></tr></thead><tbody>
		@foreach($users as $user)
		<tr><td>{{ $user->name }}</td><td>{{ $user->email }}</td>
		<td class="text-end">
			<a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary">Edit</a>
			@if($user->id !== auth()->id())
			<form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')
			<button class="btn btn-sm btn-outline-danger">Delete</button></form>
			@endif
		</td></tr>
		@endforeach
		</tbody></table>
	</div></div>
</div>
@endsection
