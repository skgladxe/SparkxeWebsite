@include('rich-editor.editor', [
    'selector' => $selector ?? '.rich-editor',
    'height' => $height ?? 400,
    'upload' => $upload ?? true,
])
