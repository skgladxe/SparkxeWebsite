<!-- Newsletter (above footer) -->
<section class="site-newsletter-bar">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="footer-newsletter wow fadeInUp row">
					<div class="col-md-4">
						<h4>Get digital tips in your inbox</h4>
						<p class="mb-2">Subscribe for marketing insights and tech updates from Sparkxe.</p>
					</div>
					<div class="col-md-8">

						<form class="newsletter-form footer-newsletter-form w-100" id="newsletterForm"
							action="{{ route('website.newsletter.store') }}" method="POST">
							@csrf
							<div class="row g-3 align-items-end w-100">
								<div class="col-md-5">
									<input type="text" name="mobile_number" placeholder="Your mobile number">
								</div>
								<div class="col-md-5">
									<input type="email" name="email" placeholder="Your email address">
								</div>
								<div class="col-md-2">
									<div class="footer-newsletter-submit">
										<button type="submit" class="btn-default">Subscribe</button>
									</div>
								</div>
							</div>
						</form>
						<p class="newsletter-message small mt-2 mb-0" id="newsletterMessage" hidden></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>