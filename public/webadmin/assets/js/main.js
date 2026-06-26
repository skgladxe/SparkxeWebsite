/**
 * WebAdmin bootstrap — loads feature modules on DOMContentLoaded.
 * UI impact: None | Functionality impact: None
 */

import { initSidebar } from './modules/app-sidebar.js';
import { initSearch } from './modules/app-search.js';
import { initTheme } from './modules/app-theme.js';
import { initDropdown } from './modules/app-dropdown.js';
import { initDatatable } from './modules/app-datatable.js';
import { initScroll } from './modules/app-scroll.js';
import { initNotifications } from './modules/app-notifications.js';

document.addEventListener('DOMContentLoaded', () => {
	try {
		initScroll();
		initSidebar();
		initSearch();
		initTheme();
		initDropdown();
		initDatatable();
		initNotifications();
	} catch (error) {
		console.error('Init Error:', error);
	}
});
