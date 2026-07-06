@props([
    'eyebrow' => null,
    'title',
    'highlight' => null,
    'description' => null,
    'breadcrumbs' => [],
    'headerImage' => null,
])

@php
	$headerImage = $headerImage ?? \App\Models\SiteSetting::defaultPageHeaderImageUrl();
@endphp

<section @class(['page-hero', 'page-hero-has-image' => filled($headerImage)]) @if($headerImage) style="background-image: url('{{ $headerImage }}');" @endif>
	<div class="container">
		@if (count($breadcrumbs))
			<x-website::breadcrumb :items="$breadcrumbs" />
		@endif
		<div class="section-title">
			@if ($eyebrow)
				<h3 class="wow fadeInUp">{{ $eyebrow }}</h3>
			@endif
			<h1 class="wow fadeInUp" data-wow-delay="0.1s">
				@if ($highlight)
					{!! str_replace($highlight, '<span>'.$highlight.'</span>', e($title)) !!}
				@else
					{{ $title }}
				@endif
			</h1>
			@if ($description)
				<p class="page-hero-desc wow fadeInUp" data-wow-delay="0.2s">{{ $description }}</p>
			@endif
		</div>
	</div>
</section>
