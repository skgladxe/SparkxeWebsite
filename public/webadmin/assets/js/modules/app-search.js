/**
 * Header search modal typeahead.
 * UI impact: None | Functionality impact: None
 */

export function initSearch() {
	if (typeof jQuery === 'undefined') {
		return;
	}

	const $ = jQuery;
	const $searchInput = $('#searchInput');

	if (!$searchInput.length) {
		return;
	}

	let listItems = [];

	$.getJSON('assets/ajax/search.json', function (data) {
		listItems = data.listItems;
	});

	$searchInput.on('keyup', function () {
		const query = $(this).val().toLowerCase();
		const $searchContainer = $('#searchContainer');

		$searchContainer.empty();
		$searchContainer.hide();
		$('#recentlyResults').hide();

		if (query.length === 0) {
			$searchContainer.hide();
			$('#recentlyResults').show();
			return;
		}

		const matched = listItems.filter((item) =>
			item.name.toLowerCase().includes(query) ||
			item.url.toLowerCase().includes(query)
		);

		if (matched.length > 0) {
			const grouped = {};

			matched.forEach((item) => {
				if (!grouped[item.category]) {
					grouped[item.category] = [];
				}
				grouped[item.category].push(item);
			});

			for (const cat in grouped) {
				$searchContainer.append(
					`<span class="text-uppercase text-2xs fw-semibold text-muted d-block mb-2">${cat}</span>`
				);

				const $ul = $('<ul class=\'list-inline search-list\'></ul>');

				grouped[cat].forEach((item) => {
					$ul.append(
						`<li>
							<a class="search-item" href="${item.url}">
								<i class="${item.icon}"></i> <span>${item.name}</span>
							</a>
						</li>`
					);
				});

				$searchContainer.append($ul);
			}

			$searchContainer.show();
		} else {
			$searchContainer.append(`
				<div class="text-center pb-5 pt-4">
					<div class="avatar avatar-lg bg-danger-subtle shadow-secondary rounded-circle text-danger mb-3 m-auto">
						<i class="fi fi-rr-assessment"></i>
					</div>
					<h5 class="mb-1">No result found</h5>
					<div class="text-muted">Please try again with a different query</div>
				</div>
			`);
			$searchContainer.show();
		}
	});
}
