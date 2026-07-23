@extends('webadmin.layouts.app')
@section('title', 'Change Password')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Change Password" :home-url="route('admin.profile.edit')" />
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.profile.password.update') }}">@csrf @method('PUT')
			<div class="row g-3" style="max-width: 480px;">
				<div class="col-12">
					<label class="form-label">Current Password</label>
					<input type="password" name="current_password" class="form-control" required>
				</div>
				<div class="col-12">
					<label class="form-label">New Password</label>
					<input type="password" name="password" class="form-control" required>
				</div>
				<div class="col-12">
					<label class="form-label">Confirm New Password</label>
					<input type="password" name="password_confirmation" class="form-control" required>
				</div>
				<div class="col-12">
					<button class="btn btn-primary">Update Password</button>
					<a href="{{ route('admin.profile.edit') }}" class="btn btn-outline-secondary">Back</a>
				</div>
			</div>
		</form>
	</div></div>
</div>
@endsection
