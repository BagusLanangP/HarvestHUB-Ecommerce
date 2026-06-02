@extends('layouts.mainlayouts')

@section('tittle', 'Detail Ahli Pakar')

@section('content')
<section class="service-detail-section py-5">
    <div class="container py-4">
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="/Ahlipakar/view" class="btn btn-link text-success p-0 fw-semibold text-decoration-none d-inline-flex align-items-center gap-1">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Jasa
            </a>
        </div>

        <div class="row g-4">
            {{-- KOLOM KIRI - Profil Utama & Kontak --}}
            <div class="col-12 col-lg-4">
                <div class="card border-0 shadow rounded-4 p-4 text-center bg-white profile-card-left">
                    <div class="position-relative mx-auto mb-3" style="width: 150px; height: 150px;">
                        <img src="{{ $itemproduk->foto ? asset('storage/' . $itemproduk->foto) : asset('img/default-avatar.png') }}" 
                             class="rounded-circle shadow border border-4 border-white object-fit-cover w-100 h-100" 
                             alt="{{ $itemproduk->nama }}">
                        <span class="position-absolute bottom-0 end-0 bg-success border border-white rounded-circle shadow-sm" style="width: 18px; height: 18px; border-width: 3px;"></span>
                    </div>

                    <h4 class="fw-bold text-dark mb-1">{{ $itemproduk->nama }}</h4>
                    <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-1.5 fw-semibold rounded-pill mb-3" style="font-size: 0.8rem;">
                        <i class="bi bi-award me-1"></i> {{ $itemproduk->keahlian }}
                    </span>

                    <hr class="my-3 opacity-10">

                    {{-- Data List --}}
                    <div class="text-start mb-4">
                        <div class="mb-3 d-flex align-items-start gap-2.5">
                            <span class="bg-light text-success p-2 rounded-circle d-flex align-items-center justify-content-center border" style="width: 36px; height: 36px;">
                                <i class="bi bi-envelope"></i>
                            </span>
                            <div>
                                <small class="text-secondary d-block" style="font-size: 0.75rem;">Email</small>
                                <span class="text-dark fw-medium" style="font-size: 0.9rem;">{{ $itemproduk->email }}</span>
                            </div>
                        </div>

                        <div class="mb-3 d-flex align-items-start gap-2.5">
                            <span class="bg-light text-success p-2 rounded-circle d-flex align-items-center justify-content-center border" style="width: 36px; height: 36px;">
                                <i class="bi bi-telephone"></i>
                            </span>
                            <div>
                                <small class="text-secondary d-block" style="font-size: 0.75rem;">Nomor Telepon</small>
                                <span class="text-dark fw-medium" style="font-size: 0.9rem;">{{ $itemproduk->phone }}</span>
                            </div>
                        </div>

                        <div class="d-flex align-items-start gap-2.5">
                            <span class="bg-light text-success p-2 rounded-circle d-flex align-items-center justify-content-center border" style="width: 36px; height: 36px;">
                                <i class="bi bi-geo-alt"></i>
                            </span>
                            <div>
                                <small class="text-secondary d-block" style="font-size: 0.75rem;">Alamat Domisili</small>
                                <span class="text-dark fw-medium" style="font-size: 0.9rem;">{{ $itemproduk->alamat }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Tombol Aksi Kiri --}}
                    <div class="d-grid gap-2">
                        @php
                            $waPhone = preg_replace('/[^0-9]/', '', $itemproduk->phone);
                            if (str_starts_with($waPhone, '0')) {
                                $waPhone = '62' . substr($waPhone, 1);
                            }
                        @endphp
                        <a href="https://wa.me/{{ $waPhone }}?text=Halo%20{{ urlencode($itemproduk->nama) }},%20saya%20tertarik%20dengan%20jasa%20konsultasi%20Anda%20di%20HarvestHUB." 
                           target="_blank" 
                           class="btn btn-success rounded-pill fw-semibold py-2.5 d-flex align-items-center justify-content-center gap-2 shadow-sm btn-action-left btn-wa">
                            <i class="bi bi-whatsapp"></i> Hubungi WhatsApp
                        </a>

                        @if($itemproduk->foto_cv)
                            <a href="{{ asset('storage/' . $itemproduk->foto_cv) }}" 
                               target="_blank" 
                               class="btn btn-outline-success rounded-pill fw-semibold py-2.5 d-flex align-items-center justify-content-center gap-2 btn-action-left">
                                <i class="bi bi-file-earmark-pdf"></i> Lihat / Download CV
                            </a>
                        @else
                            <button class="btn btn-light text-muted rounded-pill fw-semibold py-2.5 d-flex align-items-center justify-content-center gap-2 cursor-not-allowed border" disabled>
                                <i class="bi bi-file-earmark-pdf"></i> CV Belum Diunggah
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN - Rincian Jasa & Kompetensi --}}
            <div class="col-12 col-lg-8">
                <div class="card border-0 shadow rounded-4 p-4 bg-white profile-card-right h-100">
                    {{-- Judul Sekilas --}}
                    <div class="mb-4">
                        <span class="text-secondary text-uppercase fw-bold ls-2" style="font-size: 0.75rem;">Profil Jasa Ahli Pakar</span>
                        <h2 class="fw-bold text-dark mt-1">Rincian Kompetensi & Layanan</h2>
                        <hr class="mt-3 opacity-10">
                    </div>

                    {{-- Deskripsi Profil --}}
                    <div class="mb-4">
                        <h5 class="fw-bold text-dark d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-person-lines-fill text-success"></i> Tentang Ahli Pakar
                        </h5>
                        <div class="text-secondary leading-relaxed p-3 bg-light rounded-3 border" style="font-size: 0.95rem;">
                            {!! $itemproduk->deskripsi !!}
                        </div>
                    </div>

                    {{-- Pengalaman --}}
                    <div>
                        <h5 class="fw-bold text-dark d-flex align-items-center gap-2 mb-3">
                            <i class="bi bi-briefcase text-success"></i> Pengalaman Kerja & Kualifikasi
                        </h5>
                        <div class="text-secondary leading-relaxed p-3 bg-light rounded-3 border" style="font-size: 0.95rem;">
                            {!! $itemproduk->pengalaman !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Custom CSS Premium Detail Services --}}
<style>
    .service-detail-section {
        background-color: var(--bs-body-bg);
        padding-top: 95px !important; /* Push down to avoid navbar overlap */
    }

    .profile-card-left, .profile-card-right {
        background-color: #ffffff;
    }

    .dark-mode .profile-card-left,
    .dark-mode .profile-card-right {
        background-color: #1e1e1e !important;
    }

    .dark-mode .text-dark, .dark-mode h4, .dark-mode h5, .dark-mode h2 {
        color: #ffffff !important;
    }

    .dark-mode .text-secondary {
        color: #b0b0b0 !important;
    }

    .dark-mode .bg-light {
        background-color: #242424 !important;
        border-color: rgba(255, 255, 255, 0.08) !important;
    }

    .dark-mode .border {
        border-color: rgba(255, 255, 255, 0.08) !important;
    }

    .gap-2.5 {
        gap: 0.75rem;
    }

    .ls-2 {
        letter-spacing: 1.5px;
    }

    .leading-relaxed {
        line-height: 1.65;
    }

    /* WhatsApp Button Styles */
    .btn-wa {
        background-color: #25d366 !important;
        border-color: #25d366 !important;
        color: #ffffff !important;
    }
    .btn-wa:hover {
        background-color: #20ba5a !important;
        border-color: #20ba5a !important;
        box-shadow: 0 4px 10px rgba(37, 211, 102, 0.2) !important;
    }

    .btn-action-left, .btn-dashboard-toko {
        transition: all 0.2s ease-in-out;
    }

    .btn-action-left:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.08) !important;
    }

    .cursor-not-allowed {
        cursor: not-allowed !important;
    }
</style>
@endsection