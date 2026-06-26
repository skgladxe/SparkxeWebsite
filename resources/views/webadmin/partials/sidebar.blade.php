<!-- begin::Sparkxe Admin Sidebar (two-column: icon rail + menu panel) -->
<aside class="app-menubar-tabs" id="appMenubar">
  @include('webadmin.partials.sidebar.logo')
  @include('webadmin.partials.sidebar.tab-icons')
  <div class="app-tab-content">
    @include('webadmin.partials.sidebar.brand-text')
    <div class="app-content-inner">
      <div class="tab-content" id="appMenubarTabsContent">
        @include('webadmin.partials.sidebar.menu-section', [
          'id' => 'dashboardTab',
          'active' => true,
          'itemsView' => 'webadmin.partials.sidebar.menus.main',
        ])

        {{-- Unused template menu tabs (commented out)
        @include('webadmin.partials.sidebar.menu-section', ['id' => 'appsTab', 'itemsView' => 'webadmin.partials.sidebar.menus.apps'])
        @include('webadmin.partials.sidebar.menu-section', ['id' => 'pagesTab', 'itemsView' => 'webadmin.partials.sidebar.menus.pages'])
        @include('webadmin.partials.sidebar.menu-section', ['id' => 'authenticationTab', 'itemsView' => 'webadmin.partials.sidebar.menus.authentication'])
        @include('webadmin.partials.sidebar.menu-section', ['id' => 'componentsTab', 'itemsView' => 'webadmin.partials.sidebar.menus.components'])
        @include('webadmin.partials.sidebar.menu-section', ['id' => 'extendedTab', 'itemsView' => 'webadmin.partials.sidebar.menus.extended'])
        @include('webadmin.partials.sidebar.menu-section', ['id' => 'formElementsTab', 'itemsView' => 'webadmin.partials.sidebar.menus.forms'])
        @include('webadmin.partials.sidebar.menu-section', ['id' => 'chartsTab', 'itemsView' => 'webadmin.partials.sidebar.menus.charts'])
        --}}
      </div>
      @include('webadmin.partials.sidebar.footer')
    </div>
  </div>
</aside>
<!-- end::Sparkxe Admin Sidebar -->
