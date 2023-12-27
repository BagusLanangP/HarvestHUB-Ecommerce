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

    <section id="kategori" class="mt-5 mb-5" >
      <div class="container">
        <div class="row text-center mb-3 kategori-tittle">
          <div class="col category-tittle">
            <h1>Kategori</h1>
            <h4>Temukan produk yang anda inginkan</h3>
          </div>
          
        </div>
        <hr>
        <div class="row ">
          <div class="col-6">
            <p>ini adalah</p>
          </div>
          <div class="col-6">
            <div class="row">
              @foreach($kategoris as $k)
          <div class="col-4 mb-3">
            <div class="card shadow">
              <a href="{{ url('/home/kategori/' . $k->id) }}">
                <img src="{{ asset('img/home/kategori/buah-kategori.jpg') }}" class="card-img-top" alt="GAMBAR2">
                <div class="card-body">
                <h4 class="card-text text-center">{{ $k->productName }}</h4>
              </div>
              </a>
              
            </div>
          </div>
          @endforeach     
            </div>
          
          </div>
              
        </div>
        <div class="row">

        </div>
      </div>
    </section>

    <div class="mt-5"></div>
    <section class="produk vh-100 mb-5" id="produkhome">
      <div class="homeProduk">
        <div class="homeProdukTittle text-center mb-5" >
          <h1>Produk</h1>
          <h4>Pesanlah untuk anda atau orang tercinta anda!</h4>
          
        </div>
        <hr>
        <div class="homeProdukContent ">
          <div class="row-1 d-flex justify-content-between mb-3">
            @foreach($produks as $produk)
              <a href="{{ URL::to('produk/'.$produk->slug ) }}"> 
              <div class="col-2 card me-3 shadow card-product ">
                <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
                <div class="card-body">
                  <p class="card-text fw-medium">{{ $produk->name }}</p>
                  <p class="productPrice">Rp {{ $produk->harga }}</p>
                </div>             
              </div>
              </a>
            @endforeach
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

    <section class="review vh-100">

      <div class="review-tittle text-center mb-5">
        <h1>Service</h1>
        <h4>Pesanlah untuk anda atau orang tercinta anda!</h4>
      </div>
      <hr>
      <div class="review-content swiper">
        <div class="d-flex justify-content-between swiper-wrapper">
          <div class="card shadow swiper-slide" style="width: 14rem;">
            <div class="card-img pt-3 pb-3 d-flex justify-content-center">
              <img src="{{ asset('img/home/ahlipakar.jpg')}}" class="card-img-top rounded-circle" alt="..." style="width: 7rem; height:7rem">
            </div>
            <div class="card-body text-center">
              <h5 class="card-title review-name">Lanang Purbhawa</h5>
              <h4 class="card-text review-desc">Ahli Durian</h4>
            </div>
          </div>   
          <div class="card shadow swiper-slide" style="width: 14rem;">
            <div class="card-img pt-3 pb-3 d-flex justify-content-center">
              <img src="{{ asset('img/home/ahlipakar.jpg')}}" class="card-img-top rounded-circle" alt="..." style="width: 7rem; height:7rem">
            </div>
            <div class="card-body text-center">
              <h5 class="card-title review-name">Lanang Purbhawa</h5>
              <h4 class="card-text review-desc">Ahli Durian</h4>
            </div>
          </div>
          <div class="card shadow swiper-slide" style="width: 14rem;">
            <div class="card-img pt-3 pb-3 d-flex justify-content-center">
              <img src="{{ asset('img/home/ahlipakar.jpg')}}" class="card-img-top rounded-circle" alt="..." style="width: 7rem; height:7rem">
            </div>
            <div class="card-body text-center">
              <h5 class="card-title review-name">Lanang Purbhawa</h5>
              <h4 class="card-text review-desc">Ahli Durian</h4>
            </div>
          </div>
          <div class="card shadow swiper-slide" style="width: 14rem;">
            <div class="card-img pt-3 pb-3 d-flex justify-content-center">
              <img src="{{ asset('img/home/ahlipakar.jpg')}}" class="card-img-top rounded-circle" alt="..." style="width: 7rem; height:7rem">
            </div>
            <div class="card-body text-center">
              <h5 class="card-title review-name">Lanang Purbhawa</h5>
              <h4 class="card-text review-desc">Ahli Durian</h4>
            </div>
          </div>
          <div class="card shadow swiper-slide" style="width: 14rem;">
            <div class="card-img pt-3 pb-3 d-flex justify-content-center">
              <img src="{{ asset('img/home/ahlipakar.jpg')}}" class="card-img-top rounded-circle" alt="..." style="width: 7rem; height:7rem">
            </div>
            <div class="card-body text-center">
              <h5 class="card-title review-name">Lanang Purbhawa</h5>
              <h4 class="card-text review-desc">Ahli Durian</h4>
            </div>
          </div>  
           
        </div> 
         <!-- Navigation buttons -->
         <div class="swiper-button-next ">
          <i class="ri-arrow-right-s-line"></i>
          </div>
          
          <div class="swiper-button-prev">
              <i class="ri-arrow-left-s-line"></i>
          </div>

          <!-- Pagination -->
          <div class="swiper-pagination mt-3"></div>
      </div>
           
    </section>
@endsection