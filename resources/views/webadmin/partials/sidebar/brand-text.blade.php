        <div class="app-side-brands">
          <a class="navbar-brand-text" href="{{ route('admin.dashboard') }}">
            @if($adminLogoTextImageUrl ?? \App\Models\SiteSetting::adminLogoTextImageUrl())
              <img src="{{ $adminLogoTextImageUrl ?? \App\Models\SiteSetting::adminLogoTextImageUrl() }}" alt="{{ $adminLogoText ?? \App\Models\SiteSetting::adminLogoText() }}" class="admin-logo-text-img">
            @else
              {{ $adminLogoText ?? \App\Models\SiteSetting::adminLogoText() }}
            @endif
          </a>
        </div>
