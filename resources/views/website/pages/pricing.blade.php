@extends('website.layouts.website')

@section('title', 'Pricing — '.config('website.name'))
@section('meta_description', 'Flexible pricing packages from Sparkxe for websites, e-commerce, marketing, and enterprise software.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Pricing Plans',
		'title' => 'Flexible packages for every business stage',
		'highlight' => 'business stage',
		'description' => 'Whether you need a landing page, a full e-commerce store, or enterprise software — Sparkxe has a plan that fits your budget and goals.',
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Pricing'],
		],
	])

	@include('website.sections.pricing')
	@include('website.sections.faq')
	@include('website.sections.cta-banner')
@endsection
