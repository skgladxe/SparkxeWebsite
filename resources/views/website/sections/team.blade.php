<!-- Team -->
<section class="x-section spark-team" id="team">
	<div class="container">
		@if (!empty($showIntro))
			<div class="section-title section-title-center team-page-intro">
				<h3 class="wow fadeInUp">{{ $eyebrow ?? 'Our Team' }}</h3>
				<h2 class="wow fadeInUp" data-wow-delay="0.2s">{!! $titleHtml ?? 'Experts behind <span>Sparkxe</span>' !!}</h2>
			</div>
		@endif

		<div class="team-showcase">
			@forelse ($teamMembers ?? [] as $index => $member)
				<article class="team-showcase-row wow fadeInUp {{ $loop->odd ? 'is-reversed' : '' }}" data-wow-delay="{{ ($index * 0.08).'s' }}">
					<div class="team-showcase-media">
						@if ($member->photoUrl())
							<div class="team-showcase-photo">
								<img src="{{ $member->photoUrl() }}" alt="{{ $member->name }}" loading="lazy">
							</div>
						@else
							<div class="team-showcase-photo team-showcase-photo-fallback" aria-hidden="true">
								<span class="team-showcase-initial">{{ $member->initial() }}</span>
							</div>
						@endif
					</div>

					<div class="team-showcase-content">
						<span class="team-showcase-role">{{ $member->role }}</span>
						<h3 class="team-showcase-name">{{ $member->name }}</h3>

						@if ($member->description)
							<p class="team-showcase-description">{{ $member->description }}</p>
						@endif

						@if (filled($member->renderedNotes()))
							<div class="team-showcase-notes rich-content">{!! $member->renderedNotes() !!}</div>
						@endif
					</div>
				</article>
			@empty
				<article class="team-showcase-row wow fadeInUp">
					<div class="team-showcase-media">
						<div class="team-showcase-photo team-showcase-photo-fallback" aria-hidden="true">
							<span class="team-showcase-initial">S</span>
						</div>
					</div>
					<div class="team-showcase-content">
						<span class="team-showcase-role">Digital Experts</span>
						<h3 class="team-showcase-name">Sparkxe Team</h3>
						<p class="team-showcase-description">Add team members from the admin panel to display them here.</p>
					</div>
				</article>
			@endforelse
		</div>
	</div>
</section>
