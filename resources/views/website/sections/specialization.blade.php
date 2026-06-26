<!-- Section 2: Our Specialization -->
<section class="our-specialization" id="services">
	<div class="container">
		<div class="row section-row align-items-center">
			<div class="col-lg-6">
				<x-website::section-heading
					eyebrow="Our Specialization"
					title="Smart digital services built for real business growth"
					highlight="real business growth"
				/>
			</div>
			<div class="col-lg-6">
				<div class="section-content-btn">
					<div class="section-title-content wow fadeInUp" data-wow-delay="0.4s">
						<p>Sparkxe delivers end-to-end digital solutions — from marketing campaigns and branded design to custom software, mobile apps, and enterprise systems that keep your business ahead.</p>
					</div>
					<div class="section-btn wow fadeInUp" data-wow-delay="0.6s">
						<a href="{{ route('website.services.index') }}" class="btn-default">View All Services</a>
					</div>
				</div>
			</div>
		</div>

		<div class="specialization-slider wow fadeInUp" data-wow-delay="0.3s">
			<div class="swiper">
				<div class="swiper-wrapper">
					@foreach (config('website.specialization_services') as $service)
						<x-website::service-card
							:icon="$service['icon']"
							:title="$service['title']"
							:description="$service['description']"
							:slug="$service['slug']"
						/>
					@endforeach
				</div>
				<div class="swiper-pagination"></div>
			</div>
		</div>

		<div class="section-footer-text wow fadeInUp" data-wow-delay="0.2s">
			<p>Ready to grow your business online? <a href="{{ route('website.contact') }}">Let's build your next digital solution today!</a></p>
		</div>
	</div>
</section>
