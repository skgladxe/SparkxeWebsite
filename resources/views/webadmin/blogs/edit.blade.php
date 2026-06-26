@extends('webadmin.layouts.app')
@section('title', 'Edit Blog Post')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Edit Blog Post" :home-url="route('admin.blogs.index')" />
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.blogs.update', $blog) }}" enctype="multipart/form-data">@csrf @method('PUT')
			@include('webadmin.blogs._form', ['blog' => $blog])
			<button class="btn btn-primary">Update</button>
		</form>
	</div></div>
</div>
@endsection
