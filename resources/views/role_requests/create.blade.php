@extends('layouts.mainlayouts')

@section('tittle', 'Pengajuan Upgrade Role')

@section('content')
<div class="container py-5" style="padding-top: 100px !important;">
    <div class="row justify-content-center">
        <div class="col-md-9 col-lg-8">
            
            {{-- Decorative top badge --}}
            <div class="text-center mb-4">
                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1.5 fw-semibold small mb-2">Upgrade Akun</span>
                <h2 class="fw-bold text-dark" style="font-family: 'Outfit', sans-serif;">Ajukan Upgrade Role</h2>
                <p class="text-secondary small">Kembangkan akun Anda ke tingkat berikutnya untuk mengakses fitur-fitur eksklusif HarvestHUB</p>
            </div>

            <div class="card border-0 shadow rounded-4 overflow-hidden bg-white mb-5">
                <div class="card-header border-0 p-4 text-white text-center d-flex flex-column align-items-center justify-content-center gap-2" style="background: linear-gradient(135deg, #198754 0%, #2c4d3d 100%);">
                    <div class="rounded-circle bg-white bg-opacity-20 d-flex align-items-center justify-content-center mb-1" style="width: 50px; height: 50px; backdrop-filter: blur(4px);">
                        <i class="bi bi-shield-shaded text-white fs-4"></i>
                    </div>
                    <h5 class="fw-bold mb-0" style="font-family: 'Outfit', sans-serif;">Formulir Pengajuan Upgrade Akun</h5>
                </div>
                
                <div class="card-body p-4 p-sm-5">
                    @if (session('success'))
                        <div class="alert alert-success rounded-4 border-0 mb-4 d-flex align-items-center gap-2" style="background-color: rgba(25, 135, 84, 0.1); color: #198754;">
                            <i class="bi bi-check-circle-fill fs-5"></i>
                            <span class="small fw-semibold">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger rounded-4 border-0 mb-4" style="background-color: rgba(220, 53, 69, 0.1); color: #dc3545;">
                            <div class="d-flex align-items-center gap-2 mb-2">
                                <i class="bi bi-exclamation-triangle-fill fs-5"></i>
                                <span class="small fw-bold">Mohon perbaiki kesalahan berikut:</span>
                            </div>
                            <ul class="mb-0 ps-3 small">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('role_requests.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <!-- SEKSI 1: PILIH ROLE -->
                        <div class="border-bottom pb-3 mb-4">
                            <h6 class="fw-bold text-success mb-3" style="font-family: 'Outfit', sans-serif;">
                                <i class="bi bi-1-circle-fill me-2"></i>Pilih Role Baru Anda
                            </h6>
                            <div class="mb-2">
                                <label for="requested_role_id" class="form-label fw-semibold text-secondary small">Role yang Diajukan</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-person-badge text-success"></i></span>
                                    <select name="requested_role_id" id="requested_role_id" class="form-select bg-light border-0 py-2.5 @error('requested_role_id') is-invalid @enderror" required>
                                        <option value="" disabled selected>-- Pilih Role --</option>
                                        @foreach($roles as $role)
                                            @if($role->id != 1) {{-- Jangan tampilkan Admin --}}
                                                <option value="{{ $role->id }}" {{ old('requested_role_id') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- SEKSI 2: DATA DIRI -->
                        <div class="border-bottom pb-3 mb-4">
                            <h6 class="fw-bold text-success mb-3" style="font-family: 'Outfit', sans-serif;">
                                <i class="bi bi-2-circle-fill me-2"></i>Data Diri & Kontak
                            </h6>
                            
                            <div class="row">
                                <!-- NIK -->
                                <div class="col-md-6 mb-3">
                                    <label for="identity_id" class="form-label fw-semibold text-secondary small">NIK / Nomor KTP</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-card-id text-success"></i></span>
                                        <input type="text" name="identity_id" id="identity_id" class="form-control bg-light border-0 py-2.5 @error('identity_id') is-invalid @enderror" value="{{ old('identity_id') }}" placeholder="Contoh: 3201234567890001" required>
                                    </div>
                                </div>
                                <!-- WhatsApp -->
                                <div class="col-md-6 mb-3">
                                    <label for="whatsapp" class="form-label fw-semibold text-secondary small">Nomor WhatsApp Aktif</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-whatsapp text-success"></i></span>
                                        <input type="text" name="whatsapp" id="whatsapp" class="form-control bg-light border-0 py-2.5 @error('whatsapp') is-invalid @enderror" value="{{ old('whatsapp') }}" placeholder="Contoh: 08123456789" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Gmail -->
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label fw-semibold text-secondary small">Alamat Email / Gmail</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-envelope-at text-success"></i></span>
                                        <input type="email" name="email" id="email" class="form-control bg-light border-0 py-2.5 @error('email') is-invalid @enderror" value="{{ old('email', auth()->user()->email ?? '') }}" placeholder="nama@gmail.com" required>
                                    </div>
                                </div>
                                <!-- Jenis Kelamin -->
                                <div class="col-md-6 mb-3">
                                    <label for="gender" class="form-label fw-semibold text-secondary small">Jenis Kelamin</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-gender-ambiguous text-success"></i></span>
                                        <select name="gender" id="gender" class="form-select bg-light border-0 py-2.5 @error('gender') is-invalid @enderror" required>
                                            <option value="" disabled selected>Pilih Jenis Kelamin</option>
                                            <option value="Laki-laki" {{ old('gender') === 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="Perempuan" {{ old('gender') === 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Tanggal Lahir -->
                                <div class="col-md-6 mb-3">
                                    <label for="birth_date" class="form-label fw-semibold text-secondary small">Tanggal Lahir</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-calendar3 text-success"></i></span>
                                        <input type="date" name="birth_date" id="birth_date" class="form-control bg-light border-0 py-2.5 @error('birth_date') is-invalid @enderror" value="{{ old('birth_date') }}" required>
                                    </div>
                                </div>
                                <!-- Domisili -->
                                <div class="col-md-6 mb-3">
                                    <label for="domicile" class="form-label fw-semibold text-secondary small">Lokasi Domisili saat ini</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-geo-alt text-success"></i></span>
                                        <input type="text" name="domicile" id="domicile" class="form-control bg-light border-0 py-2.5 @error('domicile') is-invalid @enderror" value="{{ old('domicile') }}" placeholder="Contoh: Bandung, Jawa Barat" required>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEKSI 3: SPESIFIK ROLE (DINAMIS DENGAN JAVASCRIPT) -->
                        <div id="dynamic-role-section" class="border-bottom pb-3 mb-4 d-none">
                            <h6 class="fw-bold text-success mb-3" style="font-family: 'Outfit', sans-serif;">
                                <i class="bi bi-3-circle-fill me-2"></i>Kualifikasi Tambahan
                            </h6>
                            
                            <!-- SELLER FIELD -->
                            <div id="section-penjual" class="d-none">
                                <div class="mb-3">
                                    <label for="meta_shop_name" class="form-label fw-semibold text-secondary small">Nama Toko Tani Anda</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-shop text-success"></i></span>
                                        <input type="text" name="meta[shop_name]" id="meta_shop_name" class="form-control bg-light border-0 py-2.5" value="{{ old('meta.shop_name') }}" placeholder="Nama Toko yang direncanakan...">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="meta_shop_address" class="form-label fw-semibold text-secondary small">Alamat Lengkap Toko / Lahan Utama</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-geo text-success"></i></span>
                                        <input type="text" name="meta[shop_address]" id="meta_shop_address" class="form-control bg-light border-0 py-2.5" value="{{ old('meta.shop_address') }}" placeholder="Alamat lengkap toko / lokasi fisik...">
                                    </div>
                                </div>
                            </div>

                            <!-- EXPERT FIELD -->
                            <div id="section-ahli-pakar" class="d-none">
                                <div class="mb-3">
                                    <label for="meta_expertise" class="form-label fw-semibold text-secondary small">Bidang Spesialisasi / Keahlian</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-mortarboard text-success"></i></span>
                                        <input type="text" name="meta[expertise]" id="meta_expertise" class="form-control bg-light border-0 py-2.5" value="{{ old('meta.expertise') }}" placeholder="Contoh: Hidroponik, Pemupukan Organik, Manajemen Hama...">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="meta_experience" class="form-label fw-semibold text-secondary small">Lama Pengalaman Kerja / Praktek (Tahun)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-briefcase text-success"></i></span>
                                        <input type="text" name="meta[experience]" id="meta_experience" class="form-control bg-light border-0 py-2.5" value="{{ old('meta.experience') }}" placeholder="Contoh: 5 Tahun / Praktisi sejak 2018...">
                                    </div>
                                </div>
                            </div>

                            <!-- WORKER FIELD -->
                            <div id="section-tenaga-kerja" class="d-none">
                                <div class="mb-3">
                                    <label for="meta_skills" class="form-label fw-semibold text-secondary small">Keterampilan Kerja Utama</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-tools text-success"></i></span>
                                        <input type="text" name="meta[skills]" id="meta_skills" class="form-control bg-light border-0 py-2.5" value="{{ old('meta.skills') }}" placeholder="Contoh: Membajak sawah, Panen padi, Pengemasan hasil panen...">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="meta_rate" class="form-label fw-semibold text-secondary small">Ekspektasi Tarif Harian (IDR)</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light border-0"><i class="bi bi-cash text-success"></i></span>
                                        <input type="text" name="meta[rate]" id="meta_rate" class="form-control bg-light border-0 py-2.5" value="{{ old('meta.rate') }}" placeholder="Contoh: 100000...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- SEKSI 4: ALASAN & DOKUMEN -->
                        <div>
                            <h6 class="fw-bold text-success mb-3" style="font-family: 'Outfit', sans-serif;">
                                <i class="bi bi-4-circle-fill me-2"></i>Alasan & Lampiran Dokumen
                            </h6>

                            <div class="mb-4">
                                <label for="reason" class="form-label fw-semibold text-secondary small">Alasan Pengajuan</label>
                                <textarea name="reason" id="reason" rows="4" class="form-control bg-light border-0 rounded-3 py-2.5 @error('reason') is-invalid @enderror" required placeholder="Jelaskan secara singkat alasan Anda ingin mengubah role Anda (misal: memiliki sertifikat ahli agronomi, ingin memasarkan buah musiman sendiri, dsb)...">{{ old('reason') }}</textarea>
                            </div>

                            <div class="mb-4">
                                <label for="document" class="form-label fw-semibold text-secondary small">Dokumen Pendukung (CV/KTP/Sertifikat Keahlian)</label>
                                <div class="input-group">
                                    <input type="file" name="document" id="document" class="form-control bg-light border-0 rounded-3 py-2.5 @error('document') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                </div>
                                <small class="text-muted d-block mt-1.5" style="font-size: 0.72rem;">Format yang didukung: PDF, JPG, PNG (Maks 2MB)</small>
                            </div>
                        </div>

                        <div class="d-grid mt-4.5">
                            <button type="submit" class="btn btn-success rounded-pill py-2.5 fw-semibold shadow-xs">
                                <i class="bi bi-send-fill me-1.5"></i> Kirim Pengajuan
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const roleSelect = document.getElementById('requested_role_id');
        const dynamicSection = document.getElementById('dynamic-role-section');
        const sections = {
            'Penjual': document.getElementById('section-penjual'),
            'Ahli Pakar': document.getElementById('section-ahli-pakar'),
            'Tenaga Kerja': document.getElementById('section-tenaga-kerja')
        };

        function toggleSections() {
            const selectedOption = roleSelect.options[roleSelect.selectedIndex];
            const roleName = selectedOption ? selectedOption.text.trim() : '';

            // Sembunyikan kontainer utama terlebih dahulu
            let hasMatch = false;

            // Sembunyikan dan nonaktifkan semua bagian dinamis
            Object.keys(sections).forEach(key => {
                if (sections[key]) {
                    sections[key].classList.add('d-none');
                    sections[key].querySelectorAll('input, select, textarea').forEach(input => {
                        input.disabled = true;
                        input.removeAttribute('required');
                    });
                }
            });

            // Tampilkan bagian yang sesuai
            if (sections[roleName]) {
                dynamicSection.classList.remove('d-none');
                sections[roleName].classList.remove('d-none');
                sections[roleName].querySelectorAll('input, select, textarea').forEach(input => {
                    input.disabled = false;
                    input.setAttribute('required', 'required');
                });
                hasMatch = true;
            }

            if (!hasMatch) {
                dynamicSection.classList.add('d-none');
            }
        }

        roleSelect.addEventListener('change', toggleSections);
        // Jalankan saat load halaman jika ada input sebelumnya
        toggleSections();
    });
</script>
@endsection
