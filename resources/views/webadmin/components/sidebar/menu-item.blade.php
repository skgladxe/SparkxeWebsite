@props([
    'href' => null,
    'route' => null,
    'title',
    'icon' => null,
    'active' => false,
    'badge' => null,
    'role' => null,
])

@php
    $url = $route ?? $href ?? '#';
@endphp

<li class="menu-item">
  <a
    href="{{ $url }}"
    @class(['menu-link', 'active' => $active])
    @if($role) role="{{ $role }}" @endif
  >
    @if($icon)
      <i class="{{ $icon }}"></i>
    @endif
    @isset($iconMarkup)
      {{ $iconMarkup }}
    @endisset
    <span class="menu-label">{{ $title }}</span>
    @if($badge)
      <span class="badge badge-sm text-bg-success">{{ $badge }}</span>
    @endif
  </a>
  @isset($children)
    <ul class="menu-inner">
      {{ $children }}
    </ul>
  @endisset
</li>
