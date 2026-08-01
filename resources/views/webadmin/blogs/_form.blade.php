@php
	$blog = $blog ?? null;
	$seoMeta = $seoMeta ?? null;
	$company = config('website.name', 'Sparkxe Technologies');
@endphp

{{-- Post content --}}
<div class="card mb-3">
	<div class="card-header"><h6 class="mb-0">Post Content</h6></div>
	<div class="card-body">
		<div class="row g-3">
			<div class="col-md-8">
				<label class="form-label" for="title">Title</label>
				<input type="text" name="title" id="title" class="form-control" required value="{{ old('title', $blog?->title) }}">
			</div>
			<div class="col-md-4">
				<label class="form-label" for="blog_category_id">Category</label>
				<select name="blog_category_id" id="blog_category_id" class="form-select">
					<option value="">— None —</option>
					@foreach ($categories as $cat)
						<option value="{{ $cat->id }}" @selected(old('blog_category_id', $blog?->blog_category_id) == $cat->id)>{{ $cat->name }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-6">
				<label class="form-label" for="slug">Slug <span class="text-muted">(optional)</span></label>
				<input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug', $blog?->slug) }}" placeholder="Auto-generated from title">
			</div>
			<div class="col-md-3">
				<label class="form-label" for="read_time">Read time (min)</label>
				<input type="number" name="read_time" id="read_time" class="form-control" min="1" max="120" value="{{ old('read_time', $blog?->read_time ?? 5) }}">
			</div>
			<div class="col-md-3">
				<label class="form-label" for="published_at">Published at</label>
				<input type="datetime-local" name="published_at" id="published_at" class="form-control" value="{{ old('published_at', optional($blog?->published_at)->format('Y-m-d\TH:i')) }}">
			</div>
			<div class="col-12">
				<label class="form-label" for="excerpt">Excerpt</label>
				<textarea name="excerpt" id="excerpt" class="form-control" rows="2">{{ old('excerpt', $blog?->excerpt) }}</textarea>
			</div>
			<div class="col-12">
				<label class="form-label" for="content">Content</label>
				<textarea name="content" id="content" class="form-control rich-editor" rows="10">{{ old('content', $blog?->content) }}</textarea>
			</div>
			<div class="col-md-6">
				<label class="form-label" for="featured_image">Featured Image</label>
				<input type="file" name="featured_image" id="featured_image" class="form-control" accept="image/*">
				@if ($blog?->featured_image)
					<div class="mt-2 d-flex align-items-center gap-2 flex-wrap">
						<img src="{{ $blog->imageUrl() }}" height="80" class="rounded" alt="">
						<div class="form-check mb-0">
							<input type="checkbox" name="remove_featured_image" value="1" class="form-check-input" id="remove_featured_image">
							<label class="form-check-label text-danger" for="remove_featured_image">Remove</label>
						</div>
					</div>
				@endif
			</div>
			<div class="col-md-6 d-flex align-items-end">
				<div class="form-check form-switch">
					<input type="checkbox" name="is_published" value="1" class="form-check-input" id="is_published" @checked(old('is_published', $blog?->is_published))>
					<label class="form-check-label" for="is_published">Published</label>
				</div>
			</div>
		</div>
	</div>
</div>

{{-- SEO score widgets --}}
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
					<div class="google-preview-title" id="previewTitle">{{ old('meta_title', $seoMeta?->meta_title) ?: 'Post Title' }}</div>
					<div class="google-preview-url" id="previewUrl">{{ url('/blog/'.(old('slug', $blog?->slug) ?: 'your-post')) }}</div>
					<div class="google-preview-description" id="previewDescription">{{ old('meta_description', $seoMeta?->meta_description) ?: 'Meta description preview.' }}</div>
				</div>
			</div>
		</div>
	</div>
</div>

{{-- Basic SEO --}}
<div class="card mb-3">
	<div class="card-header"><h6 class="mb-0">Basic SEO</h6></div>
	<div class="card-body">
		<div class="row g-3">
			<div class="col-md-6">
				<label class="form-label" for="meta_title">Meta Title</label>
				<input type="text" class="form-control seo-field" id="meta_title" name="meta_title" maxlength="255" value="{{ old('meta_title', $seoMeta?->meta_title) }}" placeholder="{{ ($blog?->title ?? 'Post title').' — '.$company }}">
				<div class="form-text char-counter" data-target="meta_title" data-min="30" data-max="60">0 / 60</div>
			</div>
			<div class="col-md-6">
				<label class="form-label" for="focus_keyword">Focus Keyword</label>
				<input type="text" class="form-control seo-field" id="focus_keyword" name="focus_keyword" value="{{ old('focus_keyword', $seoMeta?->focus_keyword) }}" maxlength="150">
			</div>
			<div class="col-12">
				<label class="form-label" for="meta_description">Meta Description</label>
				<textarea class="form-control seo-field" id="meta_description" name="meta_description" rows="2">{{ old('meta_description', $seoMeta?->meta_description) }}</textarea>
				<div class="form-text char-counter" data-target="meta_description" data-min="120" data-max="160">0 / 160</div>
			</div>
			<div class="col-12">
				<label class="form-label" for="meta_keywords">Meta Keywords</label>
				<textarea class="form-control seo-field" id="meta_keywords" name="meta_keywords" rows="2" placeholder="keyword1, keyword2, keyword3">{{ old('meta_keywords', $seoMeta?->meta_keywords) }}</textarea>
			</div>
			<div class="col-md-6">
				<label class="form-label" for="h1_heading">H1 Heading</label>
				<input type="text" class="form-control seo-field" id="h1_heading" name="h1_heading" value="{{ old('h1_heading', $seoMeta?->h1_heading) }}" placeholder="Defaults to post title">
			</div>
			<div class="col-md-6">
				<label class="form-label" for="og_title">OG Title</label>
				<input type="text" class="form-control" id="og_title" name="og_title" value="{{ old('og_title', $seoMeta?->og_title) }}">
			</div>
			<div class="col-12">
				<label class="form-label" for="og_description">OG Description</label>
				<textarea class="form-control" id="og_description" name="og_description" rows="2">{{ old('og_description', $seoMeta?->og_description) }}</textarea>
			</div>
		</div>
	</div>
</div>

{{-- Technical SEO --}}
<div class="card mb-3">
	<div class="card-header"><h6 class="mb-0">Technical SEO</h6></div>
	<div class="card-body">
		<div class="row g-3">
			<div class="col-md-8">
				<label class="form-label" for="canonical_url">Canonical URL</label>
				<input type="url" class="form-control" id="canonical_url" name="canonical_url" value="{{ old('canonical_url', $seoMeta?->canonical_url) }}" placeholder="{{ url('/blog/'.(old('slug', $blog?->slug) ?: 'your-post')) }}">
			</div>
			<div class="col-md-4">
				<label class="form-label" for="sitemap_priority">Sitemap Priority</label>
				<select class="form-select" id="sitemap_priority" name="sitemap_priority">
					@foreach (['1.0', '0.9', '0.8', '0.7', '0.5', '0.3'] as $priority)
						<option value="{{ $priority }}" @selected(old('sitemap_priority', $seoMeta?->sitemap_priority ?? '0.7') == $priority)>{{ $priority }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-md-6">
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" id="robots_index" name="robots_index" value="1" @checked(old('robots_index', $seoMeta?->robots_index ?? true))>
					<label class="form-check-label" for="robots_index">Allow indexing</label>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-check form-switch">
					<input class="form-check-input" type="checkbox" id="robots_follow" name="robots_follow" value="1" @checked(old('robots_follow', $seoMeta?->robots_follow ?? true))>
					<label class="form-check-label" for="robots_follow">Allow following links</label>
				</div>
			</div>
		</div>
	</div>
</div>

{{-- Schema --}}
<div class="card mb-3">
	<div class="card-header d-flex justify-content-between align-items-center">
		<h6 class="mb-0">Schema (JSON-LD)</h6>
		<button type="button" class="btn btn-sm btn-outline-primary" id="generateSchemaBtn">Generate</button>
	</div>
	<div class="card-body">
		<div class="row g-3">
			<div class="col-md-4">
				<label class="form-label" for="schema_type">Schema Type</label>
				<select class="form-select" id="schema_type" name="schema_type">
					@foreach ([
						'Article' => 'Article / Blog Post',
						'WebPage' => 'Web Page',
						'none' => 'None',
					] as $value => $label)
						<option value="{{ $value }}" @selected(old('schema_type', $seoMeta?->schema_type ?? 'Article') === $value)>{{ $label }}</option>
					@endforeach
				</select>
			</div>
			<div class="col-12">
				<label class="form-label" for="schema_json">Schema JSON</label>
				<textarea class="form-control font-monospace" id="schema_json" name="schema_json" rows="8">{{ old('schema_json', $seoMeta?->schema_json) }}</textarea>
			</div>
		</div>
	</div>
</div>
