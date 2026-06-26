@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('seoForm');
    if (!form) return;

    const fields = {
        focus: document.getElementById('focus_keyword'),
        title: document.getElementById('meta_title'),
        description: document.getElementById('meta_description'),
        h1: document.getElementById('h1_heading'),
        urlSlug: document.getElementById('url_slug'),
        canonical: document.getElementById('canonical_url'),
        schemaJson: document.getElementById('schema_json'),
        schemaType: document.getElementById('schema_type'),
        ogImage: document.getElementById('og_image'),
        robotsIndex: document.getElementById('robots_index'),
    };

    const scoreCircle = document.getElementById('seoScoreCircle');
    const scoreLabel = document.getElementById('seoScoreLabel');
    const previewTitle = document.getElementById('previewTitle');
    const previewUrl = document.getElementById('previewUrl');
    const previewDescription = document.getElementById('previewDescription');
    const generateSchemaBtn = document.getElementById('generateSchemaBtn');
    const hasExistingOgImage = @json(filled($seoMeta->og_image));

    function getValue(el) { return el ? el.value.trim() : ''; }
    function containsKeyword(text, keyword) {
        return keyword && text && text.toLowerCase().includes(keyword.toLowerCase());
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
        const title = getValue(fields.title);
        const description = getValue(fields.description);
        const h1 = getValue(fields.h1);
        const canonical = getValue(fields.canonical);
        const urlSlug = getValue(fields.urlSlug);
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

        previewTitle.textContent = title || 'Page Title';
        previewUrl.textContent = canonical || urlSlug || @json(url('/'));
        previewDescription.textContent = description || 'Meta description preview.';
    }

    document.querySelectorAll('.char-counter').forEach(function (counter) {
        const field = document.getElementById(counter.dataset.target);
        if (field) {
            field.addEventListener('input', function () { updateCharCounter(counter); analyzeSeo(); });
            updateCharCounter(counter);
        }
    });

    form.querySelectorAll('.seo-field, #og_image, #schema_type, #robots_index').forEach(function (el) {
        el.addEventListener('input', analyzeSeo);
        el.addEventListener('change', analyzeSeo);
    });

    if (generateSchemaBtn) {
        generateSchemaBtn.addEventListener('click', function () {
            generateSchemaBtn.disabled = true;
            fetch(@json(route('admin.seo.generate-schema', $seoMeta)), {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': @json(csrf_token()),
                    'Accept': 'application/json',
                },
                body: JSON.stringify({
                    schema_type: fields.schemaType.value,
                    meta_title: fields.title.value,
                    meta_description: fields.description.value,
                    canonical_url: fields.canonical.value,
                }),
            })
            .then(r => r.json())
            .then(data => { fields.schemaJson.value = data.schema_json || ''; analyzeSeo(); })
            .finally(() => { generateSchemaBtn.disabled = false; });
        });
    }

    analyzeSeo();
});
</script>
@endpush
