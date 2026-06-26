@extends('website.layouts.website')

@section('title', 'Our Team — '.config('website.name'))
@section('meta_description', 'Meet the Sparkxe team — experts in digital marketing, software development, design, and business growth.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Our Team',
		'title' => 'Experts behind Sparkxe',
		'highlight' => 'Sparkxe',
		'description' => 'A passionate team of developers, designers, and marketers dedicated to helping your business grow online.',
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Team'],
		],
	])

	@include('website.sections.team')
	@include('website.sections.cta-banner')
@endsection
