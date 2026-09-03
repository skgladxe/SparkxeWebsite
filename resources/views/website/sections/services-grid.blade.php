<!-- Section 3b: All Services Grid -->
<section class="our-tools" id="tools">
	<div class="container">
		@php $section = \App\Models\SiteSetting::servicesSection(); @endphp
		<div class="row section-row justify-content-center text-center">
			<div class="col-lg-10">
				<div class="section-title section-title-center">
					<h3 class="wow fadeInUp">{{ $section['eyebrow'] }}</h3>
					<h2 class="wow fadeInUp" data-wow-delay="0.2s">
						{!! str_replace($section['highlight'], '<span>'.$section['highlight'].'</span>', e($section['title'])) !!}
					</h2>
				</div>
				<div class="services-section-btn wow fadeInUp" data-wow-delay="0.3s">
					<a href="{{ route('website.services.index') }}" class="btn-default">View All Services</a>
				</div>
			</div>
		</div>
		<div class="row">
			@foreach ($services as $index => $service)
				<x-website::service-grid-card
					:icon="$service->iconClass()"
					:title="$service->title"
					:subtitle="$service->subtitle"
					:slug="$service->slug"
					:delay="($index * 0.05).'s'"
				/>
			@endforeach
		</div>
	</div>
</section>
