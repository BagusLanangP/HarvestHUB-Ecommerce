<header class="navbar sticky-top flex-md-nowrap p-0 py-2 d-print-none">
    {{-- Branding Logo --}}
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-4 fs-5 text-dark d-flex align-items-center gap-2" href="/">
        <span class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 28px; height: 28px; font-size: 0.95rem;">H</span>
        <span>Harvest<span class="text-success">HUB</span></span>
    </a>
  
    {{-- Mobile Toggles --}}
    <ul class="navbar-nav flex-row d-md-none me-3">
        <li class="nav-item text-nowrap">
            <button class="btn btn-link text-success p-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="bi bi-list fs-3"></i>
            </button>
        </li>
    </ul>
  
    {{-- Global Search Bar --}}
    <div class="w-100 px-3 d-none d-md-block">
        <div class="input-group input-group-sm rounded-pill overflow-hidden border border-0" style="max-width: 320px;">
            <span class="input-group-text bg-light border-0 ps-3 text-secondary"><i class="bi bi-search"></i></span>
            <input class="form-control bg-light border-0 py-2" type="text" placeholder="Cari data..." aria-label="Search">
        </div>
    </div>

    {{-- Profil Avatar & Menu Dropdown di Kanan --}}
    <div class="dropdown me-4 d-none d-md-block">
        <button class="btn btn-link text-decoration-none dropdown-toggle d-flex align-items-center gap-2 text-dark border-0 p-0 shadow-none" type="button" id="dropdownUserMenu" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="rounded-circle bg-success text-white fw-bold d-flex align-items-center justify-content-center shadow-sm" style="width: 36px; height: 36px; font-size: 0.95rem;">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="text-start">
                <div class="fw-bold small text-dark" style="font-size: 0.82rem; line-height: 1.2;">{{ auth()->user()->name }}</div>
                <small class="text-secondary" style="font-size: 0.72rem;">{{ auth()->user()->role_id == 1 ? 'Administrator' : 'Shop Owner' }}</small>
            </div>
        </button>
        <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2" aria-labelledby="dropdownUserMenu">
            <li><a class="dropdown-item d-flex align-items-center gap-2" href="/"><i class="bi bi-house-door text-secondary"></i> Beranda Utama</a></li>
            @if(auth()->user()->role_id == 5)
            <li><a class="dropdown-item d-flex align-items-center gap-2" href="/Toko"><i class="bi bi-shop text-secondary"></i> Profil Toko</a></li>
            @endif
            <li><hr class="dropdown-divider"></li>
            <li>
                <form action="/logout" method="post" class="m-0">
                    @csrf
                    <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                </form>
            </li>
        </ul>
    </div>
</header>