(function ($) {
	"use strict";

	var $window = $(window);
	var $body = $("body");

	/* Preloader */
	$window.on("load", function () {
		$(".preloader").fadeOut(600);
	});

	/* Sticky header — pill style on scroll, always visible */
	if ($body.hasClass("active-sticky-header")) {
		$window.on("scroll", function () {
			var y = $window.scrollTop();
			$("header .header-sticky").toggleClass("is-scrolled", y > 50);
		});
	}

	/* Theme picker — 10 variants */
	var themes = ["spark", "ocean", "sunset", "violet", "forest", "rose", "midnight", "copper", "arctic", "neon"];
	var themeLocked = $body.attr("data-theme-locked") === "1";
	var savedTheme = localStorage.getItem("sparkxe-theme");

	if (!themeLocked && savedTheme && themes.indexOf(savedTheme) !== -1) {
		$body.attr("data-theme", savedTheme);
		$(".theme-dot").removeClass("active");
		$('.theme-dot[data-theme="' + savedTheme + '"]').addClass("active");
	}

	if (!themeLocked) {
		$(".theme-dot").on("click", function () {
			var theme = $(this).data("theme");
			$body.attr("data-theme", theme);
			$(".theme-dot").removeClass("active");
			$(this).addClass("active");
			localStorage.setItem("sparkxe-theme", theme);
		});
	}

	/* Hero Slider */
	if ($(".hero-slider .swiper").length) {
		var slideCount = parseInt($(".hero-slider").data("slide-count"), 10) || 1;
		var heroConfig = {
			slidesPerView: 1,
			speed: 800,
			spaceBetween: 0,
			loop: slideCount > 1
		};

		if (slideCount > 1) {
			heroConfig.autoplay = {
				delay: 5000,
				disableOnInteraction: false
			};
			heroConfig.pagination = {
				el: ".hero-slider .swiper-pagination",
				clickable: true
			};
		}

		new Swiper(".hero-slider .swiper", heroConfig);
	}

	/* Custom Mobile Menu */
	var $mobileBtn = $(".mobile-menu-btn");
	var $mobilePanel = $("#mobileMenu");

	$mobileBtn.on("click", function () {
		var open = $(this).toggleClass("open").hasClass("open");
		$mobilePanel.toggleClass("open", open);
		$body.toggleClass("menu-open", open);
	});

	$mobilePanel.find("a").on("click", function () {
		$mobileBtn.removeClass("open");
		$mobilePanel.removeClass("open");
		$body.removeClass("menu-open");
	});

	$mobilePanel.find(".mobile-sub-toggle").on("click", function () {
		$(this).closest(".mobile-has-sub").toggleClass("open");
	});

	$mobilePanel.find(".mobile-nested-toggle").on("click", function () {
		$(this).closest(".mobile-has-nested").toggleClass("open");
	});

	/* Specialization Slider */
	if ($(".specialization-slider .swiper").length) {
		new Swiper(".specialization-slider .swiper", {
			slidesPerView: 1,
			speed: 800,
			spaceBetween: 24,
			loop: true,
			autoHeight: false,
			autoplay: {
				delay: 4000,
				disableOnInteraction: false
			},
			pagination: {
				el: ".specialization-slider .swiper-pagination",
				clickable: true
			},
			breakpoints: {
				576: { slidesPerView: 2 },
				992: { slidesPerView: 3 },
				1200: { slidesPerView: 4 }
			}
		});
	}

	/* Counters — trigger once when visible; always end on data-count */
	function initCounter($c) {
		if ($c.data("counted")) return;
		$c.data("counted", true);
		var target = parseInt($c.attr("data-count"), 10);
		if (isNaN(target)) {
			target = parseInt($c.text(), 10) || 0;
		}
		$c.attr("data-count", target).text(target);
		$c.counterUp({ delay: 8, time: 1800 });
	}

	function initCounters($el) {
		$el.find(".counter").each(function () {
			initCounter($(this));
		});
	}

	$(".hero, .our-facts-box, .spark-about, .stats-strip-section").each(function () {
		var $section = $(this);
		$section.waypoint(function () {
			initCounters($section);
			this.destroy();
		}, { offset: "80%" });
	});

	$(".tool-item-counter").each(function () {
		var $counterWrap = $(this);
		$counterWrap.waypoint(function () {
			initCounters($counterWrap);
			this.destroy();
		}, { offset: "90%" });
	});

	/* FAQ Accordion */
	$(".faq-question").on("click", function () {
		var $item = $(this).closest(".faq-item");
		var wasActive = $item.hasClass("active");
		$(".faq-item").removeClass("active");
		if (!wasActive) $item.addClass("active");
	});

	/* Video Popup */
	if ($(".popup-video").length) {
		$(".popup-video").magnificPopup({
			type: "iframe",
			mainClass: "mfp-fade",
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
		});
	}

	/* Newsletter form */
	$("#newsletterForm").on("submit", function (e) {
		e.preventDefault();
		var $form = $(this);
		var $btn = $form.find("button");
		var $msg = $("#newsletterMessage");
		var originalText = $btn.text();

		$btn.prop("disabled", true).text("Subscribing...");
		$msg.prop("hidden", true).removeClass("text-success text-danger");

		$.ajax({
			url: $form.attr("action"),
			method: "POST",
			data: $form.serialize(),
			headers: {
				"X-CSRF-TOKEN": $form.find('input[name="_token"]').val(),
				"Accept": "application/json"
			}
		})
		.done(function (response) {
			$msg.text(response.message || "Thanks for subscribing!").addClass("text-success").prop("hidden", false);
			$form[0].reset();
		})
		.fail(function (xhr) {
			var message = "Something went wrong. Please try again.";
			if (xhr.responseJSON && xhr.responseJSON.message) {
				message = xhr.responseJSON.message;
			} else if (xhr.responseJSON && xhr.responseJSON.errors && xhr.responseJSON.errors.email) {
				message = xhr.responseJSON.errors.email[0];
			}
			$msg.text(message).addClass("text-danger").prop("hidden", false);
		})
		.always(function () {
			$btn.prop("disabled", false).text(originalText);
		});
	});

	/* Contact form — allow native POST when form has action attribute */
	$("#sparkContactForm").on("submit", function (e) {
		if (this.getAttribute("action")) {
			return;
		}
		e.preventDefault();
		var $form = $(this);
		var $btn = $form.find("button[type=submit]");
		$btn.text("Message Sent!").prop("disabled", true);
		setTimeout(function () {
			$btn.text("Submit Message").prop("disabled", false);
			$form[0].reset();
		}, 3000);
	});

	/* WOW Animations */
	if (typeof WOW !== "undefined") {
		new WOW({
			boxClass: "wow",
			animateClass: "animated",
			offset: 0,
			mobile: true,
			live: true
		}).init();
	}

	/* Cookie consent */
	var COOKIE_CONSENT_KEY = "sparkxe-cookie-consent";
	var $cookieBanner = $("#cookieConsent");

	function setCookieConsent(value) {
		try {
			localStorage.setItem(COOKIE_CONSENT_KEY, value);
		} catch (e) {}
		$cookieBanner.attr("hidden", true);
		document.dispatchEvent(new CustomEvent("sparkxe:cookie-consent", { detail: { value: value } }));
	}

	function getCookieConsent() {
		try {
			return localStorage.getItem(COOKIE_CONSENT_KEY);
		} catch (e) {
			return null;
		}
	}

	function updateCookiePrefStatus() {
		var $status = $("#cookiePrefStatus");
		if (!$status.length) return;
		var value = getCookieConsent();
		if (!value) {
			$status.prop("hidden", true);
			return;
		}
		$status
			.text(value === "accepted" ? "Current preference: cookies accepted." : "Current preference: cookies rejected.")
			.prop("hidden", false);
	}

	if ($cookieBanner.length && !getCookieConsent()) {
		$cookieBanner.prop("hidden", false);
	}

	$(document).on("click", "[data-cookie-consent]", function () {
		var action = $(this).attr("data-cookie-consent");
		if (action === "accept") {
			setCookieConsent("accepted");
		} else if (action === "reject") {
			setCookieConsent("rejected");
		}
		updateCookiePrefStatus();
	});

	updateCookiePrefStatus();

	/* Cursor glow — smooth green shadow follow */
	(function initCursorGlow() {
		var outer = document.getElementById("cursorGlowOuter");
		var inner = document.getElementById("cursorGlowInner");
		if (!outer || !inner) return;

		var canAnimate =
			window.matchMedia("(hover: hover)").matches &&
			!window.matchMedia("(prefers-reduced-motion: reduce)").matches;

		if (!canAnimate) return;

		var targetX = window.innerWidth / 2;
		var targetY = window.innerHeight / 2;
		var outerX = targetX;
		var outerY = targetY;
		var innerX = targetX;
		var innerY = targetY;
		var active = false;

		function setTransform(el, x, y) {
			el.style.transform = "translate3d(" + x + "px, " + y + "px, 0) translate(-50%, -50%)";
		}

		document.addEventListener("mousemove", function (e) {
			targetX = e.clientX;
			targetY = e.clientY;
			if (!active) {
				active = true;
				$body.addClass("cursor-glow-ready");
				outerX = targetX;
				outerY = targetY;
				innerX = targetX;
				innerY = targetY;
			}
		});

		document.addEventListener("mouseleave", function () {
			active = false;
			$body.removeClass("cursor-glow-ready");
		});

		(function tick() {
			outerX += (targetX - outerX) * 0.08;
			outerY += (targetY - outerY) * 0.08;
			innerX += (targetX - innerX) * 0.14;
			innerY += (targetY - innerY) * 0.14;
			setTransform(outer, outerX, outerY);
			setTransform(inner, innerX, innerY);
			requestAnimationFrame(tick);
		})();
	})();
})(jQuery);
