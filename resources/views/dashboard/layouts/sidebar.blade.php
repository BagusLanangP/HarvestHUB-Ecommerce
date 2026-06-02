<div class="sidebar border-0 col-md-3 col-lg-2 p-0 d-print-none">
  <div class="offcanvas-md offcanvas-end bg-body-tertiary w-100 h-100" tabindex="-1" id="sidebarMenu" aria-labelledby="sidebarMenuLabel">
    
    {{-- Offcanvas Mobile Header --}}
    <div class="offcanvas-header border-bottom px-4 py-3">
      <h5 class="offcanvas-title fw-bold text-success" id="sidebarMenuLabel">HarvestHUB</h5>
      <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#sidebarMenu" aria-label="Close"></button>
    </div>

    {{-- Offcanvas Body / Menu Items --}}
    <div class="offcanvas-body d-md-flex flex-column p-0 pt-lg-2 overflow-y-auto w-100 h-100 justify-content-between">
      
      <div class="w-100">
        <ul class="nav flex-column mb-3">
          @can('admin')
            {{-- MENU ADMINISTRATOR --}}
            <li class="nav-item">
              <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Request::is('dashboard/product*') ? 'active' : '' }}" href="/dashboard/product">
                <i class="bi bi-box-seam-fill"></i>
                Products
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Request::is('dashboard/user*') ? 'active' : '' }}" href="/dashboard/user">
                <i class="bi bi-people-fill"></i>
                Customers
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Request::is('dashboard/analytics*') ? 'active' : '' }}" href="{{ route('dashboard.analytics.index') }}">
                <i class="bi bi-bar-chart-line-fill"></i>
                Analytics
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Request::is('dashboard/role-requests*') ? 'active' : '' }}" href="{{ route('dashboard.role_requests.index') }}">
                <i class="bi bi-shield-lock-fill"></i>
                Role Requests
              </a>
            </li>
          @else
            {{-- MENU SHOP OWNER / PENJUAL --}}
            <li class="nav-item">
              <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="/dashboard">
                <i class="bi bi-grid-1x2-fill"></i>
                Dashboard
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ Request::is('dashboard/product*') ? 'active' : '' }}" href="/dashboard/product">
                <i class="bi bi-box-seam-fill"></i>
                Products
              </a>
            </li>
          @endcan
        </ul>
      </div>

      {{-- Menu Bawah - Keluar ke Toko Utama --}}
      <div class="w-100 mb-4">
        <div class="sidebar-divider"></div>
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link bg-light text-secondary rounded-3 py-2" href="/">
              <i class="bi bi-arrow-left-circle-fill text-success"></i>
              Keluar ke Toko
            </a>
          </li>
        </ul>
      </div>

    </div>
  </div>
</div>
