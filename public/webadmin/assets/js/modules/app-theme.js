/**
 * Light/dark theme toggle with cookie persistence.
 * UI impact: None | Functionality impact: None
 */

export function initTheme() {
	if (typeof jQuery === 'undefined') {
		return;
	}

	const $ = jQuery;
	const docEl = document.documentElement;

	const getCookie = (name) => {
		const match = document.cookie.match(new RegExp('(^| )' + name + '=([^;]+)'));
		return match ? match[2] : null;
	};

	const setCookie = (name, value, days = 365) => {
		const expires = new Date(Date.now() + days * 864e5).toUTCString();
		document.cookie = `${name}=${value}; expires=${expires}; path=/`;
	};

	const getStoredTheme = () => getCookie('theme');
	const setStoredTheme = (theme) => setCookie('theme', theme);

	const getPreferredTheme = () => {
		const storedTheme = getStoredTheme();
		if (storedTheme) {
			return storedTheme;
		}

		return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
	};

	const setTheme = (theme) => {
		docEl.setAttribute('data-bs-theme', theme);
	};

	const preferredTheme = getPreferredTheme();
	setTheme(preferredTheme);

	if (preferredTheme === 'dark') {
		$('.theme-btn').addClass('active');
	} else {
		$('.theme-btn').removeClass('active');
	}

	$('.theme-btn').on('click', function () {
		$(this).toggleClass('active');

		const currentTheme = docEl.getAttribute('data-bs-theme');
		const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

		setTheme(newTheme);
		setStoredTheme(newTheme);
	});
}
