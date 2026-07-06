@include('webadmin.partials.sidebar.menu-group', ['label' => 'Main'])

<x-webadmin::sidebar.menu-item :href="route('admin.dashboard')" title="Dashboard" icon="fi fi-rr-house-blank" />
<x-webadmin::sidebar.menu-item :href="route('admin.seo.index')" title="SEO" icon="fi fi-rr-search-alt" />
<x-webadmin::sidebar.menu-item :href="route('admin.settings.edit')" title="Logo & Settings" icon="fi fi-rr-settings" />

@include('webadmin.partials.sidebar.menu-group', ['label' => 'Content', 'divider' => true])

<x-webadmin::sidebar.menu-item :href="route('admin.hero-slides.index')" title="Hero Slides" icon="fi fi-rr-picture" />
<x-webadmin::sidebar.menu-item :href="route('admin.products.index')" title="Our Products" icon="fi fi-rr-box" />
<x-webadmin::sidebar.menu-item :href="route('admin.services.index')" title="Our Services" icon="fi fi-rr-settings-sliders" />
<x-webadmin::sidebar.menu-item :href="route('admin.blog-categories.index')" title="Blog Categories" icon="fi fi-rr-tags" />
<x-webadmin::sidebar.menu-item :href="route('admin.blogs.index')" title="Blog Posts" icon="fi fi-rr-blog-text" />
<x-webadmin::sidebar.menu-item :href="route('admin.team.index')" title="Team" icon="fi fi-rr-users" />
<x-webadmin::sidebar.menu-item :href="route('admin.faqs.index')" title="FAQs" icon="fi fi-rr-interrogation" />

@include('webadmin.partials.sidebar.menu-group', ['label' => 'Leads', 'divider' => true])

<x-webadmin::sidebar.menu-item :href="route('admin.contacts.index')" title="Contact Submissions" icon="fi fi-rr-envelope" />
<x-webadmin::sidebar.menu-item :href="route('admin.newsletter-subscribers.index')" title="Newsletter Subscribers" icon="fi fi-rr-envelope-open" />

@include('webadmin.partials.sidebar.menu-group', ['label' => 'System', 'divider' => true])

<x-webadmin::sidebar.menu-item :href="route('admin.users.index')" title="Users" icon="fi fi-rr-user" />
<x-webadmin::sidebar.menu-item href="{{ route('admin.logout.get') }}" title="Logout" icon="fi fi-rr-sign-out-alt" />
