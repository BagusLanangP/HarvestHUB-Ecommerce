@extends('layouts.mainlayouts')

@section('tittle', 'Tulis Ulasan Premium')

@section('content')
<section class="review-create-section py-5">
    <div class="container py-4">
        
        <div class="row mb-4 text-center">
            <div class="review-title-container">
                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2 mb-2 fw-semibold">
                    <i class="bi bi-chat-left-heart-fill me-1"></i> Kepuasan Pembeli
                </span>
                <h3 class="fw-bold text-dark mb-1">Berikan Ulasan Anda</h3>
                <p class="text-secondary">Bagikan pengalaman belanja Anda untuk membantu pembeli lain dan petani di HarvestHUB</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-8 col-lg-6 mx-auto">
                
                {{-- CARD UTAMA ULASAN --}}
                <div class="card border-0 shadow rounded-4 overflow-hidden bg-white review-card p-4 p-sm-5 mb-4">
                    
                    {{-- 1. Ringkasan Produk --}}
                    <div class="d-flex align-items-center gap-3 p-3 rounded-4 bg-light border border-light-subtle mb-4 product-summary-card">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="rounded-3 shadow-xs border flex-shrink-0" style="width: 75px; height: 75px; object-fit: cover;">
                        <div class="overflow-hidden">
                            <span class="text-muted small text-monospace d-block" style="font-size: 0.78rem;">INVOICE: #{{ $transaction->order->cart->no_invoice }}</span>
                            <h5 class="fw-bold text-dark mb-1 text-truncate" style="font-size: 1.05rem;">{{ $product->name }}</h5>
                            
                            {{-- Store Name --}}
                            <span class="text-secondary small d-block">
                                <i class="bi bi-shop text-success me-1"></i>Toko: 
                                <span class="text-success fw-semibold">{{ $product->toko->nama ?? 'Harvest Toko' }}</span>
                            </span>
                        </div>
                    </div>

                    <hr class="mb-4 opacity-10">

                    {{-- Form Utama Ulasan --}}
                    <form id="review-main-form" action="{{ route('review.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        {{-- 2. Interaktif Bintang Rating --}}
                        <div class="text-center mb-4">
                            <label class="form-label text-dark fw-bold mb-3 d-block" style="font-size: 1rem;">Bagaimana Kualitas Produk Ini?</label>
                            
                            {{-- Bintang Raksasa --}}
                            <div class="star-rating-container d-flex justify-content-center gap-2 mb-2">
                                <i class="bi bi-star star-icon cursor-pointer" data-value="1"></i>
                                <i class="bi bi-star star-icon cursor-pointer" data-value="2"></i>
                                <i class="bi bi-star star-icon cursor-pointer" data-value="3"></i>
                                <i class="bi bi-star star-icon cursor-pointer" data-value="4"></i>
                                <i class="bi bi-star star-icon cursor-pointer" data-value="5"></i>
                            </div>
                            
                            {{-- Teks Deskripsi Emosi Rating --}}
                            <div class="mt-2">
                                <span id="rating-text" class="fw-semibold text-secondary" style="font-size: 0.92rem;">Sentuh bintang untuk menilai</span>
                            </div>
                            
                            {{-- Input Tersembunyi --}}
                            <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}">
                            
                            @error('rating')
                                <div class="text-danger small mt-2 fw-semibold"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 3. Input Komentar --}}
                        <div class="mb-4">
                            <label for="comment" class="form-label text-dark fw-bold mb-2">Ulasan Teks (Opsional)</label>
                            <textarea class="form-control rounded-3 py-3 px-3 @error('comment') is-invalid @enderror" id="comment" name="comment" rows="4" placeholder="Ceritakan detail kualitas produk, kesegaran, kemasan, atau pelayanan kurir... (contoh: sayur sangat segar, kurir ramah!)">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback fw-semibold">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- 4. Tombol Aksi --}}
                        <div class="d-flex align-items-center justify-content-end gap-2.5 mt-4">
                            <a href="{{ route('transaksi.index') }}" class="btn btn-light rounded-pill px-4 py-2.5 text-secondary fw-semibold border btn-batal">
                                Batal
                            </a>
                            <button type="submit" id="submit-btn" class="btn btn-success rounded-pill px-5 py-2.5 fw-bold shadow-sm btn-submit-ulasan" disabled>
                                <i class="bi bi-send-fill me-1.5" style="font-size: 0.9rem;"></i> Kirim Ulasan
                            </button>
                        </div>

                    </form>

                </div>

            </div>
        </div>

    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        
        // INTERAKTIVITAS BINTANG RATING
        const stars = document.querySelectorAll('.star-icon');
        const ratingInput = document.getElementById('rating-input');
        const ratingText = document.getElementById('rating-text');
        const submitBtn = document.getElementById('submit-btn');

        const ratingLabels = {
            '1': 'Sangat Kurang 😠',
            '2': 'Kurang 😕',
            '3': 'Cukup 😐',
            '4': 'Bagus! 🙂',
            '5': 'Sangat Bagus! 😍'
        };

        // Efek Hover Sorot
        stars.forEach(star => {
            star.addEventListener('mouseover', function() {
                const hoverVal = this.getAttribute('data-value');
                highlightStars(hoverVal);
            });

            star.addEventListener('mouseout', function() {
                const currentVal = ratingInput.value;
                highlightStars(currentVal);
            });

            star.addEventListener('click', function() {
                const selectVal = this.getAttribute('data-value');
                ratingInput.value = selectVal;
                ratingText.innerText = ratingLabels[selectVal];
                ratingText.className = 'fw-bold text-success scale-up-animation';
                submitBtn.disabled = false; // Aktifkan tombol kirim
                highlightStars(selectVal);
            });
        });

        // Highlighter function
        function highlightStars(val) {
            stars.forEach(star => {
                const starVal = star.getAttribute('data-value');
                if (starVal <= val) {
                    star.className = 'bi bi-star-fill star-icon cursor-pointer text-warning glow-star';
                } else {
                    star.className = 'bi bi-star star-icon cursor-pointer text-secondary opacity-50';
                }
            });
        }

        // Jalankan highlight jika ada old value (setelah validasi gagal)
        const initialVal = ratingInput.value;
        if (initialVal) {
            highlightStars(initialVal);
            ratingText.innerText = ratingLabels[initialVal];
            ratingText.className = 'fw-bold text-success';
            submitBtn.disabled = false;
        }

    });
</script>

<style>
    .review-create-section {
        background-color: var(--bs-body-bg);
        padding-top: 95px !important;
    }

    .review-card {
        background-color: #ffffff;
        border: 1px solid rgba(0,0,0,0.03);
    }
    .dark-mode .review-card {
        background-color: #1e1e1e !important;
        border-color: rgba(255,255,255,0.04) !important;
    }

    .dark-mode .text-dark, .dark-mode h3, .dark-mode h5, .dark-mode label {
        color: #ffffff !important;
    }
    .dark-mode .text-secondary {
        color: #b0b0b0 !important;
    }

    .product-summary-card {
        background-color: #fafafa;
        border-color: rgba(0,0,0,0.04) !important;
    }
    .dark-mode .product-summary-card {
        background-color: #2b2b2b !important;
        border-color: rgba(255,255,255,0.05) !important;
    }

    /* BINTANG RATING STYLING */
    .star-icon {
        font-size: 2.5rem;
        transition: transform 0.15s ease-in-out, color 0.15s ease-in-out;
    }
    .star-icon:hover {
        transform: scale(1.18);
    }
    
    .glow-star {
        text-shadow: 0 0 10px rgba(255, 193, 7, 0.4);
    }

    /* Comment Box Area */
    #comment {
        border-color: rgba(0,0,0,0.08);
        font-size: 0.95rem;
        resize: none;
    }
    .dark-mode #comment {
        background-color: #2b2b2b !important;
        border-color: rgba(255,255,255,0.08) !important;
        color: #ffffff !important;
    }
    
    .scale-up-animation {
        animation: scaleUp 0.25s ease-out;
    }
    @keyframes scaleUp {
        0% { transform: scale(0.9); opacity: 0.8; }
        100% { transform: scale(1); opacity: 1; }
    }

    /* BUTTONS STYLING */
    .btn-batal {
        border-color: rgba(0,0,0,0.08) !important;
    }
    .dark-mode .btn-batal {
        background-color: #2b2b2b !important;
        border-color: rgba(255,255,255,0.06) !important;
        color: #b0b0b0 !important;
    }
    .dark-mode .btn-batal:hover {
        background-color: #333333 !important;
        color: #ffffff !important;
    }

    .btn-submit-ulasan {
        background-color: #198754 !important;
        border-color: #198754 !important;
        color: #ffffff !important;
        transition: all 0.2s ease-in-out;
    }
    .btn-submit-ulasan:hover:not(:disabled) {
        background-color: #157347 !important;
        border-color: #146c43 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(25, 135, 84, 0.2) !important;
    }
    
    .btn-submit-ulasan:disabled {
        background-color: #a3cfbb !important;
        border-color: #a3cfbb !important;
        color: rgba(255,255,255,0.7) !important;
        cursor: not-allowed;
        box-shadow: none !important;
    }
    .dark-mode .btn-submit-ulasan:disabled {
        background-color: #2c4d3d !important;
        border-color: #2c4d3d !important;
        color: rgba(255,255,255,0.4) !important;
    }
</style>
@endsection
