/**
 * Mail bookmark toggles and dynamic copyright year.
 * UI impact: None | Functionality impact: None
 */

export function initNotifications() {
	initBookmarks();
	updateCurrentYear();
}

function initBookmarks() {
	document.addEventListener('click', (e) => {
		const bookmark = e.target.closest('.mail-item-bookmark');

		if (bookmark) {
			bookmark.classList.toggle('active');
		}
	});
}

function updateCurrentYear() {
	document.querySelectorAll('.currentYear').forEach((el) => {
		el.textContent = new Date().getFullYear();
	});
}
