/**
 * Layout height CSS variables and Waves ripple effects.
 * UI impact: None | Functionality impact: None
 */

export function initScroll() {
	if (window.Waves) {
		Waves.init();
	}

	setElementHeight();
}

function setElementHeight() {
	const docEl = document.documentElement;
	const footer = document.querySelector('.footer-wrapper');
	const chatBox = document.querySelector('.chat-wrapper');

	if (footer) {
		docEl.style.setProperty(
			'--footer-height',
			`${footer.offsetHeight}px`
		);
	}

	if (chatBox) {
		docEl.style.setProperty(
			'--chat-height',
			`${chatBox.offsetHeight}px`
		);
	}
}
