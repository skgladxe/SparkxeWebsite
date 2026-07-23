<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#5955D1">
<meta name="robots" content="noindex, nofollow">
<meta name="description" content="{{ config('webadmin.description') }}">

<link rel="icon" href="{{ $adminFaviconUrl ?? \App\Models\SiteSetting::adminFaviconUrl() }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ $adminFaviconUrl ?? \App\Models\SiteSetting::adminFaviconUrl() }}">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="{{ config('webadmin.cdn.google_fonts') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ config('webadmin.cdn.flaticon_uicons') }}">
<link rel="stylesheet" href="{{ config('webadmin.cdn.fontawesome') }}" crossorigin="anonymous" referrerpolicy="no-referrer">
<link rel="stylesheet" href="{{ config('webadmin.cdn.bootstrap_icons') }}">

@foreach (config('webadmin.styles.plugins') as $stylesheet)
<link rel="stylesheet" href="{{ \App\Support\WebadminAsset::style($stylesheet) }}">
@endforeach

@foreach (config('webadmin.styles.app') as $stylesheet)
<link rel="stylesheet" href="{{ \App\Support\WebadminAsset::style($stylesheet) }}">
@endforeach

@stack('styles')
