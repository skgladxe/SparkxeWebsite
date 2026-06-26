@extends('website.layouts.website')

@section('title', 'About Us — '.config('website.name'))
@section('meta_description', 'Learn about Sparkxe — your partner for digital marketing, custom software, web development, and design.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'About Sparkxe',
		'title' => 'Your partner for end-to-end growth',
		'highlight' => 'end-to-end growth',
		'description' => 'Sparkxe is a full-service digital company helping businesses build their online presence, automate operations, and scale with custom software.',
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'About'],
		],
	])

	@include('website.sections.about')
	@include('website.sections.how-it-works')
	@include('website.sections.cta-banner')
@endsection
