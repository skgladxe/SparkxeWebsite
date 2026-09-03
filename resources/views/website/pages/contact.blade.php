@extends('website.layouts.website')

@section('title', 'Contact — '.config('website.name'))
@section('meta_description', 'Contact Sparkxe for a free consultation on web development, software, marketing, and design services.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Contact Us',
		'title' => "Let's discuss your next project",
		'highlight' => 'next project',
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Contact'],
		],
	])

	@include('website.partials.page-intro', [
		'eyebrow' => 'Get In Touch',
		'title' => 'Ready to start your project?',
		'highlight' => 'your project?',
		'description' => 'Tell us about your business goals and we will recommend the right mix of web, software, and marketing services.',
	])

	@include('website.sections.contact', ['hideHeading' => true, 'selectedService' => request('service'), 'showMap' => true])
	@include('website.sections.trust')
@endsection
