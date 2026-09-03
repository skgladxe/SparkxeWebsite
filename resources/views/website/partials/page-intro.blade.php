@props([
    'eyebrow' => null,
    'title',
    'highlight' => null,
    'description' => null,
    'centered' => true,
])

<section class="page-intro">
	<div class="container">
		<x-website::section-heading
			:eyebrow="$eyebrow ?? ''"
			:title="$title"
			:highlight="$highlight"
			:description="$description"
			:centered="$centered"
		/>
	</div>
</section>
