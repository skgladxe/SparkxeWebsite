      <div class="app-navbar-brand">
        <a class="navbar-brand-logo" href="{{ route('admin.dashboard') }}">
          <img style="width: 100%;" src="{{ $adminLogoUrl ?? \App\Models\SiteSetting::adminLogoUrl() }}" alt="{{ $adminLogoText ?? \App\Models\SiteSetting::adminLogoText() }}">
        </a>
      </div>
