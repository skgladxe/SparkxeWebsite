<!-- Team -->
<section class="x-section spark-team" id="team">
	<div class="container">
		<div class="section-title section-title-center team-page-intro">
			<h3 class="wow fadeInUp">Our Team</h3>
			<h2 class="wow fadeInUp" data-wow-delay="0.2s">Experts behind <span>Sparkxe</span></h2>
		</div>

		<div class="team-showcase">
			@forelse ($teamMembers ?? [] as $index => $member)
				<div class="team-showcase-row wow fadeInUp {{ $loop->odd ? 'is-reversed' : '' }}" data-wow-delay="{{ ($index * 0.1).'s' }}">
					<div class="team-showcase-media">
						@if ($member->photoUrl())
							<div class="team-showcase-photo">
								<img src="{{ $member->photoUrl() }}" alt="{{ $member->name }}">
							</div>
						@else
							<div class="team-showcase-photo team-showcase-photo-fallback">
								<span>{{ $member->initial() }}</span>
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
				</div>
			@empty
				<div class="team-showcase-row wow fadeInUp">
					<div class="team-showcase-media">
						<div class="team-showcase-photo team-showcase-photo-fallback"><span>S</span></div>
					</div>
					<div class="team-showcase-content">
						<span class="team-showcase-role">Digital Experts</span>
						<h3 class="team-showcase-name">Sparkxe Team</h3>
						<p class="team-showcase-description">Add team members from the admin panel to display them here.</p>
					</div>
				</div>
			@endforelse
		</div>
	</div>
</section>
