@extends('webadmin.layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Edit User" :home-url="route('admin.users.index')" />
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.users.update', $user) }}">@csrf @method('PUT')
			<div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" required value="{{ old('name', $user->name) }}"></div>
			<div class="mb-3"><label class="form-label">Email</label><input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}"></div>
			<div class="mb-3"><label class="form-label">New Password (optional)</label><input type="password" name="password" class="form-control"></div>
			<div class="mb-3"><label class="form-label">Confirm Password</label><input type="password" name="password_confirmation" class="form-control"></div>
			<button class="btn btn-primary">Update</button>
		</form>
	</div></div>
</div>
@endsection
