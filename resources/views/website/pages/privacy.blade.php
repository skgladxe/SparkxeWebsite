@extends('website.layouts.website')

@section('title', 'Privacy Policy — '.config('website.name'))
@section('meta_description', 'Sparkxe Privacy Policy — how we collect, use, store, and protect personal information across our website, AI-assisted digital services, and client projects.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Legal · Privacy',
		'title' => 'Privacy Policy',
		'highlight' => 'Privacy Policy',
		'description' => 'Transparent rules for how Sparkxe collects, uses, and protects your personal information.',
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Privacy Policy'],
		],
	])

	<section class="spark-legal privacy-policy-page">
		<div class="container">
			<div class="privacy-highlights wow fadeInUp">
				<article class="privacy-highlight-card">
					<span class="privacy-highlight-icon"><i class="fa-solid fa-ban"></i></span>
					<h3>We never sell your data</h3>
					<p>Your personal information is never sold to third parties for advertising or resale.</p>
				</article>
				<article class="privacy-highlight-card">
					<span class="privacy-highlight-icon"><i class="fa-solid fa-envelope-open-text"></i></span>
					<h3>Marketing only with opt-in</h3>
					<p>Newsletters and promotional emails are sent only when you explicitly subscribe.</p>
				</article>
				<article class="privacy-highlight-card">
					<span class="privacy-highlight-icon"><i class="fa-solid fa-user-shield"></i></span>
					<h3>You control your rights</h3>
					<p>Request access, correction, deletion, or a copy of your stored information anytime.</p>
				</article>
			</div>

			<div class="privacy-layout">
				<aside class="privacy-toc wow fadeInUp">
					<p class="privacy-toc-label">On this page</p>
					<nav aria-label="Privacy policy sections">
						<ol>
							<li><a href="#privacy-intro">Introduction</a></li>
							<li><a href="#privacy-collect">Information We Collect</a></li>
							<li><a href="#privacy-use">How We Use It</a></li>
							<li><a href="#privacy-cookies">Cookies</a></li>
							<li><a href="#privacy-sharing">Sharing</a></li>
							<li><a href="#privacy-security">Data Security</a></li>
							<li><a href="#privacy-retention">Retention</a></li>
							<li><a href="#privacy-rights">Your Rights</a></li>
							<li><a href="#privacy-links">Third-Party Links</a></li>
							<li><a href="#privacy-changes">Policy Changes</a></li>
							<li><a href="#privacy-contact">Contact Us</a></li>
						</ol>
					</nav>
				</aside>

				<div class="legal-panel privacy-panel wow fadeInUp" data-wow-delay="0.1s">
					<p class="legal-updated">Last updated: {{ date('F j, Y') }}</p>

					<div class="legal-block" id="privacy-intro">
						<h2>1. Introduction</h2>
						<p>Sparkxe ("we", "our", or "us") values your privacy. This Privacy Policy explains how we collect, use, store, and protect your personal information when you visit our website, contact us, or use our services — including digital marketing, custom software, AI-assisted workflows, and related solutions.</p>
					</div>

					<div class="legal-block" id="privacy-collect">
						<h2>2. Information We Collect</h2>
						<p>We may collect information you voluntarily provide, including:</p>
						<ul>
							<li>Full name</li>
							<li>Email address</li>
							<li>Phone number</li>
							<li>Company or business information</li>
							<li>Project requirements and messages submitted through our forms</li>
							<li>Newsletter subscription details</li>
						</ul>
						<p>We may also automatically collect technical information, including:</p>
						<ul>
							<li>IP address</li>
							<li>Browser type</li>
							<li>Device information</li>
							<li>Operating system</li>
							<li>Pages visited</li>
							<li>Referral sources</li>
							<li>Approximate geographic location</li>
							<li>Cookies and usage analytics</li>
						</ul>
					</div>

					<div class="legal-block" id="privacy-use">
						<h2>3. How We Use Your Information</h2>
						<p>We use your information to:</p>
						<ul>
							<li>Respond to enquiries</li>
							<li>Deliver our services</li>
							<li>Prepare quotations and project proposals</li>
							<li>Improve our website and user experience</li>
							<li>Send newsletters or promotional emails (only if you opt in)</li>
							<li>Maintain website security</li>
							<li>Comply with legal obligations</li>
						</ul>
					</div>

					<div class="legal-block" id="privacy-cookies">
						<h2>4. Cookies</h2>
						<p>We use cookies and similar technologies to:</p>
						<ul>
							<li>Remember your preferences</li>
							<li>Maintain website functionality</li>
							<li>Improve website performance</li>
							<li>Analyze visitor traffic (with your consent)</li>
						</ul>
						<p>For more details, please read our <a href="{{ route('website.cookies') }}">Cookie Policy</a>.</p>
					</div>

					<div class="legal-block" id="privacy-sharing">
						<h2>5. Sharing Your Information</h2>
						<p><strong>We never sell your personal information.</strong></p>
						<p>We may share information only with trusted service providers (such as hosting providers, analytics platforms, email services, or payment processors) when necessary to operate our business or when required by law.</p>
					</div>

					<div class="legal-block" id="privacy-security">
						<h2>6. Data Security</h2>
						<p>We use reasonable administrative, technical, and organizational security measures to protect your personal information. However, no internet transmission or storage system can be guaranteed to be 100% secure.</p>
					</div>

					<div class="legal-block" id="privacy-retention">
						<h2>7. Data Retention</h2>
						<p>We retain your personal information only for as long as necessary to provide our services, comply with legal obligations, resolve disputes, and enforce our agreements.</p>
					</div>

					<div class="legal-block" id="privacy-rights">
						<h2>8. Your Rights</h2>
						<p>Depending on your location and applicable laws, you may have the right to:</p>
						<ul>
							<li>Access your personal information</li>
							<li>Correct inaccurate information</li>
							<li>Request deletion of your information</li>
							<li>Withdraw marketing consent</li>
							<li>Request a copy of your stored information</li>
						</ul>
						<p>To exercise these rights, please contact us using the details below.</p>
					</div>

					<div class="legal-block" id="privacy-links">
						<h2>9. Third-Party Links</h2>
						<p>Our website may contain links to external websites. We are not responsible for their privacy practices. We recommend reviewing their privacy policies before providing any personal information.</p>
					</div>

					<div class="legal-block" id="privacy-changes">
						<h2>10. Changes to This Policy</h2>
						<p>We may update this Privacy Policy from time to time. The updated version will always display the latest revision date at the top of this page.</p>
					</div>

					<div class="legal-block privacy-contact-card" id="privacy-contact">
						<h2>11. Contact Us</h2>
						<p><strong>Sparkxe Technologies</strong></p>
						<ul class="privacy-contact-list">
							<li><i class="fa-solid fa-envelope"></i> Email: <a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a></li>
							<li><i class="fa-solid fa-phone"></i> Phone: <a href="tel:{{ config('website.phone_link') }}">{{ config('website.phone') }}</a></li>
							<li>
								<i class="fa-solid fa-location-dot"></i>
								Address:
								<span>
									1/25-2, North Street,<br>
									Kurunjcheri,<br>
									Udumalpet,<br>
									Tiruppur,<br>
									Tamil Nadu – 642154,<br>
									India
								</span>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
