@props([
    'eyebrow' => null,
    'title',
    'highlight' => null,
    'description' => null,
    'breadcrumbs' => [],
    'headerImage' => null,
    'titleBelowHero' => false,
])

@php
	$headerImage = $headerImage ?? \App\Models\SiteSetting::defaultPageHeaderImageUrl();
@endphp

<section @class([
	'page-hero',
	'page-hero-has-image' => filled($headerImage),
	'page-hero-banner' => $titleBelowHero,
]) @if($headerImage) style="background-image: url('{{ $headerImage }}');" @endif>
	<div class="container">
		@if (count($breadcrumbs))
			<x-website::breadcrumb :items="$breadcrumbs" />
		@endIf
		@if (! $titleBelowHero)
			<div class="section-title">
				@if ($eyebrow)
					<h3 class="wow fadeInUp">{{ $eyebrow }}</h3>
				@endIf
				<h1 class="wow fadeInUp" data-wow-delay="0.1s">
					@if ($highlight)
						{!! str_replace($highlight, '<span>'.$highlight.'</span>', e($title)) !!}
					@else
						{{ $title }}
					@endIf
				</h1>
				@if ($description)
					<p class="page-hero-desc wow fadeInUp" data-wow-delay="0.2s">{{ $description }}</p>
				@endIf
			</div>
		@endIf
	</div>
</section>
