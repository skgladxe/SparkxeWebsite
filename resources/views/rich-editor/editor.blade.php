@props([
    'selector' => '.rich-editor',
    'height' => 400,
    'upload' => true,
])

@include('rich-editor.assets')

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof window.initEditor !== 'function') {
        console.error('ProEditor script not loaded.');
        return;
    }

    window.initEditor(@json($selector), {
        uploadUrl: @json($upload ? route('admin.editor.upload') : null),
        uploadToken: @json(csrf_token()),
        height: {{ (int) $height }},
    });
});
</script>
@endpush
