@extends('layouts.mainlayouts')

@section('tittle', 'Checkout Premium')

@section('content')
<!-- Leaflet Maps CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>

<section class="checkout-section py-5">
    <div class="container py-4">
        
        <div class="row mb-4 text-center">
            <div class="checkout-title-container">
                <h2 class="fw-bold text-dark mb-1"><i class="bi bi-shield-check text-success me-2"></i>Checkout</h2>
                <p class="text-secondary">Selesaikan pesanan Anda dengan mengisi data pengiriman dan metode pembayaran</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-8 mx-auto">
                
                {{-- CARD UTAMA CHECKOUT --}}
                <div class="card border-0 shadow rounded-4 overflow-hidden bg-white checkout-card p-4 p-sm-5 mb-4">
                    
                    {{-- 1. Ringkasan Pesanan --}}
                    <h5 class="fw-bold text-dark mb-3"><i class="bi bi-receipt me-2 text-success"></i> Ringkasan Produk</h5>
                    <div class="table-responsive mb-4 rounded-3 border border-light overflow-hidden">
                        <table class="table table-align-middle mb-0" style="font-size: 0.9rem;">
                            <thead class="bg-light text-secondary">
                                <tr>
                                    <th class="ps-3 border-0 py-3">Produk</th>
                                    <th class="border-0 py-3 text-center">Jumlah</th>
                                    <th class="pe-3 border-0 py-3 text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($itemcart->detail as $produk)
                                <tr>
                                    <td class="ps-3 py-3 border-light">
                                        <div class="d-flex align-items-center gap-3">
                                            <img src="{{ $produk->produk->image_url }}" alt="{{ $produk->produk->name }}" class="rounded shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <span class="fw-semibold text-dark d-block">{{ $produk->produk->name }}</span>
                                                <small class="text-muted">Rp {{ number_format($produk->produk->harga, 0, ',', '.') }} / pcs</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3 text-center border-light text-dark fw-medium">{{ $produk->qty }}</td>
                                    <td class="pe-3 py-3 text-end border-light text-success fw-semibold">Rp {{ number_format($produk->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                                <tr class="bg-light-subtle">
                                    <td colspan="2" class="ps-3 py-3 border-0 fw-bold text-dark text-end">Total Pembayaran:</td>
                                    <td class="pe-3 py-3 border-0 text-end text-success fw-bold" style="font-size: 1.1rem;">Rp {{ number_format($itemcart->total, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <hr class="mb-4 opacity-10">

                    {{-- Form Utama Pembelian --}}
                    <form id="checkout-main-form" action="{{ route('transaksi.store') }}" method="POST">
                        @csrf
                        
                        {{-- 2. Opsi Pengiriman --}}
                        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-truck me-2 text-success"></i> Metode Pengiriman</h5>
                        <div class="row g-3 mb-4">
                            <div class="col-6">
                                <label class="delivery-option-card w-100 h-100 p-3 rounded-4 border text-center cursor-pointer d-flex flex-column align-items-center justify-content-center gap-2">
                                    <input type="radio" name="opsi_pengiriman" id="opsi_diantar" value="Diantar" checked class="d-none">
                                    <i class="bi bi-truck text-success" style="font-size: 2rem;"></i>
                                    <div>
                                        <div class="fw-bold text-dark option-title">Diantar Kurir</div>
                                        <small class="text-secondary" style="font-size: 0.8rem;">Antar langsung ke alamat</small>
                                    </div>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="delivery-option-card w-100 h-100 p-3 rounded-4 border text-center cursor-pointer d-flex flex-column align-items-center justify-content-center gap-2">
                                    <input type="radio" name="opsi_pengiriman" id="opsi_ambil" value="Ambil di tempat" class="d-none">
                                    <i class="bi bi-shop-window text-success" style="font-size: 2rem;"></i>
                                    <div>
                                        <div class="fw-bold text-dark option-title">Ambil di Tempat</div>
                                        <small class="text-secondary" style="font-size: 0.8rem;">Ambil sendiri di toko</small>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- 3. Identitas & Alamat Pengiriman --}}
                        <div id="alamat-pengiriman-wrapper">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="fw-bold text-dark mb-0"><i class="bi bi-geo-alt me-2 text-success"></i> Alamat Pengiriman</h5>
                                <button type="button" id="save-address-btn" class="btn btn-outline-success btn-sm rounded-pill px-3 fw-semibold">
                                    <i class="bi bi-save me-1"></i> Simpan Alamat
                                </button>
                            </div>
                            
                            {{-- Form Alamat Pengiriman --}}
                            <div class="checkout-form-fields">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="namapenerima" class="form-label form-checkout-label text-secondary fw-semibold">Nama Penerima</label>
                                        <input type="text" class="form-control rounded-3" id="namapenerima" name="namapenerima" required value="{{ old('namapenerima', $itemalamatpengiriman?->nama_penerima ?? auth()->user()->name) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="Telp" class="form-label form-checkout-label text-secondary fw-semibold">No. Telepon</label>
                                        <input type="text" class="form-control rounded-3" id="Telp" name="Telp" required value="{{ old('Telp', $itemalamatpengiriman?->no_tlp ?? '') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="alamat" class="form-label form-checkout-label text-secondary fw-semibold">Alamat Detail (Jalan, No. Rumah)</label>
                                        <input type="text" class="form-control rounded-3" id="alamat" name="alamat" required value="{{ old('alamat', $itemalamatpengiriman?->alamat ?? '') }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="kodepos" class="form-label form-checkout-label text-secondary fw-semibold">Kode Pos</label>
                                        <input type="text" class="form-control rounded-3" id="kodepos" name="kodepos" required value="{{ old('kodepos', $itemalamatpengiriman?->kodepos ?? '') }}">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="kelurahan" class="form-label form-checkout-label text-secondary fw-semibold">Kelurahan</label>
                                        <input type="text" class="form-control rounded-3" id="kelurahan" name="kelurahan" required value="{{ old('kelurahan', $itemalamatpengiriman?->kelurahan ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="kecamatan" class="form-label form-checkout-label text-secondary fw-semibold">Kecamatan</label>
                                        <input type="text" class="form-control rounded-3" id="kecamatan" name="kecamatan" required value="{{ old('kecamatan', $itemalamatpengiriman?->kecamatan ?? '') }}">
                                    </div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-6 mb-3">
                                        <label for="kota" class="form-label form-checkout-label text-secondary fw-semibold">Kota / Kabupaten</label>
                                        <input type="text" class="form-control rounded-3" id="kota" name="kota" required value="{{ old('kota', $itemalamatpengiriman?->kota ?? '') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="provinsi" class="form-label form-checkout-label text-secondary fw-semibold">Provinsi</label>
                                        <input type="text" class="form-control rounded-3" id="provinsi" name="provinsi" required value="{{ old('provinsi', $itemalamatpengiriman?->provinsi ?? '') }}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 4. Pilih Lokasi dari Peta (Maps) --}}
                        <div class="mb-4" id="map-section">
                            <h5 class="fw-bold text-dark mb-2"><i class="bi bi-map me-2 text-success"></i> Pilih Titik Lokasi Peta</h5>
                            <p class="text-secondary small mb-3">Klik titik lokasi pengiriman Anda pada peta di bawah ini untuk menentukan titik koordinat GPS presisi.</p>
                            
                            {{-- Container Peta --}}
                            <div id="checkout-map" class="shadow-sm border rounded-4 overflow-hidden mb-3"></div>
                            
                            <div class="d-flex align-items-center justify-content-between p-3 rounded-3 bg-light border map-coordinate-bar">
                                <div class="d-flex align-items-center gap-2">
                                    <i class="bi bi-crosshair text-success" style="font-size: 1.2rem;"></i>
                                    <span class="text-dark fw-semibold small">Koordinat GPS:</span>
                                    <span id="display-koordinat" class="text-secondary small fw-medium">Belum ada lokasi dipilih</span>
                                </div>
                                <input type="hidden" name="koordinat" id="koordinat" value="">
                            </div>
                        </div>

                        {{-- 5. Metode Pembayaran --}}
                        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-wallet2 me-2 text-success"></i> Metode Pembayaran</h5>
                        <div class="row g-3 mb-5">
                            <div class="col-6">
                                <label class="payment-option-card w-100 h-100 p-3 rounded-4 border text-center cursor-pointer d-flex flex-column align-items-center justify-content-center gap-2">
                                    <input type="radio" name="metode_pembayaran" value="QRIS" checked class="d-none">
                                    <div class="d-flex align-items-center justify-content-center border rounded px-3 py-1 bg-white shadow-xs" style="height: 36px;">
                                        <span class="fw-bold text-danger" style="font-size: 1.1rem; font-style: italic; letter-spacing: 0.5px;">QRIS</span>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark option-title">QRIS Instan</div>
                                        <small class="text-secondary" style="font-size: 0.8rem;">E-Wallet & Mobile Banking</small>
                                    </div>
                                </label>
                            </div>
                            <div class="col-6">
                                <label class="payment-option-card w-100 h-100 p-3 rounded-4 border text-center cursor-pointer d-flex flex-column align-items-center justify-content-center gap-2">
                                    <input type="radio" name="metode_pembayaran" value="Cash" class="d-none">
                                    <i class="bi bi-cash-stack text-success" style="font-size: 2.2rem;"></i>
                                    <div>
                                        <div class="fw-bold text-dark option-title">Bayar di Tempat</div>
                                        <small class="text-secondary" style="font-size: 0.8rem;">Bayar tunai (Cash) saat COD</small>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Tombol Submit Utama --}}
                        <div class="text-center">
                            <button type="submit" id="buatpesanan" class="btn btn-success rounded-pill px-5 py-3 w-100 fw-bold shadow btn-buat-pesanan" disabled>
                                <i class="bi bi-bag-check-fill me-2"></i> Buat Pesanan Sekarang
                            </button>
                            <p class="text-secondary small mt-3 mb-0">Dengan menekan tombol, Anda menyetujui syarat & ketentuan transaksi di HarvestHUB.</p>
                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>
</section>

<!-- Leaflet Maps JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // PETA INTERAKTIF LEAFLET MAPS
        const map = L.map('checkout-map', {
            scrollWheelZoom: false
        }).setView([-8.4095, 115.1889], 11); // Center Bali (OSM Map)

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '© OpenStreetMap contributors'
        }).addTo(map);

        let marker = null;

        // Geolocation browser option (jika diizinkan oleh user)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition((position) => {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const userLoc = [lat, lng];
                map.setView(userLoc, 15);
                
                // Tambahkan marker otomatis
                setCoordinates(lat, lng);
            });
        }

        function setCoordinates(lat, lng) {
            const roundedLat = parseFloat(lat).toFixed(6);
            const roundedLng = parseFloat(lng).toFixed(6);
            
            document.getElementById('koordinat').value = roundedLat + ', ' + roundedLng;
            document.getElementById('display-koordinat').innerText = 'Lat: ' + roundedLat + ', Lng: ' + roundedLng;
            
            if (marker) {
                marker.setLatLng([lat, lng]);
            } else {
                marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                
                // Drag marker event
                marker.on('dragend', function(e) {
                    const dragLat = marker.getLatLng().lat;
                    const dragLng = marker.getLatLng().lng;
                    setCoordinates(dragLat, dragLng);
                    validateForm();
                });
            }
            validateForm();
        }

        // Click map event
        map.on('click', function(e) {
            setCoordinates(e.latlng.lat, e.latlng.lng);
        });

        // GEOLOCATION TOGGLE OPSI PENGIRIMAN
        const opsiDiantar = document.getElementById('opsi_diantar');
        const opsiAmbil = document.getElementById('opsi_ambil');
        const alamatWrapper = document.getElementById('alamat-pengiriman-wrapper');
        const mapSection = document.getElementById('map-section');

        function toggleDeliveryMode() {
            if (opsiAmbil.checked) {
                // Sembunyikan form alamat & map untuk opsi ambil di tempat
                alamatWrapper.style.opacity = '0.3';
                alamatWrapper.style.pointerEvents = 'none';
                mapSection.style.opacity = '0.3';
                mapSection.style.pointerEvents = 'none';
                
                // Remove required status temporarily
                setInputsRequired(false);
            } else {
                // Diantar
                alamatWrapper.style.opacity = '1';
                alamatWrapper.style.pointerEvents = 'auto';
                mapSection.style.opacity = '1';
                mapSection.style.pointerEvents = 'auto';
                
                setInputsRequired(true);
            }
            validateForm();
        }

        function setInputsRequired(status) {
            const inputs = alamatWrapper.querySelectorAll('input');
            inputs.forEach(input => {
                input.required = status;
            });
        }

        opsiDiantar.addEventListener('change', toggleDeliveryMode);
        opsiAmbil.addEventListener('change', toggleDeliveryMode);


        // REAL-TIME VALIDATION & TOMBOL SUBMIT
        const mainForm = document.getElementById('checkout-main-form');
        const buatPesananBtn = document.getElementById('buatpesanan');
        
        function validateForm() {
            let isValid = true;
            
            if (opsiDiantar.checked) {
                // Validasi data alamat & koordinat
                const namapenerima = document.getElementById('namapenerima').value.trim();
                const telp = document.getElementById('Telp').value.trim();
                const alamat = document.getElementById('alamat').value.trim();
                const kodepos = document.getElementById('kodepos').value.trim();
                const kelurahan = document.getElementById('kelurahan').value.trim();
                const kecamatan = document.getElementById('kecamatan').value.trim();
                const kota = document.getElementById('kota').value.trim();
                const provinsi = document.getElementById('provinsi').value.trim();
                const koordinat = document.getElementById('koordinat').value.trim();

                if (!namapenerima || !telp || !alamat || !kodepos || !kelurahan || !kecamatan || !kota || !provinsi || !koordinat) {
                    isValid = false;
                }
            } else {
                // Ambil di tempat: Cukup validasi no telepon jika ada pengisian
                const telp = document.getElementById('Telp').value.trim();
                if (!telp) {
                    isValid = false;
                }
            }

            buatPesananBtn.disabled = !isValid;
        }

        // Add event listeners to all input elements for real-time validation
        const formInputs = mainForm.querySelectorAll('input');
        formInputs.forEach(input => {
            input.addEventListener('input', validateForm);
            input.addEventListener('change', validateForm);
        });

        // SIMPAN ALAMAT VIA AJAX (SAVE ADDRESS BUTTON)
        const saveAddressBtn = document.getElementById('save-address-btn');
        
        saveAddressBtn.addEventListener('click', async () => {
            saveAddressBtn.innerText = 'Menyimpan...';
            saveAddressBtn.disabled = true;

            const addressData = {
                namapenerima: document.getElementById('namapenerima').value,
                Telp: document.getElementById('Telp').value,
                alamat: document.getElementById('alamat').value,
                kodepos: document.getElementById('kodepos').value,
                kelurahan: document.getElementById('kelurahan').value,
                kecamatan: document.getElementById('kecamatan').value,
                kota: document.getElementById('kota').value,
                provinsi: document.getElementById('provinsi').value,
            };

            try {
                const response = await fetch('{{ route("checkout.alamat.store") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(addressData)
                });
                const result = await response.json();
                
                if (response.ok && result.success) {
                    alert('Sukses: ' + result.message);
                } else {
                    alert('Gagal: Periksa kembali inputan Anda.');
                }
            } catch (e) {
                console.error(e);
                alert('Terjadi kesalahan jaringan.');
            } finally {
                saveAddressBtn.innerHTML = '<i class="bi bi-save me-1"></i> Simpan Alamat';
                saveAddressBtn.disabled = false;
                validateForm();
            }
        });

        // DUA FASE SUBMIT PESANAN
        mainForm.addEventListener('submit', async (e) => {
            if (opsiDiantar.checked) {
                e.preventDefault(); // Stop default submit to save address first
                
                buatPesananBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Memproses Alamat...';
                buatPesananBtn.disabled = true;

                const addressData = {
                    namapenerima: document.getElementById('namapenerima').value,
                    Telp: document.getElementById('Telp').value,
                    alamat: document.getElementById('alamat').value,
                    kodepos: document.getElementById('kodepos').value,
                    kelurahan: document.getElementById('kelurahan').value,
                    kecamatan: document.getElementById('kecamatan').value,
                    kota: document.getElementById('kota').value,
                    provinsi: document.getElementById('provinsi').value,
                };

                try {
                    // Simpan alamat utama
                    const response = await fetch('{{ route("checkout.alamat.store") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(addressData)
                    });
                    const result = await response.json();
                    
                    if (response.ok && result.success) {
                        // Selesai menyimpan, sekarang submit formulir transaksi asli
                        buatPesananBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Membuat Pesanan...';
                        mainForm.submit();
                    } else {
                        alert('Gagal menyimpan koordinat alamat utama. Pastikan form alamat lengkap.');
                        buatPesananBtn.innerHTML = '<i class="bi bi-bag-check-fill me-2"></i> Buat Pesanan Sekarang';
                        buatPesananBtn.disabled = false;
                    }
                } catch (err) {
                    console.error(err);
                    alert('Terjadi kendala jaringan.');
                    buatPesananBtn.innerHTML = '<i class="bi bi-bag-check-fill me-2"></i> Buat Pesanan Sekarang';
                    buatPesananBtn.disabled = false;
                }
            }
        });

        // Panggil penyesuaian saat halaman dimuat
        toggleDeliveryMode();
    });
</script>

<style>
    .checkout-section {
        background-color: var(--bs-body-bg);
        padding-top: 95px !important;
    }

    .checkout-card {
        background-color: #ffffff;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .dark-mode .checkout-card {
        background-color: #1e1e1e !important;
        border-color: rgba(255,255,255,0.04) !important;
    }

    .dark-mode .text-dark, .dark-mode h2, .dark-mode h5, .dark-mode th, .dark-mode td {
        color: #ffffff !important;
    }
    .dark-mode .text-secondary {
        color: #b0b0b0 !important;
    }
    .dark-mode .bg-light {
        background-color: #2b2b2b !important;
    }
    .dark-mode .border-light {
        border-color: rgba(255,255,255,0.06) !important;
    }

    .form-checkout-label {
        font-size: 0.88rem;
    }
    .checkout-form-fields input {
        border-color: rgba(0,0,0,0.08);
        padding: 0.65rem 0.8rem;
    }
    .dark-mode .checkout-form-fields input {
        background-color: #2b2b2b !important;
        border-color: rgba(255,255,255,0.08) !important;
        color: #ffffff !important;
    }

    /* PETA LEAFLET STYLING */
    #checkout-map {
        height: 320px;
        z-index: 1;
    }
    
    .dark-mode #checkout-map {
        filter: invert(100%) hue-rotate(180deg) brightness(95%) contrast(90%);
        border-color: rgba(255,255,255,0.1) !important;
    }

    .map-coordinate-bar {
        background-color: #fafafa;
        border-color: rgba(0,0,0,0.06) !important;
    }
    .dark-mode .map-coordinate-bar {
        background-color: #2b2b2b !important;
        border-color: rgba(255,255,255,0.06) !important;
    }

    /* SEGMENTED CARDS STYLING */
    .delivery-option-card, .payment-option-card {
        background-color: #fafafa;
        border-color: rgba(0,0,0,0.08) !important;
        cursor: pointer;
        transition: all 0.22s ease-in-out;
    }
    .dark-mode .delivery-option-card, .dark-mode .payment-option-card {
        background-color: #2b2b2b !important;
        border-color: rgba(255,255,255,0.06) !important;
    }

    .delivery-option-card:hover, .payment-option-card:hover {
        transform: translateY(-2px);
        border-color: #198754 !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.04) !important;
    }

    /* Active Check state */
    .delivery-option-card:has(input:checked), .payment-option-card:has(input:checked) {
        border-color: #198754 !important;
        background-color: rgba(25, 135, 84, 0.05) !important;
        box-shadow: 0 5px 12px rgba(25, 135, 84, 0.12) !important;
        border-width: 2px !important;
    }
    
    .dark-mode .delivery-option-card:has(input:checked), .dark-mode .payment-option-card:has(input:checked) {
        background-color: rgba(25, 135, 84, 0.12) !important;
    }

    .delivery-option-card:has(input:checked) .option-title, 
    .payment-option-card:has(input:checked) .option-title {
        color: #198754 !important;
    }

    .btn-buat-pesanan {
        background-color: #198754 !important;
        border-color: #198754 !important;
        color: #ffffff !important;
        padding: 0.95rem 2rem;
        font-size: 1.05rem;
        transition: all 0.22s ease-in-out;
    }
    .btn-buat-pesanan:hover:not(:disabled) {
        background-color: #157347 !important;
        border-color: #146c43 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(25, 135, 84, 0.2) !important;
    }
    .btn-buat-pesanan:disabled {
        background-color: #a3cfbb !important;
        border-color: #a3cfbb !important;
        color: rgba(255,255,255,0.7) !important;
        cursor: not-allowed;
    }
    .dark-mode .btn-buat-pesanan:disabled {
        background-color: #2c4d3d !important;
        border-color: #2c4d3d !important;
        color: rgba(255,255,255,0.4) !important;
    }
</style>
@endsection
