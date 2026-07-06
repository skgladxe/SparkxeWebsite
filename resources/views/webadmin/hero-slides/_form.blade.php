@php $slide = $slide ?? null; @endphp
<div class="row g-3">
	<div class="col-md-6">
		<label class="form-label">Subtitle (eyebrow)</label>
		<input name="subtitle" class="form-control" required value="{{ old('subtitle', $slide?->subtitle) }}">
	</div>
	<div class="col-md-6">
		<label class="form-label">Sort Order</label>
		<input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $slide?->sort_order ?? 0) }}">
	</div>
	<div class="col-md-8">
		<label class="form-label">Title</label>
		<input name="title" class="form-control" required value="{{ old('title', $slide?->title) }}">
	</div>
	<div class="col-md-4">
		<label class="form-label">Title Highlight</label>
		<input name="title_highlight" class="form-control" value="{{ old('title_highlight', $slide?->title_highlight) }}" placeholder="Phrase to highlight">
	</div>
	<div class="col-12">
		<label class="form-label">Description</label>
		<textarea name="description" class="form-control" rows="4" required>{{ old('description', $slide?->description) }}</textarea>
	</div>
	<div class="col-md-6">
		<label class="form-label">Primary Button Text</label>
		<input name="primary_button_text" class="form-control" required value="{{ old('primary_button_text', $slide?->primary_button_text) }}">
	</div>
	<div class="col-md-6">
		<label class="form-label">Primary Button URL</label>
		<input name="primary_button_url" class="form-control" required value="{{ old('primary_button_url', $slide?->primary_button_url) }}">
	</div>
	<div class="col-md-6">
		<label class="form-label">Secondary Button Text</label>
		<input name="secondary_button_text" class="form-control" value="{{ old('secondary_button_text', $slide?->secondary_button_text) }}">
	</div>
	<div class="col-md-6">
		<label class="form-label">Secondary Button URL</label>
		<input name="secondary_button_url" class="form-control" value="{{ old('secondary_button_url', $slide?->secondary_button_url) }}">
	</div>
	<div class="col-md-4">
		<label class="form-label">Main Image</label>
		<input type="file" name="main_image" class="form-control" accept="image/*">
		@if($slide?->mainImageUrl())<img src="{{ $slide->mainImageUrl() }}" height="60" class="mt-2 rounded">@endif
	</div>
	<div class="col-md-4">
		<label class="form-label">Left Image</label>
		<input type="file" name="left_image" class="form-control" accept="image/*">
		@if($slide?->leftImageUrl())<img src="{{ $slide->leftImageUrl() }}" height="60" class="mt-2 rounded">@endif
	</div>
	<div class="col-md-4">
		<label class="form-label">Right Image</label>
		<input type="file" name="right_image" class="form-control" accept="image/*">
		@if($slide?->rightImageUrl())<img src="{{ $slide->rightImageUrl() }}" height="60" class="mt-2 rounded">@endif
	</div>
	<div class="col-12">
		<div class="form-check">
			<input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $slide?->is_active ?? true))>
			<label class="form-check-label">Active</label>
		</div>
	</div>
</div>
