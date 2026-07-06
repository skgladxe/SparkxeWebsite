@php $member = $member ?? null; @endphp
<div class="row g-3">
	<div class="col-md-6">
		<label class="form-label">Name</label>
		<input name="name" class="form-control" required value="{{ old('name', $member?->name) }}">
	</div>
	<div class="col-md-6">
		<label class="form-label">Role</label>
		<input name="role" class="form-control" required value="{{ old('role', $member?->role) }}">
	</div>
	<div class="col-md-6">
		<label class="form-label">Photo</label>
		<input type="file" name="photo" class="form-control" accept="image/*">
		<small class="text-muted">Recommended: portrait image, at least 600x800px.</small>
		@if ($member?->photoUrl())
			<div class="mt-3">
				<img src="{{ $member->photoUrl() }}" alt="{{ $member->name }}" class="rounded" style="width: 180px; height: 220px; object-fit: cover;">
			</div>
		@endif
	</div>
	<div class="col-md-3">
		<label class="form-label">Sort Order</label>
		<input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $member?->sort_order ?? 0) }}">
	</div>
	<div class="col-md-3 d-flex align-items-end">
		<div class="form-check">
			<input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $member?->is_active ?? true))>
			<label class="form-check-label">Active</label>
		</div>
	</div>
	<div class="col-12">
		<label class="form-label">Description</label>
		<textarea name="description" class="form-control" rows="3" placeholder="Short intro shown on the team page">{{ old('description', $member?->description) }}</textarea>
	</div>
	<div class="col-12">
		<label class="form-label">Notes</label>
		<textarea name="notes" class="form-control rich-editor" rows="8" placeholder="Additional details, achievements, or bio">{{ old('notes', $member?->notes) }}</textarea>
	</div>
</div>
