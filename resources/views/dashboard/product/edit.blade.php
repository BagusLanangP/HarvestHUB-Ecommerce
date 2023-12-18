@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create New Product</h1>
</div>

<div class="col-lg-8">
    <form method="post" action="/dashboard/product" class="mt-4">
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Nama</label>
          <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" required autofocus value="{{ old('name') }}">
          @error('name')
           <div class="invalid-feedback">
            {{ $message }}
           </div>
          @enderror
        </div>
        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" id="slug" name="slug" required autofocus value="{{ old('nama')}}" >
          </div>
        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" aria-label="Default select example" name="category_id">
                @foreach( $categories as $category)
                <option value="{{ $category->id }}">{{ $category->productName }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" name="harga" required>
        </div>
        <div class="mb-3">
            <label for="jumlah_produk" class="form-label">Jumlah Produk</label>
            <input type="number" class="form-control" id="jumlah_produk" name="jumlah_produk" required>
        </div>
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <div class="mb-3">
            <label for="description" class="form-label">description</label>
            <input id="description" type="hidden" name="description" required>
            <trix-editor input="description"></trix-editor>
        </div>
        <button type="submit" class="btn btn-primary">Tambahkan Barang</button>
    </form>
</div>

<script>
    const name =  document.querySelector('#namaproduk');
    const slug =  document.querySelector('#slug');

    name.addEventListener('change', function(){
        fetch('/dashboard/product/checkSlug?namaproduk=' + namaproduk.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
    })

    document.addEventListener('trix-file-accept', function(e){
        e.preventDefault();
    })
</script>

@endsection