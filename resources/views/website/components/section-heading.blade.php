@props([
    'eyebrow',
    'title',
    'highlight' => null,
    'description' => null,
    'centered' => false,
    'dark' => false,
    'delay' => '0.2s',
])

<div @class(['section-title', 'section-title-center' => $centered, 'dark-section' => $dark])>
	<h3 class="wow fadeInUp">{{ $eyebrow }}</h3>
	<h2 class="wow fadeInUp" data-wow-delay="{{ $delay }}">
		{!! $highlight ? str_replace($highlight, '<span>'.$highlight.'</span>', $title) : $title !!}
	</h2>
	@if ($description)
		<p class="wow fadeInUp" data-wow-delay="0.3s" style="margin-top: 16px; line-height: 1.65; opacity: 0.85;">{{ $description }}</p>
	@endif
</div>
