@extends('webadmin.layouts.app')
@section('title', 'Edit User')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Edit User" :home-url="route('admin.users.index')" />
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.users.update', $user) }}" enctype="multipart/form-data">@csrf @method('PUT')
			<div class="row g-3">
				<div class="col-md-6">
					<label class="form-label">Name</label>
					<input name="name" class="form-control" required value="{{ old('name', $user->name) }}">
				</div>
				<div class="col-md-6">
					<label class="form-label">Email</label>
					<input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">
				</div>
				<div class="col-md-6">
					<label class="form-label">Role</label>
					<select name="role" class="form-select">
						<option value="">— Select role —</option>
						@foreach($roles as $role)
							<option value="{{ $role }}" @selected(old('role', $user->role) === $role)>{{ $role }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-6">
					<label class="form-label">Profile Photo</label>
					<input type="file" name="avatar" class="form-control" accept="image/*">
					@if($user->hasCustomAvatar())
						<div class="mt-2 d-flex align-items-center gap-2 flex-wrap">
							<img src="{{ $user->avatarUrl() }}" width="56" height="56" class="rounded-circle object-fit-cover">
							<div class="form-check mb-0">
								<input type="checkbox" name="remove_avatar" value="1" class="form-check-input" id="remove_avatar">
								<label class="form-check-label text-danger" for="remove_avatar">Remove</label>
							</div>
						</div>
					@endif
				</div>
				<div class="col-md-6">
					<label class="form-label">New Password (optional)</label>
					<input type="password" name="password" class="form-control">
				</div>
				<div class="col-md-6">
					<label class="form-label">Confirm Password</label>
					<input type="password" name="password_confirmation" class="form-control">
				</div>
				<div class="col-12">
					<button class="btn btn-primary">Update</button>
					<a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
				</div>
			</div>
		</form>
	</div></div>
</div>
@endsection
