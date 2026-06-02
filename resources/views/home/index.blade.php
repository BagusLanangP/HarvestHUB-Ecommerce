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

    <section id="kategori" class="py-5" style="background-color: var(--bs-body-bg);">
      <div class="container">
        <div class="row text-center mb-4">
          <div class="col-12 category-tittle">
            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1.5 fw-semibold small mb-2">Katalog Segar</span>
            <h2 class="fw-bold text-dark" style="font-family: 'Outfit', sans-serif;">Pilihan Kategori Tani</h2>
            <p class="text-secondary small">Temukan berbagai produk pertanian segar langsung dari petani lokal</p>
          </div>
        </div>
        
        <style>
          .category-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            border: 1px solid rgba(0, 0, 0, 0.03) !important;
          }
          .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(25, 135, 84, 0.08) !important;
            border-color: rgba(25, 135, 84, 0.2) !important;
          }
          .category-card:hover .category-image-wrapper {
            transform: scale(1.04);
            box-shadow: 0 8px 20px rgba(25, 135, 84, 0.12) !important;
          }
        </style>

        <div class="row g-4 justify-content-center">
          @foreach($kategoris as $k)
          <div class="col-6 col-sm-4 col-md-3 col-lg-2">
            <a href="{{ url('home/kategori/' . $k->id) }}" class="text-decoration-none">
              <div class="card category-card rounded-4 text-center p-3 h-100 bg-white">
                <div class="rounded-3 mb-3 overflow-hidden bg-light shadow-xs category-image-wrapper" style="width: 100%; height: 110px; transition: all 0.3s ease;">
                  <img src="{{ asset('img/kategori/' . $k->foto ) }}" alt="{{ $k->productName }}" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <div class="pt-1">
                  <h6 class="fw-bold text-dark mb-1 tracking-tight" style="font-family: 'Outfit', sans-serif; font-size: 0.88rem;">{{ $k->productName }}</h6>
                  <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1.2 fw-semibold" style="font-size: 0.65rem;">
                    {{ $k->produk->count() }} Produk
                  </span>
                </div>
              </div>
            </a>             
          </div>
          @endforeach     
        </div>
      </div>
    </section>

    <section class="produk mb-5 py-4" id="produkhome">
      <div class="homeProduk">
        <div class="homeProdukTittle text-center mb-3" >
          <h1>Produk</h1>
          <h4>Pesanlah untuk anda atau orang tercinta anda!</h4>
        </div>
        <hr>
        <div class="homeProdukContent">
          <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 justify-content-center">
            @foreach($produks as $produk)
                <div class="col d-flex">
                    <div class="card shadow-sm card-product h-100 w-100">
                        <a href="{{ URL::to('produk/'.$produk->slug ) }}" class="text-decoration-none h-100 d-flex flex-column">
                            <img src="{{ $produk->image_url }}" class="card-img-top" alt="{{ $produk->name }}">
                            <div class="card-body">
                                <div class="mb-2">
                                    <p class="product-name-title mb-1">{{ $produk->name }}</p>
                                    @if($produk->toko)
                                        <span class="text-muted d-block text-truncate" style="font-size: 0.78rem; font-weight: 400; line-height: 1.2;" title="{{ $produk->toko->nama }}">
                                            <i class="bi bi-shop me-1" style="color: #198754;"></i> {{ $produk->toko->nama }}
                                        </span>
                                    @else
                                        <!-- Placeholder to maintain height consistency -->
                                        <span class="d-block" style="font-size: 0.78rem; line-height: 1.2; visibility: hidden;">&nbsp;</span>
                                    @endif
                                    
                                    <!-- Rating & Sold Summary -->
                                    <div class="d-flex align-items-center mt-2 flex-wrap" style="font-size: 0.72rem; gap: 4px;">
                                        <div class="d-flex align-items-center text-warning">
                                            <i class="bi bi-star-fill me-1" style="color: #ffc107;"></i>
                                            <span class="text-dark fw-semibold">{{ $produk->average_rating }}</span>
                                        </div>
                                        <span class="text-muted">|</span>
                                        <span class="text-secondary">{{ $produk->total_sold }} Terjual</span>
                                    </div>
                                </div>
                                <p class="product-price-label">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
          </div>
        </div>

          <div class="seemore d-flex justify-content-center mt-5">
              <a href="/cari" class="btn btn-custom-green d-inline-flex align-items-center py-2.5 px-4 rounded-3 fw-semibold shadow-sm text-white" style="font-size: 0.95rem; text-decoration: none;">
                Lihat Produk Lainnya
              </a>
          </div>
              
        </div> 
      </div>
    </section>

    <style>
        .hover-lift {
            transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1), box-shadow 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .hover-lift:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
        }
        .bg-success-subtle {
            background-color: rgba(25, 135, 84, 0.08) !important;
        }
        .btn-custom-green {
            background-color: #198754 !important;
            color: #ffffff !important;
            border: 1px solid #198754 !important;
            transition: all 0.2s ease-in-out !important;
        }
        .btn-custom-green:hover {
            background-color: #157347 !important;
            border-color: #146c43 !important;
            color: #ffffff !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(25, 135, 84, 0.15);
        }
    </style>

    <section class="review mb-5 py-4">
      <div class="review-tittle text-center mb-5">
        <h1 class="fw-bold text-dark">Layanan Ahli & Tenaga Kerja</h1>
        <h4 class="text-secondary">Pesan jasa profesional pertanian & peternakan untuk mendampingi usaha Anda</h4>
      </div>
      <hr class="mb-5">
      
      <div class="review-content swiper">
        <div class="swiper-wrapper">
          @foreach($service as $s)
            @php
              // Determine dynamic routing based on model instance
              $detailUrl = $s instanceof \App\Models\TenagaKerja ? URL::to('tenagakerja/' . $s->user->slug) : URL::to('ahlipakar/' . $s->user->slug);
            @endphp
            <div class="card shadow-sm border border-light rounded-4 swiper-slide bg-white h-100 hover-lift" style="width: 17rem;">
              <a href="{{ $detailUrl }}" class="text-decoration-none h-100 d-flex flex-column justify-content-between">
                <!-- Profile Image Container (Enlarged) -->
                <div class="card-img pt-4 pb-2 d-flex justify-content-center">
                  <div class="position-relative" style="width: 130px; height: 130px;">
                    <img src="{{ $s->foto ? asset('storage/' . $s->foto) : asset('img/default-avatar.png') }}" class="rounded-circle shadow border border-2 border-white" alt="{{ $s->nama }}" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.25s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
                    <!-- Online status dot -->
                    <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle" style="width: 15px; height: 15px; border-width: 2.5px;"></span>
                  </div>
                </div>
                
                <!-- Details Container -->
                <div class="card-body text-center d-flex flex-column align-items-center justify-content-between p-3" style="min-height: 180px;">
                  <div>
                    <h5 class="card-title review-name fw-bold text-dark mb-1 hover-primary" style="font-size: 1.05rem;">{{ $s->nama }}</h5>
                    
                    <!-- Location -->
                    <p class="text-muted mb-2 d-flex align-items-center justify-content-center" style="font-size: 0.78rem; font-weight: 400;">
                      <i class="bi bi-geo-alt me-1 text-danger"></i> {{ $s->alamat ?: 'Indonesia' }}
                    </p>
                    
                    <!-- Stars -->
                    <div class="mb-3 text-warning d-flex align-items-center justify-content-center" style="font-size: 0.8rem; gap: 2px;">
                      <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                      <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                      <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                      <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                      <i class="bi bi-star-fill" style="color: #ffc107;"></i>
                      <span class="text-dark fw-semibold ms-1" style="font-size: 0.75rem;">(5.0)</span>
                    </div>
                  </div>

                  <!-- Role/Expertise badge -->
                  <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 fw-semibold" style="font-size: 0.75rem; border-radius: 20px;">
                    {{ $s->keahlian }}
                  </span>
                </div>
              </a>
            </div>
          @endforeach   
        </div> 
        
        <!-- Navigation buttons -->
        <div class="swiper-button-next">
          <i class="ri-arrow-right-s-line"></i>
        </div>
        
        <div class="swiper-button-prev">
          <i class="ri-arrow-left-s-line"></i>
        </div>

        <!-- Pagination -->
        <div class="swiper-pagination mt-4"></div>
      </div>

      <!-- See More Buttons at the Bottom of Layanan Section -->
      <div class="seemore d-flex justify-content-center mt-5">
          <a href="/Tenagakerja/view" class="btn btn-custom-green d-inline-flex align-items-center py-2.5 px-4 rounded-3 fw-semibold shadow-sm text-white" style="font-size: 0.95rem; text-decoration: none;">
            <i class="bi bi-person-workspace me-2"></i> Lihat Semua Layanan
          </a>
      </div>
    </section>
@endsection