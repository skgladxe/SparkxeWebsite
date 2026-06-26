@extends('webadmin.layouts.app')
@section('title', 'Edit Category')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Edit Category" :home-url="route('admin.blog-categories.index')" />
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.blog-categories.update', $category) }}">@csrf @method('PUT')
			<div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" required value="{{ old('name', $category->name) }}"></div>
			<div class="mb-3"><label class="form-label">Slug</label><input name="slug" class="form-control" value="{{ old('slug', $category->slug) }}"></div>
			<div class="mb-3"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $category->sort_order) }}"></div>
			<div class="form-check mb-3"><input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $category->is_active))><label class="form-check-label">Active</label></div>
			<button class="btn btn-primary">Update</button>
		</form>
	</div></div>
</div>
@endsection
