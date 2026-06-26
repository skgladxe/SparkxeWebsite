<!-- WhatsApp float -->
<a
	href="https://wa.me/{{ config('website.whatsapp') }}?text={{ urlencode(config('website.whatsapp_message')) }}"
	class="whatsapp-float"
	target="_blank"
	rel="noopener noreferrer"
	aria-label="Chat on WhatsApp"
>
	<i class="fa-brands fa-whatsapp"></i>
</a>
