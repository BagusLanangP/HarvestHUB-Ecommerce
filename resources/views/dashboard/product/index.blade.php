@extends('dashboard.layouts.main')

@section('container')

<div class="py-2">

  {{-- Header Panel --}}
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
    <h1 class="h3 fw-bold text-dark mb-0" style="font-family: 'Outfit', sans-serif;">
      <i class="bi bi-box-seam text-success me-2"></i>{{ $title }}
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0 gap-2 align-items-center">
      <div class="btn-group shadow-xs">
        <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1.5 fw-medium rounded-start-3 px-3 py-1.5" style="font-size: 0.78rem;">
          <i class="bi bi-share"></i> Share
        </button>
        <button type="button" class="btn btn-outline-secondary d-flex align-items-center gap-1.5 fw-medium rounded-end-3 px-3 py-1.5" style="font-size: 0.78rem;">
          <i class="bi bi-download"></i> Export
        </button>
      </div>
      <button type="button" class="btn btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1.5 fw-medium shadow-xs rounded-3 px-3 py-1.5" style="font-size: 0.78rem; margin-right: 4px;">
        <i class="bi bi-calendar3"></i> This week
      </button>
      
      @can('toko1')
      <a href="/dashboard/product/create" class="btn btn-success d-flex align-items-center gap-1.5 fw-semibold shadow-xs rounded-3 px-3 py-1.5" style="font-size: 0.78rem;">
        <i class="bi bi-plus-circle"></i> Tambah Produk
      </a>
      @endcan
    </div>
  </div>

  {{-- Flash Messages --}}
  @if(session('success'))
      <div class="alert alert-success rounded-4 shadow-xs border-0 mb-4 d-flex align-items-center gap-2" style="background-color: rgba(25, 135, 84, 0.1); color: #198754;">
          <i class="bi bi-check-circle-fill fs-5"></i>
          <span class="small fw-semibold">{{ session('success') }}</span>
      </div>
  @endif

  {{-- Table Container with Shadow --}}
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
    <div class="table-responsive small">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th scope="col" class="ps-4">No</th>
            <th scope="col">Nama Produk</th>
            <th scope="col">Kategori</th>
            <th scope="col">Harga</th>
            <th scope="col" class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse( $Products as $product)
          <tr>
            <td class="ps-4 fw-semibold text-secondary" style="font-size: 0.85rem;">{{ $loop->iteration }}</td>
            <td>
              <div class="d-flex align-items-center gap-3">
                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="rounded-3 shadow-xs border" style="width: 50px; height: 50px; object-fit: cover;" >
                <span class="product-name text-dark" style="font-size: 0.88rem;">{{ $product->name }}</span>
              </div>
            </td>
            <td>
              <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1.5 fw-semibold small" style="font-size: 0.72rem;">
                {{ $product->kategori->productName ?? 'Kategori' }}
              </span>
            </td>
            <td class="text-success fw-bold" style="font-size: 0.88rem;">Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
            <td class="pe-4 text-end">
              <div class="d-inline-flex gap-1">
                <a href="/dashboard/product/{{ $product->id}}" class="btn btn-sm btn-info text-white rounded-3 px-2.5 py-1.5" title="Lihat Detail">
                    <i class="bi bi-eye-fill"></i>
                </a>
                 @can('toko1') 
                <a href="/dashboard/product/{{ $product->id }}/edit" class="btn btn-sm btn-warning text-dark rounded-3 px-2.5 py-1.5" title="Edit Produk">
                    <i class="bi bi-pencil-fill"></i>
                </a>
                <form action="{{ route('product.destroy', $product->id) }}" method="post" class="d-inline">
                  @csrf
                  @method('delete')
                  <button type="submit" class="btn btn-sm btn-danger rounded-3 px-2.5 py-1.5" onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')" title="Hapus Produk">
                    <i class="bi bi-trash-fill"></i>
                  </button>                    
                </form>
                @endcan
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center py-5 text-secondary">
              <i class="bi bi-box-seam text-muted d-block mb-2" style="font-size: 2.5rem;"></i>
              <span class="fw-semibold">Belum ada produk terdaftar</span>
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

@endsection