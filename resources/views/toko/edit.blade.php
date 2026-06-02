@extends('layouts.mainlayouts')

@section('tittle', 'Edit Profil Toko')

@section('content')
    <section id="tenagakerja" class="py-5" style="padding-top: 110px !important;">
      <div class="container">
        <div class="row text-center mb-4">
            <div class="login-tittle">
                <h2 class="fw-bold text-dark mb-1">Edit Profil Toko</h2>
                <p class="text-secondary">Perbarui informasi toko Anda untuk meningkatkan kepercayaan pembeli</p>
            </div>
        </div>
        
        <div class="row justify-content-center">
          <div class="col-12 col-md-10 col-lg-8">
            <div class="card border-0 shadow rounded-4 p-4 p-sm-5 bg-white edit-toko-card">
              <form action="{{ route('Toko.update', $data->id) }}" method="post" enctype="multipart/form-data">
                @method('PATCH')
                @csrf
                
                {{-- Nama Toko --}}
                <div class="mb-4">
                    <label for="nama" class="form-label fw-semibold">Nama Toko <span class="text-success small">(Telah Diverifikasi)</span></label>
                    <input type="text" class="form-control rounded-3 bg-light" id="nama" name="nama" placeholder="Masukkan nama toko" 
                      @error('nama') is-invalid @enderror value="{{ old('nama', $data->nama) }}" readonly required>
                    @error('nama')
                      <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="mb-4">
                    <label for="email" class="form-label fw-semibold">Email Toko <span class="text-success small">(Telah Diverifikasi)</span></label>
                    <input type="email" class="form-control rounded-3 bg-light" id="email" name="email" placeholder="Masukkan email toko" 
                      @error('email') is-invalid @enderror value="{{ old('email', $data->email) }}" readonly required>
                    @error('email')
                      <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Nomor Telepon --}}
                <div class="mb-4">
                    <label for="phone" class="form-label fw-semibold">Nomor Telepon <span class="text-success small">(Telah Diverifikasi)</span></label>
                    <input type="text" class="form-control rounded-3 bg-light" id="phone" name="phone" placeholder="Masukkan nomor telepon" 
                      @error('phone') is-invalid @enderror value="{{ old('phone', $data->phone) }}" readonly required>
                    @error('phone')
                      <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Alamat --}}
                <div class="mb-4">
                    <label for="alamat" class="form-label fw-semibold">Alamat Lengkap <span class="text-success small">(Telah Diverifikasi)</span></label>
                    <input type="text" class="form-control rounded-3 bg-light" id="alamat" name="alamat" placeholder="Masukkan alamat lengkap toko" 
                      @error('alamat') is-invalid @enderror value="{{ old('alamat', $data->alamat) }}" readonly required>
                    @error('alamat')
                      <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    {{-- Tahun Berdiri --}}
                    <div class="col-12 col-sm-6 mb-4">
                        <label for="year_started" class="form-label fw-semibold">Tahun Berdiri</label>
                        <input type="number" class="form-control rounded-3" id="year_started" name="year_started" placeholder="Contoh: 2024" 
                          @error('year_started') is-invalid @enderror value="{{ old('year_started', $data->year_started) }}">
                        @error('year_started')
                          <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>
                    
                    {{-- Wilayah --}}
                    <div class="col-12 col-sm-6 mb-4">
                        <label for="region" class="form-label fw-semibold">Wilayah / Kota</label>
                        <input type="text" class="form-control rounded-3" id="region" name="region" placeholder="Masukkan wilayah operasional" 
                          @error('region') is-invalid @enderror value="{{ old('region', $data->region) }}">
                        @error('region')
                          <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <hr class="my-4 opacity-10">

                {{-- Modul Edit Foto Profil Toko --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold d-block">Foto Profil Toko</label>
                    <div class="d-flex align-items-center gap-3 flex-wrap flex-sm-nowrap">
                        <img src="{{ $data->foto ? asset('storage/' . $data->foto) : asset('img/default-shop.png') }}" class="rounded-circle shadow border border-3 border-white flex-shrink-0" alt="Logo Toko" style="width: 90px; height: 90px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <input type="file" class="form-control rounded-3 form-control-sm" id="foto" name="foto" accept="image/*">
                            <small class="text-secondary d-block mt-1">Format: JPG, PNG, JPEG. Maks: 2MB (Biarkan kosong jika tidak ingin mengubah)</small>
                        </div>
                    </div>
                    @error('foto')
                      <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>

                {{-- Modul Edit Syarat Verifikasi --}}
                <div class="mb-4">
                    <label class="form-label fw-semibold d-block">Dokumen Syarat Verifikasi</label>
                    <div class="d-flex align-items-center gap-3 flex-wrap flex-sm-nowrap">
                        <div class="flex-shrink-0">
                            @if($data->foto_cv)
                                <a href="{{ asset('storage/' . $data->foto_cv) }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill px-3 py-2 fw-semibold d-inline-flex align-items-center gap-1">
                                    <i class="bi bi-file-earmark-text-fill"></i> Lihat Dokumen Saat Ini
                                </a>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary px-3 py-2 rounded-pill">Belum Ada Dokumen</span>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <input type="file" class="form-control rounded-3 form-control-sm" id="foto_syarat" name="foto_syarat" accept="image/*">
                            <small class="text-secondary d-block mt-1">Format: Gambar/Dokumen. Maks: 2MB (Upload untuk mengganti berkas verifikasi lama)</small>
                        </div>
                    </div>
                    @error('foto_syarat')
                      <div class="text-danger small mt-1"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                </div>

                <hr class="my-4 opacity-10">

                {{-- Tautan Media Sosial --}}
                <div class="row">
                    <div class="col-12 col-md-4 mb-4">
                        <label for="link_tiktok" class="form-label fw-semibold"><i class="bi bi-tiktok text-dark me-1"></i> TikTok</label>
                        <input type="url" class="form-control rounded-3" id="link_tiktok" name="link_tiktok" placeholder="https://tiktok.com/@username" 
                          @error('link_tiktok') is-invalid @enderror value="{{ old('link_tiktok', $data->link_tiktok) }}">
                        @error('link_tiktok')
                          <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-4 mb-4">
                        <label for="link_ig" class="form-label fw-semibold"><i class="bi bi-instagram text-danger me-1"></i> Instagram</label>
                        <input type="url" class="form-control rounded-3" id="link_ig" name="link_ig" placeholder="https://instagram.com/username" 
                          @error('link_ig') is-invalid @enderror value="{{ old('link_ig', $data->link_ig) }}">
                        @error('link_ig')
                          <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-12 col-md-4 mb-4">
                        <label for="link_fb" class="form-label fw-semibold"><i class="bi bi-facebook text-primary me-1"></i> Facebook</label>
                        <input type="url" class="form-control rounded-3" id="link_fb" name="link_fb" placeholder="https://facebook.com/username" 
                          @error('link_fb') is-invalid @enderror value="{{ old('link_fb', $data->link_fb) }}">
                        @error('link_fb')
                          <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-5">
                    <label for="deskripsi" class="form-label fw-semibold">Deskripsi Toko</label>
                    <input id="deskripsi" type="hidden" name="deskripsi" @error('deskripsi') is-invalid @enderror value="{{ old('deskripsi', $data->deskripsi) }}" required>
                    @error('deskripsi')
                        <div class="text-danger small mt-1 mb-2"><i class="bi bi-exclamation-circle-fill"></i> {{ $message }}</div>
                    @enderror
                    <div class="trix-wrapper rounded-3">
                        <trix-editor input="deskripsi"></trix-editor>
                    </div>
                </div>
                
                {{-- Button Submit --}}
                <div class="text-center">
                    <button type="submit" class="btn btn-success rounded-pill px-5 py-2.5 fw-semibold shadow-sm btn-submit-edit">
                        <i class="bi bi-check-circle-fill me-2"></i> Simpan Perubahan
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
    .edit-toko-card {
        background-color: #ffffff;
    }
    .dark-mode .edit-toko-card {
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
    .btn-submit-edit {
        background-color: #198754 !important;
        border-color: #198754 !important;
        color: #ffffff !important;
        transition: all 0.2s ease-in-out;
    }
    .btn-submit-edit:hover {
        background-color: #157347 !important;
        border-color: #146c43 !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(25, 135, 84, 0.2) !important;
    }
</style>
@endsection