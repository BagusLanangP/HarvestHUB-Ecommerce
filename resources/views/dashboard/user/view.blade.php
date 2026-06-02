@extends('dashboard.layouts.main')

@section('container')
<div class="py-2">

  {{-- Header Panel --}}
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
      <h1 class="h3 fw-bold text-dark mb-0" style="font-family: 'Outfit', sans-serif;">
        <i class="bi bi-person-bounding-box text-success me-2"></i>Rincian Profil Pengguna
      </h1>
      <a href="{{ route('user.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 px-3 fw-semibold">
        <i class="bi bi-arrow-left"></i> Kembali
      </a>
  </div>

  {{-- Profile Card Grid --}}
  <div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6">
      <div class="card border-0 shadow-sm rounded-4 p-4 text-center bg-white mb-4">
        
        {{-- Avatar & Basic Info --}}
        <div class="rounded-circle bg-success-subtle text-success d-inline-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
          <i class="bi bi-person-fill" style="font-size: 2.8rem;"></i>
        </div>
        
        <h4 class="fw-bold text-dark mb-1" style="font-family: 'Outfit', sans-serif;">{{ $user->name }}</h4>
        <p class="text-secondary small mb-3">{{ $user->email }}</p>
        
        <div class="d-flex justify-content-center gap-2 mb-4">
          <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1.5 fw-semibold small" style="font-size: 0.72rem;">
            ID Role: {{ $user->role_id }} ({{ $user->role->name ?? 'N/A' }})
          </span>
          @if($user->status === 'aktif')
              <span class="badge bg-success rounded-pill px-3 py-1.5 fw-semibold small" style="font-size: 0.72rem;">Status: Aktif</span>
          @else
              <span class="badge bg-danger rounded-pill px-3 py-1.5 fw-semibold small" style="font-size: 0.72rem;">Status: Banned</span>
          @endif
        </div>
        
        {{-- Detail Information Table/Grid --}}
        <div class="text-start bg-light rounded-4 p-3.5 mb-4 shadow-xs" style="font-size: 0.88rem;">
          <div class="row py-2 border-bottom border-light">
            <div class="col-4 fw-semibold text-secondary">User ID</div>
            <div class="col-8 text-dark fw-bold">#{{ $user->id }}</div>
          </div>
          <div class="row py-2 border-bottom border-light">
            <div class="col-4 fw-semibold text-secondary">No. Telepon</div>
            <div class="col-8 text-dark">{{ $user->phone }}</div>
          </div>
          <div class="row py-2 border-bottom border-light">
            <div class="col-4 fw-semibold text-secondary">Alamat Lengkap</div>
            <div class="col-8 text-dark">{{ $user->alamat ?? 'Belum mengisi alamat' }}</div>
          </div>
          <div class="row py-2">
            <div class="col-4 fw-semibold text-secondary">Bergabung Pada</div>
            <div class="col-8 text-dark">{{ $user->created_at->format('d F Y, H:i') }} WITA</div>
          </div>
        </div>

        {{-- Actions --}}
        <div class="d-flex justify-content-center gap-2">
          <a href="{{ route('user.edit', $user->slug) }}" class="btn btn-sm btn-warning text-dark rounded-pill px-3.5 py-2 fw-semibold">
              <i class="bi bi-pencil-fill me-1"></i> Edit Pengguna
          </a>
          <form action="{{ route('user.ban', $user->slug) }}" method="POST" class="d-inline">
              @csrf
              @method('PATCH')
              <button type="submit" class="btn btn-sm {{ $user->status === 'aktif' ? 'btn-danger' : 'btn-success' }} rounded-pill px-3.5 py-2 fw-semibold" onclick="return confirm('Apakah Anda yakin ingin merubah status user ini?')">
                  <i class="bi {{ $user->status === 'aktif' ? 'bi-slash-circle' : 'bi-check-circle' }} me-1"></i>
                  {{ $user->status === 'aktif' ? 'Ban User' : 'Unban User' }}
              </button>
          </form>
          <a href="{{ route('user.backup', $user->slug) }}" class="btn btn-sm btn-info text-white rounded-pill px-3.5 py-2 fw-semibold" title="Backup CSV">
              <i class="bi bi-download me-1"></i> Backup CSV
          </a>
        </div>

      </div>
    </div>
  </div>

</div>
@endsection