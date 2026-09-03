@extends('website.layouts.website')

@section('title', 'FAQ — '.config('website.name'))
@section('meta_description', 'Frequently asked questions about Sparkxe services, timelines, support, and pricing.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'FAQ',
		'title' => 'Answers to questions we hear often',
		'highlight' => 'hear often',
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'FAQ'],
		],
	])

	@include('website.partials.page-intro', [
		'eyebrow' => 'Quick Answers',
		'title' => 'Everything you need to know',
		'highlight' => 'need to know',
		'description' => "Can't find what you're looking for? Reach out — we're happy to help with a free consultation.",
	])

	@include('website.sections.faq', ['hideHeading' => true])
	@include('website.sections.differentiation', [
		'eyebrow' => 'Why Clients Stay',
		'titleHtml' => 'What makes Sparkxe <span>different</span>',
	])
	@include('website.sections.cta-banner')
@endsection
