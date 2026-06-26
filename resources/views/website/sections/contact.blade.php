<!-- Contact -->
	<section class="spark-contact" id="contact">
		<div class="container">
			<div class="contact-layout">
				<div>
					<div class="section-title">
						<h3 class="wow fadeInUp">Contact Us</h3>
						<h2 class="wow fadeInUp" data-wow-delay="0.2s">Let's discuss your <span>next project</span></h2>
						<p class="wow fadeInUp" data-wow-delay="0.3s" style="margin-top: 16px; opacity: 0.85; line-height: 1.6;">Tell us about your business goals and we'll recommend the right mix of web, software, and marketing services.</p>
					</div>
					<div class="contact-info-list wow fadeInUp" data-wow-delay="0.4s">
						<div class="contact-info-item">
							<div class="icon-wrap"><i class="fa-solid fa-location-dot"></i></div>
							<div><h4>Office</h4><p>Available for remote &amp; on-site projects</p></div>
						</div>
						<div class="contact-info-item">
							<div class="icon-wrap"><i class="fa-solid fa-phone"></i></div>
							<div><h4>Phone</h4><p><a href="tel:{{ config('website.phone_link') }}">{{ config('website.phone') }}</a></p></div>
						</div>
						<div class="contact-info-item">
							<div class="icon-wrap"><i class="fa-solid fa-envelope"></i></div>
							<div><h4>Email</h4><p><a href="mailto:{{ config('website.email') }}">{{ config('website.email') }}</a></p></div>
						</div>
					</div>
				</div>
				<div class="contact-form-box wow fadeInUp" data-wow-delay="0.3s">
					@if (session('contact_success'))
						<div class="alert alert-success mb-3">{{ session('contact_success') }}</div>
					@endif
					<p>Fill in the form and our team will get back to you within 24 hours.</p>
					@php
						$selectedService = $selectedService ?? request('service');
					@endphp
					<form class="spark-form" id="sparkContactForm" method="POST" action="{{ route('website.contact.store') }}">
						@csrf
						<div class="form-row">
							<input type="text" name="first_name" placeholder="First Name" required>
							<input type="text" name="last_name" placeholder="Last Name" required>
						</div>
						<div class="form-row">
							<input type="email" name="email" placeholder="Email Address" required>
							<input type="tel" name="phone" placeholder="Phone Number">
						</div>
						<select name="service" required>
							<option value="">Select a Service</option>
							@foreach (config('website.services') as $service)
								<option value="{{ $service['slug'] }}" @selected($selectedService === $service['slug'])>{{ $service['title'] }}</option>
							@endforeach
							<option value="other" @selected($selectedService === 'other')>Other</option>
						</select>
						<textarea name="message" placeholder="Tell us about your project..." required></textarea>
						<button type="submit" class="btn-default">Submit Message</button>
					</form>
				</div>
			</div>
		</div>
	</section>
