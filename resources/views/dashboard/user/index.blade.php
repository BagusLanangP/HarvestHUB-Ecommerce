@extends('dashboard.layouts.main')

@section('container')
<div class="py-2">

  {{-- Header Panel --}}
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
      <h1 class="h3 fw-bold text-dark mb-0" style="font-family: 'Outfit', sans-serif;">
        <i class="bi bi-people-fill text-success me-2"></i>Manajemen User
      </h1>
  </div>

  {{-- Flash Messages --}}
  @if(session('success'))
      <div class="alert alert-success rounded-4 shadow-xs border-0 mb-4 d-flex align-items-center gap-2" style="background-color: rgba(25, 135, 84, 0.1); color: #198754;">
          <i class="bi bi-check-circle-fill fs-5"></i>
          <span class="small fw-semibold">{{ session('success') }}</span>
      </div>
  @endif

  {{-- Search & Filter Bar --}}
  <div class="card border-0 shadow-sm rounded-4 p-3 mb-4 bg-white">
    <form action="{{ route('user.index') }}" method="GET" class="row g-2 align-items-center">
      <div class="col-12 col-md-5">
        <div class="input-group input-group-sm">
          <span class="input-group-text bg-light border-end-0 text-secondary rounded-start-3"><i class="bi bi-search"></i></span>
          <input type="text" name="search" class="form-control bg-light border-start-0 rounded-end-3" placeholder="Cari nama atau email..." value="{{ request('search') }}">
        </div>
      </div>
      <div class="col-12 col-md-4">
        <select name="role" class="form-select form-select-sm bg-light rounded-3">
          <option value="">Semua Role</option>
          @foreach($roles as $role)
            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>
              {{ $role->id }} - {{ $role->name }}
            </option>
          @endforeach
        </select>
      </div>
      <div class="col-12 col-md-3 d-grid d-md-block">
        <button class="btn btn-sm btn-success rounded-3 px-4 fw-semibold" type="submit">
          <i class="bi bi-funnel"></i> Filter
        </button>
        @if(request('search') || request('role'))
          <a href="{{ route('user.index') }}" class="btn btn-sm btn-outline-secondary rounded-3 ms-md-1 fw-semibold">
            <i class="bi bi-arrow-counterclockwise"></i> Reset
          </a>
        @endif
      </div>
    </form>
  </div>

  {{-- Table Container with Shadow --}}
  <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4 bg-white">
    <div class="table-responsive small">
      <table class="table align-middle mb-0">
        <thead>
          <tr>
            <th scope="col" class="ps-4">No</th>
            <th scope="col">Nama / Username</th>
            <th scope="col">Email</th>
            <th scope="col">No. Telepon</th>
            <th scope="col">Alamat</th>
            <th scope="col">Role ID & Name</th>
            <th scope="col">Status</th>
            <th scope="col" class="pe-4 text-end">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse( $users as $user)
          <tr>
            <td class="ps-4 fw-semibold text-secondary" style="font-size: 0.85rem;">{{ $loop->iteration + $users->firstItem() - 1 }}</td>
            <td class="fw-bold text-dark" style="font-size: 0.88rem;">{{ $user->name }}</td>
            <td class="text-secondary" style="font-size: 0.85rem;">{{ $user->email }}</td>
            <td class="text-secondary" style="font-size: 0.85rem;">{{ $user->phone }}</td>
            <td class="text-secondary text-truncate" style="max-width: 150px; font-size: 0.85rem;" title="{{ $user->alamat }}">{{ $user->alamat ?? '-' }}</td>
            <td>
              <span class="badge bg-success-subtle text-success rounded-pill px-3 py-1.5 fw-semibold small" style="font-size: 0.72rem;">
                {{ $user->role_id }} - {{ $user->role->name ?? 'N/A' }}
              </span>
            </td>
            <td>
                @if($user->status === 'aktif')
                    <span class="badge bg-success rounded-pill px-2.5 py-1.5 fw-semibold small" style="font-size: 0.72rem;">Aktif</span>
                @else
                    <span class="badge bg-danger rounded-pill px-2.5 py-1.5 fw-semibold small" style="font-size: 0.72rem;">Banned</span>
                @endif
            </td>
            <td class="pe-4 text-end">
              <div class="d-inline-flex gap-1">
                <a href="{{ route('user.edit', $user->slug ?? $user->id) }}" class="btn btn-sm btn-warning text-dark rounded-3 px-2.5 py-1.5" title="Edit User">
                    <i class="bi bi-pencil-fill"></i>
                </a>
                <form action="{{ route('user.ban', $user->slug ?? $user->id) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-sm {{ $user->status === 'aktif' ? 'btn-danger' : 'btn-success' }} rounded-3 px-2.5 py-1.5" onclick="return confirm('Apakah Anda yakin ingin merubah status user ini?')" title="{{ $user->status === 'aktif' ? 'Ban User' : 'Unban User' }}">
                        <i class="bi {{ $user->status === 'aktif' ? 'bi-slash-circle-fill' : 'bi-check-circle-fill' }}"></i>
                    </button>
                </form>
                <a href="{{ route('user.backup', $user->slug ?? $user->id) }}" class="btn btn-sm btn-info text-white rounded-3 px-2.5 py-1.5" title="Backup CSV">
                    <i class="bi bi-download"></i>
                </a>
              </div>
            </td>
          </tr>
          @empty
          <tr>
              <td colspan="8" class="text-center py-5 text-secondary">
                <i class="bi bi-people text-muted d-block mb-2" style="font-size: 2.5rem;"></i>
                <span class="fw-semibold">Tidak ada data user ditemukan</span>
              </td>
          </tr>
          @endforelse
        </tbody>
      </table>
      
      @if($users->hasPages())
        <div class="d-flex justify-content-center py-3 border-top bg-light">
            {{ $users->withQueryString()->links() }}
        </div>
      @endif
    </div>
  </div>

</div>
@endsection