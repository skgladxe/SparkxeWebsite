@extends('webadmin.layouts.app')
@section('title', 'Add Blog Post')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Add Blog Post" :home-url="route('admin.blogs.index')" />
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data">@csrf
			@include('webadmin.blogs._form')
			<button class="btn btn-primary">Save</button>
		</form>
	</div></div>
</div>
@endsection
