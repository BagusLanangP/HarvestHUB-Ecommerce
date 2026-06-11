@extends('layouts.mainlayouts')

@section('tittle', 'Detail Produk - ' . $itemproduk->name)

@section('content')
<section class="detailProduk">
    <div class="container py-2">
        <div class="row justify-content-center g-4">
            
            {{-- Foto Produk & Navigasi (Grid Kiri) --}}
            <div class="col-12 col-md-5 col-lg-5">
                {{-- Tombol Kembali --}}
                <div class="mb-3">
                    <a href="javascript:history.back()" class="btn btn-link text-success fw-semibold p-0 d-inline-flex align-items-center text-decoration-none hover-underline back-button">
                        <i class="bi bi-arrow-left me-2" style="font-size: 1.1rem;"></i> Kembali
                    </a>
                </div>
                {{-- Gambar Produk --}}
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white hover-zoom-container">
                    <img src="{{ $itemproduk->image_url }}" alt="{{ $itemproduk->name }}" class="img-fluid w-100 product-img-display" style="aspect-ratio: 1/1; object-fit: cover;">
                </div>
            </div>

            {{-- Kotak Detail (Grid Kanan dengan Box Shadow) --}}
            <div class="col-12 col-md-7 col-lg-6">
                <div class="card border-0 shadow rounded-4 p-4 h-100 product-detail-card">
                    
                    {{-- Judul & Toko --}}
                    <div class="mb-3">
                        <h2 class="fw-bold product-title text-dark mb-2" style="font-size: 1.6rem;">{{ $itemproduk->name }}</h2>
                        <a href="{{ URL::to('Toko/'.$itemproduk->toko_id) }}" class="tokoname d-inline-flex align-items-center text-success fw-semibold text-decoration-none hover-underline me-3">
                            <i class="bi bi-shop me-2" style="font-size: 1.1rem;"></i> {{ $itemproduk->toko->nama }}
                        </a>
                        <span class="text-secondary small d-inline-flex align-items-center" title="Lokasi Toko">
                            <i class="bi bi-geo-alt-fill me-1 text-danger"></i> {{ $itemproduk->toko->alamat }}
                        </span>
                    </div>
                    
                    {{-- Ulasan Bintang & Total Terjual --}}
                    <div class="mb-3 d-flex align-items-center flex-wrap gap-2">
                        <span class="text-warning d-flex align-items-center">
                            @for($i=1; $i<=5; $i++)
                                @if($i <= round($itemproduk->average_rating))
                                    <i class="bi bi-star-fill me-0.5"></i>
                                @else
                                    <i class="bi bi-star me-0.5"></i>
                                @endif
                            @endfor
                        </span>
                        <span class="text-secondary small">({{ $itemproduk->average_rating }} / 5)</span>
                        <span class="text-muted small">|</span>
                        <span class="text-secondary small">{{ $itemproduk->reviews->count() }} Ulasan</span>
                        <span class="text-muted small">|</span>
                        <span class="text-success small fw-semibold">{{ $itemproduk->total_sold ?? '0' }} Terjual</span>
                    </div>

                    <hr class="my-3 opacity-10">

                    {{-- Harga Produk --}}
                    <div class="mb-4">
                        <span class="text-muted d-block small mb-1">Harga</span>
                        <h3 class="fw-bold text-success product-price">Rp {{ number_format($itemproduk->harga, 0, ',', '.') }} <span class="fs-6 text-secondary fw-normal">/ kg</span></h3>
                    </div>

                    {{-- Kotak Detail Barang (Scrollable Box) --}}
                    <div class="mb-4">
                        <span class="text-muted d-block small mb-2 fw-semibold">Deskripsi Barang</span>
                        <div class="product-description-box rounded-3">
                            <p class="mb-0 text-secondary leading-relaxed" style="font-size: 0.92rem;">
                                {!! $itemproduk->description !!}
                            </p>
                        </div>
                    </div>

                    {{-- Form Pembelian (Jumlah Beli & Tombol Aksi) --}}
                    <form action="{{ route('cartdetail.store') }}" method="POST" id="purchase-form">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $itemproduk->id }}">
                        
                        {{-- Jumlah Beli (Quantity Selector) --}}
                        <div class="mb-4 d-flex align-items-center gap-3">
                            <span class="text-secondary fw-semibold" style="font-size: 0.95rem;">Jumlah Beli:</span>
                            <div class="input-group input-group-sm quantity-selector shadow-sm rounded-pill border" style="width: 120px; overflow: hidden; background: var(--bs-body-bg);">
                                <button type="button" class="btn btn-link text-decoration-none px-2.5 py-1 border-0" id="btn-qty-minus"><i class="bi bi-dash fw-bold text-dark"></i></button>
                                <input type="number" name="qty" id="qty-input" class="form-control text-center border-0 bg-transparent fw-bold" value="1" min="1" style="box-shadow: none; font-size: 0.9rem;">
                                <button type="button" class="btn btn-link text-decoration-none px-2.5 py-1 border-0" id="btn-qty-plus"><i class="bi bi-plus fw-bold text-dark"></i></button>
                            </div>
                        </div>

                        {{-- Baris Tombol Tindakan Rapi --}}
                        <div class="d-flex align-items-center gap-2 product-action-row">
                            
                            {{-- Button Chat --}}
                            @php
                                $tokoPhone = preg_replace('/[^0-9]/', '', $itemproduk->toko->phone);
                                if (str_starts_with($tokoPhone, '0')) {
                                    $tokoPhone = '62' . substr($tokoPhone, 1);
                                }
                                $chatUrl = "https://wa.me/" . $tokoPhone . "?text=Halo%20Toko%20" . urlencode($itemproduk->toko->nama) . ",%20saya%20tertarik%20dengan%20produk%20" . urlencode($itemproduk->name) . "%20yang%20saya%20lihat%20di%20HarvestHUB.";
                            @endphp
                            <a href="{{ $chatUrl }}" target="_blank" class="btn btn-outline-success rounded-pill d-flex align-items-center justify-content-center p-0 flex-shrink-0 btn-action" style="width: 48px; height: 48px;" title="Chat Penjual">
                                <i class="bi bi-chat-left-text" style="font-size: 1.2rem;"></i>
                            </a>

                            {{-- Button Love (Wishlist) --}}
                            @auth
                                @php
                                    $isWishlist = \App\Models\Wishlist::where('produk_id', $itemproduk->id)->where('user_id', auth()->id())->exists();
                                @endphp
                            @endauth
                            <button type="button" class="btn btn-outline-danger rounded-pill d-flex align-items-center justify-content-center p-0 flex-shrink-0 btn-action @if(isset($isWishlist) && $isWishlist) active-wish @endif" style="width: 48px; height: 48px;" id="btn-wishlist-toggle" title="Tambah ke Wishlist">
                                <i class="bi @if(isset($isWishlist) && $isWishlist) bi-heart-fill @else bi-heart @endif" style="font-size: 1.2rem;"></i>
                            </button>

                            {{-- Button Add to Cart --}}
                            <button type="submit" class="btn btn-success rounded-pill flex-grow-1 fw-semibold py-2.5 d-flex align-items-center justify-content-center gap-2 btn-add-cart shadow-sm" style="height: 48px;">
                                <i class="bi bi-cart-fill"></i> Tambah Keranjang
                            </button>
                        </div>
                    </form>

                    {{-- Form Tersembunyi untuk Wishlist --}}
                    <form id="wishlist-action-form" action="{{ route('wishlist.store') }}" method="POST" class="d-none">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $itemproduk->id }}">
                    </form>

                </div>
            </div>

        </div>

        {{-- Ulasan Produk (Paling Bawah Banget dengan Box dan Shadow) --}}
        <div class="row justify-content-center mt-5">
            <div class="col-12 col-md-12 col-lg-11">
                <div class="card border-0 shadow rounded-4 p-4 review-section-card bg-white">
                    <h4 class="fw-bold text-dark mb-4 d-flex align-items-center">
                        <i class="bi bi-chat-square-quote me-2 text-success"></i> Ulasan Produk
                    </h4>
                    <hr class="mb-4 opacity-10">
                    
                    @if($itemproduk->reviews->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-chat-left-dots text-muted" style="font-size: 3rem;"></i>
                            <p class="text-secondary mt-3 mb-0">Belum ada ulasan untuk produk ini.</p>
                        </div>
                    @else
                        <div class="d-flex flex-column gap-3">
                            @foreach($itemproduk->reviews as $review)
                                <div class="p-3 rounded-3 review-item-card border" style="background-color: var(--bs-body-bg);">
                                    <div class="d-flex w-100 justify-content-between align-items-center flex-wrap gap-2 mb-2">
                                        <h6 class="mb-0 fw-bold text-dark">{{ $review->user->name }}</h6>
                                        <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="text-warning mb-2" style="font-size: 0.85rem;">
                                        @for($i=1; $i<=5; $i++)
                                            @if($i <= $review->rating)
                                                <i class="bi bi-star-fill"></i>
                                            @else
                                                <i class="bi bi-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <p class="mb-0 text-secondary leading-relaxed" style="font-size: 0.9rem;">{{ $review->comment }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>

    </div>
</section>

{{-- Custom CSS untuk Redesain Halaman Detail Produk Premium --}}
<style>
    /* Styling khusus detail produk */
    .detailProduk {
        background-color: var(--bs-body-bg);
        padding-top: 95px !important; /* Push content down to prevent overlap with fixed navbar */
    }
    
    .back-button {
        transition: transform 0.2s ease;
    }
    .back-button:hover {
        transform: translateX(-4px);
    }
    
    .hover-zoom-container {
        overflow: hidden;
        border: 1px solid rgba(0,0,0,0.04);
        transition: box-shadow 0.3s ease;
    }
    .hover-zoom-container:hover {
        box-shadow: 0 10px 30px rgba(0,0,0,0.08) !important;
    }
    .product-img-display {
        transition: transform 0.5s ease;
    }
    .hover-zoom-container:hover .product-img-display {
        transform: scale(1.03);
    }
    
    .product-detail-card {
        background-color: #ffffff;
    }
    .dark-mode .product-detail-card, .dark-mode .review-section-card {
        background-color: #1e1e1e !important;
    }
    
    /* Box Deskripsi Scrollable */
    .product-description-box {
        max-height: 180px;
        overflow-y: auto;
        border: 1px solid rgba(0,0,0,0.06);
        padding: 15px;
        background-color: rgba(0,0,0,0.02);
        scrollbar-width: thin;
        scrollbar-color: rgba(0,0,0,0.15) transparent;
    }
    .dark-mode .product-description-box {
        border-color: rgba(255,255,255,0.06) !important;
        background-color: rgba(255,255,255,0.02) !important;
    }
    
    /* Scrollbar style */
    .product-description-box::-webkit-scrollbar {
        width: 6px;
    }
    .product-description-box::-webkit-scrollbar-track {
        background: transparent;
    }
    .product-description-box::-webkit-scrollbar-thumb {
        background-color: rgba(0,0,0,0.15);
        border-radius: 10px;
    }
    .dark-mode .product-description-box::-webkit-scrollbar-thumb {
        background-color: rgba(255,255,255,0.15);
    }

    /* Kuantitas Selector */
    .quantity-selector button {
        box-shadow: none !important;
        border-radius: 0 !important;
    }
    .quantity-selector button:hover {
        background-color: rgba(0,0,0,0.05);
    }
    .dark-mode .quantity-selector button:hover {
        background-color: rgba(255,255,255,0.05);
    }
    .dark-mode .quantity-selector button i {
        color: #ffffff !important;
    }
    .quantity-selector input[type="number"]::-webkit-outer-spin-button,
    .quantity-selector input[type="number"]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .quantity-selector input[type="number"] {
        -moz-appearance: textfield;
    }

    /* Tombol Aksi */
    .btn-action {
        transition: all 0.2s ease-in-out;
        border-color: rgba(0,0,0,0.08);
    }
    .dark-mode .btn-action {
        border-color: rgba(255,255,255,0.08) !important;
        color: #b0b0b0 !important;
    }
    .btn-action:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.06);
    }
    .btn-action.active-wish {
        background-color: rgba(220, 53, 69, 0.1);
        border-color: #dc3545 !important;
        color: #dc3545 !important;
    }
    .dark-mode .btn-action.active-wish {
        background-color: rgba(220, 53, 69, 0.2) !important;
    }

    /* Add to Cart button */
    .btn-add-cart {
        background-color: #198754 !important;
        border-color: #198754 !important;
        color: #ffffff !important;
        transition: all 0.2s ease-in-out;
    }
    .btn-add-cart:hover {
        background-color: #157347 !important;
        border-color: #146c43 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2) !important;
    }

    /* Ulasan Section */
    .review-item-card {
        border-color: rgba(0,0,0,0.06) !important;
        transition: transform 0.2s ease;
    }
    .review-item-card:hover {
        transform: translateX(4px);
    }
    .dark-mode .review-item-card {
        border-color: rgba(255,255,255,0.06) !important;
        background-color: #1a1a1a !important;
    }
    .tokoname:hover {
        color: #157347 !important;
    }

    /* Product Detail Mobile Responsive CSS Overrides */
    @media (max-width: 576px) {
        .detailProduk {
            padding-top: 80px !important;
        }
        .product-detail-card {
            padding: 20px !important;
        }
        .product-title {
            font-size: 1.35rem !important;
        }
        .product-price {
            font-size: 1.5rem !important;
        }
        .product-action-row {
            flex-wrap: wrap !important;
            gap: 10px !important;
        }
        .product-action-row .btn-action {
            flex-grow: 1 !important;
            width: auto !important;
            height: 46px !important;
        }
        .product-action-row .btn-add-cart {
            width: 100% !important;
            flex-basis: 100% !important;
            height: 46px !important;
            margin-top: 5px;
        }
    }
</style>

{{-- Script JS Interaktif untuk Kuantitas dan Wishlist Toggle --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const btnMinus = document.getElementById('btn-qty-minus');
        const btnPlus = document.getElementById('btn-qty-plus');
        const qtyInput = document.getElementById('qty-input');
        const btnWishlist = document.getElementById('btn-wishlist-toggle');
        const wishlistForm = document.getElementById('wishlist-action-form');

        // Kurangi Kuantitas
        if (btnMinus && qtyInput) {
            btnMinus.addEventListener('click', function () {
                let currentVal = parseInt(qtyInput.value) || 1;
                if (currentVal > 1) {
                    qtyInput.value = currentVal - 1;
                }
            });
        }

        // Tambah Kuantitas
        if (btnPlus && qtyInput) {
            btnPlus.addEventListener('click', function () {
                let currentVal = parseInt(qtyInput.value) || 1;
                qtyInput.value = currentVal + 1;
            });
        }

        // Validasi input manual
        if (qtyInput) {
            qtyInput.addEventListener('change', function () {
                let val = parseInt(qtyInput.value);
                if (isNaN(val) || val < 1) {
                    qtyInput.value = 1;
                }
            });
        }

        // Wishlist Toggle Form submit
        if (btnWishlist && wishlistForm) {
            btnWishlist.addEventListener('click', function (e) {
                e.preventDefault();
                wishlistForm.submit();
            });
        }
    });
</script>
@endsection