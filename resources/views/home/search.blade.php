@extends('layouts.mainlayouts')

@section('tittle', 'Katalog Produk')

@section('content')
<section class="produk mb-5 produk-cari" id="produkhome" style="padding-top: 100px;">
    <div class="container">
      <!-- Section Title -->
      <div class="homeProduk">
        <div class="homeProdukTittle text-center mb-4">
          <h1 class="fw-bold text-dark">Katalog Produk</h1>
          <h4 class="text-secondary">Temukan produk pertanian & peternakan terbaik untuk kebutuhan Anda</h4>
        </div>
      </div>
      <hr class="mb-4">

      <!-- Interactive Search & Filter Bar -->
      <div class="row justify-content-center mb-5">
        <div class="col-12 col-md-6">
          <form action="/cari" method="GET" class="d-flex shadow-sm rounded-pill overflow-hidden bg-white border border-light p-1">
            <input type="text" name="cari" class="form-control border-0 px-4 py-2" placeholder="Cari produk pertanian & peternakan..." value="{{ request('cari') }}" style="outline: none; box-shadow: none; font-size: 0.95rem;">
            <button type="submit" class="btn btn-success px-4 border-0 rounded-pill fw-bold text-white d-flex align-items-center justify-content-center" style="background-color: #198754; transition: background-color 0.2s ease;">
              <i class="bi bi-search me-1"></i> Cari
            </button>
          </form>
        </div>
      </div>

      <!-- Dynamic Search Term Heading -->
      <div class="mb-4">
        @if(request('cari'))
          <h5 class="text-secondary fw-normal">
            Menampilkan hasil pencarian untuk: <span class="text-success fw-bold">"{{ request('cari') }}"</span>
            <span class="badge bg-light text-dark border ms-2" style="font-size: 0.8rem; font-weight: 500;">{{ $hasil->count() }} Ditemukan</span>
          </h5>
        @else
          <h5 class="text-secondary fw-bold" style="font-size: 1.1rem; border-left: 4px solid #198754; padding-left: 10px;">Semua Produk Katalog</h5>
        @endif
      </div>

      <!-- Product Catalog Grid -->
      <div class="homeProdukContent">
        @if($hasil->count() > 0)
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 justify-content-center">
          @foreach($hasil as $produk)
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
        @else
        <!-- Beautiful Empty State -->
        <div class="text-center my-5 py-5 bg-white shadow-sm rounded-4 border border-light">
            <div class="text-muted mb-3">
                <i class="bi bi-search" style="font-size: 4rem; color: #6c757d;"></i>
            </div>
            <h4 class="text-dark fw-bold mb-2">Produk Tidak Ditemukan</h4>
            <p class="text-secondary px-4">Maaf, kami tidak dapat menemukan produk pertanian dengan kata kunci <span class="fw-semibold">"{{ request('cari') }}"</span>.</p>
            <a href="/cari" class="btn btn-success mt-3 rounded-pill px-4 py-2 fw-semibold text-white shadow-sm" style="background-color: #198754;">
              Lihat Semua Produk
            </a>
        </div>
        @endif
      </div>
    </div>
</section>
@endsection
