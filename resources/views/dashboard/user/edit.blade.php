@extends('dashboard.layouts.main')

@section('container')
<div class="py-2">

  {{-- Header Panel --}}
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
      <h1 class="h3 fw-bold text-dark mb-0" style="font-family: 'Outfit', sans-serif;">
        <i class="bi bi-person-gear text-success me-2"></i>Edit User: {{ $user->name }}
      </h1>
  </div>

  {{-- Edit Form in Premium Card --}}
  <div class="row">
    <div class="col-12 col-lg-8">
      <div class="card border-0 shadow-sm rounded-4 p-4 p-sm-5 bg-white mb-4">
        <form method="POST" action="{{ route('user.update', $user->slug) }}">
            @csrf
            @method('PUT')
            
            <div class="mb-3.5">
                <label for="name" class="form-label fw-semibold text-secondary small">Nama / Username</label>
                <input type="text" class="form-control bg-light border-0 rounded-3 py-2.5 @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3.5 mt-3">
                <label for="email" class="form-label fw-semibold text-secondary small">Email</label>
                <input type="email" class="form-control bg-light border-0 rounded-3 py-2.5 @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3.5 mt-3">
                <label for="phone" class="form-label fw-semibold text-secondary small">No. Telepon</label>
                <input type="text" class="form-control bg-light border-0 rounded-3 py-2.5 @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}" required>
                @error('phone')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3.5 mt-3">
                <label for="role_id" class="form-label fw-semibold text-secondary small">Role Pengguna</label>
                <select class="form-select bg-light border-0 rounded-3 py-2.5 @error('role_id') is-invalid @enderror" name="role_id" id="role_id" required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                            {{ $role->id }} - {{ $role->name }}
                        </option>
                    @endforeach
                </select>
                @error('role_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3.5 mt-3">
                <label for="status" class="form-label fw-semibold text-secondary small">Status Akun</label>
                <select class="form-select bg-light border-0 rounded-3 py-2.5 @error('status') is-invalid @enderror" name="status" id="status" required>
                    <option value="aktif" {{ old('status', $user->status) == 'aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="banned" {{ old('status', $user->status) == 'banned' ? 'selected' : '' }}>Banned</option>
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-4 mt-3">
                <label for="password" class="form-label fw-semibold text-secondary small">Password Baru (Opsional)</label>
                <input type="password" class="form-control bg-light border-0 rounded-3 py-2.5 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password">
                <small class="text-muted" style="font-size: 0.72rem;">Biarkan kosong untuk mempertahankan password lama.</small>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-2">
              <button type="submit" class="btn btn-success rounded-pill px-4 py-2 fw-semibold shadow-xs">
                <i class="bi bi-check-circle"></i> Simpan Perubahan
              </button>
              <a href="{{ route('user.index') }}" class="btn btn-outline-secondary rounded-pill px-4 py-2 fw-semibold">
                Kembali
              </a>
            </div>
        </form>
      </div>
    </div>
  </div>

</div>
@endsection
