@if (!($siteSettings['hideThemePicker'] ?? false) && ($siteSettings['themeMode'] ?? 'preset') !== 'custom')
<!-- Theme picker (left side) -->
<div class="theme-picker" aria-label="Color theme switcher">
	<span class="theme-picker-label">Theme</span>
	<div class="theme-picker-dots">
		@php $activeTheme = $siteSettings['themePreset'] ?? config('website.default_theme'); @endphp
		@foreach (config('website.themes') as $theme => $label)
			<button
				class="theme-dot{{ $theme === $activeTheme ? ' active' : '' }}"
				data-theme="{{ $theme }}"
				type="button"
				aria-label="{{ $label }}"
			></button>
		@endforeach
	</div>
</div>
@endif
