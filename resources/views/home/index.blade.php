@extends('layouts.mainlayouts')

@section('tittle', 'Home')


@section('content')

    <section class="home" id="home">
        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner" >
              <div class="carousel-item active">
                <img src="{{ asset('img/home/pekerja2.jpg')}}" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="{{ asset('img/home/produk.jpg')}}" class="d-block w-100" alt="...">
              </div>
              <div class="carousel-item">
                <img src="{{asset('img/home/ahlipakar2.jpg')}}" class="d-block w-100" alt="...">
              </div>
            </div>
            <div class="overlay-container">
                <div class="overlay-content container">
                  <div class="row">
                    <div class="col-12 text-center">
                      <img src="{{asset('img/Logo-harvesthub.png')}}" alt="" class="logo-home">
                    </div>
                  </div>
                  <div class="row app-tittle">
                    <div class="col text-center">
                      <h1 id="carouselTitle">HarvestHUB</h1>
                    </div>
                  </div>
                  <div class="row text-center app-desc">
                    <div class="col">
                      <h5 id="carouselText">E-commerce dan penyedia layanan jasa di bidang <br> pertanian dan peternakan!</h5>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-3"></div>
                    <div class="col-6">
                      <button type="submit" class="btn submit-login d-flex justify-content-center">Discovery Our Collection</button>
                    </div>
                    <div class="col-3"></div>
                  </div>
                </div>
            </div>
              
        </div>
    </section>

    <section class="kategori vh-100" id="category">
       <p>I Love You so</p>
    </section>

    <section class="produk vh-100 mb-5" id="produkhome">
      <div class="homeProduk">
        <div class="homeProdukTittle text-center mb-5" >
          <h1>Produk</h1>
          <h4>Pesanlah untuk anda atau orang tercinta anda!</h4>
          
        </div>
        <hr>
        <div class="homeProdukContent ">
          <div class="row-1 d-flex justify-content-between mb-3">
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
                <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <p class="card-text fw-medium">Daging Sapi</p>
                  <p class="productPrice">Rp.15000/kg</p>
                </div>             
            </div>
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text fw-medium">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>
              </div>             
            </div>
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text fw-medium">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>
              </div>             
            </div>
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text fw-medium">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>
              </div>             
            </div>
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text fw-medium">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>
              </div>             
            </div>
            </div>
          </div>
          <div class="row-1 d-flex justify-content-between mb-3">
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
                <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <p class="card-text fw-medium">Daging Sapi</p>
                  <p class="productPrice">Rp.15000/kg</p>
                </div>             
            </div>
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text fw-medium">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>
              </div>             
            </div>
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text fw-medium">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>
              </div>             
            </div>
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text fw-medium">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>
              </div>             
            </div>
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text fw-medium">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>
              </div>             
            </div>
            </div>
          </div>
          {{-- <div class="row-2 d-flex justify-content-between">
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>
              </div>             
            </div>
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>     
            </div>
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>
              </div>             
            </div>
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>
              </div>             
            </div>
            <div class="col-3 card me-3 shadow " style="width: 14rem;">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text">Daging Sapi</p>
                <p class="productPrice">Rp.15000/kg</p>
              </div>             
            </div>
          </div> --}}
          <div class="seemore d-flex justify-content-center mt-5">
            <div class="produkhomeseemore">
              <button type="submit" class="btn submit-login d-flex justify-content-center">Lihat Produk Lainnya</button>
            </div>     
          </div>
              
        </div> 
      </div>
    </section>

    
@endsection