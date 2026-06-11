@extends('layouts.mainlayouts')

@section('tittle', 'Kategori ' . $category->productName)

@section('content')
<section class="categoryselect" style="background-color: var(--bs-body-bg); min-height: 80vh; padding-top: 7rem;">
    <div class="container py-4">
        <!-- Breadcrumb / Navigation path -->
        <div class="row mb-3">
            <div class="col">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="/" class="text-success text-decoration-none fw-medium"><i class="bi bi-house-door-fill me-1"></i>Home</a></li>
                        <li class="breadcrumb-item text-secondary active" aria-current="page">Kategori</li>
                        <li class="breadcrumb-item text-secondary active" aria-current="page">{{ $category->productName }}</li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Banner Header Kategori -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card border-0 rounded-4 overflow-hidden shadow-sm position-relative text-white" style="height: 160px; background: linear-gradient(135deg, #198754 0%, #157347 100%);">
                    @if($category->foto)
                        <!-- Subtle background decoration image -->
                        <div class="position-absolute end-0 top-0 bottom-0 opacity-25 w-50" style="background: url('{{ asset('img/kategori/' . $category->foto) }}') center/cover no-repeat; mask-image: linear-gradient(to left, rgba(0,0,0,1), rgba(0,0,0,0)); -webkit-mask-image: linear-gradient(to left, rgba(0,0,0,1), rgba(0,0,0,0));"></div>
                    @endif
                    <div class="card-body d-flex flex-column justify-content-center p-4 p-md-5 position-relative" style="z-index: 2;">
                        <span class="badge bg-white text-success rounded-pill px-3 py-1.5 fw-semibold small mb-2 align-self-start shadow-xs">Kategori Produk</span>
                        <h1 class="fw-bold mb-0 text-white" style="font-family: 'Outfit', sans-serif;">{{ $category->productName }}</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Section Title & Subtitle -->
        <div class="row align-items-center mb-4">
            <div class="col-12 col-md-8">
                <div class="category-name d-flex align-items-center">
                    <h2 class="fw-bold text-dark mb-0" style="font-family: 'Outfit', sans-serif;">Daftar Produk {{ $category->productName }}</h2>
                </div>
                <p class="text-secondary small mb-0 mt-1">Menampilkan {{ $productCat->count() }} produk hasil pertanian segar di wilayah Anda</p>
            </div>
        </div>
        <hr class="mb-4">

        <!-- Product Grid -->
        @if($productCat->isEmpty())
            <div class="row py-5">
                <div class="col-12 text-center py-5">
                    <div class="mb-3">
                        <i class="bi bi-basket text-secondary" style="font-size: 4rem;"></i>
                    </div>
                    <h5 class="fw-bold text-secondary">Belum ada produk di kategori ini</h5>
                    <p class="text-muted small">Silakan kembali lagi nanti atau cari produk lainnya di halaman utama.</p>
                    <a href="/" class="btn btn-custom-green mt-3 px-4 py-2 rounded-pill fw-semibold shadow-sm text-white">Kembali ke Beranda</a>
                </div>
            </div>
        @else
            <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-6 g-3 justify-content-start mb-5">
                @foreach($productCat as $pc)
                    <div class="col d-flex">
                        <div class="card shadow-sm card-product h-100 w-100">
                            <a href="{{ URL::to('produk/'.$pc->slug) }}" class="text-decoration-none h-100 d-flex flex-column">
                                <img src="{{ $pc->image_url }}" class="card-img-top" alt="{{ $pc->name }}">
                                <div class="card-body">
                                    <div class="mb-2">
                                        <p class="product-name-title mb-1">{{ $pc->name }}</p>
                                        @if($pc->toko)
                                            <div class="d-flex align-items-center justify-content-between text-muted mt-1" style="font-size: 0.78rem; line-height: 1.2;">
                                                <span class="text-truncate me-2" style="max-width: 60%;" title="{{ $pc->toko->nama }}">
                                                    <i class="bi bi-shop me-1" style="color: #198754;"></i> {{ $pc->toko->nama }}
                                                </span>
                                                <span class="text-truncate text-secondary text-end fw-medium" style="max-width: 40%; font-size: 0.74rem;" title="{{ $pc->toko->alamat }}">
                                                    <i class="bi bi-geo-alt-fill me-0.5 text-danger"></i> {{ $pc->toko->alamat }}
                                                </span>
                                            </div>
                                        @else
                                            <!-- Placeholder to maintain height consistency -->
                                            <div class="d-flex" style="font-size: 0.78rem; line-height: 1.2; visibility: hidden;">&nbsp;</div>
                                        @endif
                                        
                                        <!-- Rating & Sold Summary -->
                                        <div class="d-flex align-items-center mt-2 flex-wrap" style="font-size: 0.72rem; gap: 4px;">
                                            <div class="d-flex align-items-center text-warning">
                                                <i class="bi bi-star-fill me-1" style="color: #ffc107;"></i>
                                                <span class="text-dark fw-semibold">{{ $pc->average_rating }}</span>
                                            </div>
                                            <span class="text-muted">|</span>
                                            <span class="text-secondary">{{ $pc->total_sold }} Terjual</span>
                                        </div>
                                    </div>
                                    <p class="product-price-label">Rp {{ number_format($pc->harga, 0, ',', '.') }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $productCat->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</section>

<style>
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
@endsection