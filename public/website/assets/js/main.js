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

	/* Counters — trigger when visible */
	function initCounter($c) {
		if ($c.data("counted")) return;
		$c.data("counted", true);
		var target = parseInt($c.data("count"), 10);
		if (isNaN(target)) {
			target = parseInt($c.text(), 10) || 0;
		}
		$c.text(target);
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
		}, { offset: "80%" });
	});

	$(".tool-item-counter").each(function () {
		var $counterWrap = $(this);
		$counterWrap.waypoint(function () {
			initCounters($counterWrap);
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
})(jQuery);
