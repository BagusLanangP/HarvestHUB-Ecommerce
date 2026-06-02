@extends('layouts.mainlayouts')

@section('tittle', 'Profil Toko')

@section('content')
<section class="tokodetail py-5">
    <div class="container py-2">
        <div class="row text-center mb-4">
            <div class="login-tittle">
                <h2 class="fw-bold text-dark mb-1">Profil Toko</h2>
                <p class="text-secondary">Kelola profil dan katalog produk toko Anda melalui panel ini</p>
            </div>
        </div>

        <div class="row g-4">
            
            {{-- GRID KIRI (Profil, Tabel Data, Deskripsi, Tombol Aksi) --}}
            <div class="col-12 col-lg-5">
                
                {{-- Card Profil Utama --}}
                <div class="card border-0 shadow rounded-4 p-4 mb-4 text-center text-sm-start bg-white shop-profile-card">
                    <div class="d-flex align-items-center gap-3 flex-wrap flex-sm-nowrap justify-content-center justify-content-sm-start">
                        {{-- Logo Toko --}}
                        <img src="{{ $data->foto ? asset('storage/' . $data->foto) : asset('img/default-shop.png') }}" class="rounded-circle shadow border border-3 border-white shop-logo-display flex-shrink-0" alt="{{ $data->nama }}" style="width: 100px; height: 100px; object-fit: cover;">
                        
                        <div>
                            <h4 class="fw-bold text-dark mb-1">{{ $data->nama }}</h4>
                            {{-- Rating & Bintang --}}
                            <div class="d-flex align-items-center justify-content-center justify-content-sm-start mb-2 gap-1" style="font-size: 0.85rem;">
                                <span class="text-warning">
                                    @for($i=1; $i<=5; $i++)
                                        @if($i <= round($data->overall_rating))
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </span>
                                <span class="text-secondary fw-semibold">({{ $data->overall_rating }} / 5)</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card Tabel Data Toko --}}
                <div class="card border-0 shadow rounded-4 p-4 mb-4 bg-white shop-info-card">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-info-circle me-2 text-success"></i> Informasi Toko</h5>
                    <div class="table-responsive">
                        <table class="table table-borderless mb-0 align-middle shop-info-table" style="font-size: 0.92rem;">
                            <tbody>
                                <tr>
                                    <td class="text-secondary ps-0 py-2" style="width: 35%;">Email</td>
                                    <td class="text-dark fw-medium py-2">{{ $data->email }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary ps-0 py-2">Telepon</td>
                                    <td class="text-dark fw-medium py-2">{{ $data->phone }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary ps-0 py-2">Wilayah</td>
                                    <td class="text-dark fw-medium py-2">{{ $data->region ?: 'Indonesia' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary ps-0 py-2">Tahun Berdiri</td>
                                    <td class="text-dark fw-medium py-2">{{ $data->year_started ?: '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary ps-0 py-2">Alamat</td>
                                    <td class="text-dark fw-medium py-2">{{ $data->alamat }}</td>
                                </tr>
                                @if($data->link_tiktok || $data->link_ig || $data->link_fb)
                                <tr>
                                    <td class="text-secondary ps-0 py-2">Media Sosial</td>
                                    <td class="py-2">
                                        <div class="d-flex gap-2">
                                            @if($data->link_tiktok)
                                                <a href="{{ $data->link_tiktok }}" target="_blank" class="btn btn-light btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center border" style="width: 32px; height: 32px;" title="TikTok"><i class="bi bi-tiktok text-dark"></i></a>
                                            @endif
                                            @if($data->link_ig)
                                                <a href="{{ $data->link_ig }}" target="_blank" class="btn btn-light btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center border" style="width: 32px; height: 32px;" title="Instagram"><i class="bi bi-instagram text-danger"></i></a>
                                            @endif
                                            @if($data->link_fb)
                                                <a href="{{ $data->link_fb }}" target="_blank" class="btn btn-light btn-sm rounded-circle p-0 d-flex align-items-center justify-content-center border" style="width: 32px; height: 32px;" title="Facebook"><i class="bi bi-facebook text-primary"></i></a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Card Statistik Toko (Required by Tests & Great for UX) --}}
                <div class="card border-0 shadow rounded-4 p-4 mb-4 bg-white shop-stats-card">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-bar-chart-line me-2 text-success"></i> Statistik Toko</h5>
                    
                    @php
                        $totalProducts = $products->count();
                        $bestSeller = $products->sortByDesc(function($product) {
                            return $product->total_sold;
                        })->first();
                        $hasSales = $bestSeller && $bestSeller->total_sold > 0;
                    @endphp

                    <div class="mb-3">
                        <span class="text-secondary d-block mb-1" style="font-size: 0.88rem;">Jumlah Produk</span>
                        <span class="fw-bold text-dark fs-5">{{ $totalProducts }} produk</span>
                    </div>

                    <div>
                        <span class="text-secondary d-block mb-1" style="font-size: 0.88rem;">Produk Terlaris</span>
                        @if($hasSales)
                            <span class="fw-bold text-dark fs-6">{{ $bestSeller->name }} ({{ $bestSeller->total_sold }} terjual)</span>
                        @else
                            <span class="text-muted" style="font-size: 0.95rem;">Belum ada produk terjual</span>
                        @endif
                    </div>
                </div>

                {{-- Card Deskripsi Toko --}}
                <div class="card border-0 shadow rounded-4 p-4 mb-4 bg-white shop-description-card">
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-file-text me-2 text-success"></i> Deskripsi Toko</h5>
                    <div class="text-secondary leading-relaxed" style="font-size: 0.92rem;">
                        {!! $data->deskripsi ?: '<p class="text-muted mb-0">Belum ada deskripsi.</p>' !!}
                    </div>
                </div>

                {{-- Tombol Aksi Pemilik (Edit & Hapus Sejajar) --}}
                <div class="d-flex align-items-center gap-2 mb-4">
                    {{-- Button Edit --}}
                    <a href="{{ route('Toko.edit', $data->id) }}" class="btn btn-warning rounded-pill flex-grow-1 fw-semibold py-2 d-inline-flex align-items-center justify-content-center gap-1 btn-owner shadow-sm">
                        <i class="bi bi-pencil-square"></i> Edit Profil
                    </a>
                    
                    {{-- Button Hapus --}}
                    <form action="{{ route('Toko.destroy', $data->id) }}" method="POST" class="flex-grow-1" onsubmit="return confirm('Apakah Anda yakin ingin menghapus toko ini secara permanen?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill w-100 fw-semibold py-2 d-inline-flex align-items-center justify-content-center gap-1 btn-owner shadow-sm">
                            <i class="bi bi-trash-fill"></i> Hapus Toko
                        </button>
                    </form>
                </div>

            </div>

            {{-- GRID KANAN (Aksi Dashboard & Katalog Produk) --}}
            <div class="col-12 col-lg-7">
                
                {{-- Area Dashboard Toko --}}
                <div class="d-flex justify-content-end mb-4">
                    <a href="/dashboard" class="btn btn-success rounded-pill px-4 py-2.5 fw-semibold d-inline-flex align-items-center gap-2 shadow-sm btn-dashboard-toko">
                        <i class="bi bi-speedometer2" style="font-size: 1.1rem;"></i> Dashboard Toko
                    </a>
                </div>

                {{-- Katalog Produk Toko --}}
                <div class="card border-0 shadow rounded-4 p-4 bg-white shop-products-card">
                    <h4 class="fw-bold text-dark mb-4 d-flex align-items-center">
                        <i class="bi bi-bag-check-fill me-2 text-success"></i> Katalog Produk Toko
                    </h4>
                    <hr class="mb-4 opacity-10">

                    {{-- Form Pencarian & Filter Terpadu --}}
                    <form action="{{ request()->url() }}" method="GET" id="filter-search-form" class="mb-4">
                        <div class="row g-2">
                            {{-- Input Pencarian --}}
                            <div class="col-12 col-md-7">
                                <div class="input-group shadow-sm rounded-pill overflow-hidden border filter-input-group">
                                    <span class="input-group-text bg-white border-0 ps-3 text-secondary">
                                        <i class="bi bi-search"></i>
                                    </span>
                                    <input type="text" name="search" class="form-control border-0 ps-2 py-2.5 shadow-none bg-white text-dark" placeholder="Cari produk toko..." value="{{ request('search') }}">
                                    @if(request('search') || request('sort'))
                                        <a href="{{ request()->url() }}" class="btn btn-link text-secondary bg-white border-0 pe-3 d-flex align-items-center justify-content-center text-decoration-none btn-clear-filter" title="Reset Pencarian & Filter">
                                            <i class="bi bi-x-circle-fill"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                            
                            {{-- Dropdown Sorting --}}
                            <div class="col-12 col-md-5">
                                <div class="shadow-sm rounded-pill overflow-hidden border filter-select-group">
                                    <select name="sort" class="form-select border-0 py-2.5 px-3 shadow-none bg-white text-dark" onchange="document.getElementById('filter-search-form').submit()">
                                        <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>Terlama</option>
                                        <option value="terlaris" {{ request('sort') == 'terlaris' ? 'selected' : '' }}>Terlaris</option>
                                        <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga: Terendah</option>
                                        <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga: Tertinggi</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if($products->isEmpty())
                        <div class="text-center py-5">
                            <i class="bi bi-bag-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-secondary mt-3 mb-0">Toko ini belum menambahkan produk.</p>
                        </div>
                    @else
                        <div class="row row-cols-2 row-cols-md-3 g-3">
                            @foreach($products as $produk)
                                <div class="col d-flex">
                                    <div class="card shadow-sm card-product h-100 w-100 border-0 rounded-3 overflow-hidden bg-white hover-zoom-container">
                                        <a href="{{ URL::to('produk/'.$produk->slug ) }}" class="text-decoration-none h-100 d-flex flex-column text-dark">
                                            {{-- Foto Produk --}}
                                            <img src="{{ $produk->image_url }}" class="card-img-top" alt="{{ $produk->name }}" style="height: 160px; object-fit: cover; border-bottom: 1px solid rgba(0,0,0,0.03);">
                                            
                                            {{-- Detail Singkat --}}
                                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                                                <div>
                                                    <p class="product-name-title fw-semibold mb-1 text-truncate text-dark" style="font-size: 0.95rem;">{{ $produk->name }}</p>
                                                    <div class="d-flex align-items-center mb-2" style="font-size: 0.75rem; gap: 4px;">
                                                        <span class="text-warning d-inline-flex align-items-center"><i class="bi bi-star-fill me-1"></i> {{ $produk->average_rating }}</span>
                                                        <span class="text-muted">|</span>
                                                        <span class="text-secondary">{{ $produk->total_sold ?? 0 }} Terjual</span>
                                                    </div>
                                                </div>
                                                <p class="fw-bold text-success mb-0" style="font-size: 1.05rem;">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

            </div>

        </div>

    </div>
</section>

{{-- Custom CSS untuk Tampilan Halaman Utama Profil Toko Premium --}}
<style>
    /* Form Search & Filter Premium Styling */
    .filter-input-group, .filter-select-group {
        border-color: rgba(0,0,0,0.06) !important;
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .filter-input-group:focus-within, .filter-select-group:focus-within {
        border-color: #198754 !important;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.15) !important;
    }

    .dark-mode .filter-input-group,
    .dark-mode .filter-input-group .input-group-text,
    .dark-mode .filter-input-group input,
    .dark-mode .filter-input-group .btn-clear-filter,
    .dark-mode .filter-select-group,
    .dark-mode .filter-select-group select {
        background-color: #242424 !important;
        color: #ffffff !important;
        border-color: rgba(255,255,255,0.08) !important;
    }

    .dark-mode .filter-input-group input::placeholder {
        color: #888888 !important;
    }

    .dark-mode .btn-clear-filter {
        color: #b0b0b0 !important;
    }
    .dark-mode .btn-clear-filter:hover {
        color: #ffffff !important;
    }

    /* Styling khusus detail toko */
    .tokodetail {
        background-color: var(--bs-body-bg);
        padding-top: 95px !important; /* Push down content to prevent overlap with fixed navbar */
    }

    .shop-profile-card, .shop-info-card, .shop-stats-card, .shop-description-card, .shop-products-card {
        background-color: #ffffff;
    }
    .dark-mode .shop-profile-card, 
    .dark-mode .shop-info-card, 
    .dark-mode .shop-stats-card,
    .dark-mode .shop-description-card, 
    .dark-mode .shop-products-card {
        background-color: #1e1e1e !important;
    }

    .dark-mode .text-dark, .dark-mode h4, .dark-mode h5, .dark-mode td {
        color: #ffffff !important;
    }
    .dark-mode .text-secondary {
        color: #b0b0b0 !important;
    }
    .dark-mode td.text-secondary {
        color: #b0b0b0 !important;
    }

    /* Info Table styling */
    .shop-info-table td {
        border: none;
    }
    .dark-mode .shop-info-table td {
        background-color: transparent !important;
    }

    /* Zoom Hover for Cards */
    .hover-zoom-container {
        overflow: hidden;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border: 1px solid rgba(0,0,0,0.04) !important;
    }
    .hover-zoom-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
    }
    .dark-mode .hover-zoom-container {
        border-color: rgba(255,255,255,0.06) !important;
    }

    /* Button Styling */
    .btn-follow {
        background-color: #198754 !important;
        border-color: #198754 !important;
        color: #ffffff !important;
    }
    .btn-follow:hover {
        background-color: #157347 !important;
        border-color: #146c43 !important;
        box-shadow: 0 4px 8px rgba(25, 135, 84, 0.15);
    }
    .btn-chat {
        border-color: #198754 !important;
        color: #198754 !important;
    }
    .btn-chat:hover {
        background-color: #198754 !important;
        color: #ffffff !important;
    }
    .dark-mode .btn-chat {
        border-color: #198754 !important;
        color: #198754 !important;
    }
    .dark-mode .btn-chat:hover {
        background-color: #198754 !important;
        color: #ffffff !important;
    }

    .btn-owner {
        transition: all 0.2s ease-in-out;
    }
    .btn-owner:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0,0,0,0.1) !important;
    }

    .btn-dashboard-toko {
        background-color: #198754 !important;
        border-color: #198754 !important;
        color: #ffffff !important;
        transition: all 0.2s ease-in-out;
    }
    .btn-dashboard-toko:hover {
        background-color: #157347 !important;
        border-color: #146c43 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(25, 135, 84, 0.2) !important;
    }

    .tokoname:hover {
        color: #157347 !important;
    }
</style>
@endsection