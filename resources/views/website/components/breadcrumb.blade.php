@props([
    'items' => [],
])

<nav class="breadcrumb-nav wow fadeInUp" data-wow-delay="0.15s" aria-label="Breadcrumb">
	<ol class="breadcrumb-list">
		@foreach ($items as $index => $item)
			<li class="breadcrumb-item{{ $loop->last ? ' active' : '' }}">
				@if (! $loop->last && isset($item['url']))
					<a href="{{ $item['url'] }}">{{ $item['label'] }}</a>
				@else
					<span>{{ $item['label'] }}</span>
				@endif
			</li>
		@endforeach
	</ol>
</nav>
