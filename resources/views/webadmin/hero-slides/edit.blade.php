@extends('webadmin.layouts.app')
@section('title', 'Edit Hero Slide')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Edit Hero Slide" :home-url="route('admin.hero-slides.index')" />
	@include('webadmin.partials.alerts')
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.hero-slides.update', $slide) }}" enctype="multipart/form-data">@csrf @method('PUT')
			@include('webadmin.hero-slides._form', ['slide' => $slide])
			<button class="btn btn-primary mt-3">Update</button>
		</form>
	</div></div>
</div>
@endsection
