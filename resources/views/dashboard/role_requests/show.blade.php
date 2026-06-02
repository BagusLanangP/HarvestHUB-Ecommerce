@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2" style="font-family: 'Outfit', sans-serif;">Detail Verifikasi Pengajuan Role</h1>
</div>

<a href="{{ route('dashboard.role_requests.index') }}" class="btn btn-sm btn-outline-secondary mb-4">
    <i class="bi bi-arrow-left"></i> Kembali ke Antrean
</a>

@if (session('success'))
    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-success bg-opacity-10 col-lg-11 border-start border-4 border-success">
        <div class="d-flex align-items-center gap-2 mb-2 text-success">
            <i class="bi bi-check-circle-fill fs-5"></i>
            <h5 class="fw-bold mb-0" style="font-family: 'Outfit', sans-serif;">{{ session('success') }}</h5>
        </div>
        <p class="text-secondary small mb-3">Tindakan berhasil disimpan. Sekarang Anda dapat langsung mengirimkan pesan notifikasi resmi kepada pemohon melalui WhatsApp atau Gmail di bawah ini:</p>
        
        <div class="d-flex flex-wrap gap-2">
            @if(session('notify_approved'))
                @php
                    $notifWaNumber = preg_replace('/[^0-9]/', '', session('notify_whatsapp_number'));
                    if (str_starts_with($notifWaNumber, '0')) {
                        $notifWaNumber = '62' . substr($notifWaNumber, 1);
                    }
                    $notifWaText = "Halo " . session('notify_user_name') . ", Selamat! Pengajuan upgrade akun Anda menjadi " . session('notify_role_name') . " di HarvestHUB telah *DISETUJUI* oleh Admin.\n\nSilakan masuk kembali (re-login) ke akun Anda untuk melengkapi biodata profil Anda agar layanan Anda segera aktif dan tampil secara publik.\n\nTerima kasih atas partisipasi Anda!\nSalam hangat,\nAdmin HarvestHUB";
                    $notifWaUrl = "https://wa.me/" . $notifWaNumber . "?text=" . rawurlencode($notifWaText);

                    $notifEmailSubject = "Selamat! Pengajuan Upgrade Akun HarvestHUB Disetujui";
                    $notifEmailBody = "Halo " . session('notify_user_name') . ",\n\nSelamat! Pengajuan upgrade akun Anda menjadi " . session('notify_role_name') . " di HarvestHUB telah DISETUJUI oleh tim Administrator kami.\n\nSilakan lakukan login ulang ke platform HarvestHUB dan masuk ke menu profil untuk melengkapi data pendukung agar layanan Anda aktif secara komersial di website kami.\n\nTerima kasih dan selamat berkarya bersama HarvestHUB!\n\nSalam hangat,\nAdmin HarvestHUB";
                    $notifEmailUrl = "mailto:" . session('notify_email_address') . "?subject=" . rawurlencode($notifEmailSubject) . "&body=" . rawurlencode($notifEmailBody);
                @endphp
                <a href="{{ $notifWaUrl }}" target="_blank" class="btn btn-success rounded-pill btn-sm fw-semibold d-inline-flex align-items-center gap-2 px-3 py-2 text-white text-decoration-none">
                    <i class="bi bi-whatsapp"></i> Kirim Notifikasi via WA
                </a>
                <a href="{{ $notifEmailUrl }}" target="_blank" class="btn btn-danger rounded-pill btn-sm fw-semibold d-inline-flex align-items-center gap-2 px-3 py-2 text-white text-decoration-none">
                    <i class="bi bi-envelope-at"></i> Kirim Notifikasi via Gmail
                </a>
            @elseif(session('notify_rejected'))
                @php
                    $notifWaNumber = preg_replace('/[^0-9]/', '', session('notify_whatsapp_number'));
                    if (str_starts_with($notifWaNumber, '0')) {
                        $notifWaNumber = '62' . substr($notifWaNumber, 1);
                    }
                    $notifWaText = "Halo " . session('notify_user_name') . ", mohon maaf, pengajuan upgrade akun Anda menjadi " . session('notify_role_name') . " di HarvestHUB saat ini belum dapat disetujui karena berkas atau data pendukung belum memenuhi syarat.\n\nSilakan kirimkan kembali pengajuan Anda dengan data yang lebih lengkap.\n\nSalam hangat,\nAdmin HarvestHUB";
                    $notifWaUrl = "https://wa.me/" . $notifWaNumber . "?text=" . rawurlencode($notifWaText);

                    $notifEmailSubject = "Update Status Pengajuan Upgrade Akun HarvestHUB";
                    $notifEmailBody = "Halo " . session('notify_user_name') . ",\n\nTerima kasih telah mengajukan upgrade akun di platform kami.\n\nMohon maaf, setelah melakukan verifikasi berkas, pengajuan upgrade akun menjadi " . session('notify_role_name') . " belum dapat disetujui karena data pendukung yang Anda lampirkan belum memenuhi persyaratan kelayakan.\n\nSilakan ajukan kembali jika berkas persyaratan Anda sudah lengkap.\n\nSalam hangat,\nAdmin HarvestHUB";
                    $notifEmailUrl = "mailto:" . session('notify_email_address') . "?subject=" . rawurlencode($notifEmailSubject) . "&body=" . rawurlencode($notifEmailBody);
                @endphp
                <a href="{{ $notifWaUrl }}" target="_blank" class="btn btn-success rounded-pill btn-sm fw-semibold d-inline-flex align-items-center gap-2 px-3 py-2 text-white text-decoration-none">
                    <i class="bi bi-whatsapp"></i> Kirim Notifikasi via WA
                </a>
                <a href="{{ $notifEmailUrl }}" target="_blank" class="btn btn-danger rounded-pill btn-sm fw-semibold d-inline-flex align-items-center gap-2 px-3 py-2 text-white text-decoration-none">
                    <i class="bi bi-envelope-at"></i> Kirim Notifikasi via Gmail
                </a>
            @endif
        </div>
    </div>
@endif

@php
    // Persiapan Link WhatsApp Terverifikasi
    $waNumber = preg_replace('/[^0-9]/', '', $roleRequest->whatsapp);
    if (str_starts_with($waNumber, '0')) {
        $waNumber = '62' . substr($waNumber, 1);
    }
    $waText = "Halo " . $roleRequest->user->name . ", saya admin HarvestHUB ingin melakukan verifikasi terkait pengajuan upgrade akun Anda menjadi " . $roleRequest->role->name . ". Apakah Anda memiliki waktu luang untuk melakukan verifikasi data diri?";
    $waUrl = "https://wa.me/" . $waNumber . "?text=" . rawurlencode($waText);

    // Persiapan Link Gmail Terverifikasi
    $emailSubject = "Verifikasi Pengajuan Upgrade Akun HarvestHUB - " . $roleRequest->user->name;
    $emailBody = "Halo " . $roleRequest->user->name . ",\n\nTerima kasih telah mengajukan upgrade akun menjadi " . $roleRequest->role->name . " di HarvestHUB.\n\nKami telah meninjau profil Anda dan ingin menjadwalkan verifikasi data diri / interview singkat via video call untuk memproses pengajuan Anda.\n\nMohon kabari kami kapan waktu luang Anda untuk melakukan proses verifikasi ini.\n\nSalam hangat,\nAdmin HarvestHUB";
    $emailUrl = "mailto:" . $roleRequest->email . "?subject=" . rawurlencode($emailSubject) . "&body=" . rawurlencode($emailBody);
@endphp

<div class="row g-4 col-lg-11 mb-5">
    <!-- KOLOM KIRI: DETAIL PROFIL & DATA DIRI -->
    <div class="col-md-7 col-lg-8">
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
            <div class="d-flex align-items-center gap-3 border-bottom pb-3 mb-4">
                <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center text-success" style="width: 60px; height: 60px;">
                    <i class="bi bi-person-check fs-2"></i>
                </div>
                <div>
                    <h5 class="fw-bold mb-0 text-dark" style="font-family: 'Outfit', sans-serif;">{{ $roleRequest->user->name }}</h5>
                    <p class="text-muted small mb-0">Diajukan pada {{ $roleRequest->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <!-- TABEL DATA DIRI -->
            <h6 class="fw-bold mb-3"><i class="bi bi-card-text text-success me-2"></i>Data Diri Pemohon</h6>
            <div class="table-responsive mb-4">
                <table class="table table-striped table-bordered align-middle">
                    <tbody>
                        <tr>
                            <th class="w-30 bg-light text-secondary small fw-bold">NIK / No. Identitas</th>
                            <td class="fw-semibold">{{ $roleRequest->identity_id ?? 'Tidak diisi' }}</td>
                        </tr>
                        <tr>
                            <th class="w-30 bg-light text-secondary small fw-bold">Email Terdaftar</th>
                            <td>{{ $roleRequest->email ?? 'Tidak diisi' }}</td>
                        </tr>
                        <tr>
                            <th class="w-30 bg-light text-secondary small fw-bold">No. WhatsApp</th>
                            <td>{{ $roleRequest->whatsapp ?? 'Tidak diisi' }}</td>
                        </tr>
                        <tr>
                            <th class="w-30 bg-light text-secondary small fw-bold">Jenis Kelamin</th>
                            <td>{{ $roleRequest->gender ?? 'Tidak diisi' }}</td>
                        </tr>
                        <tr>
                            <th class="w-30 bg-light text-secondary small fw-bold">Tanggal Lahir</th>
                            <td>{{ $roleRequest->birth_date ? \Carbon\Carbon::parse($roleRequest->birth_date)->format('d M Y') : 'Tidak diisi' }}</td>
                        </tr>
                        <tr>
                            <th class="w-30 bg-light text-secondary small fw-bold">Lokasi Domisili</th>
                            <td>{{ $roleRequest->domicile ?? 'Tidak diisi' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- DYNAMIC METADATA (JSON) -->
            <h6 class="fw-bold mb-3"><i class="bi bi-patch-check-fill text-success me-2"></i>Kualifikasi Khusus Role ({{ $roleRequest->role->name }})</h6>
            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <tbody>
                        @if($roleRequest->role->name === 'Penjual')
                            <tr>
                                <th class="w-30 bg-success bg-opacity-10 text-success small fw-bold">Nama Toko</th>
                                <td class="fw-semibold text-dark">{{ $roleRequest->metadata['shop_name'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="w-30 bg-success bg-opacity-10 text-success small fw-bold">Alamat Toko / Lahan</th>
                                <td>{{ $roleRequest->metadata['shop_address'] ?? '-' }}</td>
                            </tr>
                        @elseif($roleRequest->role->name === 'Ahli Pakar')
                            <tr>
                                <th class="w-30 bg-success bg-opacity-10 text-success small fw-bold">Bidang Keahlian</th>
                                <td class="fw-semibold text-dark">{{ $roleRequest->metadata['expertise'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="w-30 bg-success bg-opacity-10 text-success small fw-bold">Lama Pengalaman</th>
                                <td>{{ $roleRequest->metadata['experience'] ?? '-' }}</td>
                            </tr>
                        @elseif($roleRequest->role->name === 'Tenaga Kerja')
                            <tr>
                                <th class="w-30 bg-success bg-opacity-10 text-success small fw-bold">Keterampilan Utama</th>
                                <td class="fw-semibold text-dark">{{ $roleRequest->metadata['skills'] ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th class="w-30 bg-success bg-opacity-10 text-success small fw-bold">Ekspektasi Tarif</th>
                                <td class="fw-bold text-success">
                                    {{ is_numeric($roleRequest->metadata['rate'] ?? null) ? 'Rp ' . number_format($roleRequest->metadata['rate'], 0, ',', '.') : ($roleRequest->metadata['rate'] ?? '-') }}
                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="2" class="text-center text-muted">Tidak ada data metadata khusus.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- ALASAN PENGAJUAN -->
            <div class="mb-4">
                <h6 class="fw-bold mb-2"><i class="bi bi-chat-left-text text-success me-2"></i>Alasan Pengajuan Upgrade Role</h6>
                <div class="bg-light p-3 rounded-3 border-start border-4 border-success">
                    <p class="mb-0 text-dark small" style="white-space: pre-line;">{{ $roleRequest->reason }}</p>
                </div>
            </div>

            <!-- DOKUMEN PENDUKUNG -->
            <div>
                <h6 class="fw-bold mb-2"><i class="bi bi-file-earmark-arrow-up text-success me-2"></i>Lampiran Berkas Pendukung</h6>
                @if($roleRequest->document_path)
                    <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-file-earmark-pdf-fill text-danger fs-4"></i>
                            <div>
                                <p class="mb-0 small fw-bold">Berkas Persyaratan.pdf</p>
                                <span class="text-muted" style="font-size: 0.72rem;">Klik tombol kanan untuk meninjau secara penuh</span>
                            </div>
                        </div>
                        <a href="{{ asset('storage/' . $roleRequest->document_path) }}" target="_blank" class="btn btn-sm btn-success">
                            <i class="bi bi-eye"></i> Buka Lampiran
                        </a>
                    </div>
                @else
                    <div class="p-3 bg-light rounded-3 text-center text-muted small">
                        <i class="bi bi-file-earmark-x me-1"></i> Tidak ada lampiran berkas terunggah
                    </div>
                @endif
            </div>

        </div>
    </div>

    <!-- KOLOM KANAN: HUBUNGI & AKSI PERSATUAN -->
    <div class="col-md-5 col-lg-4">
        <!-- HUBUNGI PENGGUNA -->
        <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
            <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-telephone-outbound text-success me-2"></i>Hubungi Untuk Verifikasi</h6>
            <p class="text-muted small mb-4">Lakukan video call atau tanya-jawab tambahan dengan pemohon secara instan via WhatsApp atau Gmail.</p>

            <div class="d-grid gap-3">
                <a href="{{ $waUrl }}" target="_blank" class="btn btn-success py-2.5 rounded-3 text-white fw-semibold d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-whatsapp fs-5"></i> Hubungi via WhatsApp
                </a>
                
                <a href="{{ $emailUrl }}" target="_blank" class="btn btn-outline-danger py-2.5 rounded-3 fw-semibold d-flex align-items-center justify-content-center gap-2">
                    <i class="bi bi-envelope-fill fs-5"></i> Hubungi via Gmail
                </a>
            </div>
        </div>

        <!-- TINDAKAN ADMIN -->
        <div class="card border-0 shadow-sm rounded-4 p-4 bg-white">
            <h6 class="fw-bold mb-3 text-dark"><i class="bi bi-check-circle-fill text-success me-2"></i>Tindakan Pengajuan</h6>
            <p class="text-muted small mb-4">Setujui untuk memperbarui role pemohon secara otomatis atau Tolak jika syarat belum terpenuhi.</p>

            <div class="d-flex flex-column gap-2.5">
                <form action="{{ route('dashboard.role_requests.update', $roleRequest->id) }}" method="POST" class="w-100">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="approved">
                    <button type="submit" class="btn btn-success w-100 py-2.5 rounded-3 fw-semibold" onclick="return confirm('Apakah Anda yakin ingin menyetujui pengajuan ini? Pengguna akan otomatis beralih ke role baru.')">
                        <i class="bi bi-check-lg me-1.5"></i> Setujui Pengajuan
                    </button>
                </form>

                <form action="{{ route('dashboard.role_requests.update', $roleRequest->id) }}" method="POST" class="w-100">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="rejected">
                    <button type="submit" class="btn btn-danger w-100 py-2.5 rounded-3 fw-semibold" onclick="return confirm('Apakah Anda yakin ingin menolak pengajuan ini?')">
                        <i class="bi bi-x-lg me-1.5"></i> Tolak Pengajuan
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
