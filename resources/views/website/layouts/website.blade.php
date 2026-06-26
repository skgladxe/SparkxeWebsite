<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	@include('website.partials.seo-head', ['seo' => $seo ?? app(\App\Services\SeoService::class)->resolveForRequest()])
	<link rel="icon" type="image/svg+xml" href="{{ asset('website/assets/images/logo.svg') }}">

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/magnific-popup.min.css" rel="stylesheet">
	<link href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" rel="stylesheet">

	<link href="{{ asset('website/assets/css/variables.css') }}" rel="stylesheet">
	<link href="{{ asset('website/assets/css/preloader.css') }}" rel="stylesheet">
	<link href="{{ asset('website/assets/css/base.css') }}" rel="stylesheet">
	<link href="{{ asset('website/assets/css/header.css') }}" rel="stylesheet">
	<link href="{{ asset('website/assets/css/hero.css') }}" rel="stylesheet">
	<link href="{{ asset('website/assets/css/sections.css') }}" rel="stylesheet">
	<link href="{{ asset('website/assets/css/pages.css') }}" rel="stylesheet">
	<link href="{{ asset('website/assets/css/extra-sections.css') }}" rel="stylesheet">
	@stack('styles')
</head>
<body class="active-sticky-header" data-theme="{{ config('website.default_theme') }}">

	@include('website.partials.preloader')
	@include('website.partials.grid-lines')
	@include('website.partials.header')

	@yield('content')

	@include('website.partials.footer')

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/waypoints/4.0.1/jquery.waypoints.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Counter-Up/1.0.0/jquery.counterup.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/magnific-popup.js/1.1.0/jquery.magnific-popup.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

	@include('website.partials.theme-picker')
	@include('website.partials.whatsapp-float')

	<script src="{{ asset('website/assets/js/main.js') }}"></script>
	@stack('scripts')
</body>
</html>
