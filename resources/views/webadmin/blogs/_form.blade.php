@php $blog = $blog ?? null; @endphp
<div class="row g-3">
	<div class="col-md-8"><label class="form-label">Title</label><input name="title" class="form-control" required value="{{ old('title', $blog?->title) }}"></div>
	<div class="col-md-4"><label class="form-label">Category</label>
		<select name="blog_category_id" class="form-select">
			<option value="">— None —</option>
			@foreach($categories as $cat)
				<option value="{{ $cat->id }}" @selected(old('blog_category_id', $blog?->blog_category_id) == $cat->id)>{{ $cat->name }}</option>
			@endforeach
		</select>
	</div>
	<div class="col-md-6"><label class="form-label">Slug (optional)</label><input name="slug" class="form-control" value="{{ old('slug', $blog?->slug) }}"></div>
	<div class="col-md-3"><label class="form-label">Read time (min)</label><input type="number" name="read_time" class="form-control" value="{{ old('read_time', $blog?->read_time ?? 5) }}"></div>
	<div class="col-md-3"><label class="form-label">Published at</label><input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', optional($blog?->published_at)->format('Y-m-d\TH:i')) }}"></div>
	<div class="col-12"><label class="form-label">Excerpt</label><textarea name="excerpt" class="form-control" rows="2">{{ old('excerpt', $blog?->excerpt) }}</textarea></div>
	<div class="col-12"><label class="form-label">Content</label><textarea name="content" class="form-control" rows="10">{{ old('content', $blog?->content) }}</textarea></div>
	<div class="col-md-6">
		<label class="form-label">Featured Image</label>
		<input type="file" name="featured_image" class="form-control" accept="image/*">
		@if($blog?->featured_image)
			<div class="mt-2 d-flex align-items-center gap-2 flex-wrap">
				<img src="{{ $blog->imageUrl() }}" height="80" class="rounded">
				<div class="form-check mb-0">
					<input type="checkbox" name="remove_featured_image" value="1" class="form-check-input" id="remove_featured_image">
					<label class="form-check-label text-danger" for="remove_featured_image">Remove</label>
				</div>
			</div>
		@endif
	</div>
	<div class="col-md-6 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_published" value="1" class="form-check-input" @checked(old('is_published', $blog?->is_published))><label class="form-check-label">Published</label></div></div>
</div>
