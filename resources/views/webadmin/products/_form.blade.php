@php $product = $product ?? null; @endphp
<div class="row g-3">
	<div class="col-md-6">
		<label class="form-label">Title</label>
		<input name="title" class="form-control" required value="{{ old('title', $product?->title) }}">
	</div>
	<div class="col-md-6">
		<label class="form-label">Slug</label>
		<input name="slug" class="form-control" value="{{ old('slug', $product?->slug) }}" placeholder="Auto-generated from title">
	</div>
	<div class="col-md-6">
		<label class="form-label">Subtitle</label>
		<input name="subtitle" class="form-control" value="{{ old('subtitle', $product?->subtitle) }}">
	</div>
	<div class="col-md-3">
		<label class="form-label">Sort Order</label>
		<input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $product?->sort_order ?? 0) }}">
	</div>
	<div class="col-md-3 d-flex align-items-end">
		<div class="form-check">
			<input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $product?->is_active ?? true))>
			<label class="form-check-label">Active</label>
		</div>
	</div>
	<div class="col-12">
		<label class="form-label">Icon</label>
		<input name="icon" class="form-control" value="{{ old('icon', $product?->icon) }}" placeholder="fa-solid fa-pen-nib">
	</div>
	<div class="col-12">
		<label class="form-label">Description</label>
		<textarea name="description" class="form-control" rows="3" required>{{ old('description', $product?->description) }}</textarea>
	</div>
	<div class="col-12">
		<label class="form-label">Notes (detail page)</label>
		<textarea name="notes" class="form-control rich-editor" rows="8">{{ old('notes', $product?->notes) }}</textarea>
	</div>
	<div class="col-md-6">
		<label class="form-label">Card Image</label>
		<input type="file" name="image" class="form-control" accept="image/*">
		@if($product?->imageUrl())<img src="{{ $product->imageUrl() }}" height="60" class="mt-2 rounded">@endif
	</div>
</div>
