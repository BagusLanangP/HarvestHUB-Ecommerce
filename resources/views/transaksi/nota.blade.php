@extends('layouts.mainlayouts')

@section('tittle', 'Nota Pembayaran - ' . $transaction->order->cart->no_invoice)

@section('content')

@php
    $alamat_raw = $transaction->order->alamat;
    $parts = explode(' | ', $alamat_raw);
    $alamat_clean = $parts[0] ?? '-';
    $koordinat = '-';
    $pengiriman = 'Diantar';
    $pembayaran = 'Cash';
    foreach ($parts as $part) {
        if (strpos($part, 'Koordinat:') === 0) {
            $koordinat = str_replace('Koordinat: ', '', $part);
        } elseif (strpos($part, 'Pengiriman:') === 0) {
            $pengiriman = str_replace('Pengiriman: ', '', $part);
        } elseif (strpos($part, 'Pembayaran:') === 0) {
            $pembayaran = str_replace('Pembayaran: ', '', $part);
        }
    }
@endphp

<section class="nota-section py-5">
    <div class="container py-4">
        
        <div class="row mb-4 text-center d-print-none">
            <div>
                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 mb-2 fw-semibold">
                    <i class="bi bi-check-circle-fill me-1"></i> Transaksi Berhasil Dibuat
                </span>
                <h3 class="fw-bold text-dark">Nota Belanja Anda</h3>
                <p class="text-secondary">Simpan nota ini sebagai bukti transaksi resmi Anda di HarvestHUB</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 mx-auto">
                
                {{-- STRUK NOTA FISIK-DIGITAL PREMIUM --}}
                <div class="receipt-container position-relative mb-4">
                    
                    <div class="receipt-card bg-white p-4 p-sm-5 shadow-lg rounded-4 border-0" id="nota-receipt-card">
                        
                        {{-- Header Toko & Invoice --}}
                        <div class="text-center mb-4">
                            <div class="d-flex align-items-center justify-content-center gap-2 mb-2">
                                <span class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center fw-bold shadow-sm" style="width: 32px; height: 32px; font-size: 1.1rem;">H</span>
                                <h4 class="fw-bold text-dark mb-0 tracking-tight">Harvest<span class="text-success">HUB</span></h4>
                            </div>
                            <span class="text-muted small text-uppercase tracking-wider">E-Receipt / Bukti Pembelian</span>
                            <h2 class="fw-bold text-dark mt-3 mb-1" style="font-size: 1.5rem; letter-spacing: 0.5px;">{{ $transaction->order->cart->no_invoice }}</h2>
                            <small class="text-secondary d-block">{{ $transaction->created_at->format('d F Y | H:i') }} WITA</small>
                        </div>

                        {{-- Barcode Mock --}}
                        <div class="text-center mb-4 barcode-container">
                            <div class="d-inline-block px-3 py-1 bg-light rounded-3 border">
                                <div class="barcode-lines d-flex align-items-center justify-content-center gap-1 py-1" style="height: 35px;">
                                    <span style="width: 2px; height: 30px; background: #000;"></span>
                                    <span style="width: 1px; height: 30px; background: #000;"></span>
                                    <span style="width: 3px; height: 30px; background: #000;"></span>
                                    <span style="width: 1px; height: 30px; background: #000;"></span>
                                    <span style="width: 4px; height: 30px; background: #000;"></span>
                                    <span style="width: 2px; height: 30px; background: #000;"></span>
                                    <span style="width: 1px; height: 30px; background: #000;"></span>
                                    <span style="width: 3px; height: 30px; background: #000;"></span>
                                    <span style="width: 2px; height: 30px; background: #000;"></span>
                                    <span style="width: 1px; height: 30px; background: #000;"></span>
                                    <span style="width: 4px; height: 30px; background: #000;"></span>
                                    <span style="width: 2px; height: 30px; background: #000;"></span>
                                    <span style="width: 1px; height: 30px; background: #000;"></span>
                                </div>
                                <small class="text-muted text-monospace small" style="font-size: 0.72rem; letter-spacing: 2px;">*HVH-TRX-{{ $transaction->id }}*</small>
                            </div>
                        </div>

                        <hr class="receipt-divider mb-4">

                        {{-- Identitas Alamat --}}
                        <h6 class="fw-bold text-dark text-uppercase small tracking-wider mb-3"><i class="bi bi-person-badge text-success me-2"></i>Detail Penerima</h6>
                        <table class="table table-borderless table-sm mb-4 receipt-info-table" style="font-size: 0.88rem;">
                            <tbody>
                                <tr>
                                    <td class="text-secondary ps-0 py-1" style="width: 35%;">Nama Penerima</td>
                                    <td class="text-dark fw-semibold py-1">: {{ $transaction->order->nama_penerima }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary ps-0 py-1">No. Telepon</td>
                                    <td class="text-dark fw-semibold py-1">: {{ $transaction->order->no_tlp }}</td>
                                </tr>
                                @if($pengiriman === 'Ambil di tempat')
                                <tr>
                                    <td class="text-secondary ps-0 py-1">Alamat</td>
                                    <td class="text-dark fw-semibold py-1">: Diambil Langsung di Toko</td>
                                </tr>
                                @else
                                <tr>
                                    <td class="text-secondary ps-0 py-1">Alamat Detail</td>
                                    <td class="text-dark fw-semibold py-1">: {{ $alamat_clean }}</td>
                                </tr>
                                <tr>
                                    <td class="text-secondary ps-0 py-1">Wilayah / Pos</td>
                                    <td class="text-dark fw-semibold py-1">: Kec. {{ $transaction->order->kecamatan }}, {{ $transaction->order->kota }}, {{ $transaction->order->provinsi }} ({{ $transaction->order->kodepos }})</td>
                                </tr>
                                @endif
                                @if($koordinat !== '-')
                                <tr>
                                    <td class="text-secondary ps-0 py-1">Titik GPS Map</td>
                                    <td class="text-success fw-bold py-1">: [{{ $koordinat }}]</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>

                        <hr class="receipt-divider mb-4">

                        {{-- Daftar Belanja --}}
                        <h6 class="fw-bold text-dark text-uppercase small tracking-wider mb-3"><i class="bi bi-basket3 text-success me-2"></i>Rincian Produk</h6>
                        <div class="table-responsive mb-4">
                            <table class="table table-borderless table-sm mb-0 align-middle" style="font-size: 0.88rem;">
                                <thead>
                                    <tr class="border-bottom border-light-subtle">
                                        <th class="ps-0 py-2 text-secondary fw-semibold">Item</th>
                                        <th class="py-2 text-center text-secondary fw-semibold">Qty</th>
                                        <th class="pe-0 py-2 text-end text-secondary fw-semibold">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($transaction->order->cart->detail as $produk)
                                    <tr>
                                        <td class="ps-0 py-2 fw-medium text-dark">{{ $produk->produk->name }}</td>
                                        <td class="py-2 text-center text-dark">{{ $produk->qty }}</td>
                                        <td class="pe-0 py-2 text-end fw-semibold text-success">Rp {{ number_format($produk->subtotal, 0, ',', '.') }}</td>
                                    </tr>
                                    @endforeach
                                    <tr class="border-top border-light-subtle">
                                        <td colspan="2" class="ps-0 py-3 fw-bold text-dark">Subtotal Belanja</td>
                                        <td class="pe-0 py-3 text-end fw-bold text-dark">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="ps-0 py-1 text-secondary">Metode Pengiriman</td>
                                        <td class="pe-0 py-1 text-end text-dark fw-semibold">{{ $pengiriman }}</td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" class="ps-0 py-1 text-secondary">Metode Pembayaran</td>
                                        <td class="pe-0 py-1 text-end text-dark fw-semibold">{{ $pembayaran }}</td>
                                    </tr>
                                    <tr class="border-top border-dark border-dashed">
                                        <td colspan="2" class="ps-0 py-3 fw-bold text-dark" style="font-size: 1.1rem;">GRAND TOTAL</td>
                                        <td class="pe-0 py-3 text-end fw-bold text-success" style="font-size: 1.25rem;">Rp {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <hr class="receipt-divider mb-4">

                        {{-- Opsi Visual Metode Pembayaran --}}
                        <div class="d-flex flex-column align-items-center justify-content-center mt-3">
                            @if($pembayaran === 'QRIS')
                                <div class="text-center p-3 rounded-4 border bg-white shadow-xs" style="max-width: 200px;">
                                    <div class="qris-header d-flex align-items-center justify-content-center mb-2">
                                        <span class="fw-bold text-danger italic" style="font-size: 0.9rem; font-style: italic;">QRIS</span>
                                        <small class="text-secondary ms-1 small" style="font-size: 0.6rem;">Instan</small>
                                    </div>
                                    
                                    {{-- Mocking QR Code dynamic --}}
                                    <div class="mock-qr-code rounded bg-white p-2 border d-inline-block shadow-xs mb-2">
                                        <svg width="120" height="120" viewBox="0 0 100 100" class="d-block mx-auto">
                                            <!-- Corner Squares -->
                                            <rect x="5" y="5" width="25" height="25" fill="#111" stroke="#fff" stroke-width="2"/>
                                            <rect x="10" y="10" width="15" height="15" fill="#fff"/>
                                            <rect x="13" y="13" width="9" height="9" fill="#111"/>

                                            <rect x="70" y="5" width="25" height="25" fill="#111" stroke="#fff" stroke-width="2"/>
                                            <rect x="75" y="10" width="15" height="15" fill="#fff"/>
                                            <rect x="78" y="78" width="9" height="9" fill="#111"/>

                                            <rect x="5" y="70" width="25" height="25" fill="#111" stroke="#fff" stroke-width="2"/>
                                            <rect x="10" y="75" width="15" height="15" fill="#fff"/>
                                            <rect x="13" y="78" width="9" height="9" fill="#111"/>

                                            <!-- Random dots of QR code -->
                                            <rect x="35" y="5" width="10" height="10" fill="#111"/>
                                            <rect x="50" y="15" width="15" height="5" fill="#111"/>
                                            <rect x="35" y="25" width="5" height="15" fill="#111"/>
                                            <rect x="55" y="30" width="10" height="10" fill="#111"/>
                                            
                                            <rect x="5" y="40" width="15" height="10" fill="#111"/>
                                            <rect x="25" y="45" width="10" height="5" fill="#111"/>
                                            <rect x="40" y="45" width="20" height="15" fill="#111"/>
                                            
                                            <rect x="70" y="40" width="10" height="10" fill="#111"/>
                                            <rect x="85" y="45" width="10" height="15" fill="#111"/>
                                            <rect x="75" y="65" width="20" height="5" fill="#111"/>

                                            <rect x="35" y="65" width="5" height="15" fill="#111"/>
                                            <rect x="45" y="70" width="15" height="10" fill="#111"/>
                                            <rect x="55" y="85" width="10" height="10" fill="#111"/>
                                            <rect x="35" y="85" width="10" height="5" fill="#111"/>

                                            <!-- Central target -->
                                            <rect x="45" y="45" width="10" height="10" fill="green"/>
                                        </svg>
                                    </div>
                                    <small class="text-secondary d-block" style="font-size: 0.72rem;">Scan QR di atas untuk membayar</small>
                                </div>
                            @else
                                {{-- CASH Stamp --}}
                                <div class="cash-stamp-badge rounded border border-danger p-2 text-danger fw-bold text-center text-uppercase border-3 position-relative shadow-xs" style="font-size: 1.15rem; transform: rotate(-8deg); letter-spacing: 1px; max-width: 220px; font-family: 'Courier New', Courier, monospace;">
                                    <i class="bi bi-wallet2 me-1"></i> Bayar Di Tempat
                                    <div class="stamp-sub d-block text-danger small font-monospace" style="font-size: 0.65rem;">CASH ON DELIVERY</div>
                                </div>
                            @endif
                        </div>

                        {{-- Footer Struk --}}
                        <div class="text-center mt-5">
                            <span class="fw-medium text-dark d-block">Terima Kasih Telah Berbelanja!</span>
                            <span class="text-secondary small">HarvestHUB - Solusi Pertanian & E-commerce Terpercaya</span>
                        </div>

                    </div>
                    
                    {{-- Efek Sobek Kertas Struk Bawah --}}
                    <div class="receipt-jagged-bottom d-print-none"></div>

                </div>

                {{-- ACTION BUTTONS (CETAK & UNDUH) --}}
                <div class="row g-2 d-print-none mb-5">
                    <div class="col-6">
                        <button type="button" id="print-pdf-btn" class="btn btn-success rounded-pill w-100 py-2.5 fw-semibold shadow-sm d-inline-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-printer-fill"></i> Cetak / PDF
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="button" id="download-png-btn" class="btn btn-outline-success rounded-pill w-100 py-2.5 fw-semibold shadow-sm d-inline-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-image-fill"></i> Unduh Gambar
                        </button>
                    </div>
                    <div class="col-12 mt-2">
                        <a href="/transaksi" class="btn btn-light rounded-pill w-100 py-2.5 text-secondary fw-semibold border d-inline-flex align-items-center justify-content-center gap-1">
                            <i class="bi bi-arrow-left"></i> Kembali ke Riwayat Transaksi
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</section>

<!-- html2canvas library for capturing receipt element as PNG -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js" integrity="sha512-BNaRQnYcabRBOFyWh/yNyLYSGwZhYJ1aFv1z45gIB05jNiANyR3C6kXq549hxwtnhM3531ibYEKNRCYg7z6VbA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // 1. PDF CETAK NOTA (NATIVE BROWSER PRINT)
        document.getElementById('print-pdf-btn').addEventListener('click', () => {
            window.print();
        });

        // 2. UNDUH NOTA SEBAGAI GAMBAR (PNG)
        document.getElementById('download-png-btn').addEventListener('click', function() {
            const btn = document.getElementById('download-png-btn');
            btn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Mengunduh...';
            btn.disabled = true;

            const target = document.getElementById('nota-receipt-card');
            const invoiceNum = '{{ $transaction->order->cart->no_invoice }}';

            // Menjalankan capture html2canvas
            html2canvas(target, {
                scale: 2, // High resolution capture
                useCORS: true,
                backgroundColor: '#ffffff'
            }).then(canvas => {
                const link = document.createElement('a');
                link.download = 'Nota_HarvestHUB_' + invoiceNum + '.png';
                link.href = canvas.toDataURL('image/png');
                link.click();
            }).catch(err => {
                console.error(err);
                alert('Gagal mengunduh gambar nota.');
            }).finally(() => {
                btn.innerHTML = '<i class="bi bi-image-fill"></i> Unduh Gambar';
                btn.disabled = false;
            });
        });

    });
</script>

<style>
    .nota-section {
        background-color: var(--bs-body-bg);
        padding-top: 95px !important;
    }

    /* DESAIN STRUK FISIK DIGITAL */
    .receipt-card {
        background-color: #ffffff;
        border-bottom-left-radius: 0 !important;
        border-bottom-right-radius: 0 !important;
        box-shadow: 0 15px 35px rgba(0,0,0,0.08) !important;
    }
    
    .receipt-divider {
        border-top: 2px dashed rgba(0,0,0,0.1);
        opacity: 1;
    }

    .border-dashed {
        border-top: 2px dashed #000000 !important;
    }

    .receipt-info-table td {
        background-color: transparent !important;
    }

    /* Sobek Kertas Struk bawah */
    .receipt-jagged-bottom {
        height: 18px;
        background-image: linear-gradient(-45deg, var(--bs-body-bg) 9px, transparent 0), 
                          linear-gradient(45deg, var(--bs-body-bg) 9px, transparent 0);
        background-position: left bottom;
        background-repeat: repeat-x;
        background-size: 18px 18px;
        filter: drop-shadow(0 4px 5px rgba(0,0,0,0.03));
        z-index: 10;
        margin-top: -2px;
    }

    /* PRINT STYLESHEET */
    @media print {
        body * {
            visibility: hidden;
        }
        #nota-receipt-card, #nota-receipt-card * {
            visibility: visible;
        }
        #nota-receipt-card {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            border: none !important;
            box-shadow: none !important;
            padding: 0 !important;
            margin: 0 !important;
        }
        .d-print-none {
            display: none !important;
        }
        .nota-section {
            padding-top: 0 !important;
            margin: 0 !important;
        }
    }

    /* DARK MODE COMPATIBILITY IN SCREEN */
    .dark-mode .nota-section {
        background-color: #121212 !important;
    }
    
    /* Keep physical receipt card always white for perfect printing/saving quality */
    .receipt-card {
        color: #111111 !important;
    }
</style>
@endsection
