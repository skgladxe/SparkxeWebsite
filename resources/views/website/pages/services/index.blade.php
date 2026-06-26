@extends('website.layouts.website')

@section('title', 'Our Services — '.config('website.name'))
@section('meta_description', 'Explore all digital services from Sparkxe — marketing, software, web, design, and more.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Our Services',
		'title' => 'Everything your business needs to win online',
		'highlight' => 'win online',
		'description' => 'From digital marketing and custom software to branding and hosting — Sparkxe delivers end-to-end solutions under one roof.',
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Services'],
		],
	])

	<section class="our-tools services-index-page">
		<div class="container">
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

	@include('website.sections.cta-banner')
@endsection
