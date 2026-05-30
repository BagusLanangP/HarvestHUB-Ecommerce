@extends('layouts.mainlayouts')

@section('tittle', 'Tulis Ulasan')

@section('content')
<div class="container mt-5 mb-5 pt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4>Tulis Ulasan Produk</h4>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center mb-4">
                        <img src="{{ $product->image_url }}" alt="" class="rounded me-3" style="width: 80px; height: 80px; object-fit: cover;">
                        <div>
                            <h5 class="mb-0">{{ $product->name }}</h5>
                            <small class="text-muted">Order #{{ $transaction->order_id }}</small>
                        </div>
                    </div>

                    <form action="{{ route('review.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        
                        <div class="mb-3">
                            <label for="rating" class="form-label">Rating (1-5 Bintang)</label>
                            <select class="form-select @error('rating') is-invalid @enderror" id="rating" name="rating" required>
                                <option value="" disabled selected>Pilih Rating...</option>
                                <option value="5" {{ old('rating') == '5' ? 'selected' : '' }}>5 - Sangat Bagus</option>
                                <option value="4" {{ old('rating') == '4' ? 'selected' : '' }}>4 - Bagus</option>
                                <option value="3" {{ old('rating') == '3' ? 'selected' : '' }}>3 - Cukup</option>
                                <option value="2" {{ old('rating') == '2' ? 'selected' : '' }}>2 - Kurang</option>
                                <option value="1" {{ old('rating') == '1' ? 'selected' : '' }}>1 - Sangat Kurang</option>
                            </select>
                            @error('rating')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="comment" class="form-label">Komentar (Opsional)</label>
                            <textarea class="form-control @error('comment') is-invalid @enderror" id="comment" name="comment" rows="4" placeholder="Bagaimana kualitas produk ini?">{{ old('comment') }}</textarea>
                            @error('comment')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
