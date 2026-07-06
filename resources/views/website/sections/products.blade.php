@php
	$sectionId = $sectionId ?? 'services';
	$eyebrow = $eyebrow ?? 'Our Products';
	$title = $title ?? 'Smart digital services built for real business growth';
	$highlight = $highlight ?? 'real business growth';
	$descriptionText = $descriptionText ?? 'Sparkxe delivers end-to-end digital solutions - from marketing campaigns and branded design to custom software, mobile apps, and enterprise systems that keep your business ahead.';
	$buttonLabel = $buttonLabel ?? 'View All Products';
	$buttonUrl = $buttonUrl ?? route('website.home').'#services';
@endphp

<!-- Section: Our Products -->
<section class="our-specialization our-products" id="{{ $sectionId }}">
	<div class="container">
		<div class="row section-row align-items-center">
			<div class="col-lg-6">
				<x-website::section-heading
					:eyebrow="$eyebrow"
					:title="$title"
					:highlight="$highlight"
				/>
			</div>
			<div class="col-lg-6">
				<div class="section-content-btn">
					<div class="section-title-content wow fadeInUp" data-wow-delay="0.4s">
						<p>{{ $descriptionText }}</p>
					</div>
					<div class="section-btn wow fadeInUp" data-wow-delay="0.6s">
						<a href="{{ $buttonUrl }}" class="btn-default">{{ $buttonLabel }}</a>
					</div>
				</div>
			</div>
		</div>

		@if ($products->isNotEmpty())
			<div class="specialization-slider wow fadeInUp" data-wow-delay="0.3s">
				<div class="swiper">
					<div class="swiper-wrapper">
						@foreach ($products as $product)
							<x-website::product-card
								:title="$product->title"
								:description="$product->description"
								:image="$product->imageUrl()"
								:icon="$product->iconClass()"
								:slug="$product->slug"
							/>
						@endforeach
					</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>
		@endif

		<div class="section-footer-text wow fadeInUp" data-wow-delay="0.2s">
			<p>Ready to grow your business online? <a href="{{ route('website.contact') }}">Let's build your next digital solution today!</a></p>
		</div>
	</div>
</section>
