{{-- Cookie consent banner --}}
<div
	id="cookieConsent"
	class="cookie-consent"
	role="dialog"
	aria-labelledby="cookieConsentTitle"
	aria-describedby="cookieConsentText"
	hidden
>
	<div class="cookie-consent-inner">
		<div class="cookie-consent-copy">
			<h3 id="cookieConsentTitle">We use cookies</h3>
			<p id="cookieConsentText">
				We use cookies to improve your experience and analyse site traffic.
				You can accept or reject non-essential cookies.
				<a href="{{ route('website.cookies') }}">Cookie Policy</a>
				·
				<a href="{{ route('website.privacy') }}">Privacy Policy</a>
			</p>
		</div>
		<div class="cookie-consent-actions">
			<button type="button" class="btn-outline-soft" data-cookie-consent="reject">Reject</button>
			<button type="button" class="btn-default" data-cookie-consent="accept">Accept</button>
		</div>
	</div>
</div>
