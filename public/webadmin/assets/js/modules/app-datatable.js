/**
 * DataTables, flatpickr, and table checkbox sync.
 * UI impact: None | Functionality impact: None
 */

import { initSelectPicker } from './app-dropdown.js';

export function initDatatable() {
	initSectionCheckboxSync();
	initCheckable();
	initPluginsDataTable();
	initFlatpickrDate();
}

export function initSectionCheckboxSync() {
	document.querySelectorAll('.data-row-checkbox').forEach((section) => {
		const master = section.querySelector('[data-row-checkbox]');
		const boxes = section.querySelectorAll('[data-checkbox]');

		if (!master || !boxes.length) {
			return;
		}

		master.addEventListener('change', () => {
			boxes.forEach((cb) => {
				cb.checked = master.checked;
			});
		});

		boxes.forEach((cb) => {
			cb.addEventListener('change', () => {
				master.checked = [...boxes].every((entry) => entry.checked);
			});
		});
	});
}

function initCheckable() {
	document.querySelectorAll('.checkable-wrapper').forEach((wrapper) => {
		const all = wrapper.querySelector('.checkable-check-all');
		const boxes = wrapper.querySelectorAll('.checkable-check-input');

		if (all) {
			all.addEventListener('change', () => {
				boxes.forEach((box) => {
					box.checked = all.checked;
					box.closest('.checkable-item')?.classList.toggle('is-checked', all.checked);
				});
			});
		}

		wrapper.addEventListener('change', (e) => {
			if (!e.target.classList.contains('checkable-check-input')) {
				return;
			}

			e.target.closest('.checkable-item')?.classList.toggle('is-checked', e.target.checked);

			if (all) {
				all.checked = !wrapper.querySelector('.checkable-check-input:not(:checked)');
			}
		});
	});
}

function initPluginsDataTable() {
	if (typeof jQuery === 'undefined' || !$('.dataTable').length) {
		return;
	}

	$('.dataTable').each(function () {
		const dtInstance = $(this).DataTable();

		dtInstance.on('draw.dt', function () {
			initSelectPicker();
			initSectionCheckboxSync();
		});
	});
}

function initFlatpickrDate() {
	if (typeof jQuery === 'undefined' || !$('.flatpickr-date').length) {
		return;
	}

	$('.flatpickr-date').flatpickr({
		enableTime: false,
		dateFormat: 'Y-m-d H:i',
	});
}
