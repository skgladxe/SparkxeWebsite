@extends('website.layouts.website')

@section('title', 'Portfolio — '.config('website.name'))
@section('meta_description', 'Recent projects from Sparkxe — e-commerce, POS, mobile apps, ERP, marketing, and websites.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Portfolio',
		'title' => "Recent work we're proud of",
		'highlight' => 'proud of',
		'description' => 'A selection of digital projects delivered for retail, restaurants, startups, and growing enterprises.',
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Portfolio'],
		],
	])

	<section class="x-section spark-portfolio portfolio-page">
		<div class="container">
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

	@include('website.sections.cta-banner')
@endsection
