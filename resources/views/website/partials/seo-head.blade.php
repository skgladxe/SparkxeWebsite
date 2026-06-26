@php
    $metaTitle = $seo->meta_title ?? config('website.title');
    $metaDescription = $seo->meta_description ?? config('website.description');
    $metaKeywords = $seo->meta_keywords ?? 'sparkxe, digital marketing, software';
    $canonicalUrl = $seo->canonical_url_resolved ?? $seo->canonical_url ?? url()->current();
    $ogTitle = $seo->og_title ?? $metaTitle;
    $ogDescription = $seo->og_description ?? $metaDescription;
    $ogImage = $seo->og_image_url ?? asset('website/assets/images/logo.svg');
@endphp

<title>{{ e($metaTitle) }}</title>
<meta name="description" content="{{ e($metaDescription) }}">
<meta name="keywords" content="{{ e($metaKeywords) }}">
<meta name="robots" content="{{ e($seo->robots_content) }}">
<link rel="canonical" href="{{ e($canonicalUrl) }}">

<meta property="og:type" content="website">
<meta property="og:title" content="{{ e($ogTitle) }}">
<meta property="og:description" content="{{ e($ogDescription) }}">
<meta property="og:url" content="{{ e($canonicalUrl) }}">
<meta property="og:image" content="{{ e($ogImage) }}">
<meta property="og:site_name" content="{{ e(config('website.name', 'Sparkxe')) }}">

<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ e($ogTitle) }}">
<meta name="twitter:description" content="{{ e($ogDescription) }}">
<meta name="twitter:image" content="{{ e($ogImage) }}">

@if (filled($seo->schema_json))
<script type="application/ld+json">{!! $seo->schema_json !!}</script>
@endif
