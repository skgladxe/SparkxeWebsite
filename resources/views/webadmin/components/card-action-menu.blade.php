{{--
  Reusable card/table action dropdown.
  UI: unchanged — supports default, light (on primary cards), and table variants.
--}}
@props([
    'items' => [
        ['label' => 'Edit', 'href' => 'javascript:void(0);'],
        ['label' => 'Delete', 'href' => 'javascript:void(0);'],
    ],
    'variant' => 'default',
    'wrapperClass' => '',
])

@php
    $buttonClass = match ($variant) {
        'light' => 'btn btn-sm btn-icon text-white waves-effect dropdown-toggle',
        'table' => 'btn btn-subtle-primary btn-sm btn-shadow btn-icon waves-effect dropdown-toggle',
        default => 'btn btn-action-primary btn-sm btn-icon waves-effect dropdown-toggle',
    };
    $iconClass = $variant === 'table' ? 'fi fi-rr-menu-dots' : 'fi fi-bs-menu-dots';
@endphp

<div class="btn-group {{ $wrapperClass }}">
	<button class="{{ $buttonClass }}" type="button" data-bs-toggle="dropdown" aria-expanded="false">
		<i class="{{ $iconClass }}"></i>
	</button>
	<ul class="dropdown-menu dropdown-menu-end">
		@foreach ($items as $item)
			<li>
				<a class="dropdown-item" href="{{ $item['href'] ?? 'javascript:void(0);' }}">{{ $item['label'] }}</a>
			</li>
		@endforeach
	</ul>
</div>
