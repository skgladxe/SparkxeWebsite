@extends('webadmin.layouts.app')
@section('title', 'Add Hero Slide')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Add Hero Slide" :home-url="route('admin.hero-slides.index')" />
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.hero-slides.store') }}" enctype="multipart/form-data">@csrf
			@include('webadmin.hero-slides._form')
			<button class="btn btn-primary mt-3">Save</button>
		</form>
	</div></div>
</div>
@endsection
