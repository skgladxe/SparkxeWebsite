      <div class="app-navbar-tabs" data-simplebar>
        <ul class="nav" id="appMenubarTabs" role="tablist" aria-orientation="vertical">
          <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Menu">
            <a class="menu-link active" href="#dashboardTab" role="tab" aria-controls="dashboardTab" aria-selected="true" data-bs-toggle="tab">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.5" d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z" stroke="var(--bs-heading-color)" stroke-width="2" />
                <path d="M12 15V18" stroke="var(--bs-heading-color)" stroke-width="2" stroke-linecap="round" />
              </svg>
            </a>
          </li>

          {{-- Unused template tab icons (commented out)
          <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Apps">...</li>
          <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Pages">...</li>
          <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Authentication">...</li>
          <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Components">...</li>
          <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Extended UI">...</li>
          <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Forms & Tables">...</li>
          <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Charts & Maps">...</li>
          --}}

          <li class="nav-item-hr"></li>
          <li class="nav-item mt-auto mb-3" data-bs-toggle="tooltip" data-bs-placement="right" data-bs-title="Logout">
            <a class="menu-link" href="{{ route('admin.logout.get') }}">
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path opacity="0.5" d="M9.00195 7C9.01406 4.82497 9.11051 3.64706 9.87889 2.87868C10.7576 2 12.1718 2 15.0002 2H16.0002C18.8286 2 20.2429 2 21.1215 2.87868C22.0002 3.75736 22.0002 5.17157 22.0002 8V16C22.0002 18.8284 22.0002 20.2426 21.1215 21.1213C20.2429 22 18.8286 22 16.0002 22H15.0002C12.1718 22 10.7576 22 9.87889 21.1213C9.11051 20.3529 9.01406 19.175 9.00195 17" stroke="var(--bs-heading-color)" stroke-width="2" stroke-linecap="round" />
                <path d="M15 12H2M2 12L5.5 9M2 12L5.5 15" stroke="var(--bs-heading-color)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </a>
          </li>
        </ul>
      </div>
