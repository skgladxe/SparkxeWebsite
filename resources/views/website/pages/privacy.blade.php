@extends('website.layouts.website')

@section('title', 'Privacy Policy — '.config('website.name'))
@section('meta_description', 'Read how Sparkxe collects, uses, and protects your personal information.')

@section('content')
	@include('website.partials.page-hero', [
		'eyebrow' => 'Legal',
		'title' => 'Privacy Policy',
		'highlight' => 'Privacy Policy',
		'description' => 'How we collect, use, and protect your information when you use our website and services.',
		'breadcrumbs' => [
			['label' => 'Home', 'url' => route('website.home')],
			['label' => 'Privacy Policy'],
		],
	])

	<section class="spark-legal">
		<div class="container">
			<div class="legal-panel wow fadeInUp">
				<p class="legal-updated">Last updated: {{ date('F j, Y') }}</p>

				<div class="legal-block">
					<h2>1. Introduction</h2>
					<p>{{ config('website.name') }} (“we”, “us”, or “our”) respects your privacy. This Privacy Policy explains what information we collect when you visit our website or contact us, how we use it, and the choices you have.</p>
				</div>

				<div class="legal-block">
					<h2>2. Information we collect</h2>
					<p>We may collect information you provide directly, such as:</p>
					<ul>
						<li>Name, email address, phone number, and company details submitted via contact or enquiry forms</li>
						<li>Newsletter subscription email addresses</li>
						<li>Messages and project details you share with our team</li>
					</ul>
					<p>We may also collect technical data automatically, such as browser type, device information, approximate location, pages visited, and referring URLs, through cookies and similar technologies.</p>
				</div>

				<div class="legal-block">
					<h2>3. How we use your information</h2>
					<p>We use the information we collect to:</p>
					<ul>
						<li>Respond to enquiries and provide requested services</li>
						<li>Send updates, newsletters, or marketing communications when you opt in</li>
						<li>Improve our website, content, and user experience</li>
						<li>Maintain security, prevent abuse, and meet legal obligations</li>
					</ul>
				</div>

				<div class="legal-block">
					<h2>4. Cookies</h2>
					<p>Our website uses cookies and similar technologies to remember preferences and understand how the site is used. You can accept or reject non-essential cookies through our cookie banner. For more detail, see our <a href="{{ route('website.cookies') }}">Cookie Policy</a>.</p>
				</div>

				<div class="legal-block">
					<h2>5. Sharing of information</h2>
					<p>We do not sell your personal information. We may share data with trusted service providers who help us operate our website and business (for example hosting, email, or analytics), only as needed to perform those services, and with authorities when required by law.</p>
				</div>

				<div class="legal-block">
					<h2>6. Data retention &amp; security</h2>
					<p>We keep personal information only as long as needed for the purposes described in this policy, or as required by law. We take reasonable technical and organisational measures to protect your data, though no method of transmission over the internet is completely secure.</p>
				</div>

				<div class="legal-block">
					<h2>7. Your rights</h2>
					<p>Depending on applicable law, you may have the right to access, correct, update, or request deletion of your personal information, and to withdraw consent for marketing communications. To make a request, contact us using the details below.</p>
				</div>

				<div class="legal-block">
					<h2>8. Third-party links</h2>
					<p>Our website may link to third-party sites. We are not responsible for the privacy practices or content of those sites. We encourage you to review their policies before providing personal information.</p>
				</div>

				<div class="legal-block">
					<h2>9. Changes to this policy</h2>
					<p>We may update this Privacy Policy from time to time. The “Last updated” date at the top of this page will reflect the latest revision. Continued use of our website after changes means you accept the updated policy.</p>
				</div>

				<div class="legal-block">
					<h2>10. Contact us</h2>
					<p>If you have questions about this Privacy Policy or how we handle your data, contact us at:</p>
					<ul>
						<li>Email: <a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a></li>
						<li>Phone: <a href="tel:{{ config('website.phone_link') }}">{{ config('website.phone') }}</a></li>
						<li>
							Address:
							{{ implode(' ', config('website.address_lines')) }}
						</li>
						<li>Or visit our <a href="{{ route('website.contact') }}">Contact</a> page</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
@endsection
