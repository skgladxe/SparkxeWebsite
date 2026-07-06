@extends('webadmin.layouts.app')
@section('title', 'Edit Service')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Edit Service" :home-url="route('admin.services.index')" />
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.services.update', $service) }}" enctype="multipart/form-data">@csrf @method('PUT')
			@include('webadmin.services._form', ['service' => $service])
			<button class="btn btn-primary mt-3">Update</button>
		</form>
	</div></div>
</div>
@endsection
@include('webadmin.partials.rich-editor')
