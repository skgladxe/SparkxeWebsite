<!-- Theme picker (left side) -->
<div class="theme-picker" aria-label="Color theme switcher">
	<span class="theme-picker-label">Theme</span>
	<div class="theme-picker-dots">
		@foreach (config('website.themes') as $theme => $label)
			<button
				class="theme-dot{{ $theme === config('website.default_theme') ? ' active' : '' }}"
				data-theme="{{ $theme }}"
				type="button"
				aria-label="{{ $label }}"
			></button>
		@endforeach
	</div>
</div>
