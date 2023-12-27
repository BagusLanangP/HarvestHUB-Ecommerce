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

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://unpkg.com/feather-icons"></script>

    {{-- Trix editor --}}
    <link rel="stylesheet" type="text/css" href="/css/trix.css">
    <script type="text/javascript" src="/js/trix.js"></script>

    
  </head>
  <body>

  <header class="header">
    <nav class="navbar navbar-expand-lg bg-body shadow-sm">
      <div class="container-fluid">
      ` <img src="{{ asset('img/Logo-harvesthub.png') }}" class="logo me-2" alt="">
        <a class="navbar-brand" href="#">HarvestHUB</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse d-flex justify-content-center" id="navbarNavDropdown">
          <ul class="navbar-nav">
            <li class="nav-item me-5">
              <a class="nav-link {{ Request::is('.home') ? 'active' : '' }}" aria-current="page" href=".home">Home</a>
            </li>
            <li class="nav-item me-5">
              <a class="nav-link {{ Request::is('#category') ? 'active' : '' }}" href="#category">Categori</a>
            </li>
            <li class="nav-item me-5">
              <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="#">Product</a>
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

        <div class="d-flex justify-content-end">
          <ul class="navbar-nav">
            
            <li class="nav-item search">
              <i class="bi bi-search nav-link nav-item" style="font-size: 30px;" id="search-btn"></i>
            </li>
            @auth
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="bi bi-person" style="font-size: 30px;"></i>
              </a>
              <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                <li><a class="dropdown-item" href="/cart"><i class="bi bi-heart"></i>Wishlist</a></li>
                <li><a class="dropdown-item" href="/cart"><i class="bi bi-cart"></i>Keranjang</a></li>
                <li><a class="dropdown-item" href="#"><i class="bi bi-bag"></i>Transaksi</a></li>
                @can('tenagaKerja0')
                  <li><a class="dropdown-item" href="/TenagaKerja/create"><i class="bi bi-person-circle"></i>Profil</a></li>
                @elsecan('tenagaKerja1')
                  <li><a class="dropdown-item" href="/TenagaKerja"><i class="bi bi-person-circle"></i>Profil</a></li>
                @elsecan('konsultan0')
                  <li><a class="dropdown-item" href="/Konsultan/create"><i class="bi bi-person-circle"></i>Profil</a></li>
                @elsecan('konsultan1')
                  <li><a class="dropdown-item" href="/Konsultan/"><i class="bi bi-person-circle"></i>Profil</a></li>
                @elsecan('toko0')
                  <li><a class="dropdown-item" href="/Toko/create"><i class="bi bi-person-circle"></i>Profil</a></li>
                @elsecan('toko1')
                  <li><a class="dropdown-item" href="/Toko/"><i class="bi bi-person-circle"></i>Profil</a></li>
                @endcan
                  
               @can('dashboard')
               <li><a class="dropdown-item" href="/dashboard"><i class="bi bi-database"></i></i>Dashboard</a></li>
               @endcan
                
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
            <li class="divider-vertical"></li>
            <li class="nav-item">
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="bi bi-sun" style="font-size: 30px;"></i>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <li><a class="dropdown-item" href="/cart"><i class="bi bi-moon-stars"></i>Keranjang</a></li>
                  <li><a class="dropdown-item" href="#"><i class="bi bi-bag"></i>Transaksi</a></li>
                  <li class="dropdown-divider"></li>
                  <li>
                    <form action="/logout" method="post">
                      @csrf
                      <button type="submit" class="dropdown-item"><i class="bi bi-box-arrow-right"></i> Log Out</button>
                    </form>
                  </li>
                </ul>
              </li>
            {{-- <div class="form-check form-switch nav-item"> --}}
                {{-- <input type="checkbox" class="form-check-input " id="checkbox">
                <label class="form-check-label nav-link" for="checkbox">Dark Mode</label>
              </div> --}}
          </li>


            
            {{-- <li class="nav-item">
              <div class="form-check form-switch nav-item">
                  <input type="checkbox" class="form-check-input " id="checkbox">
                  <label class="form-check-label nav-link" for="checkbox">Dark Mode</label>
                </div>
            </li> --}}
          </ul>
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
  </body>
</html>