{{-- ProEditor global assets – include once in layout --}}
@once
    @push('styles')
        <link rel="stylesheet" href="{{ asset('rich-editor/style.css') }}">
    @endpush

    @push('scripts')
        @include('rich-editor.modals')
        <script src="{{ asset('rich-editor/script.js') }}"></script>
    @endpush
@endonce
