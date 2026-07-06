@props([
    'title',
    'description',
    'notes' => null,
    'image' => null,
    'icon' => null,
    'slug' => null,
    'link' => null,
])

@php
    $href = $link ?? ($slug ? route('website.products.show', $slug) : null);
@endphp

<div class="swiper-slide">
	@if ($href)
		<a href="{{ $href }}" class="product-item-link">
	@endif
	<div class="service-item product-item">
		@if ($image)
			<div class="product-item-image">
				<img src="{{ $image }}" alt="{{ $title }}">
			</div>
		@elseif ($icon)
			<div class="service-item-header">
				<div class="icon-box"><i class="{{ $icon }}"></i></div>
			</div>
		@endif
		<div class="service-item-body">
			<h3>{{ $title }}</h3>
			<p>{{ $description }}</p>
		</div>
	</div>
	@if ($href)
		</a>
	@endif
</div>
