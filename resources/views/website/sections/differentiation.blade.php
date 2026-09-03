<!-- Differentiation -->
<section @class(['x-section', 'spark-difference', 'spark-difference-compact' => $compact ?? false]) id="differentiation">
	<div class="container">
		@if ($compact ?? false)
			<div class="difference-intro-centered wow fadeInUp">
				<div class="section-title section-title-center">
					<h3>{{ $eyebrow ?? 'What Sets Us Apart' }}</h3>
					<h2>{!! $titleHtml ?? 'The Sparkxe <span>difference</span>' !!}</h2>
				</div>
				<p class="difference-lead">{{ $lead ?? 'We don’t compete on generic feature lists. Sparkxe Technologies is built around clarity, ownership, and outcomes that keep compounding after launch.' }}</p>
			</div>
		@endIf

		<div class="difference-layout">
			@if (! ($compact ?? false))
				<div class="difference-intro wow fadeInUp">
					<div class="section-title">
						<h3>{{ $eyebrow ?? 'What Sets Us Apart' }}</h3>
						<h2>{!! $titleHtml ?? 'The Sparkxe <span>difference</span>' !!}</h2>
					</div>
					<p class="difference-lead">{{ $lead ?? 'We don’t compete on generic feature lists. Sparkxe Technologies is built around clarity, ownership, and outcomes that keep compounding after launch.' }}</p>
					<a href="{{ route('website.contact') }}" class="btn-default">Talk to our team</a>
				</div>
			@endIf

			<div class="difference-rail">
				<article class="difference-item wow fadeInUp">
					<span class="difference-index">01</span>
					<div class="difference-copy">
						<h3>One Partner, Full Stack</h3>
						<p>Strategy, design, development, and marketing stay aligned under one team — no agency handoffs.</p>
					</div>
				</article>
				<article class="difference-item wow fadeInUp" data-wow-delay="0.05s">
					<span class="difference-index">02</span>
					<div class="difference-copy">
						<h3>Clear Milestones</h3>
						<p>Every project runs on a defined roadmap with visible progress, so you always know what’s next.</p>
					</div>
				</article>
				<article class="difference-item wow fadeInUp" data-wow-delay="0.1s">
					<span class="difference-index">03</span>
					<div class="difference-copy">
						<h3>Specialists, Not Generalists</h3>
						<p>Dedicated experts for design, engineering, and growth work together on outcomes that matter.</p>
					</div>
				</article>
				<article class="difference-item wow fadeInUp" data-wow-delay="0.15s">
					<span class="difference-index">04</span>
					<div class="difference-copy">
						<h3>Built for Long-Term</h3>
						<p>We stay after launch — hosting, updates, campaigns, and continuous improvement included.</p>
					</div>
				</article>
				<article class="difference-item wow fadeInUp" data-wow-delay="0.2s">
					<span class="difference-index">05</span>
					<div class="difference-copy">
						<h3>Business-First Thinking</h3>
						<p>We design for leads, sales, and efficiency — not just screens that look good in a demo.</p>
					</div>
				</article>
				<article class="difference-item wow fadeInUp" data-wow-delay="0.25s">
					<span class="difference-index">06</span>
					<div class="difference-copy">
						<h3>Transparent Pricing</h3>
						<p>Scoped proposals, clear timelines, and no surprise fees — you approve before we build.</p>
					</div>
				</article>
			</div>
		</div>

		@if ($compact ?? false)
			<div class="difference-cta wow fadeInUp" data-wow-delay="0.15s">
				<a href="{{ route('website.contact') }}" class="btn-default">Talk to our team</a>
			</div>
		@endIf
	</div>
</section>
