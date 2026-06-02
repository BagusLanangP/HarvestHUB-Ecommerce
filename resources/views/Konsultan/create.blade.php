@extends('layouts.mainlayouts')

@section('tittle', 'Lengkapi Profil Ahli Pakar')

@section('content')
    <section id="tenagakerja" class="py-5" style="padding-top: 110px !important;">
      <div class="container">
        <div class="row text-center mb-4">
            <div class="login-tittle">
                <h2 class="fw-bold text-dark mb-1">Lengkapi Data Profil Ahli Pakar</h2>
                <p class="text-secondary">Lengkapi profil konsultasi Anda yang telah disetujui untuk mulai menawarkan layanan edukasi pertanian</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
          <div class="col-12 col-md-10 col-lg-8">
            <div class="card border-0 shadow rounded-4 p-4 p-sm-5 bg-white create-ks-card">
              <form action="/Konsultan" method="post" enctype="multipart/form-data">
                @csrf
                
                {{-- Nama (Prefilled & Readonly) --}}
                <div class="mb-4">
                    <label for="nama" class="form-label fw-semibold">Nama Lengkap <span class="text-success small">(Telah Diverifikasi)</span></label>
                    <input type="text" class="form-control rounded-3 bg-light" id="nama" name="nama" 
                      value="{{ old('nama', $latestRequest->user->name ?? '') }}" readonly required>
                    @error('nama')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Email (Prefilled & Readonly) --}}
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">Email <span class="text-success small">(Telah Diverifikasi)</span></label>
                    <input type="email" class="form-control rounded-3 bg-light" id="email" name="email" 
                      value="{{ old('email', $latestRequest->email ?? auth()->user()->email ?? '') }}" readonly required>
                    @error('email')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Nomor Telepon (Prefilled & Readonly) --}}
                <div class="mb-4">
                    <label for="phone" class="form-label fw-semibold">Nomor Telepon <span class="text-success small">(Telah Diverifikasi)</span></label>
                    <input type="text" class="form-control rounded-3 bg-light" id="phone" name="phone" 
                      value="{{ old('phone', $latestRequest->whatsapp ?? '') }}" readonly required>
                    @error('phone')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat (Prefilled & Readonly) --}}
                <div class="mb-4">
                    <label for="alamat" class="form-label fw-semibold">Alamat Lengkap / Domisili <span class="text-success small">(Telah Diverifikasi)</span></label>
                    <input type="text" class="form-control rounded-3 bg-light" id="alamat" name="alamat" 
                      value="{{ old('alamat', $latestRequest->domicile ?? '') }}" readonly required>
                    @error('alamat')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Keahlian (Prefilled & Readonly) --}}
                <div class="mb-4">
                    <label for="keahlian" class="form-label fw-semibold">Keahlian / Spesialisasi Utama <span class="text-success small">(Telah Diverifikasi)</span></label>
                    <input type="text" class="form-control rounded-3 bg-light" id="keahlian" name="keahlian" 
                      value="{{ old('keahlian', $latestRequest->metadata['expertise'] ?? '') }}" readonly required>
                    @error('keahlian')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4 opacity-10">

                {{-- Foto Profil (Editable) --}}
                <div class="mb-4">
                    <label for="foto" class="form-label fw-semibold">Foto Profil Resmi</label>
                    <input type="file" class="form-control rounded-3" id="foto" name="foto" accept="image/*" required>
                    <small class="text-secondary d-block mt-1">Format: JPG, PNG, JPEG. Maks: 2MB</small>
                    @error('foto')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Upload CV/Sertifikat (Editable) --}}
                <div class="mb-4">
                    <label for="foto_cv" class="form-label fw-semibold">Sertifikasi Keahlian / CV (PDF/Gambar)</label>
                    <input type="file" class="form-control rounded-3" id="foto_cv" name="foto_cv">
                    <small class="text-secondary d-block mt-1">Format: PDF/Gambar. Maks: 2MB</small>
                    @error('foto_cv')
                      <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4 opacity-10">

                {{-- Pengalaman (Editable) --}}
                <div class="mb-4">
                    <label for="pengalaman" class="form-label fw-semibold">Tahun Pengalaman & Portofolio</label>
                    <input id="pengalaman" type="hidden" name="pengalaman" value="{{ old('pengalaman', $latestRequest->metadata['experience'] ?? '') }}" required>
                    @error('pengalaman')
                        <div class="text-danger small mt-1 mb-2">{{ $message }}</div>
                    @enderror
                    <div class="trix-wrapper rounded-3">
                        <trix-editor input="pengalaman" placeholder="Jabarkan tentang pengalaman praktek / sertifikasi Anda..."></trix-editor>
                    </div>
                </div>

                {{-- Deskripsi (Editable) --}}
                <div class="mb-5">
                    <label for="deskripsi" class="form-label fw-semibold">Deskripsi Layanan Konsultasi</label>
                    <input id="deskripsi" type="hidden" name="deskripsi" value="{{ old('deskripsi') }}" required>
                    @error('deskripsi')
                        <div class="text-danger small mt-1 mb-2">{{ $message }}</div>
                    @enderror
                    <div class="trix-wrapper rounded-3">
                        <trix-editor input="deskripsi" placeholder="Tuliskan penjelasan tentang diri Anda dan layanan konsultasi Anda..."></trix-editor>
                    </div>
                </div>
                
                {{-- Button Submit --}}
                <div class="text-center">
                    <button type="submit" class="btn btn-success rounded-pill px-5 py-2.5 fw-semibold shadow-sm btn-submit-create">
                        <i class="bi bi-save me-2"></i> Simpan Profil
                    </button>
                </div>
                                
              </form>
            </div>
          </div>
        </div>
        
      </div>
    </section>

{{-- Custom CSS untuk Tampilan Premium & Kompatibilitas Dark Mode --}}
<style>
    .create-ks-card {
        background-color: #ffffff;
    }
    .dark-mode .create-ks-card {
        background-color: #1e1e1e !important;
    }
    .dark-mode .form-label {
        color: #e0e0e0 !important;
    }
    .dark-mode .form-control {
        background-color: #2b2b2b !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
    }
    .dark-mode .form-control:focus {
        border-color: #198754 !important;
        box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25) !important;
    }
    .trix-wrapper trix-editor {
        min-height: 180px;
        background-color: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 0.375rem;
    }
    .dark-mode .trix-wrapper trix-editor {
        background-color: #2b2b2b !important;
        border-color: rgba(255, 255, 255, 0.1) !important;
        color: #ffffff !important;
    }
    .btn-submit-create {
        background-color: #198754 !important;
        border-color: #198754 !important;
        color: #ffffff !important;
        transition: all 0.2s ease-in-out;
    }
    .btn-submit-create:hover {
        background-color: #157347 !important;
        border-color: #146c43 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(25, 135, 84, 0.2) !important;
    }
</style>
@endsection