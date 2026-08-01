<!-- Footer -->
	<footer class="spark-footer">
		<div class="container">
			<div class="footer-panel wow fadeInUp">
				<div class="footer-top">
					<div class="footer-brand">
						<a href="{{ route('website.home') }}" class="footer-logo d-inline-block mb-3">
							<img src="{{ $siteFooterLogoUrl ?? \App\Models\SiteSetting::websiteFooterLogoUrl() }}" alt="{{ config('website.name') }}" height="48">
						</a>
						<h2>Smart Software for Seamless Business Growth</h2>
						<div class="footer-brand-line"></div>
					</div>
					<div class="footer-col">
						<h4>Solutions</h4>
						<ul>
							@foreach (\App\Support\WebsiteServices::footerServices() as $service)
								<li><a href="{{ route('website.services.show', $service['slug']) }}">{{ $service['title'] }}</a></li>
							@endforeach
						</ul>
					</div>
					<div class="footer-col">
						<h4>Company</h4>
						<ul>
							<li><a href="{{ route('website.about') }}">About Sparkxe</a></li>
							<li><a href="{{ route('website.team') }}">Our Team</a></li>
							<li><a href="{{ route('website.services.index') }}">Our Services</a></li>
							<li><a href="{{ route('website.contact') }}">Get a Quote</a></li>
							<li><a href="{{ route('website.pricing') }}">Pricing</a></li>
							<li><a href="{{ route('website.privacy') }}">Privacy Policy</a></li>
							<li><a href="{{ route('website.cookies') }}">Cookie Policy</a></li>
						</ul>
					</div>
					<div class="footer-col footer-col-contact">
						<h4>Contact</h4>
						<div class="footer-contact-mini">
							<p>
								<a href="{{ config('website.social.map') }}" target="_blank" rel="noopener noreferrer">
									@foreach (config('website.address_lines') as $line)
										{{ $line }}@if (!$loop->last)<br>@endif
									@endforeach
								</a>
							</p>
							<p><a href="tel:{{ config('website.phone_link') }}">{{ config('website.phone') }}</a></p>
							<p><a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a></p>
						</div>
						<div class="footer-social">
							<a href="{{ config('website.social.instagram') }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
							<a href="{{ config('website.social.facebook') }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
							<a href="{{ config('website.social.whatsapp') }}?text={{ urlencode(config('website.whatsapp_message')) }}" target="_blank" rel="noopener noreferrer" aria-label="WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
							<a href="{{ config('website.social.map') }}" target="_blank" rel="noopener noreferrer" aria-label="Location map"><i class="fa-solid fa-location-dot"></i></a>
							<a href="{{ config('website.social.phone') }}" aria-label="Call"><i class="fa-solid fa-phone"></i></a>
						</div>
					</div>
				</div>
				<div class="footer-bottom">
					<p>Copyright &copy; {{ date('Y') }} {{ config('website.name', 'Sparkxe Technologies') }}. All rights reserved. <a href="{{ config('website.domain', 'https://sparkxe.com') }}" rel="noopener">sparkxe.com</a></p>
				</div>
			</div>
		</div>
	</footer>
