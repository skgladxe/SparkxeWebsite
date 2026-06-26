<!DOCTYPE html>
<html lang="en">
<head>
	@include('webadmin.partials.head')
	<title>@yield('title', config('webadmin.name'))</title>
</head>
<body>
	<div class="page-layout">
		@include('webadmin.partials.header')
		@include('webadmin.partials.search-modal')
		@include('webadmin.partials.sidebar')
		@include('webadmin.partials.add-customer-modal')

		<main class="app-wrapper">
			@yield('content')
		</main>

		@include('webadmin.partials.footer')
	</div>

	@include('webadmin.partials.scripts')
</body>
</html>