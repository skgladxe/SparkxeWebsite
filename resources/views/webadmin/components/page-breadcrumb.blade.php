{{--
  Page breadcrumb block used at top of admin content areas.
  UI: unchanged — same app-page-head / breadcrumb markup.
--}}
@props([
    'title',
    'homeLabel' => 'Home',
    'homeUrl' => '#',
])

<div class="app-page-head d-flex align-items-center justify-content-between">
	<nav aria-label="breadcrumb">
		<ol class="breadcrumb mb-0">
			<li class="breadcrumb-item">
				<a href="{{ $homeUrl }}">
					<i class="fi fi-rr-home"></i> {{ $homeLabel }}
				</a>
			</li>
			<li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
		</ol>
	</nav>
</div>
