@foreach (config('webadmin.scripts.core') as $script)
@if ($script === config('webadmin.scripts.module'))
<script type="module" src="{{ \App\Support\WebadminAsset::script($script) }}"></script>
@else
<script src="{{ \App\Support\WebadminAsset::script($script) }}"></script>
@endif
@endforeach

@stack('scripts')
