<!-- Portfolio -->
	<section class="x-section spark-portfolio" id="portfolio">
		<div class="container">
			<div class="row section-row align-items-end">
				<div class="col-lg-7"><div class="section-title"><h3 class="wow fadeInUp">Portfolio</h3><h2 class="wow fadeInUp" data-wow-delay="0.2s">Recent work we're <span>proud of</span></h2></div></div>
				<div class="col-lg-5 text-lg-end">
					<a href="{{ route('website.portfolio') }}" class="btn-default wow fadeInUp" data-wow-delay="0.25s">View Portfolio</a>
				</div>
			</div>
			<div class="portfolio-grid">
				@foreach (config('website.portfolio_items') as $index => $item)
					<a href="{{ route('website.services.show', $item['slug']) }}" class="portfolio-card-link wow fadeInUp" data-wow-delay="{{ ($index * 0.1).'s' }}">
						<div class="portfolio-card">
							<div class="portfolio-card-placeholder"><i class="fa-solid fa-image"></i></div>
							<div class="portfolio-card-body">
								<span class="portfolio-tag">{{ $item['tag'] }}</span>
								<h3>{{ $item['title'] }}</h3>
								<p>{{ $item['description'] }}</p>
							</div>
						</div>
					</a>
				@endforeach
			</div>
		</div>
	</section>
