/**
 * Sidebar toggler + menubar navigation + email/chat mobile sidebars.
 * UI impact: None | Functionality impact: None
 */

export function initSidebar() {
	const docEl = document.documentElement;
	const appTogglers = document.querySelectorAll('.app-toggler');
	const appMenubar = document.getElementById('appMenubar');

	if (appTogglers.length && appMenubar) {
		appTogglers.forEach((toggler) => {
			toggler.addEventListener('click', () => {
				toggler.classList.toggle('active');
				appMenubar.classList.toggle('open');

				if (window.innerWidth >= 1280) {
					const current = docEl.getAttribute('data-app-sidebar');
					docEl.setAttribute(
						'data-app-sidebar',
						current === 'full' ? 'mini' : 'full'
					);
				}
			});
		});

		appMenubar.addEventListener('mouseenter', () => {
			if (docEl.getAttribute('data-app-sidebar') === 'mini') {
				docEl.setAttribute('data-app-sidebar', 'mini-hover');
			}
		});

		appMenubar.addEventListener('mouseleave', () => {
			if (docEl.getAttribute('data-app-sidebar') === 'mini-hover') {
				docEl.setAttribute('data-app-sidebar', 'mini');
			}
		});
	}

	initSidebarMenu();
	initEmailSidebarToggle();
	initChatSidebarToggle();
}

function initSidebarMenu() {
	if (typeof jQuery === 'undefined') {
		return;
	}

	const $ = jQuery;

	$('.app-navbar .menu-inner').hide();

	$('.app-navbar').on('click', 'li > a', function (e) {
		const $link = $(this);
		const $submenu = $link.next('.menu-inner');

		if ($submenu.length) {
			e.preventDefault();

			if ($link.hasClass('open')) {
				$link.removeClass('open');
				$submenu.slideUp();
			} else {
				$link.closest('.app-navbar')
					.find('a.open').removeClass('open')
					.next('.menu-inner').slideUp();

				$link.addClass('open');
				$submenu.slideDown();
			}
		}
	});

	$('.app-navbar a').removeClass('active open');
	$('.app-navbar li').removeClass('active');
	$('.app-navbar-tabs .menu-link').removeClass('active');
	$('.app-tab-content .tab-pane').removeClass('active show');

	const $activeLink = $('.app-tab-content .side-menubar a').filter(function () {
		const href = $(this).attr('href');
		if (!href || href === '#' || href.startsWith('http')) {
			return false;
		}

		try {
			const linkPath = new URL(href, window.location.origin).pathname.replace(/\/$/, '') || '/';
			const currentPath = window.location.pathname.replace(/\/$/, '') || '/';
			return linkPath === currentPath;
		} catch {
			return false;
		}
	}).first();

	if ($activeLink.length) {
		$activeLink.addClass('active');
		$activeLink.parent('li').addClass('active');
		$activeLink
			.parents('.menu-inner').show()
			.prev('a').addClass('open active');

		const $tabPane = $activeLink.closest('.tab-pane');

		if ($tabPane.length) {
			$tabPane.addClass('active show');

			const tabId = $tabPane.attr('id');
			$('.app-navbar-tabs .menu-link[href="#' + tabId + '"]').addClass('active');
		}
	} else {
		const $firstTab = $('.app-navbar-tabs .menu-link[href^="#"]').first();
		const firstTabId = $firstTab.attr('href');

		if (firstTabId) {
			$firstTab.addClass('active');
			$(firstTabId).addClass('active show');
		}
	}
}

function initEmailSidebarToggle() {
	const toggler = document.querySelector('.mail-sidebar-toggler');
	const sidebar = document.querySelector('.mail-sidebar');
	const overlay = document.querySelector('.sidebar-mobile-overlay');

	if (!toggler || !sidebar || !overlay) {
		return;
	}

	toggler.onclick = () => {
		sidebar.classList.toggle('open');
		overlay.classList.toggle('show', sidebar.classList.contains('open'));
	};

	overlay.onclick = () => {
		sidebar.classList.remove('open');
		overlay.classList.remove('show');
	};
}

function initChatSidebarToggle() {
	const toggler = document.querySelector('.chat-sidebar-toggler');
	const sidebar = document.querySelector('.chat-sidebar');
	const overlay = document.querySelector('.sidebar-mobile-overlay');
	const closeBtn = document.querySelector('.btn-close');

	if (!toggler || !sidebar || !overlay) {
		return;
	}

	const close = () => {
		sidebar.classList.remove('open');
		overlay.classList.remove('show');
	};

	toggler.onclick = () => {
		sidebar.classList.toggle('open');
		overlay.classList.toggle('show', sidebar.classList.contains('open'));
	};

	overlay.onclick = close;

	if (closeBtn) {
		closeBtn.onclick = close;
	}
}
