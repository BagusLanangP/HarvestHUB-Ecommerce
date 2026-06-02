@extends('layouts.mainlayouts')

@section('tittle', 'Riwayat Transaksi Premium')

@section('content')
<section class="transaction-history-section py-5">
    <div class="container py-4">
        
        <div class="row mb-5 text-center">
            <div class="history-title-container">
                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 mb-2 fw-semibold">
                    <i class="bi bi-clock-history me-1"></i> Transaksi Saya
                </span>
                <h2 class="fw-bold text-dark mb-1">Riwayat Transaksi</h2>
                <p class="text-secondary">Kelola, tinjau, dan pantau status pesanan belanja Anda di HarvestHUB</p>
            </div>
        </div>

        @if(session('success'))
            <div class="row">
                <div class="col-12 col-lg-8 mx-auto">
                    <div class="alert alert-success alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="row">
                <div class="col-12 col-lg-8 mx-auto">
                    <div class="alert alert-danger alert-dismissible fade show rounded-4 shadow-sm mb-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                
                @if($transactions->isEmpty())
                    <div class="card border-0 shadow rounded-4 p-5 text-center bg-white empty-card">
                        <div class="rounded-circle bg-light text-muted d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-bag-x" style="font-size: 3rem;"></i>
                        </div>
                        <h4 class="fw-bold text-dark mb-2">Belum Ada Transaksi</h4>
                        <p class="text-secondary px-sm-5 mb-4">Anda belum melakukan pembelian produk apa pun di platform kami. Ayo mulai berbelanja hasil tani segar langsung dari petani!</p>
                        <div>
                            <a href="/cari" class="btn btn-success rounded-pill px-4 py-2.5 fw-semibold shadow-sm">
                                <i class="bi bi-cart-plus me-1"></i> Mulai Belanja
                            </a>
                        </div>
                    </div>
                @else
                    
                    {{-- TRANSACTIONS CARD LOOP --}}
                    @foreach($transactions as $trx)
                        <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden bg-white transaction-card transition-all">
                            
                            {{-- Header Card --}}
                            <div class="card-header border-0 py-3.5 px-4 d-flex flex-wrap align-items-center justify-content-between gap-3 bg-light-subtle">
                                <div class="d-flex align-items-center gap-2.5 flex-wrap">
                                    <span class="text-dark fw-bold" style="font-size: 0.95rem;">
                                        Invoice: <span class="text-success">{{ $trx->order->cart->no_invoice }}</span>
                                    </span>
                                    <span class="text-muted d-none d-sm-inline">|</span>
                                    <span class="text-secondary small fw-medium">
                                        <i class="bi bi-calendar-event me-1"></i>{{ $trx->created_at->format('d M Y, H:i') }}
                                    </span>
                                </div>
                                
                                <div class="d-flex align-items-center gap-2">
                                    {{-- Lihat Nota Shortcut --}}
                                    <a href="{{ route('transaksi.nota', $trx->id) }}" class="btn btn-sm btn-white border text-success fw-semibold rounded-pill px-3 py-1 d-inline-flex align-items-center gap-1 shadow-xs btn-lihat-nota" title="Lihat struk nota detail">
                                        <i class="bi bi-file-earmark-text"></i> Lihat Nota
                                    </a>
                                    
                                    {{-- Status Badge --}}
                                    <span class="badge rounded-pill px-3 py-1.5 fw-semibold d-inline-flex align-items-center gap-1 shadow-xs
                                        {{ $trx->status == 'Completed' ? 'bg-success text-white' : ($trx->status == 'Pending' ? 'bg-warning text-dark' : 'bg-danger text-white') }}">
                                        @if($trx->status == 'Completed')
                                            <i class="bi bi-check-circle-fill" style="font-size: 0.8rem;"></i> Selesai
                                        @elseif($trx->status == 'Pending')
                                            <i class="bi bi-hourglass-split" style="font-size: 0.8rem;"></i> Pending
                                        @else
                                            <i class="bi bi-x-circle-fill" style="font-size: 0.8rem;"></i> Dibatalkan
                                        @endif
                                    </span>
                                </div>
                            </div>
                            
                            {{-- Body Card - List Items --}}
                            <div class="card-body p-4 border-0">
                                
                                <ul class="list-group list-group-flush mb-0">
                                    @foreach($trx->order->cart->detail as $detail)
                                    <li class="list-group-item d-flex flex-wrap flex-sm-nowrap align-items-start justify-content-between gap-3 border-light ps-0 pe-0 py-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $detail->produk->image_url }}" alt="{{ $detail->produk->name }}" style="width: 60px; height: 60px; object-fit: cover;" class="rounded-3 shadow-xs border">
                                            <div>
                                                <h6 class="mb-1 text-dark fw-bold">{{ $detail->produk->name }}</h6>
                                                
                                                {{-- Eager Loaded Store Name & Link --}}
                                                <span class="text-secondary small d-block mb-1.5">
                                                    <i class="bi bi-shop text-success me-1"></i>Toko: 
                                                    <a href="/Toko/{{ $detail->produk->toko->id ?? '#' }}" class="text-decoration-none text-success fw-semibold hover-underline">
                                                        {{ $detail->produk->toko->nama ?? 'Harvest Toko' }}
                                                    </a>
                                                </span>
                                                
                                                <small class="text-muted d-block fw-medium">
                                                    {{ $detail->qty }} x <span class="text-success fw-semibold">Rp {{ number_format($detail->harga, 0, ',', '.') }}</span>
                                                </small>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex flex-column align-items-end gap-2 justify-content-center h-100 flex-shrink-0">
                                            {{-- Chat Penjual WhatsApp --}}
                                            @if(isset($detail->produk->toko->phone))
                                                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $detail->produk->toko->phone) }}?text=Halo%20Toko%20{{ urlencode($detail->produk->toko->nama) }},%20saya%20ingin%20bertanya%20mengenai%20pesanan%20saya%20dengan%20Invoice%20{{ $trx->order->cart->no_invoice }}" target="_blank" class="btn btn-sm btn-outline-success rounded-pill d-inline-flex align-items-center gap-1 btn-chat-wa py-1.5 px-3">
                                                    <i class="bi bi-whatsapp"></i> Chat Penjual
                                                </a>
                                            @endif

                                            @if($trx->status == 'Completed')
                                                <a href="{{ route('review.create', ['transaction' => $trx->id, 'product' => $detail->produk->id]) }}" class="btn btn-sm btn-outline-primary rounded-pill d-inline-flex align-items-center gap-1 py-1.5 px-3">
                                                    <i class="bi bi-pencil-square"></i> Tulis Ulasan
                                                </a>
                                            @endif
                                        </div>
                                    </li>
                                    @endforeach
                                </ul>
                                
                            </div>

                            {{-- Footer Card --}}
                            <div class="card-footer border-0 py-3.5 px-4 bg-light-subtle d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <span class="text-secondary small fw-medium d-block">Total Belanja:</span>
                                    <h4 class="fw-bold text-success mb-0" style="font-size: 1.25rem;">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</h4>
                                </div>
                                
                                <div class="d-flex align-items-center gap-2">
                                    @if($trx->status == 'Pending')
                                        {{-- Batalkan Pesanan (Cancel Button) --}}
                                        <form action="{{ route('transaksi.cancel', $trx->id) }}" method="POST" class="d-inline m-0" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini secara permanen?')">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill px-3.5 py-2 fw-semibold hover-btn-cancel">
                                                <i class="bi bi-x-circle me-1"></i> Batalkan Pesanan
                                            </button>
                                        </form>

                                        {{-- Pesanan Diterima (Selesaikan - Triggering Modal) --}}
                                        <button type="button" class="btn btn-success btn-sm rounded-pill px-4 py-2 fw-semibold shadow-sm btn-complete-trigger" data-id="{{ $trx->id }}">
                                            <i class="bi bi-check-circle-fill me-1"></i> Pesanan Diterima
                                        </button>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach

                @endif

            </div>
        </div>

    </div>
</section>

<!-- BOOTSTRAP MODAL KONFIRMASI PENERIMAAN PESANAN -->
<div class="modal fade" id="confirmCompleteModal" tabindex="-1" aria-labelledby="confirmCompleteModalLabel" aria-hidden="true" style="z-index: 1060;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden bg-white">
            <div class="modal-header border-0 bg-success text-white py-3.5">
                <h5 class="modal-title fw-bold" id="confirmCompleteModalLabel">
                    <i class="bi bi-shield-check me-2" style="font-size: 1.2rem;"></i>Konfirmasi Pesanan Selesai
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-4">
                <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mb-3 shadow-xs" style="width: 75px; height: 75px;">
                    <i class="bi bi-patch-check-fill" style="font-size: 2.8rem;"></i>
                </div>
                <h5 class="fw-bold text-dark mb-2" style="font-size: 1.15rem;">Apakah pesanan Anda sudah selesai?</h5>
                <p class="text-secondary small mb-0 px-2 leading-relaxed">Dengan mengonfirmasi pesanan diterima, dana transaksi akan diteruskan ke penjual dan status pesanan ini akan diselesaikan secara permanen.</p>
            </div>
            <div class="modal-footer border-0 p-3 bg-light d-flex gap-2">
                <button type="button" class="btn btn-light border rounded-pill py-2.5 flex-grow-1 text-secondary fw-semibold" data-bs-dismiss="modal">Belum Selesai</button>
                <form id="complete-order-form" action="" method="POST" class="flex-grow-1 m-0">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success rounded-pill py-2.5 w-100 fw-bold shadow-xs">Ya, Selesai</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // TRIGGER BOOTSTRAP MODAL KONFIRMASI SELESAI PESANAN
        const completeTriggers = document.querySelectorAll('.btn-complete-trigger');
        const completeForm = document.getElementById('complete-order-form');
        const confirmModalEl = document.getElementById('confirmCompleteModal');
        
        // Cek ketersediaan modal element
        if (confirmModalEl && completeTriggers.length > 0) {
            const bootstrapModal = new bootstrap.Modal(confirmModalEl);
            
            completeTriggers.forEach(button => {
                button.addEventListener('click', function() {
                    const trxId = this.getAttribute('data-id');
                    completeForm.action = `/transaksi/${trxId}/complete`;
                    bootstrapModal.show();
                });
            });
        }

    });
</script>

<style>
    .transaction-history-section {
        background-color: var(--bs-body-bg);
        padding-top: 95px !important;
    }

    .transaction-card {
        background-color: #ffffff;
        border: 1px solid rgba(0,0,0,0.03) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .transaction-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(0,0,0,0.04) !important;
    }

    .border-light {
        border-color: rgba(0,0,0,0.04) !important;
    }

    .btn-lihat-nota {
        background-color: #ffffff !important;
        border-color: rgba(0,0,0,0.08) !important;
        color: #198754 !important;
    }
    .btn-lihat-nota:hover {
        background-color: rgba(25, 135, 84, 0.05) !important;
        border-color: #198754 !important;
    }

    .btn-chat-wa {
        border-color: #25d366 !important;
        color: #25d366 !important;
        font-weight: 500;
        transition: all 0.2s ease-in-out;
    }
    .btn-chat-wa:hover {
        background-color: #25d366 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 8px rgba(37, 211, 102, 0.15) !important;
    }

    .hover-underline:hover {
        text-decoration: underline !important;
    }

    .hover-btn-cancel {
        transition: all 0.2s ease-in-out;
    }
    .hover-btn-cancel:hover {
        background-color: #dc3545 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.15) !important;
    }

    /* DARK MODE STYLING IN SCREEN */
    .dark-mode .transaction-card, .dark-mode .empty-card {
        background-color: #1e1e1e !important;
        border-color: rgba(255,255,255,0.04) !important;
    }
    
    .dark-mode .modal-content {
        background-color: #1e1e1e !important;
        color: #ffffff !important;
    }

    .dark-mode .text-dark, .dark-mode h2, .dark-mode h4, .dark-mode h5, .dark-mode h6, .dark-mode th, .dark-mode td {
        color: #ffffff !important;
    }
    .dark-mode .text-secondary {
        color: #b0b0b0 !important;
    }
    .dark-mode .bg-light-subtle {
        background-color: #262626 !important;
    }
    .dark-mode .border-light {
        border-color: rgba(255,255,255,0.06) !important;
    }
    .dark-mode .btn-lihat-nota {
        background-color: #262626 !important;
        border-color: rgba(255,255,255,0.06) !important;
        color: #198754 !important;
    }
    .dark-mode .btn-lihat-nota:hover {
        background-color: rgba(25, 135, 84, 0.1) !important;
    }
    .dark-mode .modal-footer {
        background-color: #262626 !important;
    }
    .dark-mode .modal-footer .btn-light {
        background-color: #333333 !important;
        color: #b0b0b0 !important;
        border-color: rgba(255,255,255,0.06) !important;
    }
</style>
@endsection
