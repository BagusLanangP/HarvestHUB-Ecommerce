@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Admin Analytics Dashboard</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <form action="{{ route('dashboard.analytics.index') }}" method="GET" class="d-flex">
            <select name="period" class="form-select me-2" onchange="this.form.submit()">
                <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Harian</option>
                <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Mingguan</option>
                <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Bulanan</option>
            </select>
        </form>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white h-100 shadow">
            <div class="card-body py-5">
                <h5 class="card-title">Registrasi Pengguna Baru</h5>
                <h2 class="display-4 fw-bold">{{ $newRegistrations }}</h2>
                <p class="card-text">Periode: {{ $label }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-md-4 mb-4">
        <div class="card bg-success text-white h-100 shadow">
            <div class="card-body py-5">
                <h5 class="card-title">Volume Transaksi (Selesai)</h5>
                <h2 class="display-4 fw-bold">Rp {{ number_format($transactionVolume, 0, ',', '.') }}</h2>
                <p class="card-text">Periode: {{ $label }}</p>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card bg-info text-white h-100 shadow">
            <div class="card-body py-5">
                <h5 class="card-title">Total Transaksi</h5>
                <h2 class="display-4 fw-bold">{{ $transactionCount }}</h2>
                <p class="card-text">Periode: {{ $label }}</p>
            </div>
        </div>
    </div>
</div>

@endsection
