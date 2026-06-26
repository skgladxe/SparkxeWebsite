@extends('webadmin.layouts.app')
@section('title', 'Add Category')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Add Category" :home-url="route('admin.blog-categories.index')" />
	<div class="card"><div class="card-body">
		<form method="POST" action="{{ route('admin.blog-categories.store') }}">@csrf
			<div class="mb-3"><label class="form-label">Name</label><input name="name" class="form-control" required value="{{ old('name') }}"></div>
			<div class="mb-3"><label class="form-label">Slug (optional)</label><input name="slug" class="form-control" value="{{ old('slug') }}"></div>
			<div class="mb-3"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}"></div>
			<div class="form-check mb-3"><input type="checkbox" name="is_active" value="1" class="form-check-input" checked><label class="form-check-label">Active</label></div>
			<button class="btn btn-primary">Save</button>
		</form>
	</div></div>
</div>
@endsection
