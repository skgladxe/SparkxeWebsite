@extends('webadmin.layouts.app')
@section('title', 'Add Team Member')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Add Team Member" :home-url="route('admin.team.index')" />
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.team.store') }}" enctype="multipart/form-data">@csrf
			@include('webadmin.team._form')
			<button class="btn btn-primary">Save</button>
		</form>
	</div></div>
</div>
@endsection
