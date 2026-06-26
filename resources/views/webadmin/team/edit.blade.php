@extends('webadmin.layouts.app')
@section('title', 'Edit Team Member')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Edit Team Member" :home-url="route('admin.team.index')" />
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.team.update', $member) }}" enctype="multipart/form-data">@csrf @method('PUT')
			@include('webadmin.team._form', ['member' => $member])
			<button class="btn btn-primary">Update</button>
		</form>
	</div></div>
</div>
@endsection
