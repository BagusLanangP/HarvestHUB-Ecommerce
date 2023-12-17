@extends('layouts.mainlayouts')

@section('tittle', 'Buat Profil Toko')


@section('content')
    <section id="tenagakerja">
      <div class="container">
        <div class="row text-center">
            <div class="login-tittle">
                  <h2>Buat Profil Toko</h2>
                  <h4>ini klo ga dibutuhin hapus aja</h4>
        </div>
        </div>
        <div class="row justify-content-center">
          <div class="col col-8">
          <div class="tenagakerja-form">
            <form action="{{ route('Toko.store') }}" method="post">
              @csrf
                <div class="mb-4">
                    <label for="nama" class="form-label">Nama Toko</label>
                    <input type="text" class="form-control" id="nama" placeholder="Masukkan nama" name="nama"
                      @error('nama') is-invalid @enderror value="{{ old('nama') }}" required>

                      @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" 
                      @error('email') is-invalid @enderror value="{{ old('email') }}" required>
                      
                      @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                </div>
                <div class="mb-4">
                    <label for="phone" class="form-label">nomor Telepon </label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan Nomor Telepon" 
                      @error('phone') is-invalid @enderror value="{{ old('phone') }}" required >

                      @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                </div>
                <div class="mb-4">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat"  name="alamat" placeholder="Masukan alamat"
                      @error('alamat') is-invalid @enderror value="{{ old('alamat') }}" required >

                      @error('alamat')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                </div>
                <div class="mb-4">
                    <label for="deskripsi" class="form-label">deskripsi</label>
                    <input id="deskripsi" type="hidden" name="deskripsi" @error('deskripsi') is-invalid @enderror required value="{{ old('deskripsi') }}">

                    @error('deskripsi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <trix-editor input="deskripsi"></trix-editor>
                </div>
                
                    <button type="submit" class="btn submit-login mb-5 mx-auto d-block">Simpan</button>
                                
            </form>
          </div>

        </div>
      </div>
    </div>
    </section>


@endsection