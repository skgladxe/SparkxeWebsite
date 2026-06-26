<!-- Section 3b: All Services Grid -->
	<section class="our-tools" id="tools">
		<div class="container">
			<div class="row section-row">
				<div class="col-lg-8">
					<div class="section-title">
						<h3 class="wow fadeInUp">Our Services</h3>
						<h2 class="wow fadeInUp" data-wow-delay="0.2s">Everything your business needs to <span>win online</span></h2>
					</div>
				</div>
				<div class="col-lg-4 text-lg-end align-self-end">
					<a href="{{ route('website.services.index') }}" class="btn-default wow fadeInUp" data-wow-delay="0.3s">View All Services</a>
				</div>
			</div>
			<div class="row">
				@foreach (config('website.services') as $index => $service)
					<x-website::service-grid-card
						:icon="$service['icon']"
						:title="$service['title']"
						:subtitle="$service['subtitle']"
						:slug="$service['slug']"
						:counter="$service['counter']"
						:delay="($index * 0.05).'s'"
					/>
				@endforeach
			</div>
		</div>
	</section>
