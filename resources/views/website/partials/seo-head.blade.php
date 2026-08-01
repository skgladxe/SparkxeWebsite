@php
    $company = config('website.name', 'Sparkxe Technologies');
    $shortName = config('website.short_name', 'Sparkxe');
    $domain = rtrim((string) config('website.domain', 'https://sparkxe.com'), '/');

    $metaTitle = $seo->meta_title ?? config('website.title');
    $metaDescription = $seo->meta_description ?? config('website.description');
    $metaKeywords = $seo->meta_keywords ?? config('website.seo.default_keywords');
    $focusKeyword = $seo->focus_keyword ?? 'sparkxe technologies';
    $canonicalUrl = $seo->canonical_url_resolved ?? $seo->canonical_url ?? $domain;
    $ogTitle = $seo->og_title ?? $metaTitle;
    $ogDescription = $seo->og_description ?? $metaDescription;
    $ogImage = $seo->og_image_resolved ?? config('website.seo.og_image', $domain.'/images/og-image.jpg');
    $ogUrl = $seo->og_url_resolved ?? $canonicalUrl;
    $ogType = $seo->og_type ?? config('website.seo.og_type', 'website');
    $ogSiteName = $seo->og_site_name ?? $company;
    $twitterCard = $seo->twitter_card ?? config('website.seo.twitter_card', 'summary_large_image');
    $twitterTitle = $seo->twitter_title ?? $ogTitle;
    $twitterDescription = $seo->twitter_description ?? $ogDescription;
    $twitterImage = $ogImage;
@endphp

<title>{{ e($metaTitle) }}</title>
<meta name="description" content="{{ e($metaDescription) }}">
<meta name="keywords" content="{{ e($metaKeywords) }}">
<meta name="author" content="{{ e($company) }}">
<meta name="application-name" content="{{ e($shortName) }}">
<meta name="robots" content="{{ e($seo->robots_content ?? 'index,follow') }}">
<meta name="googlebot" content="{{ e($seo->robots_content ?? 'index,follow') }}">
<link rel="canonical" href="{{ e($canonicalUrl) }}">

<meta name="geo.region" content="IN-TN">
<meta name="geo.placename" content="Udumalpet, Tiruppur, Tamil Nadu">
<meta name="language" content="English">
@if (filled($focusKeyword))
<meta name="news_keywords" content="{{ e($focusKeyword) }}">
@endif

<meta property="og:type" content="{{ e($ogType) }}">
<meta property="og:site_name" content="{{ e($ogSiteName) }}">
<meta property="og:title" content="{{ e($ogTitle) }}">
<meta property="og:description" content="{{ e($ogDescription) }}">
<meta property="og:url" content="{{ e($ogUrl) }}">
<meta property="og:image" content="{{ e($ogImage) }}">
<meta property="og:image:alt" content="{{ e($ogTitle) }}">
<meta property="og:locale" content="en_IN">

<meta name="twitter:card" content="{{ e($twitterCard) }}">
<meta name="twitter:title" content="{{ e($twitterTitle) }}">
<meta name="twitter:description" content="{{ e($twitterDescription) }}">
<meta name="twitter:image" content="{{ e($twitterImage) }}">
<meta name="twitter:image:alt" content="{{ e($twitterTitle) }}">

<meta name="theme-color" content="#0b1220">
<link rel="alternate" hreflang="en" href="{{ e($canonicalUrl) }}">
<link rel="alternate" hreflang="x-default" href="{{ e($canonicalUrl) }}">

@if (filled($seo->schema_json))
<script type="application/ld+json">{!! $seo->schema_json !!}</script>
@endif
