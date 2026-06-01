@extends('layouts.mainlayouts')

@section('tittle', 'Masuk')

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

    <div class="card border-0 shadow-lg p-4 p-md-5 rounded-4 bg-white" style="width: 100%; max-width: 460px; border-radius: 16px !important;">
        <div class="text-center mb-4">
            <img src="{{ asset('img/Logo-harvesthub.png') }}" alt="HarvestHUB Logo" class="mb-3" style="width: 75px; height: 75px; object-fit: contain;">
            <h2 class="fw-bold text-dark mb-1">Selamat Datang Kembali</h2>
            <p class="text-secondary small">Masukkan email dan password Anda untuk masuk ke akun</p>
        </div>

        @if(Session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm" role="alert">
                {{ session('success') }}  
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (Session::has('status'))
            <div class="alert alert-danger border-0 shadow-sm" role="alert">
                {{ Session::get('message') }}
            </div>          
        @endif

        <form action="" method="post" class="login-form">
            @csrf
            <!-- Email Input -->
            <div class="mb-4">
                <label for="emailInput" class="form-label fw-semibold text-secondary" style="font-size: 0.9rem;">Alamat Email</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control border-start-0" id="emailInput" name="email" required value="{{ old('email') }}" placeholder="contoh@domain.com">
                </div>
                @error('email')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password Input with Eye Icon Toggle -->
            <div class="mb-4">
                <label for="passwordInput" class="form-label fw-semibold text-secondary" style="font-size: 0.9rem;">Kata Sandi</label>
                <div class="input-group">
                    <span class="input-group-text bg-light text-secondary border-end-0"><i class="bi bi-key"></i></span>
                    <input type="password" class="form-control border-start-0 border-end-0" id="passwordInput" name="password" required placeholder="Masukkan kata sandi Anda">
                    <button class="btn btn-outline-secondary border-start-0 text-secondary bg-light" type="button" id="toggle-password" style="border-color: #dee2e6;">
                        <i class="bi bi-eye" id="eye-icon"></i>
                    </button>
                </div>
                @error('password')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me checkbox -->
            <div class="mb-4 form-check d-flex align-items-center">
                <input type="checkbox" class="form-check-input" id="rememberCheck" style="cursor: pointer; width: 1.1rem; height: 1.1rem;">
                <label class="form-check-label text-secondary small ms-2" for="rememberCheck" style="cursor: pointer; user-select: none;">Ingat saya di perangkat ini</label>
            </div>

            <!-- Login Button -->
            <button type="submit" class="btn btn-custom-green py-2.5 rounded-3 fw-bold shadow-sm mb-3">Masuk Sekarang</button>
        </form>

        <div class="text-center mt-3">
            <h6 class="text-secondary small mb-0">Belum memiliki akun? <a href="/register" class="text-success fw-bold text-decoration-none hover-underline">Daftar di sini</a></h6>
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