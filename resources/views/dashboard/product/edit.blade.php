@extends('dashboard.layouts.main')

@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Produk</h1>
</div>

<div class="col-lg-8">
    <form method="post" action="/dashboard/product/{{ $data->id }}" class="mt-4" enctype="multipart/form-data">
        @method('PATCH')
        @csrf
        <div class="mb-3">
          <label for="name" class="form-label">Nama</label>
          <input type="text" class="form-control"  @error('name') is-invalid @enderror id="name" name="name" required value="{{ $data->name }}">
           @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="foto" class="form-label">Upload Gambar</label>
            @if($data->foto)
                <img src="{{ asset('storage/' . $data->foto) }}" class="img-preview img-fluid mb-3 col-sm-5 d-block">
            @else
                <img class="img-preview img-fluid mb-3 col-sm-5">
            @endif
            <input class="form-control" @error('foto') is-invalid @enderror type="file" id="foto" name="foto" onchange="previewImage()">
            @error('foto')
           <div class="alert alert-danger">
            {{ $message }}
           </div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="slug" class="form-label">Slug</label>
            <input type="text" class="form-control" @error('slug') is-invalid @enderror id="slug" name="slug" required value="{{ $data->slug }}" >
        @error('slug')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        </div>

        <div class="mb-3">
            <label for="kategori" class="form-label">Kategori</label>
            <select class="form-select" aria-label="Default select example" name="category_id">
                @foreach( $kategoris as $kategori)
                 @if( old('category_id', $kategori->category_id) == $kategori->id)
                        <option value="{{ $kategori->id }}" selected>{{ $kategori->productName }}</option>
                    @else
                        <option value="{{ $kategori->id }}">{{ $kategori->productName }}</option>
                    @endif
                
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" class="form-control" id="harga" @error('harga') is-invalid @enderror name="harga" required value="{{ $data->harga }}">
            @error('harga')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="jumlah_produk" class="form-label">Jumlah Produk</label>
            <input type="number" @error('jumlah_produk') is-invalid @enderror class="form-control" id="jumlah_produk" name="jumlah_produk" required value="{{ $data->jumlah_produk }}">
            @error('jumlah_produk')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">description</label>
            <input id="description" type="hidden" name="description"  @error('description') is-invalid @enderror required value="{{ $data->description }}">
            <trix-editor input="description"></trix-editor>
            @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Tambahkan Barang</button>
    </form>
</div>

<script>
    const name =  document.querySelector('#name');
    const slug =  document.querySelector('#slug');

    name.addEventListener('change', function(){
        fetch('/dashboard/product/checkSlug?namaproduk=' + name.value)
            .then(response => response.json())
            .then(data => slug.value = data.slug)
    })

    document.addEventListener('trix-file-accept', function(e){
        e.preventDefault();
    })

    function previewImage(){
        const foto =  document.querySelector('#foto');
        const imgPreview =  document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(foto.files[0]);

        oFReader.onload = function(oFREvent){
            imgPreview.src = oFREvent.target.result;
        }

    }
</script>

@endsection