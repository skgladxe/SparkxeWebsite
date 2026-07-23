<style>
	.customer-image-box {
		background-color: rgba(255, 255, 255, 0);
		padding: 0;
	}
	.experience-counter-box {
		background-color: rgba(255, 255, 255, 0);
		padding: 0;
	}
</style>

@if ($heroSlides->isNotEmpty())
<!-- Hero -->
<section class="hero hero-slider mt-4" id="home" data-slide-count="{{ $heroSlides->count() }}">
	<div class="swiper">
		<div class="swiper-wrapper">
			@foreach ($heroSlides as $slide)
				<div class="swiper-slide">
					<div class="container">
						<div class="row align-items-center">
							<div class="col-lg-6">
								<div class="hero-content">
									<div class="section-title dark-section">
										<h3 class="wow fadeInUp">{{ $slide->subtitle }}</h3>
										<h1 class="wow fadeInUp" data-wow-delay="0.2s">
											{!! $slide->renderedTitle() !!}
										</h1>
										<p class="wow fadeInUp" data-wow-delay="0.4s">{{ $slide->description }}</p>
									</div>
									<div class="hero-body wow fadeInUp" data-wow-delay="0.6s">
										@if (filled($slide->primary_button_text))
											<div class="hero-btn">
												<a href="{{ $slide->buttonUrl($slide->primary_button_url) }}" class="btn-default">{{ $slide->primary_button_text }}</a>
											</div>
										@endif
										@if (filled($slide->secondary_button_text) && filled($slide->secondary_button_url))
											<div class="hero-btn btn-outline">
												<a href="{{ $slide->buttonUrl($slide->secondary_button_url) }}" class="btn-default">{{ $slide->secondary_button_text }}</a>
											</div>
										@endif
									</div>
								</div>
							</div>
							<div class="col-lg-6">
								<div class="hero-image">
									<div class="hero-img">
										<img src="{{ $slide->mainImageUrl() }}" alt="{{ $slide->title }}">
									</div>
									@if ($slide->leftImageUrl())
										<div class="customer-image-box">
											<img style="width: 100%; height: 100%; object-fit: cover;" src="{{ $slide->leftImageUrl() }}" alt="">
										</div>
									@endif
									@if ($slide->rightImageUrl())
										<div class="experience-counter-box">
											<img style="width: 100%; height: 100%; object-fit: cover;" src="{{ $slide->rightImageUrl() }}" alt="">
										</div>
									@endif
								</div>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		</div>
		@if ($heroSlides->count() > 1)
			<div class="swiper-pagination"></div>
		@endif
	</div>
</section>
@endif
