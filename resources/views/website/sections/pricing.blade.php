<!-- Pricing -->
<section class="spark-pricing" id="pricing">
	<div class="container">
		<div class="row section-row justify-content-center text-center">
			<div class="col-lg-8">
				<x-website::section-heading
					eyebrow="Pricing Plans"
					title="Flexible packages for every business stage"
					highlight="business stage"
					description="Whether you need a landing page, a full e-commerce store, or enterprise software — Sparkxe has a plan that fits your budget and goals."
					:centered="true"
				/>
			</div>
		</div>
		<div class="pricing-grid wow fadeInUp" data-wow-delay="0.2s">
			@foreach (config('website.pricing_plans') as $plan)
				<x-website::pricing-card
					:name="$plan['name']"
					:description="$plan['description']"
					:price="$plan['price']"
					:priceSuffix="$plan['price_suffix']"
					:features="$plan['features']"
					:featured="$plan['featured']"
					:badge="$plan['badge']"
					:buttonClass="$plan['button_class']"
					:buttonText="$plan['button_text']"
				/>
			@endforeach
		</div>
	</div>
</section>
