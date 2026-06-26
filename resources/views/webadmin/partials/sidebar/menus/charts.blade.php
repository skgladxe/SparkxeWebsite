@include('webadmin.partials.sidebar.menu-group', ['label' => 'Charts'])

<x-webadmin::sidebar.menu-item href="chart/apexchart.html" title="Apex Chart" icon="fi fi-br-chart-histogram" />
<x-webadmin::sidebar.menu-item href="chart/chartjs.html" title="Chart JS" icon="fi fi-rr-chart-pie-alt" />

@include('webadmin.partials.sidebar.menu-group', ['label' => 'Maps', 'divider' => true])

<x-webadmin::sidebar.menu-item href="maps/jsvectormap.html" title="JS Vector Map" icon="fi fi-rr-marker" />
<x-webadmin::sidebar.menu-item href="maps/leaflet.html" title="Leaflet" icon="fi fi-rr-map-marker" />
