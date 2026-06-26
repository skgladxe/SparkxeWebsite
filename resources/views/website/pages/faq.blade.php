@extends('website.layouts.website')

@section('title', 'FAQ — '.config('website.name'))
@section('meta_description', 'Frequently asked questions about Sparkxe services, timelines, support, and pricing.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'FAQ',
		'title' => 'Answers to questions we hear often',
		'highlight' => 'hear often',
		'description' => "Can't find what you're looking for? Reach out — we're happy to help with a free consultation.",
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'FAQ'],
		],
	])

	@include('website.sections.faq')
	@include('website.sections.cta-banner')
@endsection
