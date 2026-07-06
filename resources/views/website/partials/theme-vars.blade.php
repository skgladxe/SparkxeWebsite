@php
	$accent = $siteSettings['themeAccentColor'];
	$accentSecondary = $siteSettings['themeAccentSecondaryColor'];
	$black = $siteSettings['themeBlackColor'];
	$primary = $siteSettings['themePrimaryColor'];
	$hex = ltrim($black, '#');
	$rgb = strlen($hex) === 6
		? implode(', ', [hexdec(substr($hex, 0, 2)), hexdec(substr($hex, 2, 2)), hexdec(substr($hex, 4, 2))])
		: '22, 48, 49';
@endphp
@if ($siteSettings['themeMode'] === 'custom')
<style>
[data-theme="custom"] {
	--primary-color: {{ $primary }};
	--secondary-color: #FFFFFF0A;
	--text-color: {{ $primary }};
	--accent-color: {{ $accent }};
	--accent-secondary-color: {{ $accentSecondary }};
	--black-color: {{ $black }};
	--divider-color: #FFFFFF0F;
	--dark-divider-color: #16151324;
	--error-color: rgb(230, 87, 87);
	--nav-shell-bg: rgba({{ $rgb }}, 0.96);
	--gradient-accent: linear-gradient(254.54deg, var(--accent-color) 0.03%, var(--accent-secondary-color) 100%);
	--gradient-accent-reverse: linear-gradient(254.54deg, var(--accent-secondary-color) 0.03%, var(--accent-color) 100%);
}
</style>
@endif
