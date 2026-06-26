@include('webadmin.partials.sidebar.menu-group', ['label' => 'Extended UI'])

<x-webadmin::sidebar.menu-item href="extended-ui/avatar.html" title="Avatar" icon="fi fi-rr-circle-user" />
<x-webadmin::sidebar.menu-item href="extended-ui/card-action.html" title="Card action" icon="fi fi-rr-credit-card" />
<x-webadmin::sidebar.menu-item href="extended-ui/drag-and-drop.html" title="Drag & drop" icon="fi fi-rr-arrows" />
<x-webadmin::sidebar.menu-item href="extended-ui/simplebar.html" title="Simplebar" icon="fi fi-rr-star" />
<x-webadmin::sidebar.menu-item href="extended-ui/swiper.html" title="Swiper" icon="fi fi-rr-sliders-h-square" />

@include('webadmin.partials.sidebar.menu-group', ['label' => 'Icons', 'divider' => true])

<x-webadmin::sidebar.menu-item href="icons/flaticon.html" title="Flaticon" icon="fi fi-rr-star" />
<x-webadmin::sidebar.menu-item href="icons/lucide.html" title="Lucide" icon="fi fi-rr-star" />
<x-webadmin::sidebar.menu-item href="icons/fontawesome.html" title="Font Awesome" icon="fi fi-rr-star" />
