@extends('website.layouts.website')

@section('title', 'Cookie Policy — '.config('website.name'))
@section('meta_description', 'Sparkxe Cookie Policy — how we use essential, preference, and analytics cookies, and how you can manage consent on our digital and AI-powered website experiences.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Legal · Cookies',
		'title' => 'Cookie Policy',
		'highlight' => 'Cookie Policy',
		'description' => 'How Sparkxe uses cookies, what each type does, and how you control your preferences.',
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Cookie Policy'],
		],
	])

	<section class="spark-legal cookie-policy-page">
		<div class="container">
			<div class="cookie-intro-panel wow fadeInUp">
				<p class="legal-updated">Last updated: {{ date('F j, Y') }}</p>
				<div class="cookie-intro-grid">
					<div>
						<h2>1. What Are Cookies?</h2>
						<p>Cookies are small text files stored on your device when you visit a website. They help websites remember your preferences, improve performance, and provide a better browsing experience.</p>
					</div>
					<div class="cookie-intro-note">
						<strong>Important</strong>
						<p>Essential cookies keep the site secure and functional. Analytics cookies run only after you give consent.</p>
					</div>
				</div>
			</div>

			<div class="cookie-type-grid wow fadeInUp" data-wow-delay="0.1s">
				<article class="cookie-type-card">
					<span class="cookie-type-badge essential">Essential</span>
					<h3>Essential Cookies</h3>
					<p>Required for the website to function properly. These cookies cannot be disabled through our cookie banner.</p>
				</article>
				<article class="cookie-type-card">
					<span class="cookie-type-badge preference">Preference</span>
					<h3>Preference Cookies</h3>
					<p>Remember your selected preferences, such as theme and display settings, so your experience stays consistent.</p>
				</article>
				<article class="cookie-type-card">
					<span class="cookie-type-badge analytics">Analytics</span>
					<h3>Analytics Cookies</h3>
					<p>Help us understand visitor behavior and improve our website. These cookies are enabled only after you provide consent.</p>
				</article>
			</div>

			<div class="cookie-sections wow fadeInUp" data-wow-delay="0.15s">
				<article class="cookie-section-card" id="cookie-usage">
					<div class="cookie-section-num">02</div>
					<div>
						<h2>How Sparkxe Uses Cookies</h2>
						<p>We use cookies to:</p>
						<ul>
							<li>Remember your cookie preferences</li>
							<li>Maintain secure website functionality</li>
							<li>Improve website performance</li>
							<li>Analyze website traffic (with your consent)</li>
							<li>Remember user interface preferences such as theme settings</li>
						</ul>
					</div>
				</article>

				<article class="cookie-section-card" id="cookie-manage">
					<div class="cookie-section-num">04</div>
					<div>
						<h2>Managing Your Cookie Preferences</h2>
						<p>When you first visit our website, you can:</p>
						<ul>
							<li>Accept All Cookies</li>
							<li>Reject Non-Essential Cookies</li>
						</ul>
						<p>Your preference is stored on your device and can be changed anytime by clearing your browser cookies or updating your browser settings.</p>
						<p><strong>Please note:</strong> disabling certain cookies may affect website functionality.</p>
						<div class="legal-actions">
							<button type="button" class="btn-default cookie-pref-accept" data-cookie-consent="accept">Accept All Cookies</button>
							<button type="button" class="btn-outline-soft cookie-pref-reject" data-cookie-consent="reject">Reject Non-Essential</button>
						</div>
						<p class="legal-pref-status" id="cookiePrefStatus" hidden></p>
					</div>
				</article>

				<article class="cookie-section-card" id="cookie-third-party">
					<div class="cookie-section-num">05</div>
					<div>
						<h2>Third-Party Cookies</h2>
						<p>Some third-party services (such as Google Analytics or embedded content) may place cookies on your device. Their use is governed by their respective privacy policies.</p>
					</div>
				</article>

				<article class="cookie-section-card" id="cookie-learn-more">
					<div class="cookie-section-num">06</div>
					<div>
						<h2>Learn More</h2>
						<p>For more information about how we collect and process personal data, please read our <a href="{{ route('website.privacy') }}">Privacy Policy</a>.</p>
					</div>
				</article>

				<article class="cookie-section-card cookie-contact-card" id="cookie-contact">
					<div class="cookie-section-num">07</div>
					<div>
						<h2>Contact Us</h2>
						<p>Questions regarding our Cookie Policy?</p>
						<ul class="cookie-contact-list">
							<li><i class="fa-solid fa-envelope"></i> Email: <a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a></li>
							<li><i class="fa-solid fa-phone"></i> Phone: <a href="tel:{{ config('website.phone_link') }}">{{ config('website.phone') }}</a></li>
							<li><i class="fa-solid fa-paper-plane"></i> Or contact us through our <a href="{{ route('website.contact') }}">Contact</a> page.</li>
						</ul>
					</div>
				</article>
			</div>
		</div>
	</section>
@endsection
