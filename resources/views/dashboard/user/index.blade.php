@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen User</h1>
</div>

@if(session('success'))
    <div class="alert alert-success col-lg-12">
        {{ session('success') }}
    </div>
@endif

<div class="row mb-3">
    <div class="col-md-6">
        <form action="{{ route('user.index') }}" method="GET" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Cari nama atau email..." value="{{ request('search') }}">
            <select name="role" class="form-select me-2">
                <option value="">Semua Role</option>
                @foreach($roles as $role)
                    <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                @endforeach
            </select>
            <button class="btn btn-outline-success" type="submit">Filter</button>
        </form>
    </div>
</div>

<div class="table-responsive small">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama</th>
          <th scope="col">Email</th>
          <th scope="col">Role</th>
          <th scope="col">Status</th>
          <th scope="col">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse( $users as $user)
        <tr>
          <td>{{ $loop->iteration + $users->firstItem() - 1 }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td><span class="badge bg-secondary">{{ $user->role->name ?? 'N/A' }}</span></td>
          <td>
              @if($user->status === 'aktif')
                  <span class="badge bg-success">Aktif</span>
              @else
                  <span class="badge bg-danger">Banned</span>
              @endif
          </td>
          <td>
            <a href="{{ route('user.edit', $user->slug) }}" class="btn btn-sm btn-warning" title="Edit">
                <span data-feather="edit"></span> Edit
            </a>
            <form action="{{ route('user.ban', $user->slug) }}" method="POST" class="d-inline">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-sm {{ $user->status === 'aktif' ? 'btn-danger' : 'btn-success' }}" onclick="return confirm('Yakin ingin merubah status user ini?')">
                    <span data-feather="{{ $user->status === 'aktif' ? 'slash' : 'check-circle' }}"></span>
                    {{ $user->status === 'aktif' ? 'Ban' : 'Unban' }}
                </button>
            </form>
            <a href="{{ route('user.backup', $user->slug) }}" class="btn btn-sm btn-info text-white" title="Backup/Export CSV">
                <span data-feather="download"></span> Backup
            </a>
          </td>
        </tr>
        @empty
        <tr>
            <td colspan="6" class="text-center">Tidak ada data user.</td>
        </tr>
        @endforelse
      </tbody>
    </table>
    
    <div class="d-flex justify-content-center">
        {{ $users->withQueryString()->links() }}
    </div>
</div>
@endsection