<!-- Team -->
	<section class="x-section spark-team" id="team">
		<div class="container">
			<div class="section-title section-title-center" style="text-align:center;margin-bottom:50px;">
				<h3 class="wow fadeInUp">Our Team</h3>
				<h2 class="wow fadeInUp" data-wow-delay="0.2s">Experts behind <span>Sparkxe</span></h2>
			</div>
			<div class="team-grid">
				@forelse ($teamMembers ?? [] as $index => $member)
					<div class="team-card wow fadeInUp" data-wow-delay="{{ ($index * 0.1).'s' }}">
						@if ($member->photoUrl())
							<div class="team-avatar team-avatar-photo"><img src="{{ $member->photoUrl() }}" alt="{{ $member->name }}"></div>
						@else
							<div class="team-avatar">{{ $member->initial() }}</div>
						@endif
						<h3>{{ $member->name }}</h3>
						<span>{{ $member->role }}</span>
						<div class="team-social">
							@if ($member->linkedin)<a href="{{ $member->linkedin }}" target="_blank" rel="noopener"><i class="fa-brands fa-linkedin-in"></i></a>@endif
							@if ($member->twitter)<a href="{{ $member->twitter }}" target="_blank" rel="noopener"><i class="fa-brands fa-x-twitter"></i></a>@endif
							@if ($member->github)<a href="{{ $member->github }}" target="_blank" rel="noopener"><i class="fa-brands fa-github"></i></a>@endif
							@if ($member->dribbble)<a href="{{ $member->dribbble }}" target="_blank" rel="noopener"><i class="fa-brands fa-dribbble"></i></a>@endif
							@if ($member->instagram)<a href="{{ $member->instagram }}" target="_blank" rel="noopener"><i class="fa-brands fa-instagram"></i></a>@endif
						</div>
					</div>
				@empty
					<div class="team-card wow fadeInUp"><div class="team-avatar">S</div><h3>Sparkxe Team</h3><span>Digital Experts</span></div>
				@endforelse
			</div>
		</div>
	</section>
