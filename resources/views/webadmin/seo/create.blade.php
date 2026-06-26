@extends('webadmin.layouts.app')

@section('title', 'Add SEO Page — '.config('webadmin.name'))

@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Add SEO Page" :home-url="route('admin.seo.index')" />

	<div class="card">
		<div class="card-body">
			<form method="POST" action="{{ route('admin.seo.store') }}">
				@csrf
				<div class="row g-3">
					<div class="col-md-6">
						<label for="page_label" class="form-label">Page Label</label>
						<input type="text" class="form-control" id="page_label" name="page_label" value="{{ old('page_label') }}" required>
					</div>
					<div class="col-md-6">
						<label for="route_key" class="form-label">Route Key</label>
						<input type="text" class="form-control" id="route_key" name="route_key" list="routeKeySuggestions" value="{{ old('route_key') }}" required>
						<datalist id="routeKeySuggestions">
							@foreach ($routeKeySuggestions as $key => $label)
								<option value="{{ $key }}">{{ $label }}</option>
							@endforeach
						</datalist>
					</div>
					<div class="col-md-6">
						<label for="url_slug" class="form-label">URL Slug</label>
						<input type="text" class="form-control" id="url_slug" name="url_slug" value="{{ old('url_slug') }}" placeholder="/new-website/about" required>
					</div>
					<div class="col-md-6">
						<label for="meta_title" class="form-label">Meta Title</label>
						<input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" maxlength="255">
					</div>
					<div class="col-12">
						<label for="meta_description" class="form-label">Meta Description</label>
						<textarea class="form-control" id="meta_description" name="meta_description" rows="3">{{ old('meta_description') }}</textarea>
					</div>
					<div class="col-md-6">
						<label for="schema_type" class="form-label">Schema Type</label>
						<select class="form-select" id="schema_type" name="schema_type">
							@foreach (['WebPage' => 'Web Page', 'FAQPage' => 'FAQ Page', 'Organization' => 'Organization', 'none' => 'None'] as $value => $label)
								<option value="{{ $value }}" @selected(old('schema_type', 'WebPage') === $value)>{{ $label }}</option>
							@endforeach
						</select>
					</div>
					<div class="col-md-6">
						<label for="sitemap_priority" class="form-label">Sitemap Priority</label>
						<select class="form-select" id="sitemap_priority" name="sitemap_priority">
							@foreach (['1.0', '0.9', '0.8', '0.7', '0.5', '0.3'] as $priority)
								<option value="{{ $priority }}" @selected(old('sitemap_priority', '0.5') == $priority)>{{ $priority }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="d-flex gap-2 mt-4">
					<button type="submit" class="btn btn-primary">Create SEO Page</button>
					<a href="{{ route('admin.seo.index') }}" class="btn btn-outline-secondary">Cancel</a>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection
