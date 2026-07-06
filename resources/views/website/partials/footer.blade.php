<!-- Footer -->
	<footer class="spark-footer">
		<div class="container">
			<div class="footer-panel wow fadeInUp">
				<div class="footer-top">
					<div class="footer-brand">
						<h2>Smart Software for Seamless Business Growth</h2>
						<div class="footer-brand-line"></div>
						<div class="footer-social">
							<a href="{{ config('website.social.facebook') }}" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
							<a href="{{ config('website.social.twitter') }}" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
							<a href="{{ config('website.social.instagram') }}" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
							<a href="{{ config('website.social.linkedin') }}" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
						</div>
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
						<h4>Support</h4>
						<ul>
							<li><a href="{{ route('website.faq') }}">Help Center</a></li>
							<li><a href="{{ route('website.contact') }}">Contact Support</a></li>
							<li><a href="{{ route('website.pricing') }}">Pricing</a></li>
							<li><a href="{{ route('website.blog') }}">Blog</a></li>
						</ul>
					</div>
					<div class="footer-col">
						<h4>Company</h4>
						<ul>
							<li><a href="{{ route('website.about') }}">About Sparkxe</a></li>
							<li><a href="{{ route('website.team') }}">Our Team</a></li>
							<li><a href="{{ route('website.services.index') }}">Our Services</a></li>
							<li><a href="{{ route('website.contact') }}">Get a Quote</a></li>
						</ul>
					</div>
				</div>
				<div class="footer-bottom">
					<p>Copyright &copy; {{ date('Y') }} Sparkxe. All rights reserved.</p>
				</div>
			</div>
		</div>
	</footer>
