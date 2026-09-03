@if ($paginator->hasPages())
	<nav class="site-pagination" aria-label="Page navigation">
		<ul class="site-pagination-list">
			@if ($paginator->onFirstPage())
				<li class="site-pagination-item disabled" aria-disabled="true">
					<span class="site-pagination-link" aria-hidden="true"><i class="fa-solid fa-chevron-left"></i></span>
				</li>
			@else
				<li class="site-pagination-item">
					<a class="site-pagination-link" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page">
						<i class="fa-solid fa-chevron-left"></i>
					</a>
				</li>
			@endIf

			@foreach ($elements as $element)
				@if (is_string($element))
					<li class="site-pagination-item disabled" aria-disabled="true">
						<span class="site-pagination-link">{{ $element }}</span>
					</li>
				@endIf

				@if (is_array($element))
					@foreach ($element as $page => $url)
						@if ($page == $paginator->currentPage())
							<li class="site-pagination-item active" aria-current="page">
								<span class="site-pagination-link">{{ $page }}</span>
							</li>
						@else
							<li class="site-pagination-item">
								<a class="site-pagination-link" href="{{ $url }}">{{ $page }}</a>
							</li>
						@endIf
					@endforeach
				@endIf
			@endforeach

			@if ($paginator->hasMorePages())
				<li class="site-pagination-item">
					<a class="site-pagination-link" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page">
						<i class="fa-solid fa-chevron-right"></i>
					</a>
				</li>
			@else
				<li class="site-pagination-item disabled" aria-disabled="true">
					<span class="site-pagination-link" aria-hidden="true"><i class="fa-solid fa-chevron-right"></i></span>
				</li>
			@endIf
		</ul>
	</nav>
@endIf
