<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HarvestHub | @yield('tittle')</title>
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    {{-- Swipper --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/3.5.0/remixicon.css" crossorigin="">

    <!--=============== SWIPER CSS ===============-->
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">

    {{-- Bootstrap Icon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://unpkg.com/feather-icons"></script>

    {{-- Trix editor --}}
    <link rel="stylesheet" type="text/css" href="/css/trix.css">
    <script type="text/javascript" src="/js/trix.js"></script>

    @livewireStyles
    <script>
      (function() {
        const theme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-bs-theme', theme);
        if (theme === 'dark') {
          document.documentElement.classList.add('dark-mode');
        }
      })();
    </script>
    <style>
      /* Smooth transition */
      body {
        transition: background-color 0.3s ease, color 0.3s ease;
      }
      
      /* Dark mode styles & overrides */
      html[data-bs-theme="dark"], .dark-mode {
        --firstColorWhite: hsl(210, 15%, 15%);
        --SecColorGrey: hsl(210, 15%, 10%);
        --ForthColorBlack: hsl(210, 15%, 95%);
        --FiveColorSecGreen: hsl(147, 20%, 18%);
        --SevenColorGreyOld: hsl(210, 10%, 70%);
        
        --bs-body-bg: #121212;
        --bs-body-color: #f5f5f5;
      }
      
      .dark-mode body {
        background-color: #121212 !important;
        color: #f5f5f5 !important;
      }
      .dark-mode .navbar {
        background-color: #1e1e1e !important;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08) !important;
      }
      .dark-mode .navbar-brand, .dark-mode .nav-link {
        color: #f5f5f5 !important;
      }
      .dark-mode .nav-link.active {
        color: #198754 !important;
      }
      .dark-mode .card-product, .dark-mode .card {
        background-color: #1e1e1e !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
      }
      .dark-mode .card-product a, .dark-mode .card a {
        color: #f5f5f5 !important;
      }
      .dark-mode .card-title, .dark-mode .card-text, .dark-mode h1, .dark-mode h2, .dark-mode h3, .dark-mode h4, .dark-mode h5, .dark-mode h6 {
        color: #f5f5f5 !important;
      }
      .dark-mode .text-dark {
        color: #f5f5f5 !important;
      }
      .dark-mode .text-muted, .dark-mode .text-secondary {
        color: #b0b0b0 !important;
      }
      .dark-mode .bg-white {
        background-color: #1e1e1e !important;
      }
      .dark-mode hr {
        color: rgba(255, 255, 255, 0.15) !important;
        background-color: rgba(255, 255, 255, 0.15) !important;
      }
      .dark-mode .search-form {
        background-color: #1e1e1e !important;
      }
      .dark-mode .search-form input {
        background-color: #2b2b2b !important;
        color: #fff !important;
      }
      .dark-mode .divider-vertical {
        background-color: rgba(255, 255, 255, 0.15) !important;
      }
      .dark-mode .dropdown-menu {
        background-color: #1e1e1e !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
      }
      .dark-mode .dropdown-item {
        color: #e0e0e0 !important;
      }
      .dark-mode .dropdown-item:hover {
        background-color: #2a2a2a !important;
        color: #fff !important;
      }
      .dark-mode .btn-close {
        filter: invert(1) grayscale(1) brightness(2);
      }
      .dark-mode .modal-content {
        background-color: #1e1e1e !important;
        color: #f5f5f5 !important;
      }
      .dark-mode .modal-header, .dark-mode .modal-footer {
        border-color: rgba(255, 255, 255, 0.08) !important;
      }
      
      /* Dark mode switch hover micro-animation */
      #dark-mode-toggle {
        transition: transform 0.3s ease;
      }
      #dark-mode-toggle:hover {
        transform: rotate(15deg) scale(1.1);
      }
      #theme-icon {
        transition: color 0.3s ease;
      }
      
      /* Mobile responsiveness overrides */
      @media (max-width: 991px) {
        .navbar-nav {
          padding: 1rem 0;
          text-align: center;
        }
        .navbar-nav .nav-item {
          margin-right: 0 !important;
          margin-bottom: 0.5rem;
        }
      }
      @media (max-width: 768px) {
        :root {
          --paddingContentRL: 1rem !important;
          --paddingContentRL2: 1rem !important;
          --paddingContentTB: 2.5rem !important;
          --paddingInElemenMini: 1.5rem !important;
        }
        .header .search-form {
          width: calc(100vw - 2rem) !important;
        }
        .navbar {
          padding-left: 10px !important;
          padding-right: 10px !important;
        }
        .divider-vertical {
          margin: auto 8px !important;
        }
        .search {
          margin-right: 10px !important;
        }
      }

      /* Custom Pagination Styles */
      .pagination {
        margin-bottom: 0;
        gap: 5px;
      }
      .pagination .page-link {
        color: #198754 !important;
        border-color: rgba(25, 135, 84, 0.15) !important;
        background-color: #ffffff !important;
        border-radius: 8px !important;
        font-weight: 600;
        padding: 8px 16px;
        transition: all 0.2s ease-in-out;
        box-shadow: none !important;
      }
      .pagination .page-link:hover {
        color: #ffffff !important;
        background-color: #157347 !important;
        border-color: #157347 !important;
      }
      .pagination .page-item.active .page-link {
        background-color: #198754 !important;
        border-color: #198754 !important;
        color: #ffffff !important;
      }
      .pagination .page-item.disabled .page-link {
        background-color: #f8f9fa !important;
        border-color: rgba(0, 0, 0, 0.05) !important;
        color: #6c757d !important;
        opacity: 0.6;
      }
      .dark-mode .pagination .page-link {
        background-color: #1e1e1e !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
        color: #e0e0e0 !important;
      }
      .dark-mode .pagination .page-link:hover {
        background-color: #157347 !important;
        color: #ffffff !important;
      }
      .dark-mode .pagination .page-item.active .page-link {
        background-color: #198754 !important;
        border-color: #198754 !important;
      }
      .dark-mode .pagination .page-item.disabled .page-link {
        background-color: #121212 !important;
        border-color: rgba(255, 255, 255, 0.05) !important;
        color: #777777 !important;
      }
    </style>
  </head>
  <body>

  <header class="header">
    <nav class="navbar navbar-expand-lg bg-body shadow-sm">
      <div class="container-fluid">
      ` <img src="{{ asset('img/Logo-harvesthub.png') }}" class="logo me-2" alt="">
        <a class="navbar-brand" href="/">HarvestHUB</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
          <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
            <li class="nav-item me-5">
              <a class="nav-link {{ Request::is('/') ? 'active' : '' }}" aria-current="page" href="/">Home</a>
            </li>
            <li class="nav-item me-5">
              <a class="nav-link" href="/#kategori">Categori</a>
            </li>
            <li class="nav-item me-5">
              <a class="nav-link {{ Request::is('cari') ? 'active' : '' }}" href="/cari">Product</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Service
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="/Tenagakerja/view">Tenaga Kerja</a></li>
                <li><a class="dropdown-item" href="/Ahlipakar/view">Ahli Pakar</a></li>
              </ul>
            </li>
          </ul>
          
          <div class="d-flex align-items-center justify-content-center justify-content-lg-end mt-3 mt-lg-0">
            <ul class="navbar-nav flex-row align-items-center justify-content-center gap-3">
              
              <li class="nav-item dropdown me-3 d-flex align-items-center">
                <a class="nav-link dropdown-toggle d-flex align-items-center gap-1 text-success fw-semibold" href="#" id="locationDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="font-size: 1rem;">
                  <i class="bi bi-geo-alt-fill text-success" style="font-size: 20px;"></i>
                  <span id="nav-location-text">{{ session('selected_location', 'Pilih Lokasi') }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end shadow border-0 p-3 rounded-4 mt-2" aria-labelledby="locationDropdown" style="width: 280px; z-index: 1050;">
                  <h6 class="fw-bold text-dark mb-2" style="font-size: 0.88rem;">Pilih Wilayah Operasional</h6>
                  <div class="input-group input-group-sm mb-3">
                    <span class="input-group-text bg-light border-0"><i class="bi bi-search" style="font-size: 0.8rem;"></i></span>
                    <input type="text" id="navbar-location-search" class="form-control bg-light border-0" placeholder="Cari kota/kabupaten..." style="font-size: 0.8rem;">
                  </div>
                  <div id="navbar-location-list" style="max-height: 180px; overflow-y: auto;">
                    {{-- Will be populated dynamically via JS --}}
                  </div>
                  <div class="border-top pt-2 mt-2 text-center">
                    <a href="#" class="text-decoration-none text-danger small fw-semibold" id="reset-location-btn" style="font-size: 0.75rem;">Hapus Filter Lokasi</a>
                  </div>
                </div>
              </li>

              <li class="nav-item search me-2">
                <i class="bi bi-search nav-link nav-item" style="font-size: 30px; cursor: pointer;" id="search-btn"></i>
              </li>
              @auth
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bi bi-person" style="font-size: 30px;"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="/wishlist"><i class="bi bi-heart"></i>Wishlist</a></li>
                  <li><a class="dropdown-item" href="/cart"><i class="bi bi-cart"></i>Keranjang</a></li>
                  <li><a class="dropdown-item" href="/transaksi"><i class="bi bi-bag"></i>Transaksi</a></li>
                  <li><a class="dropdown-item" href="/chat"><i class="bi bi-chat-left-text"></i>Chat</a></li>
                  @can('tenagaKerja0')
                    <li><a class="dropdown-item" href="/TenagaKerja/create"><i class="bi bi-person-circle"></i>Profil</a></li>
                  @elsecan('tenagaKerja1')
                    <li><a class="dropdown-item" href="/TenagaKerja"><i class="bi bi-person-circle"></i>Profil</a></li>
                  @elsecan('konsultan0')
                    <li><a class="dropdown-item" href="/Konsultan/create"><i class="bi bi-person-circle"></i>Profil</a></li>
                  @elsecan('konsultan1')
                    <li><a class="dropdown-item" href="/Konsultan"><i class="bi bi-person-circle"></i>Profil</a></li>
                  @elsecan('toko0')
                    <li><a class="dropdown-item" href="/Toko/create"><i class="bi bi-person-circle"></i>Profil</a></li>
                  @elsecan('toko1')
                    <li><a class="dropdown-item" href="/Toko"><i class="bi bi-person-circle"></i>Profil</a></li>
                  @endcan
                    
                 @can('admin')
                 <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-database"></i></i>Dashboard</a></li>
                 @endcan
                  <li><a class="dropdown-item" href="{{ route('role_requests.create') }}"><i class="bi bi-person-lines-fill"></i>Pengajuan Role</a></li>
                  
                  <li class="dropdown-divider"></li>
                  <li>
                    <form action="/logout" method="post">
                      @csrf
                      <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Log Out</button>
                    </form>
                  </li>
                </ul>
              </li>
              @else
              <li class="nav-item">
                <a href="/login" class="nav-link">
                  <i class="bi bi-person" style="font-size: 30px;"></i>
                </a>
              </li>
              @endauth
              <!-- Garis vertikal -->
              <li class="divider-vertical d-none d-lg-block"></li>
              <li class="nav-item d-flex align-items-center ms-2">
                <button id="dark-mode-toggle" class="btn btn-link nav-link p-0" style="border: none; background: none;">
                  <i class="bi bi-sun" id="theme-icon" style="font-size: 30px; cursor: pointer;"></i>
                </button>
              </li>
            </ul>
          </div>
        </div>


        {{-- @auth
        <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item me-5">
              <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item me-5">
              <a class="nav-link" href="#">Categori</a>
            </li>
            <li class="nav-item me-5">
              <a class="nav-link" href="#">Product</a>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                Service
              </a>
              <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#">Tenaga Kerja</a></li>
                <li><a class="dropdown-item" href="#">Ahli Pakar</a></li>
              </ul>
            </li>
          </ul>
        </div>

        @else
        <div class="navbar d-flex justify-content-end">
          <ul class="navbar-nav">
            <li class="nav-item me-5 ">
              <i class="bi bi-search nav-link"></i>
            </li>
            <li class="nav-item">
              <div class="form-check form-switch nav-link">
                  <input type="checkbox" class="form-check-input" id="checkbox">
                  <label class="form-check-label nav-link" for="checkbox">Dark Mode</label>
                </div>
            </li>
          </ul>
        </div>
      </div>
        
      @endauth --}}

       
    </nav>
    <form action="/cari" class="search-form rounded shadow">
      <input type="search" id="search-box" placeholder="search here..." name="cari"
      value="{{ request('cari') }}" class="shadow rounded">
      <label for="search-box" class="fas fa-search"></label>
    </form>

  </header> 


  @yield('content')


  <section id="FOOTER "> 
    <div class="ft-2  bg-black text-white p-5">
      <hr class="color-white">
      <div class="row justify-content-center p-5">
        <div class="col-md-6 p-5">
          <h3 class="fw-bold ">HARVEST HUB</h3>
          <p> E-Commerce dan  layanan konsultasi <br>di bidang Pertanian dan Peternakan.</p>
            
        </div>
        <div class="col-md-6 row justify-content-between text-start p-5 ">
          <div class="col-md-4">
            <h6>Contact</h6><br> 
              <ul>
                <li><h6>Email</h6></li>
                <li>Facebook</li>
                <li>Instagram</li>
              </ul>
          </div>
          <div class="col-md-4">
            <h6>About</h6><br>
            <ul>
              <li>Team</li>
              <li>Shipping</li>
              <li>Affiliate</li>
            </ul>
          </div>
          <div class="col-md-4">
            <h6>Info</h6><br>
            <ul>
              <li>Privacy Policies</li>
              <li>Terms & Conditions</li>
            </ul>
          </div>
        </div>
      </div>
    </div>
    
  </section>



    



    <script>
      feather.replace();
    </script>
     <!--=============== SWIPER JS ===============-->
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @livewireScripts
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('dark-mode-toggle');
        const themeIcon = document.getElementById('theme-icon');
        
        function updateIcon(theme) {
          if (theme === 'dark') {
            themeIcon.className = 'bi bi-moon-stars';
          } else {
            themeIcon.className = 'bi bi-sun';
          }
        }
        
        const currentTheme = localStorage.getItem('theme') || 'light';
        updateIcon(currentTheme);
        
        if (toggleBtn) {
          toggleBtn.addEventListener('click', function () {
            let theme = document.documentElement.getAttribute('data-bs-theme');
            if (theme === 'dark') {
              theme = 'light';
              document.documentElement.setAttribute('data-bs-theme', 'light');
              document.documentElement.classList.remove('dark-mode');
            } else {
              theme = 'dark';
              document.documentElement.setAttribute('data-bs-theme', 'dark');
              document.documentElement.classList.add('dark-mode');
            }
            localStorage.setItem('theme', theme);
            updateIcon(theme);
          });
        }

        // Location selection autocomplete script
        const locations = [
            'Badung',
            'Bangli',
            'Buleleng',
            'Denpasar',
            'Gianyar',
            'Jembrana',
            'Karangasem',
            'Klungkung',
            'Tabanan',
            'Jakarta',
            'Surabaya',
            'Malang',
            'Bandung',
            'Yogyakarta'
        ];

        const locationList = document.getElementById('navbar-location-list');
        const locationSearch = document.getElementById('navbar-location-search');
        const locationText = document.getElementById('nav-location-text');
        const resetBtn = document.getElementById('reset-location-btn');

        function renderLocations(filterText = '') {
            if (!locationList) return;
            locationList.innerHTML = '';
            const filtered = locations.filter(loc => 
                loc.toLowerCase().includes(filterText.toLowerCase())
            );

            if (filtered.length === 0) {
                locationList.innerHTML = '<div class="text-center py-3 text-muted small">Lokasi tidak ditemukan</div>';
                return;
            }

            filtered.forEach(loc => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.className = 'dropdown-item rounded-3 py-1.5 px-3 mb-1 text-start w-100 border-0 bg-transparent text-secondary small';
                btn.style.fontSize = '0.82rem';
                btn.innerHTML = `<i class="bi bi-geo-alt me-2 text-muted"></i>${loc}`;
                btn.addEventListener('click', function() {
                    selectLocation(loc);
                });
                locationList.appendChild(btn);
            });
        }

        function selectLocation(loc) {
            fetch('{{ route("set-location") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ lokasi: loc })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    if (locationText) locationText.textContent = loc;
                    const url = new URL(window.location.href);
                    if (url.pathname === '/cari') {
                        url.searchParams.set('lokasi', loc);
                        window.location.href = url.toString();
                    } else {
                        window.location.reload();
                    }
                }
            });
        }

        if (resetBtn) {
            resetBtn.addEventListener('click', function(e) {
                e.preventDefault();
                fetch('{{ route("set-location") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ lokasi: null })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (locationText) locationText.textContent = 'Pilih Lokasi';
                        const url = new URL(window.location.href);
                        if (url.pathname === '/cari') {
                            url.searchParams.delete('lokasi');
                            window.location.href = url.toString();
                        } else {
                            window.location.reload();
                        }
                    }
                });
            });
        }

        if (locationSearch) {
            locationSearch.addEventListener('input', function() {
                renderLocations(this.value);
            });
        }

        // Initial render
        renderLocations();
      });
    </script>
  </body>
</html>