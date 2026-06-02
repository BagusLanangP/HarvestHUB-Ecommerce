@extends('layouts.mainlayouts')

@section('tittle', 'Pusat Chat & Hubungi')

@section('content')
<section class="chat-hub-section py-5">
    <div class="container py-4">
        {{-- Header Section --}}
        <div class="text-center mb-5 mt-3">
            <span class="text-success text-uppercase fw-bold ls-2" style="font-size: 0.8rem;">HarvestHUB Connect</span>
            <h1 class="fw-bold text-dark mt-1">Pusat Hubungan & Chat</h1>
            <p class="text-secondary mx-auto" style="max-width: 600px;">Hubungi para penjual produk tani, ahli pakar pertanian, atau tenaga kerja profesional secara instan melalui kontak di bawah ini.</p>
        </div>

        {{-- Nav Tabs --}}
        <ul class="nav nav-pills nav-justified mb-5 shadow-sm rounded-pill p-1.5 bg-white border filter-pills" id="chatHubTabs" role="tablist" style="max-width: 750px; margin: 0 auto;">
            <li class="nav-item" role="presentation">
                <button class="nav-link active rounded-pill fw-semibold py-2.5" id="toko-tab" data-bs-toggle="pill" data-bs-target="#toko-pane" type="button" role="tab" aria-controls="toko-pane" aria-selected="true">
                    <i class="bi bi-shop me-1.5"></i> Toko Tani / Penjual
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill fw-semibold py-2.5" id="pakar-tab" data-bs-toggle="pill" data-bs-target="#pakar-pane" type="button" role="tab" aria-controls="pakar-pane" aria-selected="false">
                    <i class="bi bi-award me-1.5"></i> Ahli Pakar / Konsultan
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link rounded-pill fw-semibold py-2.5" id="pekerja-tab" data-bs-toggle="pill" data-bs-target="#pekerja-pane" type="button" role="tab" aria-controls="pekerja-pane" aria-selected="false">
                    <i class="bi bi-person-workspace me-1.5"></i> Tenaga Kerja
                </button>
            </li>
        </ul>

        {{-- Tab Panes --}}
        <div class="tab-content mt-4" id="chatHubTabsContent">
            
            {{-- PANE TOKO TANI --}}
            <div class="tab-pane fade show active" id="toko-pane" role="tabpanel" aria-labelledby="toko-tab" tabindex="0">
                @if($tokos->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-shop text-muted" style="font-size: 3.5rem;"></i>
                        <p class="text-secondary mt-3 fs-5">Belum ada penjual/toko tani terdaftar saat ini.</p>
                    </div>
                @else
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach($tokos as $toko)
                            <div class="col">
                                <div class="card border-0 shadow rounded-4 p-4 h-100 bg-white hover-zoom-container">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <img src="{{ $toko->foto ? asset('storage/' . $toko->foto) : asset('img/default-shop.png') }}" 
                                             class="rounded-circle border border-2 border-white shadow-sm flex-shrink-0" 
                                             alt="{{ $toko->nama }}" 
                                             style="width: 65px; height: 65px; object-fit: cover;">
                                        <div>
                                            <h5 class="fw-bold text-dark mb-0.5">{{ $toko->nama }}</h5>
                                            <span class="text-secondary small d-block"><i class="bi bi-geo-alt text-danger me-1"></i>{{ $toko->alamat }}</span>
                                        </div>
                                    </div>
                                    <p class="text-secondary small leading-relaxed mb-4 flex-grow-1">{!! Str::limit(strip_tags($toko->deskripsi), 95) !!}</p>
                                    
                                    @php
                                        $tokoWa = preg_replace('/[^0-9]/', '', $toko->phone);
                                        if (str_starts_with($tokoWa, '0')) {
                                            $tokoWa = '62' . substr($tokoWa, 1);
                                        }
                                        $tokoWaUrl = "https://wa.me/" . $tokoWa . "?text=Halo%20Toko%20" . urlencode($toko->nama) . ",%20saya%20ingin%20bertanya%20mengenai%20katalog%20produk%20tani%20Anda%20di%20HarvestHUB.";
                                    @endphp
                                    <div class="d-grid gap-2">
                                        <a href="{{ $tokoWaUrl }}" target="_blank" class="btn btn-success rounded-pill fw-semibold py-2 d-flex align-items-center justify-content-center gap-2 text-white text-decoration-none shadow-sm btn-contact btn-wa">
                                            <i class="bi bi-whatsapp fs-5"></i> Chat via WhatsApp
                                        </a>
                                        <a href="mailto:{{ $toko->email }}" class="btn btn-outline-success rounded-pill fw-semibold py-2 d-flex align-items-center justify-content-center gap-2 btn-contact">
                                            <i class="bi bi-envelope"></i> Kirim Email
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- PANE AHLI PAKAR --}}
            <div class="tab-pane fade" id="pakar-pane" role="tabpanel" aria-labelledby="pakar-tab" tabindex="0">
                @if($konsultans->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-award text-muted" style="font-size: 3.5rem;"></i>
                        <p class="text-secondary mt-3 fs-5">Belum ada konsultan/ahli pakar terdaftar saat ini.</p>
                    </div>
                @else
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach($konsultans as $pakar)
                            <div class="col">
                                <div class="card border-0 shadow rounded-4 p-4 h-100 bg-white hover-zoom-container">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <img src="{{ $pakar->foto ? asset('storage/' . $pakar->foto) : asset('img/default-avatar.png') }}" 
                                             class="rounded-circle border border-2 border-white shadow-sm flex-shrink-0" 
                                             alt="{{ $pakar->nama }}" 
                                             style="width: 65px; height: 65px; object-fit: cover;">
                                        <div>
                                            <h5 class="fw-bold text-dark mb-0.5">{{ $pakar->nama }}</h5>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle small fw-semibold px-2 py-0.5 rounded-pill">{{ $pakar->keahlian }}</span>
                                        </div>
                                    </div>
                                    <p class="text-secondary small leading-relaxed mb-4 flex-grow-1">{!! Str::limit(strip_tags($pakar->deskripsi), 95) !!}</p>
                                    
                                    @php
                                        $pakarWa = preg_replace('/[^0-9]/', '', $pakar->phone);
                                        if (str_starts_with($pakarWa, '0')) {
                                            $pakarWa = '62' . substr($pakarWa, 1);
                                        }
                                        $pakarWaUrl = "https://wa.me/" . $pakarWa . "?text=Halo%20" . urlencode($pakar->nama) . ",%20saya%20ingin%20melakukan%20konsultasi%20pertanian%20mengenai%20jasa%20Anda%20di%20HarvestHUB.";
                                    @endphp
                                    <div class="d-grid gap-2">
                                        <a href="{{ $pakarWaUrl }}" target="_blank" class="btn btn-success rounded-pill fw-semibold py-2 d-flex align-items-center justify-content-center gap-2 text-white text-decoration-none shadow-sm btn-contact btn-wa">
                                            <i class="bi bi-whatsapp fs-5"></i> Chat via WhatsApp
                                        </a>
                                        <a href="/ahlipakar/{{ $pakar->user->slug }}" class="btn btn-outline-success rounded-pill fw-semibold py-2 d-flex align-items-center justify-content-center gap-2 btn-contact">
                                            <i class="bi bi-person-lines-fill"></i> Lihat Profil Lengkap
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- PANE TENAGA KERJA --}}
            <div class="tab-pane fade" id="pekerja-pane" role="tabpanel" aria-labelledby="pekerja-tab" tabindex="0">
                @if($tenagaKerjas->isEmpty())
                    <div class="text-center py-5">
                        <i class="bi bi-person-workspace text-muted" style="font-size: 3.5rem;"></i>
                        <p class="text-secondary mt-3 fs-5">Belum ada tenaga kerja terdaftar saat ini.</p>
                    </div>
                @else
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @foreach($tenagaKerjas as $pekerja)
                            <div class="col">
                                <div class="card border-0 shadow rounded-4 p-4 h-100 bg-white hover-zoom-container">
                                    <div class="d-flex align-items-center gap-3 mb-3">
                                        <img src="{{ $pekerja->foto ? asset('storage/' . $pekerja->foto) : asset('img/default-avatar.png') }}" 
                                             class="rounded-circle border border-2 border-white shadow-sm flex-shrink-0" 
                                             alt="{{ $pekerja->nama }}" 
                                             style="width: 65px; height: 65px; object-fit: cover;">
                                        <div>
                                            <h5 class="fw-bold text-dark mb-0.5">{{ $pekerja->nama }}</h5>
                                            <span class="badge bg-info-subtle text-info border border-info-subtle small fw-semibold px-2 py-0.5 rounded-pill">{{ $pekerja->keahlian }}</span>
                                        </div>
                                    </div>
                                    <p class="text-secondary small leading-relaxed mb-4 flex-grow-1">{!! Str::limit(strip_tags($pekerja->deskripsi), 95) !!}</p>
                                    
                                    @php
                                        $pekerjaWa = preg_replace('/[^0-9]/', '', $pekerja->phone);
                                        if (str_starts_with($pekerjaWa, '0')) {
                                            $pekerjaWa = '62' . substr($pekerjaWa, 1);
                                        }
                                        $pekerjaWaUrl = "https://wa.me/" . $pekerjaWa . "?text=Halo%20" . urlencode($pekerja->nama) . ",%20saya%20tertarik%20untuk%20merekrut%20Anda%20sebagai%20tenaga%20kerja%20melalui%20HarvestHUB.";
                                    @endphp
                                    <div class="d-grid gap-2">
                                        <a href="{{ $pekerjaWaUrl }}" target="_blank" class="btn btn-success rounded-pill fw-semibold py-2 d-flex align-items-center justify-content-center gap-2 text-white text-decoration-none shadow-sm btn-contact btn-wa">
                                            <i class="bi bi-whatsapp fs-5"></i> Chat via WhatsApp
                                        </a>
                                        <a href="/tenagakerja/{{ $pekerja->user->slug }}" class="btn btn-outline-success rounded-pill fw-semibold py-2 d-flex align-items-center justify-content-center gap-2 btn-contact">
                                            <i class="bi bi-person-lines-fill"></i> Lihat Profil Lengkap
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

{{-- Custom Style --}}
<style>
    .chat-hub-section {
        background-color: var(--bs-body-bg);
        padding-top: 95px !important; /* Push down to avoid navbar overlap */
    }

    .ls-2 {
        letter-spacing: 1.8px;
    }

    .leading-relaxed {
        line-height: 1.6;
    }

    /* Tabs Styling */
    .filter-pills {
        background-color: #ffffff;
        border-color: rgba(0, 0, 0, 0.05) !important;
    }
    .dark-mode .filter-pills {
        background-color: #1e1e1e !important;
        border-color: rgba(255, 255, 255, 0.06) !important;
    }

    #chatHubTabs button {
        color: #6c757d;
        transition: all 0.25s ease-in-out;
    }
    #chatHubTabs button.active {
        background-color: #198754 !important;
        color: #ffffff !important;
        box-shadow: 0 4px 10px rgba(25, 135, 84, 0.18) !important;
    }

    /* Cards Styling */
    .hover-zoom-container {
        transition: transform 0.25s ease, box-shadow 0.25s ease;
        border: 1px solid rgba(0, 0, 0, 0.04) !important;
    }
    .hover-zoom-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08) !important;
    }

    .dark-mode .card {
        background-color: #1e1e1e !important;
        border-color: rgba(255, 255, 255, 0.06) !important;
    }
    .dark-mode .text-dark, .dark-mode h1, .dark-mode h5 {
        color: #ffffff !important;
    }
    .dark-mode .text-secondary {
        color: #b0b0b0 !important;
    }

    /* WhatsApp button formatting */
    .btn-wa {
        background-color: #25d366 !important;
        border-color: #25d366 !important;
    }
    .btn-wa:hover {
        background-color: #20ba5a !important;
        border-color: #20ba5a !important;
        box-shadow: 0 4px 10px rgba(37, 211, 102, 0.18) !important;
    }

    .btn-contact {
        transition: all 0.25s ease-in-out;
    }
    .btn-contact:hover {
        transform: translateY(-1.5px);
    }
</style>
@endsection
