<!-- FAQ -->
<section @class(['spark-faq', 'spark-faq-compact' => $hideHeading ?? false]) id="faq">
	<div class="container">
		@if ($hideHeading ?? false)
			<div class="faq-accordion wow fadeInUp" data-wow-delay="0.1s">
				@forelse ($faqs ?? [] as $faq)
					<x-website::faq-item
						:question="$faq->question"
						:answer="$faq->answer"
						:active="$faq->is_open_default"
					/>
				@empty
					@foreach (config('website.faqs') as $faq)
						<x-website::faq-item
							:question="$faq['question']"
							:answer="$faq['answer']"
							:active="$faq['active']"
						/>
					@endforeach
				@endforelse
			</div>
		@else
			<div class="faq-layout">
				<div>
					<x-website::section-heading
						eyebrow="FAQ"
						title="Answers to questions we hear often"
						highlight="hear often"
						description="Can't find what you're looking for? Reach out — we're happy to help with a free consultation."
					/>
				</div>
				<div class="faq-accordion wow fadeInUp" data-wow-delay="0.2s">
					@forelse ($faqs ?? [] as $faq)
						<x-website::faq-item
							:question="$faq->question"
							:answer="$faq->answer"
							:active="$faq->is_open_default"
						/>
					@empty
						@foreach (config('website.faqs') as $faq)
							<x-website::faq-item
								:question="$faq['question']"
								:answer="$faq['answer']"
								:active="$faq['active']"
							/>
						@endforeach
					@endforelse
				</div>
			</div>
		@endIf
	</div>
</section>
