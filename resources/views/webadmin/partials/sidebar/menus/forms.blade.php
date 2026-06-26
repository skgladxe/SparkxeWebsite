@include('webadmin.partials.sidebar.menu-group', ['label' => 'Forms'])

<x-webadmin::sidebar.menu-item href="forms/form-elements.html" title="Form Elements" icon="fi fi-rr-form" />
<x-webadmin::sidebar.menu-item href="forms/form-floating.html" title="Form Floating" icon="fi fi-rr-form" />
<x-webadmin::sidebar.menu-item href="forms/form-input-group.html" title="Form Input Group" icon="fi fi-rr-form" />
<x-webadmin::sidebar.menu-item href="forms/form-layout.html" title="Form Layout" icon="fi fi-rr-form" />
<x-webadmin::sidebar.menu-item href="forms/form-validation.html" title="Form Validation" icon="fi fi-rr-form" />

@include('webadmin.partials.sidebar.menu-group', ['label' => 'Forms Plugins'])

<x-webadmin::sidebar.menu-item href="forms/flatpickr.html" title="Flatpickr" icon="fi fi-rr-calendar-lines" />
<x-webadmin::sidebar.menu-item href="forms/tagify.html" title="Tagify" icon="fi fi-rr-tags" />

@include('webadmin.partials.sidebar.menu-group', ['label' => 'Table', 'divider' => true])

<x-webadmin::sidebar.menu-item href="table/tables-basic.html" title="Table" icon="fi fi-rr-table-list" />
<x-webadmin::sidebar.menu-item href="table/tables-datatable.html" title="Datatable" icon="fi fi-rr-table" />
