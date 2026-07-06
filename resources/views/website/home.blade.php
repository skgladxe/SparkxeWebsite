@extends('website.layouts.website')

@section('content')
	@if ($siteSettings['heroVisible'])
		@include('website.sections.hero')
	@endif
	@include('website.sections.ticker')
	@if ($siteSettings['productsVisible'])
		@include('website.sections.products')
	@endif
	@include('website.sections.facts')
	@include('website.sections.services-grid')
	@include('website.sections.why-choose-us')
	@include('website.sections.industries')
	@include('website.sections.testimonials')
	@include('website.sections.cta-banner')
	@include('website.sections.contact')
@endsection
