<div>
    <style>
        .sticky-checkout-bar {
            position: sticky;
            bottom: 3rem;
            z-index: 1020;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            -webkit-backdrop-filter: blur(10px);
            box-shadow: 0 -10px 30px rgba(0, 0, 0, 0.08) !important;
            border-top: 1px solid rgba(0, 0, 0, 0.08) !important;
            border-left: 1px solid rgba(0, 0, 0, 0.05) !important;
            border-right: 1px solid rgba(0, 0, 0, 0.05) !important;
            border-radius: 16px 16px 0 0 !important;
            margin-bottom: 3rem !important;
            margin-top: 3rem !important;
        }
        
        .hover-primary:hover {
            color: #198754 !important;
            text-decoration: underline !important;
            transition: color 0.15s ease-in-out;
        }

        .img-zoom {
            transition: transform 0.2s ease-in-out;
        }

        .img-zoom:hover {
            transform: scale(1.05);
        }
    </style>

    <div class="cart-content">
        <div class="cart-tittle text-center mb-5">
            <h1>Keranjang Belanjamu!</h1>
            <h4>Ayok Checkout barangmu sebelum kehabisan!</h4>
            <!-- Loading indicator -->
            <div wire:loading class="spinner-border text-success" role="status">
              <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        <hr>

        <!-- Alerts for feedback -->
        @if(session()->has('warning'))
            <div class="alert alert-warning alert-dismissible fade show mb-4 shadow-sm border-0 d-flex align-items-center" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2 fs-5"></i>
                <div class="fw-semibold">
                    {{ session('warning') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if($itemcart && $itemcart->detail->count() > 0)
        <!-- Desktop Table View (visible on screen sizes md and up) -->
        <div class="d-none d-md-block shadow-sm rounded bg-white p-3 mb-4 border border-light">
            <table class="table table-striped table-sm align-middle">
              <thead>
                <tr>
                    <th scope="col" style="width: 8%;" class="text-center">
                        <div class="d-flex flex-column align-items-center">
                            <span class="text-muted small mb-1" style="font-size: 0.75rem;">Pilih Semua</span>
                            <input type="checkbox" wire:click="toggleSelectAll" id="select-all-checkbox" class="form-check-input" style="width: 1.25rem; height: 1.25rem; cursor: pointer;" {{ $this->isAllSelected() ? 'checked' : '' }}>
                        </div>
                    </th>
                    <th scope="col" style="width: 42%;">Produk</th>
                    <th scope="col" style="width: 15%;" class="text-center">Harga</th>
                    <th scope="col" style="width: 12%;" class="text-center">Kuantitas</th>
                    <th scope="col" style="width: 15%;" class="text-center">Total</th>
                    <th scope="col" style="width: 8%;" class="text-center">Hapus</th>
                </tr>
              </thead>
              <tbody>
                @foreach($itemcart->detail as $detail)
                    <tr wire:key="detail-desktop-{{ $detail->id }}">
                        <td class="text-center align-middle">
                            <input type="checkbox" wire:model.live="selectedItems" value="{{ $detail->id }}" class="form-check-input" style="width: 1.35rem; height: 1.35rem; cursor: pointer;">
                        </td>
                        <td class="product-info align-middle">
                            <div class="d-flex align-items-center">
                                <a href="{{ URL::to('produk/' . $detail->produk->slug) }}" class="text-decoration-none me-3">
                                    <img src="{{ $detail->produk->image_url }}" alt="{{ $detail->produk->name }}" class="rounded shadow-sm img-zoom" style="width: 100px; height: 100px; object-fit: cover; border: 1px solid #eef2f6;">
                                </a>
                                <div class="d-flex flex-column">
                                    <a href="{{ URL::to('produk/' . $detail->produk->slug) }}" class="text-decoration-none">
                                        <span class="product-name fw-semibold text-dark mb-1 hover-primary">{{ $detail->produk->name }}</span>
                                    </a>
                                    @if($detail->produk->toko)
                                        <a href="{{ URL::to('Toko/' . $detail->produk->toko->id) }}" class="text-success text-decoration-none small d-flex align-items-center mt-1" style="font-size: 0.85rem; font-weight: 500;">
                                            <i class="bi bi-shop me-1"></i> {{ $detail->produk->toko->nama }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="text-center align-middle">
                            <span class="product-name">Rp {{ number_format($detail->produk->harga, 0, ',', '.') }}</span>
                        </td>
                        <td class="cart-jml text-center align-middle ps-2">
                            <div class="btn-group" role="group">
                                <button wire:click="decrementQty({{ $detail->id }})" wire:loading.attr="disabled" class="tombol-kurang-cart rounded">
                                  -
                                </button>
                                <button class="tombol-qty me-1 ms-1" disabled="true">
                                  {{ number_format($detail->qty, 0) }}
                                </button>
                                <button wire:click="incrementQty({{ $detail->id }})" wire:loading.attr="disabled" class="tombol-tambah-cart rounded">
                                  +
                                </button>
                            </div>        
                        </td>
                        <td class="text-center align-middle">
                            <span class="product-name fw-semibold text-success">               
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </span>
                        </td>
                        <td class="text-center align-middle">
                            <button wire:click="removeItem({{ $detail->id }})" wire:loading.attr="disabled" class="tombol-hapus-cart rounded btn-sm">
                              Hapus
                            </button>                    
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
        </div>

        <!-- Mobile Card View (visible on screen sizes smaller than md) -->
        <div class="d-md-none mb-4">
            <!-- Select All Checkbox on Mobile -->
            <div class="d-flex align-items-center bg-white p-3 rounded shadow-sm mb-3 border border-light">
                <input type="checkbox" wire:click="toggleSelectAll" id="select-all-checkbox-mobile" class="form-check-input me-2" style="width: 1.25rem; height: 1.25rem; cursor: pointer;" {{ $this->isAllSelected() ? 'checked' : '' }}>
                <label for="select-all-checkbox-mobile" class="fw-semibold text-dark mb-0" style="font-size: 0.95rem; cursor: pointer;">Pilih Semua Produk</label>
            </div>

            @foreach($itemcart->detail as $detail)
                <div class="card mb-3 shadow-sm border-0 rounded-3 p-3 bg-white border border-light" wire:key="detail-mobile-{{ $detail->id }}">
                    <div class="d-flex align-items-start">
                        <!-- Checkbox -->
                        <div class="me-2 pt-1">
                            <input type="checkbox" wire:model.live="selectedItems" value="{{ $detail->id }}" class="form-check-input" style="width: 1.35rem; height: 1.35rem; cursor: pointer;">
                        </div>
                        
                        <!-- Product Image -->
                        <a href="{{ URL::to('produk/' . $detail->produk->slug) }}" class="text-decoration-none">
                            <img src="{{ $detail->produk->image_url }}" alt="{{ $detail->produk->name }}" class="rounded shadow-sm me-3 img-zoom" style="width: 80px; height: 80px; object-fit: cover; border: 1px solid #eef2f6;">
                        </a>
                        
                        <!-- Details -->
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="d-flex flex-column">
                                    <a href="{{ URL::to('produk/' . $detail->produk->slug) }}" class="text-decoration-none">
                                        <span class="product-name fw-semibold text-dark mb-1 hover-primary" style="font-size: 0.95rem; line-height: 1.2;">{{ $detail->produk->name }}</span>
                                    </a>
                                    @if($detail->produk->toko)
                                        <a href="{{ URL::to('Toko/' . $detail->produk->toko->id) }}" class="text-success text-decoration-none small d-flex align-items-center mt-1" style="font-size: 0.8rem; font-weight: 500;">
                                            <i class="bi bi-shop me-1"></i> {{ $detail->produk->toko->nama }}
                                        </a>
                                    @endif
                                </div>
                                <button wire:click="removeItem({{ $detail->id }})" wire:loading.attr="disabled" class="btn p-0 border-0 text-danger ms-2 bg-transparent" title="Hapus Produk">
                                    <i class="bi bi-trash fs-5"></i>
                                </button>
                            </div>
                            
                            <!-- Price and controls -->
                            <div class="mt-3 d-flex flex-wrap justify-content-between align-items-center">
                                <div>
                                    <div class="text-muted small" style="font-size: 0.75rem;">Harga Satuan</div>
                                    <div class="fw-semibold text-dark" style="font-size: 0.9rem;">Rp {{ number_format($detail->produk->harga, 0, ',', '.') }}</div>
                                </div>
                                
                                <div class="btn-group" role="group">
                                    <button wire:click="decrementQty({{ $detail->id }})" wire:loading.attr="disabled" class="tombol-kurang-cart rounded px-2 py-1">
                                      -
                                    </button>
                                    <button class="tombol-qty mx-1 px-2 border-0 bg-transparent" disabled>
                                      {{ $detail->qty }}
                                    </button>
                                    <button wire:click="incrementQty({{ $detail->id }})" wire:loading.attr="disabled" class="tombol-tambah-cart rounded px-2 py-1">
                                      +
                                    </button>
                                </div>
                            </div>
                            
                            <hr class="my-2 border-light">
                            
                            <!-- Subtotal -->
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="text-muted small" style="font-size: 0.8rem;">Subtotal:</span>
                                <span class="fw-bold text-success" style="font-size: 0.95rem;">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
    <!-- Checkout Summary Sticky Bar -->
    <div class="cart-checkout sticky-checkout-bar shadow p-2 bg-white">
        <div class="container-fluid px-4 py-3">
            <div class="row align-items-center gy-3">
                <div class="col-12 col-md-4 text-center text-md-start">
                    <h5 class="mb-1 text-secondary" style="font-size: 0.9rem; font-weight: 500;">Ringkasan Belanja</h5>
                    <span class="fw-semibold text-dark" style="font-size: 1.05rem;">
                        Total Produk Pilihan: <span class="text-success fw-bold">{{ count($selectedItems) }}</span> Item
                    </span>
                </div>
                <div class="col-6 col-md-3 text-center text-md-start">
                    <div class="text-secondary small" style="font-size: 0.75rem;">Total Harga Checkout</div>
                    <span class="fw-bold fs-4 text-success">Rp {{ number_format($selectedTotal, 0, ',', '.') }}</span>
                </div>
                <div class="col-6 col-md-2 text-center">
                    <button wire:click="emptyCart({{ $itemcart->id }})" wire:loading.attr="disabled" class="btn btn-outline-danger w-100 fw-semibold rounded">
                        Kosongkan
                    </button>
                </div>
                <div class="col-12 col-md-3">
                    <button wire:click="proceedToCheckout" wire:loading.attr="disabled" class="btn submit-login d-block w-100 py-2.5 fs-5 fw-bold text-white shadow-sm transition-all rounded" style="transition: all 0.2s ease;">
                        Checkout
                    </button>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="text-center my-5 py-5 shadow-sm rounded bg-white border border-light">
            <div class="mb-3 text-muted">
                <i class="bi bi-cart-x" style="font-size: 4rem;"></i>
            </div>
            <p class="fs-4 fw-semibold text-dark">Keranjang belanja Anda kosong.</p>
            <p class="text-secondary">Anda belum menambahkan produk apapun ke dalam keranjang.</p>
            <a href="/" class="btn btn-success mt-3 px-4 py-2 fw-semibold rounded shadow-sm">Mulai Belanja</a>
        </div>
    @endif
</div>
