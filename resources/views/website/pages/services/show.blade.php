@extends('website.layouts.website')

@section('title', $service->title.' — '.config('website.name'))
@section('meta_description', $service->description)

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Service',
		'title' => $service->title,
		'description' => $service->subtitle,
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Services', 'url' => route('website.services.index')],
			['label' => $service->title],
		],
	])

	<section class="service-detail-overview">
		<div class="container">
			<div class="service-detail-layout">
				<div class="service-detail-main wow fadeInUp">
					@if ($service->imageUrl())
						<div class="service-detail-image mb-4">
							<img src="{{ $service->imageUrl() }}" alt="{{ $service->title }}" class="img-fluid rounded">
						</div>
					@endif
					@if ($service->description)
						<p>{{ $service->description }}</p>
					@endif
					@if (filled($service->renderedNotes()))
						<div class="rich-content">{!! $service->renderedNotes() !!}</div>
					@endif
					<a href="{{ route('website.contact', ['service' => $service->slug]) }}" class="btn-default">Get a Quote</a>
				</div>
			</div>
		</div>
	</section>

	@include('website.sections.cta-banner')
@endsection
