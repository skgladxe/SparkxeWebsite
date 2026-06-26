@props([
    'icon',
    'title',
    'subtitle',
    'slug',
    'counter' => 98,
    'delay' => '0s',
])

@php
    $href = route('website.services.show', $slug);
@endphp

<div class="col-lg-4 col-md-6">
	<a href="{{ $href }}" class="tool-item-link wow fadeInUp" data-wow-delay="{{ $delay }}">
		<div class="tool-item">
			<div class="tool-item-box">
				<div class="icon-box"><i class="{{ $icon }}"></i></div>
				<div class="tool-item-content">
					<h3>{{ $title }}</h3>
					<p>{{ $subtitle }}</p>
				</div>
			</div>
			<div class="tool-item-counter"><h2><span class="counter" data-count="{{ $counter }}">0</span>%</h2></div>
		</div>
	</a>
</div>
