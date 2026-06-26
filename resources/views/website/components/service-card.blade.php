@props([
    'icon',
    'title',
    'description',
    'slug' => null,
    'link' => null,
])

@php
    $href = $link ?? ($slug ? route('website.services.show', $slug) : route('website.contact'));
@endphp

<div class="swiper-slide">
	<div class="service-item">
		<div class="service-item-header">
			<div class="icon-box"><i class="{{ $icon }}"></i></div>
			<div class="service-item-btn"><a href="{{ $href }}"><i class="fa-solid fa-arrow-up-right"></i></a></div>
		</div>
		<div class="service-item-body">
			<h3><a href="{{ $href }}">{{ $title }}</a></h3>
			<p>{{ $description }}</p>
		</div>
	</div>
</div>
