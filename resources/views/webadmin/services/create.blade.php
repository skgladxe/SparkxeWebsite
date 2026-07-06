@extends('webadmin.layouts.app')
@section('title', 'Add Service')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Add Service" :home-url="route('admin.services.index')" />
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data">@csrf
			@include('webadmin.services._form')
			<button class="btn btn-primary mt-3">Save</button>
		</form>
	</div></div>
</div>
@endsection
@include('webadmin.partials.rich-editor')
