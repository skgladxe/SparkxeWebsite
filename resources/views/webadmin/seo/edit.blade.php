@extends('webadmin.layouts.app')

@section('title', 'Edit SEO — '.$seoMeta->page_label)

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
	<x-webadmin::page-breadcrumb :title="'Edit SEO: '.$seoMeta->page_label" :home-url="route('admin.seo.index')" />

	<p class="text-muted mb-3">
		Route key: <code>{{ $seoMeta->route_key }}</code>
		· URL: <code>{{ $seoMeta->url_slug }}</code>
	</p>

	@if ($errors->any())
		<div class="alert alert-danger mb-3">
			@foreach ($errors->all() as $error)
				<div>{{ $error }}</div>
			@endforeach
		</div>
	@endif

	<form method="POST" action="{{ route('admin.seo.update', $seoMeta) }}" enctype="multipart/form-data" id="seoForm">
		@csrf
		@method('PUT')

		<div class="row g-3 mb-3">
			<div class="col-md-4">
				<div class="card h-100">
					<div class="card-body text-center py-3">
						<h6 class="mb-2">SEO Score</h6>
						<div class="seo-score-circle score-poor" id="seoScoreCircle">0</div>
						<p class="text-muted small mb-0" id="seoScoreLabel">Not analyzed</p>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card h-100">
					<div class="card-header py-2"><h6 class="mb-0">Checklist</h6></div>
					<div class="card-body py-2">
						<div class="seo-check-item"><span>Title</span><span id="checkTitle" class="badge bg-secondary">—</span></div>
						<div class="seo-check-item"><span>Description</span><span id="checkDescription" class="badge bg-secondary">—</span></div>
						<div class="seo-check-item"><span>Keyword</span><span id="checkKeyword" class="badge bg-secondary">—</span></div>
						<div class="seo-check-item"><span>Schema</span><span id="checkSchema" class="badge bg-secondary">—</span></div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<div class="card h-100">
					<div class="card-header py-2"><h6 class="mb-0">Google Preview</h6></div>
					<div class="card-body py-2">
						<div class="google-preview-box">
							<div class="google-preview-title" id="previewTitle">Page Title</div>
							<div class="google-preview-url" id="previewUrl">{{ url('/') }}</div>
							<div class="google-preview-description" id="previewDescription">Meta description preview.</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card mb-3">
			<div class="card-header"><h6 class="mb-0">Basic SEO</h6></div>
			<div class="card-body">
				@php
					$urlSlugDisplay = old('url_slug');
					if ($urlSlugDisplay === null && $seoMeta->url_slug) {
						$urlSlugDisplay = $seoMeta->url_slug === '/' ? url('/') : url(ltrim($seoMeta->url_slug, '/'));
					}
				@endphp
				<div class="row g-3">
					<div class="col-md-6">
						<label for="url_slug" class="form-label">URL Slug</label>
						<input type="text" class="form-control seo-field" id="url_slug" name="url_slug" value="{{ $urlSlugDisplay }}" required>
					</div>
					<div class="col-md-6">
						<label for="focus_keyword" class="form-label">Focus Keyword</label>
						<input type="text" class="form-control seo-field" id="focus_keyword" name="focus_keyword" value="{{ old('focus_keyword', $seoMeta->focus_keyword) }}">
					</div>
					<div class="col-md-6">
						<label for="meta_title" class="form-label">Meta Title</label>
						<input type="text" class="form-control seo-field" id="meta_title" name="meta_title" value="{{ old('meta_title', $seoMeta->meta_title) }}" maxlength="255">
						<div class="form-text char-counter" data-target="meta_title" data-min="30" data-max="60">0 / 60</div>
					</div>
					<div class="col-md-6">
						<label for="h1_heading" class="form-label">H1 Heading</label>
						<input type="text" class="form-control seo-field" id="h1_heading" name="h1_heading" value="{{ old('h1_heading', $seoMeta->h1_heading) }}">
					</div>
					<div class="col-12">
						<label for="meta_description" class="form-label">Meta Description</label>
						<textarea class="form-control seo-field" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $seoMeta->meta_description) }}</textarea>
						<div class="form-text char-counter" data-target="meta_description" data-min="120" data-max="160">0 / 160</div>
					</div>
					<div class="col-12">
						<label for="meta_keywords" class="form-label">Meta Keywords</label>
						<textarea class="form-control seo-field" id="meta_keywords" name="meta_keywords" rows="2">{{ old('meta_keywords', $seoMeta->meta_keywords) }}</textarea>
					</div>
				</div>
			</div>
		</div>

		<div class="card mb-3">
			<div class="card-header"><h6 class="mb-0">Social Media</h6></div>
			<div class="card-body">
				<div class="row g-3">
					<div class="col-md-6">
						<label for="og_title" class="form-label">OG Title</label>
						<input type="text" class="form-control" id="og_title" name="og_title" value="{{ old('og_title', $seoMeta->og_title) }}">
					</div>
					<div class="col-md-6">
						<label for="og_image" class="form-label">OG Image</label>
						@if ($seoMeta->og_image)
							<div class="mb-2"><img src="{{ $seoMeta->og_image_url }}" alt="OG" class="img-thumbnail" style="max-height:80px"></div>
						@endif
						<input type="file" class="form-control" id="og_image" name="og_image" accept="image/*">
					</div>
					<div class="col-12">
						<label for="og_description" class="form-label">OG Description</label>
						<textarea class="form-control" id="og_description" name="og_description" rows="2">{{ old('og_description', $seoMeta->og_description) }}</textarea>
					</div>
				</div>
			</div>
		</div>

		<div class="card mb-3">
			<div class="card-header"><h6 class="mb-0">Technical SEO</h6></div>
			<div class="card-body">
				<div class="row g-3">
					<div class="col-md-8">
						<label for="canonical_url" class="form-label">Canonical URL</label>
						<input type="url" class="form-control" id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $seoMeta->canonical_url) }}">
					</div>
					<div class="col-md-4">
						<label for="sitemap_priority" class="form-label">Sitemap Priority</label>
						<select class="form-select" id="sitemap_priority" name="sitemap_priority">
							@foreach (['1.0', '0.9', '0.8', '0.7', '0.5', '0.3'] as $priority)
								<option value="{{ $priority }}" @selected(old('sitemap_priority', $seoMeta->sitemap_priority) == $priority)>{{ $priority }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6">
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" id="robots_index" name="robots_index" value="1" {{ old('robots_index', $seoMeta->robots_index) ? 'checked' : '' }}>
							<label class="form-check-label" for="robots_index">Allow indexing</label>
						</div>
					</div>
					<div class="col-md-6">
						<div class="form-check form-switch">
							<input class="form-check-input" type="checkbox" id="robots_follow" name="robots_follow" value="1" {{ old('robots_follow', $seoMeta->robots_follow) ? 'checked' : '' }}>
							<label class="form-check-label" for="robots_follow">Allow following links</label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="card mb-3">
			<div class="card-header d-flex justify-content-between align-items-center">
				<h6 class="mb-0">Schema (JSON-LD)</h6>
				<button type="button" class="btn btn-sm btn-outline-primary" id="generateSchemaBtn">Generate</button>
			</div>
			<div class="card-body">
				<div class="row g-3">
					<div class="col-md-4">
						<label for="schema_type" class="form-label">Schema Type</label>
						<select class="form-select" id="schema_type" name="schema_type">
							@foreach (['none' => 'None', 'WebPage' => 'Web Page', 'FAQPage' => 'FAQ Page', 'Organization' => 'Organization'] as $value => $label)
								<option value="{{ $value }}" @selected(old('schema_type', $seoMeta->schema_type) === $value)>{{ $label }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-12">
						<label for="schema_json" class="form-label">Schema JSON</label>
						<textarea class="form-control font-monospace" id="schema_json" name="schema_json" rows="6">{{ old('schema_json', $seoMeta->schema_json) }}</textarea>
					</div>
				</div>
			</div>
		</div>

		<div class="d-flex gap-2 mb-2">
			<button type="submit" class="btn btn-primary">Save SEO Settings</button>
			<a href="{{ route('admin.seo.index') }}" class="btn btn-outline-secondary">Cancel</a>
		</div>
	</form>
</div>

@include('webadmin.seo._analyzer')
@endsection
