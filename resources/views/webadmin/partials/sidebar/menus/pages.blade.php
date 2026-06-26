@include('webadmin.partials.sidebar.menu-group', ['label' => 'Website'])

<x-webadmin::sidebar.menu-item :href="route('admin.seo.index')" title="SEO Management" icon="fi fi-rr-search-alt" />
<x-webadmin::sidebar.menu-item :href="route('admin.dashboard')" title="Dashboard" icon="fi fi-rr-house-blank" />

@include('webadmin.partials.sidebar.menu-group', ['label' => 'Account', 'divider' => true])

<x-webadmin::sidebar.menu-item href="{{ route('admin.logout.get') }}" title="Logout" icon="fi fi-rr-sign-out-alt" />
