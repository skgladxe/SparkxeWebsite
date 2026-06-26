<x-webadmin::sidebar.menu-item
  :href="$href ?? null"
  :route="$route ?? null"
  :title="$title ?? $label"
  :icon="$icon ?? null"
  :active="$active ?? false"
  :badge="$badge ?? null"
  :role="$role ?? null"
>
  @if(!empty($iconHtml))
    <x-slot:iconMarkup>{!! $iconHtml !!}</x-slot:iconMarkup>
  @endif
  @if(!empty($children))
    <x-slot:children>{!! $children !!}</x-slot:children>
  @endif
</x-webadmin::sidebar.menu-item>
