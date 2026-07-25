@extends('website.layouts.website')

@section('title', 'Cookie Policy — '.config('website.name'))
@section('meta_description', 'Learn how Sparkxe uses cookies and how you can accept or reject them.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Legal',
		'title' => 'Cookie Policy',
		'highlight' => 'Cookie Policy',
		'description' => 'What cookies we use, why we use them, and how you can manage your preferences.',
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Cookie Policy'],
		],
	])

	<section class="spark-legal">
		<div class="container">
			<div class="legal-panel wow fadeInUp">
				<p class="legal-updated">Last updated: {{ date('F j, Y') }}</p>

				<div class="legal-block">
					<h2>1. What are cookies?</h2>
					<p>Cookies are small text files stored on your device when you visit a website. They help the site remember your preferences, keep sessions working, and understand how visitors use the site.</p>
				</div>

				<div class="legal-block">
					<h2>2. How we use cookies</h2>
					<p>{{ config('website.name') }} uses cookies to:</p>
					<ul>
						<li>Remember your cookie consent choice (accept or reject)</li>
						<li>Store display preferences such as theme selection</li>
						<li>Support essential site functionality and security</li>
						<li>Optionally measure traffic and improve content when analytics cookies are accepted</li>
					</ul>
				</div>

				<div class="legal-block">
					<h2>3. Types of cookies we use</h2>
					<ul>
						<li><strong>Essential cookies</strong> — required for basic site operation and to store your consent preference. These cannot be turned off through the banner.</li>
						<li><strong>Preference cookies</strong> — remember choices like theme so your experience stays consistent.</li>
						<li><strong>Analytics / performance cookies</strong> — help us understand usage patterns. These are only used if you accept cookies via the banner.</li>
					</ul>
				</div>

				<div class="legal-block">
					<h2>4. Your choices</h2>
					<p>When you first visit our site, a cookie banner lets you <strong>Accept</strong> or <strong>Reject</strong> non-essential cookies. Your choice is saved locally so we do not ask again until you clear site data or change your preference.</p>
					<p>You can also control cookies through your browser settings. Blocking some cookies may affect how parts of the site work.</p>
					<div class="legal-actions">
						<button type="button" class="btn-default cookie-pref-accept" data-cookie-consent="accept">Accept cookies</button>
						<button type="button" class="btn-outline-soft cookie-pref-reject" data-cookie-consent="reject">Reject cookies</button>
					</div>
					<p class="legal-pref-status" id="cookiePrefStatus" hidden></p>
				</div>

				<div class="legal-block">
					<h2>5. More about privacy</h2>
					<p>For details on how we handle personal information more broadly, please read our <a href="{{ route('website.privacy') }}">Privacy Policy</a>.</p>
				</div>

				<div class="legal-block">
					<h2>6. Contact</h2>
					<p>Questions about cookies? Reach us at <a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a> or through our <a href="{{ route('website.contact') }}">Contact</a> page.</p>
				</div>
			</div>
		</div>
	</section>
@endsection
