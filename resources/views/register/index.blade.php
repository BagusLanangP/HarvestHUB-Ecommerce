@extends('layouts.mainlayouts')

@section('tittle', 'Daftar')

@section('content')
<main class="1-main d-flex align-items-center justify-content-center" style="min-height: calc(100vh - 8rem); padding-top: 120px; padding-bottom: 60px; background-color: #f8f9fa;">
    <style>
        .btn-custom-green {
            background-color: #198754 !important;
            color: #ffffff !important;
            border: 1px solid #198754 !important;
            transition: all 0.2s ease-in-out !important;
            width: 100%;
        }
        .btn-custom-green:hover {
            background-color: #157347 !important;
            border-color: #146c43 !important;
            color: #ffffff !important;
            box-shadow: 0 4px 8px rgba(25, 135, 84, 0.15);
        }
        .form-control:focus {
            border-color: #198754 !important;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25) !important;
        }
    </style>

    <div class="card border-0 shadow-lg p-4 p-md-5 rounded-4 bg-white" style="width: 100%; max-width: 480px; border-radius: 16px !important;">
        <div class="text-center mb-4">
            <img src="{{ asset('img/Logo-harvesthub.png') }}" alt="HarvestHUB Logo" class="mb-3" style="width: 75px; height: 75px; object-fit: contain;">
            <h2 class="fw-bold text-dark mb-1">Daftar Akun Baru</h2>
            <p class="text-secondary small">Isi formulir di bawah ini untuk membuat akun baru Anda</p>
        </div>

        <form action="/register" method="post" class="login-form">
            @csrf
            <!-- Name Input -->
            <div class="mb-3">
                <label for="InputNama" class="form-label fw-semibold text-secondary" style="font-size: 0.9rem;">Nama Lengkap</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control border-start-0" id="InputNama" name="name" required value="{{ old('name') }}" placeholder="Nama Lengkap Anda">
                </div>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Input -->
            <div class="mb-3">
                <label for="emailInput" class="form-label fw-semibold text-secondary" style="font-size: 0.9rem;">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control border-start-0" id="emailInput" name="email" required value="{{ old('email') }}" placeholder="contoh@domain.com">
                </div>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Phone Input -->
            <div class="mb-3">
                <label for="phoneInput" class="form-label fw-semibold text-secondary" style="font-size: 0.9rem;">Nomor Telepon</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-telephone"></i></span>
                    <input type="tel" class="form-control border-start-0" id="phoneInput" name="phone" required value="{{ old('phone') }}" placeholder="08xxxxxxxxxx">
                </div>
                @error('phone')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Input with Eye Icon Toggle -->
            <div class="mb-4">
                <label for="passwordInput" class="form-label fw-semibold text-secondary" style="font-size: 0.9rem;">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-key"></i></span>
                    <input type="password" class="form-control border-start-0 border-end-0" id="passwordInput" name="password" required placeholder="Buat kata sandi minimal 6 karakter">
                    <button class="btn btn-outline-secondary border-start-0 text-secondary bg-light" type="button" id="toggle-password" style="border-color: #dee2e6;">
                        <i class="bi bi-eye" id="eye-icon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Terms checkbox -->
            <div class="mb-4 form-check d-flex align-items-center">
                <input type="checkbox" class="form-check-input" id="termsCheck" required style="cursor: pointer; width: 1.1rem; height: 1.1rem;">
                <label class="form-check-label text-secondary small ms-2" for="termsCheck" style="cursor: pointer; user-select: none;">Saya menyetujui Syarat & Ketentuan Layanan</label>
            </div>

            <!-- Register Button -->
            <button type="submit" class="btn btn-custom-green py-2.5 rounded-3 fw-bold shadow-sm mb-3">Daftar Sekarang</button>
        </form>

        <div class="text-center mt-3">
            <h6 class="text-secondary small mb-0">Sudah memiliki akun? <a href="/login" class="text-success fw-bold text-decoration-none hover-underline">Masuk di sini</a></h6>
        </div>
    </div>
</main>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtn = document.getElementById('toggle-password');
        const passwordField = document.getElementById('passwordInput');
        const eyeIcon = document.getElementById('eye-icon');

        if(toggleBtn && passwordField && eyeIcon) {
            toggleBtn.addEventListener('click', function() {
                if (passwordField.type === 'password') {
                    passwordField.type = 'text';
                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');
                } else {
                    passwordField.type = 'password';
                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                }
            });
        }
    });
</script>
@endsection