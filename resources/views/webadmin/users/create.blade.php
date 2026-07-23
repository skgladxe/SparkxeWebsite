@extends('webadmin.layouts.app')
@section('title', 'Add User')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Add User" :home-url="route('admin.users.index')" />
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">@csrf
			<div class="row g-3">
				<div class="col-md-6">
					<label class="form-label">Name</label>
					<input name="name" class="form-control" required value="{{ old('name') }}">
				</div>
				<div class="col-md-6">
					<label class="form-label">Email</label>
					<input type="email" name="email" class="form-control" required value="{{ old('email') }}">
				</div>
				<div class="col-md-6">
					<label class="form-label">Role</label>
					<select name="role" class="form-select">
						<option value="">— Select role —</option>
						@foreach($roles as $role)
							<option value="{{ $role }}" @selected(old('role') === $role)>{{ $role }}</option>
						@endforeach
					</select>
				</div>
				<div class="col-md-6">
					<label class="form-label">Profile Photo</label>
					<input type="file" name="avatar" class="form-control" accept="image/*">
				</div>
				<div class="col-md-6">
					<label class="form-label">Password</label>
					<input type="password" name="password" class="form-control" required>
				</div>
				<div class="col-md-6">
					<label class="form-label">Confirm Password</label>
					<input type="password" name="password_confirmation" class="form-control" required>
				</div>
				<div class="col-12">
					<button class="btn btn-primary">Save</button>
					<a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Cancel</a>
				</div>
			</div>
		</form>
	</div></div>
</div>
@endsection
