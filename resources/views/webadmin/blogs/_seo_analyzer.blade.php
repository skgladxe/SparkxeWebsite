@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
	const form = document.getElementById('blogForm');
	if (!form) return;

	const company = @json(config('website.name', 'Sparkxe Technologies'));
	const domain = @json(rtrim((string) config('website.domain', url('/')), '/'));
	const generateSchemaUrl = @json(isset($seoMeta) && $seoMeta?->id ? route('admin.seo.generate-schema', $seoMeta) : null);

	const fields = {
		title: document.getElementById('title'),
		slug: document.getElementById('slug'),
		excerpt: document.getElementById('excerpt'),
		focus: document.getElementById('focus_keyword'),
		metaTitle: document.getElementById('meta_title'),
		description: document.getElementById('meta_description'),
		h1: document.getElementById('h1_heading'),
		canonical: document.getElementById('canonical_url'),
		schemaJson: document.getElementById('schema_json'),
		schemaType: document.getElementById('schema_type'),
	};

	const scoreCircle = document.getElementById('seoScoreCircle');
	const scoreLabel = document.getElementById('seoScoreLabel');
	const previewTitle = document.getElementById('previewTitle');
	const previewUrl = document.getElementById('previewUrl');
	const previewDescription = document.getElementById('previewDescription');
	const generateSchemaBtn = document.getElementById('generateSchemaBtn');

	function getValue(el) { return el ? el.value.trim() : ''; }
	function containsKeyword(text, keyword) {
		return keyword && text && text.toLowerCase().includes(keyword.toLowerCase());
	}

	function postUrl() {
		const slug = getValue(fields.slug) || 'your-post';
		return domain + '/blog/' + slug.replace(/^\/+/, '');
	}

	function updateCharCounter(counter) {
		const field = document.getElementById(counter.dataset.target);
		if (!field) return;
		const length = field.value.length;
		const max = parseInt(counter.dataset.max, 10);
		counter.textContent = length + ' / ' + max;
	}

	function setBadge(el, status, good, bad) {
		el.textContent = status ? good : bad;
		el.className = 'badge ' + (status ? 'bg-success' : 'bg-danger');
	}

	function analyzeSeo() {
		let score = 0;
		const keyword = getValue(fields.focus);
		const title = getValue(fields.metaTitle) || getValue(fields.title);
		const description = getValue(fields.description) || getValue(fields.excerpt);
		const h1 = getValue(fields.h1) || getValue(fields.title);
		const schemaJson = getValue(fields.schemaJson);
		const titleOk = title.length >= 30 && title.length <= 60;
		const descOk = description.length >= 120 && description.length <= 160;
		const keywordOk = keyword && (containsKeyword(title, keyword) || containsKeyword(description, keyword) || containsKeyword(h1, keyword));
		let schemaOk = false;
		try { schemaOk = schemaJson.length > 0 && JSON.parse(schemaJson) !== null; } catch (e) { schemaOk = false; }

		if (titleOk) score += 25;
		if (descOk) score += 25;
		if (keywordOk) score += 25;
		if (schemaOk) score += 25;

		scoreCircle.textContent = score;
		scoreCircle.className = 'seo-score-circle ' + (score >= 75 ? 'score-good' : score >= 50 ? 'score-medium' : 'score-poor');
		scoreLabel.textContent = score >= 75 ? 'Good SEO' : score >= 50 ? 'Needs improvement' : 'Poor SEO';

		setBadge(document.getElementById('checkTitle'), titleOk, 'Good', 'Fix');
		setBadge(document.getElementById('checkDescription'), descOk, 'Good', 'Fix');
		setBadge(document.getElementById('checkKeyword'), keywordOk, 'Good', 'Missing');
		setBadge(document.getElementById('checkSchema'), schemaOk, 'Valid', 'Invalid');

		previewTitle.textContent = title || 'Post Title';
		previewUrl.textContent = getValue(fields.canonical) || postUrl();
		previewDescription.textContent = description || 'Meta description preview.';
	}

	function buildArticleSchema() {
		const title = getValue(fields.metaTitle) || getValue(fields.title) || 'Blog Post';
		const description = getValue(fields.description) || getValue(fields.excerpt) || '';
		const url = getValue(fields.canonical) || postUrl();
		const type = getValue(fields.schemaType) || 'Article';

		if (type === 'none') {
			return '';
		}

		const schema = {
			'@context': 'https://schema.org',
			'@type': type === 'WebPage' ? 'WebPage' : 'Article',
			headline: title,
			name: title,
			description: description,
			url: url,
			mainEntityOfPage: { '@type': 'WebPage', '@id': url },
			publisher: {
				'@type': 'Organization',
				name: company,
				url: domain,
			},
			isPartOf: {
				'@type': 'WebSite',
				name: company,
				url: domain,
			},
		};

		return JSON.stringify(schema, null, 2);
	}

	document.querySelectorAll('.char-counter').forEach(function (counter) {
		const field = document.getElementById(counter.dataset.target);
		if (field) {
			field.addEventListener('input', function () { updateCharCounter(counter); analyzeSeo(); });
			updateCharCounter(counter);
		}
	});

	form.querySelectorAll('.seo-field, #title, #slug, #excerpt, #schema_type, #canonical_url, #schema_json').forEach(function (el) {
		el.addEventListener('input', analyzeSeo);
		el.addEventListener('change', analyzeSeo);
	});

	if (generateSchemaBtn) {
		generateSchemaBtn.addEventListener('click', function () {
			if (generateSchemaUrl && getValue(fields.schemaType) !== 'Article') {
				generateSchemaBtn.disabled = true;
				fetch(generateSchemaUrl, {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
						'X-CSRF-TOKEN': @json(csrf_token()),
						'Accept': 'application/json',
					},
					body: JSON.stringify({
						schema_type: fields.schemaType.value,
						meta_title: fields.metaTitle.value || fields.title.value,
						meta_description: fields.description.value || fields.excerpt.value,
						canonical_url: fields.canonical.value || postUrl(),
						force: true,
					}),
				})
				.then(function (r) { return r.json(); })
				.then(function (data) {
					fields.schemaJson.value = data.schema_json || buildArticleSchema();
					analyzeSeo();
				})
				.catch(function () {
					fields.schemaJson.value = buildArticleSchema();
					analyzeSeo();
				})
				.finally(function () { generateSchemaBtn.disabled = false; });
				return;
			}

			fields.schemaJson.value = buildArticleSchema();
			analyzeSeo();
		});
	}

	analyzeSeo();
});
</script>
@endpush
