@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Antrean Pengajuan Role</h1>
</div>

@if (session('success'))
    <div class="alert alert-success col-lg-10">
        {{ session('success') }}
    </div>
@endif

<div class="table-responsive col-lg-12">
    <table class="table table-striped table-sm">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama User</th>
                <th scope="col">Email</th>
                <th scope="col">Role Diajukan</th>
                <th scope="col">Alasan</th>
                <th scope="col">Dokumen</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($requests as $req)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $req->user->name }}</td>
                    <td>{{ $req->user->email }}</td>
                    <td><span class="badge bg-primary">{{ $req->role->name }}</span></td>
                    <td>{{ Str::limit($req->reason, 50) }}</td>
                    <td>
                        @if($req->document_path)
                            <a href="{{ asset('storage/' . $req->document_path) }}" target="_blank" class="btn btn-sm btn-info text-white"><span data-feather="file-text"></span> Lihat</a>
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('dashboard.role_requests.update', $req->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="approved">
                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Setujui pengajuan ini?')"><span data-feather="check"></span> Setujui</button>
                        </form>
                        
                        <form action="{{ route('dashboard.role_requests.update', $req->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Tolak pengajuan ini?')"><span data-feather="x"></span> Tolak</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada pengajuan role yang pending.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
