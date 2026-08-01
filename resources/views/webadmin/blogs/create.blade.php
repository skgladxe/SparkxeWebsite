@extends('webadmin.layouts.app')

@section('title', 'Add Blog Post')

@push('styles')
<style>
	.seo-score-circle { width: 90px; height: 90px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; font-weight: 700; margin: 0 auto 0.5rem; border: 5px solid #e9ecef; }
	.seo-score-circle.score-good { border-color: #25cba1; color: #15715a; }
	.seo-score-circle.score-medium { border-color: #ffc107; color: #856404; }
	.seo-score-circle.score-poor { border-color: #dc3545; color: #842029; }
	.seo-check-item { display: flex; justify-content: space-between; padding: 0.35rem 0; border-bottom: 1px solid #f1f1f1; font-size: 0.875rem; }
	.seo-check-item:last-child { border-bottom: none; }
	.google-preview-box { border: 1px solid #dfe1e5; border-radius: 8px; padding: 1rem; background: #fff; }
	.google-preview-title { color: #1a0dab; font-size: 1rem; margin-bottom: 0.25rem; }
	.google-preview-url { color: #006621; font-size: 0.8rem; margin-bottom: 0.25rem; }
	.google-preview-description { color: #545454; font-size: 0.8rem; }
</style>
@endpush

@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Add Blog Post" :home-url="route('admin.blogs.index')" />

	@include('webadmin.partials.alerts')

	@if ($errors->any())
		<div class="alert alert-danger mb-3">
			@foreach ($errors->all() as $error)
				<div>{{ $error }}</div>
			@endforeach
		</div>
	@endif

	<form method="POST" action="{{ route('admin.blogs.store') }}" enctype="multipart/form-data" id="blogForm">
		@csrf

		@include('webadmin.blogs._form', ['seoMeta' => null])

		<div class="d-flex gap-2 mb-3">
			<button type="submit" class="btn btn-primary">Save Post</button>
			<a href="{{ route('admin.blogs.index') }}" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>

@include('webadmin.blogs._seo_analyzer', ['seoMeta' => null])
@endsection

@include('webadmin.partials.rich-editor')
