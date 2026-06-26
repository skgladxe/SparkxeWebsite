@extends('website.layouts.website')

@section('title', $service['title'].' — '.config('website.name'))
@section('meta_description', $service['description'])

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Service',
		'title' => $service['title'],
		'description' => $service['subtitle'],
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Services', 'url' => route('website.services.index')],
			['label' => $service['title']],
		],
	])

	<section class="service-detail-overview">
		<div class="container">
			<div class="service-detail-layout">
				<div class="service-detail-main wow fadeInUp">
					<div class="service-detail-icon"><i class="{{ $service['icon'] }}"></i></div>
					<p>{{ $service['description'] }}</p>
					<a href="{{ route('website.contact', ['service' => $service['slug']]) }}" class="btn-default">Get a Quote</a>
				</div>
				<div class="service-detail-features wow fadeInUp" data-wow-delay="0.15s">
					<h3>What you get</h3>
					<ul class="service-feature-list">
						@foreach ($service['features'] as $feature)
							<li><i class="fa-solid fa-circle-check"></i> {{ $feature }}</li>
						@endforeach
					</ul>
				</div>
			</div>
		</div>
	</section>

	<section class="spark-process service-detail-process">
		<div class="container">
			<div class="row section-row justify-content-center text-center">
				<div class="col-lg-8">
					<div class="section-title section-title-center">
						<h3 class="wow fadeInUp">How we deliver</h3>
						<h2 class="wow fadeInUp" data-wow-delay="0.1s">Our <span>process</span></h2>
					</div>
				</div>
			</div>
			<div class="process-steps">
				@foreach ($service['process'] as $index => $step)
					<div class="process-step wow fadeInUp" data-wow-delay="{{ ($index * 0.1 + 0.1).'s' }}">
						<div class="step-num">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</div>
						<h3>{{ $step['title'] }}</h3>
						<p>{{ $step['text'] }}</p>
					</div>
				@endforeach
			</div>
		</div>
	</section>

	@if (count($relatedServices))
		<section class="service-related">
			<div class="container">
				<div class="section-title">
					<h3 class="wow fadeInUp">Related Services</h3>
					<h2 class="wow fadeInUp" data-wow-delay="0.1s">You might also <span>need</span></h2>
				</div>
				<div class="row">
					@foreach ($relatedServices as $index => $related)
						<x-website::service-grid-card
							:icon="$related['icon']"
							:title="$related['title']"
							:subtitle="$related['subtitle']"
							:slug="$related['slug']"
							:counter="$related['counter']"
							:delay="($index * 0.1).'s'"
						/>
					@endforeach
				</div>
			</div>
		</section>
	@endif

	@include('website.sections.cta-banner')
@endsection
