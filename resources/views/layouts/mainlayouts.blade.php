<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>HarvestHub | @yield('tittle')</title>
    <!-- bootstrap css -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="https://unpkg.com/feather-icons"></script>
  </head>
  <body>

  <header>
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

        <div class="navbar-">
          <ul class="navbar-nav d-flex d-flex justify-content-end">
            <li class="nav-item ">
              <i data-feather="user"></i>
              <i data-feather="circle"></i>
            </li>
            <li class="nav-item">
              <div class="form-check form-switch nav-link">
                  <input type="checkbox" class="form-check-input" id="checkbox">
                  <label class="form-check-label" for="checkbox">Dark Mode</label>
                </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>

  </header> 


@yield('content');


    



    <script>
      feather.replace();
    </script>
    <!-- bootstrap js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  </body>
</html>