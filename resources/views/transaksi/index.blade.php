@extends('layouts.mainlayouts')

@section('tittle', 'Riwayat Transaksi')

@section('content')
<div class="container mt-5 mb-5 pt-5">
    <h2 class="mb-4">Riwayat Transaksi</h2>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($transactions->isEmpty())
        <div class="alert alert-info">Anda belum memiliki riwayat transaksi.</div>
    @else
        @foreach($transactions as $trx)
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><strong>Order ID:</strong> #{{ $trx->order_id }} | <strong>Tanggal:</strong> {{ $trx->created_at->format('d M Y H:i') }}</span>
                    <span class="badge {{ $trx->status == 'Completed' ? 'bg-success' : ($trx->status == 'Pending' ? 'bg-warning text-dark' : 'bg-danger') }}">{{ $trx->status }}</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Total Belanja: Rp {{ number_format($trx->total_price, 0, ',', '.') }}</h5>
                    <hr>
                    <h6>Detail Produk:</h6>
                    <ul class="list-group list-group-flush mb-3">
                        @foreach($trx->order->cart->detail as $detail)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img src="{{ $detail->produk->image_url }}" alt="" style="width: 50px; height: 50px; object-fit: cover;" class="me-3 rounded">
                                <div>
                                    <h6 class="mb-0">{{ $detail->produk->name }}</h6>
                                    <small>{{ $detail->qty }} x Rp {{ number_format($detail->harga, 0, ',', '.') }}</small>
                                </div>
                            </div>
                            @if($trx->status == 'Completed')
                                <a href="{{ route('review.create', ['transaction' => $trx->id, 'product' => $detail->produk->id]) }}" class="btn btn-sm btn-outline-primary">Tulis Ulasan</a>
                            @endif
                        </li>
                        @endforeach
                    </ul>
                    
                    @if($trx->status == 'Pending')
                        <form action="{{ route('transaksi.complete', $trx->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success" onclick="return confirm('Apakah Anda yakin pesanan ini sudah diterima dan selesai?')">Pesanan Diterima (Selesaikan)</button>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
