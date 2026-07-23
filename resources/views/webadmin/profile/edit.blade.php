@extends('webadmin.layouts.app')
@section('title', 'Profile')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="My Profile" :home-url="route('admin.dashboard')" />
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">@csrf @method('PUT')
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
					<input class="form-control" value="{{ $user->roleLabel() }}" disabled>
				</div>
				<div class="col-md-6">
					<label class="form-label">Profile Photo</label>
					<input type="file" name="avatar" class="form-control" accept="image/*">
					<div class="mt-2 d-flex align-items-center gap-2 flex-wrap">
						<img src="{{ $user->avatarUrl() }}" width="56" height="56" class="rounded-circle object-fit-cover" alt="">
						@if($user->hasCustomAvatar())
							<div class="form-check mb-0">
								<input type="checkbox" name="remove_avatar" value="1" class="form-check-input" id="remove_avatar">
								<label class="form-check-label text-danger" for="remove_avatar">Remove</label>
							</div>
						@endif
					</div>
				</div>
				<div class="col-12">
					<button class="btn btn-primary">Save Profile</button>
					<a href="{{ route('admin.profile.password.edit') }}" class="btn btn-outline-secondary">Change Pass</a>
				</div>
			</div>
		</form>
	</div></div>
</div>
@endsection
