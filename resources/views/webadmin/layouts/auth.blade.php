<!DOCTYPE html>
<html lang="en">
<head>
	@include('webadmin.partials.head')
	<title>@yield('title', 'Login — '.($adminLogoText ?? \App\Models\SiteSetting::adminLogoText()))</title>
</head>
<body>
	@yield('content')
	<script src="{{ asset('webadmin/assets/plugins/global/global.min.js') }}"></script>
	@stack('scripts')
</body>
</html>
