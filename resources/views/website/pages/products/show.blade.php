@extends('website.layouts.website')

@section('title', $product->title.' — '.config('website.name'))
@section('meta_description', $product->description)

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Product',
		'title' => $product->title,
		'description' => $product->subtitle,
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Our Products', 'url' => route('website.home').'#services'],
			['label' => $product->title],
		],
	])

	<section class="service-detail-overview">
		<div class="container">
			<div class="service-detail-layout">
				<div class="service-detail-main wow fadeInUp">
				
					{{-- @if ($product->iconClass())
						<div class="service-detail-icon"><i class="{{ $product->iconClass() }}"></i></div>
					@endif --}}
					@if ($product->imageUrl())
						<div class="service-detail-image mb-4">
							<img src="{{ $product->imageUrl() }}" alt="{{ $product->title }}" class="img-fluid rounded">
						</div>
					@endif
					@if ($product->title)
					<h1 class="service-detail-title font-weight-bold pb-5">{{ $product->title }}</h1>
				@endif
					@if ($product->description)
						<p>{{ $product->description }}</p>
					@endif
					@if (filled($product->renderedNotes()))
						<div class="rich-content">{!! $product->renderedNotes() !!}</div>
					@endif
					<a href="{{ route('website.contact') }}" class="btn-default">Get Started</a>
				</div>
			</div>
		</div>
	</section>

	@if ($relatedProducts->isNotEmpty())
		@include('website.sections.products', [
			'products' => $relatedProducts,
			'sectionId' => 'more-products',
			'eyebrow' => 'More Products',
			'title' => 'Explore our solutions',
			'highlight' => 'solutions',
			'descriptionText' => 'Browse more digital solutions tailored to branding, marketing, software, mobile apps, and business growth.',
			'buttonLabel' => 'See All Products',
			'buttonUrl' => route('website.home').'#services',
		])
	@endif

	@include('website.sections.cta-banner')
@endsection
