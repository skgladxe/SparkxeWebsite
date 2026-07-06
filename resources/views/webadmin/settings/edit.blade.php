@extends('webadmin.layouts.app')
@section('title', 'Logo & Settings')
@section('content')
<div class="container-fluid">
	<x-webadmin::page-breadcrumb title="Logo & Settings" :home-url="route('admin.dashboard')" />
	@include('webadmin.partials.alerts')
	<div class="card mb-4"><div class="card-body">
		<h5 class="card-title mb-3">Logo</h5>
		<form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" id="settingsForm">@csrf @method('PUT')
			<div class="mb-3"><label class="form-label">Current Logo</label><div><img src="{{ $logoUrl }}" alt="Logo" height="48" class="border rounded p-2"></div></div>
			<div class="mb-3"><label class="form-label">Upload New Logo</label><input type="file" name="logo" class="form-control" accept="image/*"></div>
			<p class="text-muted small">Recommended: SVG or PNG with transparent background.</p>

			<hr class="my-4">
			<h5 class="card-title mb-3">Theme Colors</h5>
			<div class="mb-3">
				<div class="form-check form-check-inline">
					<input type="radio" name="theme_mode" value="preset" class="form-check-input" id="themePreset" @checked(old('theme_mode', $settings['theme_mode']) === 'preset')>
					<label class="form-check-label" for="themePreset">Preset Theme</label>
				</div>
				<div class="form-check form-check-inline">
					<input type="radio" name="theme_mode" value="custom" class="form-check-input" id="themeCustom" @checked(old('theme_mode', $settings['theme_mode']) === 'custom')>
					<label class="form-check-label" for="themeCustom">Custom Colors</label>
				</div>
			</div>
			<div class="mb-3" id="presetThemeGroup">
				<label class="form-label">Preset</label>
				<select name="theme_preset" class="form-select">
					@foreach($themes as $key => $label)
						<option value="{{ $key }}" @selected(old('theme_preset', $settings['theme_preset']) === $key)>{{ $label }}</option>
					@endforeach
				</select>
			</div>
			<div class="row g-3 mb-3" id="customThemeGroup">
				@foreach([
					'theme_accent_color' => 'Accent Color',
					'theme_accent_secondary_color' => 'Accent Secondary',
					'theme_black_color' => 'Dark Background',
					'theme_primary_color' => 'Light Text',
				] as $field => $label)
				<div class="col-md-3">
					<label class="form-label">{{ $label }}</label>
					<div class="d-flex gap-2 align-items-center">
						<input type="color" name="{{ $field }}" class="form-control form-control-color" value="{{ old($field, $settings[$field]) }}">
						<input type="text" class="form-control form-control-sm hex-input" data-for="{{ $field }}" value="{{ old($field, $settings[$field]) }}" maxlength="7">
					</div>
				</div>
				@endforeach
				<div class="col-12">
					<div id="themePreview" class="p-3 rounded" style="background: {{ $settings['theme_black_color'] }}; color: {{ $settings['theme_primary_color'] }};">
						<span class="badge me-2" style="background: linear-gradient(254deg, {{ $settings['theme_accent_color'] }}, {{ $settings['theme_accent_secondary_color'] }}); color: {{ $settings['theme_black_color'] }};">Preview</span>
						Theme preview swatch
					</div>
				</div>
			</div>
			<div class="form-check mb-3">
				<input type="checkbox" name="hide_theme_picker" value="1" class="form-check-input" id="hideThemePicker" @checked(old('hide_theme_picker', $settings['hide_theme_picker']))>
				<label class="form-check-label" for="hideThemePicker">Hide theme picker on website</label>
			</div>

			<hr class="my-4">
			<h5 class="card-title mb-3">Homepage Sections</h5>
			<div class="form-check mb-2">
				<input type="checkbox" name="section_hero_visible" value="1" class="form-check-input" id="sectionHero" @checked(old('section_hero_visible', $settings['section_hero_visible']))>
				<label class="form-check-label" for="sectionHero">Show Hero section on website</label>
			</div>
			<div class="form-check mb-3">
				<input type="checkbox" name="section_products_visible" value="1" class="form-check-input" id="sectionProducts" @checked(old('section_products_visible', $settings['section_products_visible']))>
				<label class="form-check-label" for="sectionProducts">Show Our Products section on website</label>
			</div>

			<hr class="my-4">
			<h5 class="card-title mb-3">Common Page Header Image</h5>
			<div class="mb-3">
				<label class="form-label">Header Image (all pages except home)</label>
				@if($defaultHeaderImageUrl)<div class="mb-2"><img src="{{ $defaultHeaderImageUrl }}" height="80" class="rounded"></div>@endif
				<input type="file" name="default_page_header_image" class="form-control" accept="image/*">
				<p class="text-muted small">Used as the banner background on services, products, about, contact, and all other inner pages.</p>
			</div>

			<hr class="my-4">
			<h5 class="card-title mb-3">Our Services Section (Homepage)</h5>
			<div class="row g-3">
				<div class="col-md-4">
					<label class="form-label">Eyebrow</label>
					<input name="services_section_eyebrow" class="form-control" value="{{ old('services_section_eyebrow', $settings['services_section_eyebrow']) }}">
				</div>
				<div class="col-md-8">
					<label class="form-label">Title</label>
					<input name="services_section_title" class="form-control" value="{{ old('services_section_title', $settings['services_section_title']) }}">
				</div>
				<div class="col-md-4">
					<label class="form-label">Title Highlight</label>
					<input name="services_section_title_highlight" class="form-control" value="{{ old('services_section_title_highlight', $settings['services_section_title_highlight']) }}">
				</div>
			</div>

			<button class="btn btn-primary mt-4">Save Settings</button>
		</form>
	</div></div>
</div>
@push('scripts')
<script>
(function () {
	var preset = document.getElementById('themePreset');
	var custom = document.getElementById('themeCustom');
	var presetGroup = document.getElementById('presetThemeGroup');
	var customGroup = document.getElementById('customThemeGroup');
	var preview = document.getElementById('themePreview');

	function toggleThemeGroups() {
		var isCustom = custom.checked;
		presetGroup.style.display = isCustom ? 'none' : 'block';
		customGroup.style.display = isCustom ? 'flex' : 'none';
		customGroup.classList.toggle('row', isCustom);
	}

	function updatePreview() {
		var accent = document.querySelector('[name="theme_accent_color"]').value;
		var accent2 = document.querySelector('[name="theme_accent_secondary_color"]').value;
		var black = document.querySelector('[name="theme_black_color"]').value;
		var primary = document.querySelector('[name="theme_primary_color"]').value;
		preview.style.background = black;
		preview.style.color = primary;
		preview.querySelector('.badge').style.background = 'linear-gradient(254deg, ' + accent + ', ' + accent2 + ')';
		preview.querySelector('.badge').style.color = black;
	}

	preset.addEventListener('change', toggleThemeGroups);
	custom.addEventListener('change', toggleThemeGroups);
	document.querySelectorAll('input[type="color"]').forEach(function (el) {
		el.addEventListener('input', function () {
			document.querySelector('.hex-input[data-for="' + el.name + '"]').value = el.value;
			updatePreview();
		});
	});
	document.querySelectorAll('.hex-input').forEach(function (el) {
		el.addEventListener('input', function () {
			if (/^#[0-9A-Fa-f]{6}$/.test(el.value)) {
				document.querySelector('[name="' + el.dataset.for + '"]').value = el.value;
				updatePreview();
			}
		});
	});

	toggleThemeGroups();
})();
</script>
@endpush
@endsection
