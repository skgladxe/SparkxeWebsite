@php $member = $member ?? null; @endphp
<div class="row g-3">
	<div class="col-md-6"><label class="form-label">Name</label><input name="name" class="form-control" required value="{{ old('name', $member?->name) }}"></div>
	<div class="col-md-6"><label class="form-label">Role</label><input name="role" class="form-control" required value="{{ old('role', $member?->role) }}"></div>
	<div class="col-md-6"><label class="form-label">Photo</label><input type="file" name="photo" class="form-control" accept="image/*">
		@if($member?->photoUrl())<img src="{{ $member->photoUrl() }}" height="60" class="mt-2 rounded-circle">@endif
	</div>
	<div class="col-md-3"><label class="form-label">Sort Order</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $member?->sort_order ?? 0) }}"></div>
	<div class="col-md-3 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" @checked(old('is_active', $member?->is_active ?? true))><label class="form-check-label">Active</label></div></div>
	<div class="col-md-6"><label class="form-label">LinkedIn</label><input name="linkedin" class="form-control" value="{{ old('linkedin', $member?->linkedin) }}"></div>
	<div class="col-md-6"><label class="form-label">Twitter / X</label><input name="twitter" class="form-control" value="{{ old('twitter', $member?->twitter) }}"></div>
	<div class="col-md-4"><label class="form-label">GitHub</label><input name="github" class="form-control" value="{{ old('github', $member?->github) }}"></div>
	<div class="col-md-4"><label class="form-label">Dribbble</label><input name="dribbble" class="form-control" value="{{ old('dribbble', $member?->dribbble) }}"></div>
	<div class="col-md-4"><label class="form-label">Instagram</label><input name="instagram" class="form-control" value="{{ old('instagram', $member?->instagram) }}"></div>
</div>
