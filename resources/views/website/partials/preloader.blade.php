<!-- Preloader -->
	<div class="preloader">
		<div class="loading-container">
			<div class="loading"></div>
			<div id="loading-icon"><img src="{{ $siteLogoUrl ?? \App\Models\SiteSetting::websiteNavLogoUrl() }}" alt="{{ config('website.name') }}"></div>
		</div>
	</div>
