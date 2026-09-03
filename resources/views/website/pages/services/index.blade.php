@extends('website.layouts.website')

@section('title', 'Our Services — '.config('website.name'))
@section('meta_description', 'Explore all digital services from Sparkxe — marketing, software, web, design, and more.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => $section['eyebrow'],
		'title' => $section['title'],
		'highlight' => $section['highlight'],
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Services'],
		],
	])

	@include('website.partials.page-intro', [
		'eyebrow' => 'What We Offer',
		'title' => 'End-to-end solutions for your business',
		'highlight' => 'your business',
		'description' => 'From digital marketing and custom software to branding and hosting — Sparkxe delivers everything under one roof.',
	])

	<section class="our-tools services-index-page">
		<div class="container">
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

	@include('website.sections.how-it-works')
	@include('website.sections.industries')
	@include('website.sections.tech-stack')
	@include('website.sections.cta-banner')
@endsection
