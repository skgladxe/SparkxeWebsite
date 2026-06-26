@props([
    'name',
    'description',
    'price',
    'priceSuffix' => null,
    'features' => [],
    'featured' => false,
    'badge' => null,
    'buttonClass' => 'btn-outline',
    'buttonText' => 'Get Started',
])

<div @class(['pricing-card', 'featured' => $featured])>
	@if ($badge)
		<span class="pricing-badge">{{ $badge }}</span>
	@endif
	<h3>{{ $name }}</h3>
	<p class="price-desc">{{ $description }}</p>
	<div class="price">{{ $price }}@if ($priceSuffix)<span>{{ $priceSuffix }}</span>@endif</div>
	<ul class="pricing-features">
		@foreach ($features as $feature)
			<li><i class="fa-solid fa-check"></i> {{ $feature }}</li>
		@endforeach
	</ul>
	<a href="{{ route('website.contact') }}" class="{{ $buttonClass }}">{{ $buttonText }}</a>
</div>
