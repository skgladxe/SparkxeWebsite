/**
 * Bootstrap dropdowns, tooltips, popovers, and status pickers.
 * UI impact: None | Functionality impact: None
 */

export function initDropdown() {
	initSelectPicker();
	initTooltips();
	initPopover();
	initPasswordToggle();
	initSidebarPanel();
	initPriceSwitch();
}

export function initSelectPicker() {
	document.querySelectorAll('.select-status').forEach((dropdown) => {
		const toggleBtn = dropdown.querySelector('.dropdown-toggle');
		const items = dropdown.querySelectorAll('.dropdown-item');

		if (!toggleBtn) {
			return;
		}

		const updateBtn = (text, cls) => {
			toggleBtn.classList.forEach((className) => {
				if (/^btn-/.test(className) && !['btn-sm', 'btn-lg'].includes(className)) {
					toggleBtn.classList.remove(className);
				}
			});

			if (cls) {
				toggleBtn.classList.add(...cls.split(' '));
			}

			toggleBtn.textContent = text;
		};

		const defaultItem = dropdown.querySelector('[data-selected="true"]');

		if (defaultItem) {
			updateBtn(
				defaultItem.textContent.trim(),
				defaultItem.getAttribute('data-class')
			);
		}

		items.forEach((item) => {
			item.addEventListener('click', (e) => {
				e.preventDefault();
				items.forEach((entry) => entry.removeAttribute('data-selected'));
				item.setAttribute('data-selected', 'true');
				updateBtn(
					item.textContent.trim(),
					item.getAttribute('data-class')
				);
			});
		});
	});
}

function initTooltips() {
	if (!window.bootstrap) {
		return;
	}

	document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach((el) => {
		const tooltip = new bootstrap.Tooltip(el);

		el.addEventListener('click', () => {
			tooltip.hide();
			el.blur();
		});
	});
}

function initPopover() {
	if (!window.bootstrap) {
		return;
	}

	document.querySelectorAll('[data-bs-toggle="popover"]').forEach((el) => {
		new bootstrap.Popover(el);
	});
}

function initPasswordToggle() {
	document.addEventListener('click', (e) => {
		const btn = e.target.closest('.toggle-password');

		if (!btn) {
			return;
		}

		const input = btn.previousElementSibling;

		if (!input) {
			return;
		}

		const isPassword = input.type === 'password';
		input.type = isPassword ? 'text' : 'password';
		btn.classList.toggle('active', isPassword);
	});
}

function initSidebarPanel() {
	document.addEventListener('click', function (e) {
		const toggler = e.target.closest('.sidebar-panel-toggler');
		const closeBtn = e.target.closest('.sidebar-close');

		if (!toggler || closeBtn) {
			return;
		}

		if (toggler) {
			const panel = document.querySelector('.app-sidebar-panel');

			if (panel) {
				panel.classList.toggle('show');
			}
		}

		if (closeBtn) {
			document.querySelectorAll('.app-sidebar-panel').forEach((panel) => {
				panel.classList.remove('show');
			});
		}
	});
}

function initPriceSwitch() {
	const priceSwitch = document.querySelector('#priceSwitchCheck');

	if (!priceSwitch) {
		return;
	}

	priceSwitch.addEventListener('change', function () {
		const isYearly = this.checked;
		const monthlyPrices = document.querySelectorAll('.price-monthly');
		const yearlyPrices = document.querySelectorAll('.price-yearly');

		monthlyPrices.forEach((price) => price.classList.toggle('d-none', isYearly));
		yearlyPrices.forEach((price) => price.classList.toggle('d-none', !isYearly));
	});
}
