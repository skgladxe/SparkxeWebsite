# ProEditor (Rich Text Editor)

Framework-agnostic rich text editor. Copy this folder to any project.

## Files

- `style.css` – editor styles and modals
- `script.js` – `ProEditor` class and `initEditor()` helper
- `content.css` – frontend display styles for saved HTML (wrap output in `.rich-content`)

## Laravel usage

```blade
<textarea class="rich-editor" id="content" name="content">{{ old('content') }}</textarea>

@include('rich-editor.editor', [
    'selector' => '#content',
    'height' => 400,
    'upload' => true,
])
```

Blade partials live in `resources/views/rich-editor/`:

- `assets.blade.php` – loads CSS, JS, and modals once
- `modals.blade.php` – shared modal markup
- `editor.blade.php` – initializes editor on a textarea selector

## Frontend display

Saved HTML uses editor classes like `pe-img-left`, `pe-img-wrap`, and standard tables. On the website, wrap content and load `content.css`:

```html
<link rel="stylesheet" href="/rich-editor/content.css">
<div class="rich-content">
  <!-- editor HTML here -->
</div>
```

## Plain HTML / JS

```html
<link rel="stylesheet" href="/rich-editor/style.css">
<!-- include modal markup from modals.blade.php or index.html -->
<script src="/rich-editor/script.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    initEditor('#my-textarea', {
      height: 400,
      uploadUrl: '/api/upload',
      uploadToken: 'csrf-token-here',
    });
  });
</script>
```

## Image upload API

POST multipart `file` field. Response JSON:

```json
{ "location": "https://example.com/storage/image.jpg" }
```

Without `uploadUrl`, images are embedded as base64 data URLs.
