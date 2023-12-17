@extends('layouts.mainlayouts')

@section('tittle', 'Edit Profil Toko')


@section('content')
    <section id="tenagakerja">
      <div class="container">
        <div class="row text-center">
            <div class="login-tittle">
                  <h2>Edit Profil Toko</h2>
                  <h4>ini klo ga dibutuhin hapus aja</h4>
        </div>
        </div>
        <div class="row justify-content-center">
          <div class="col col-8">
          <div class="tenagakerja-form">
            <form action="{{ route('Toko.update', $data->id) }}" method="post">
              @method('PATCH')
              @csrf
                <div class="mb-4">
                    <label for="nama" class="form-label">Nama Toko</label>
                    <input type="nama" class="form-control" id="nama" name="nama" placeholder="Masukkan nama" 
                      @error('nama') is-invalid @enderror value="{{ $data->nama }}" required>

                      @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan email" 
                      @error('email') is-invalid @enderror value="{{ $data->email }}" required>

                      @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                </div>
                <div class="mb-4">
                    <label for="phone" class="form-label">nomor Telepon </label>
                    <input type="text" class="form-control" id="phone" name="phone" placeholder="Masukkan Nomor Telepon" 
                      @error('phone') is-invalid @enderror value="{{ $data->phone }}" required >
                </div>
                <div class="mb-4">
                    <label for="alamat" class="form-label">Alamat</label>
                    <input type="text" class="form-control" id="alamat"  name="alamat" placeholder="Masukan alamat" 
                      @error('alamat') is-invalid @enderror value="{{ $data->alamat }}" required >

                      @error('alamat')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                </div>
                <div class="mb-4">
                    <label for="deskripsi" class="form-label">deskripsi</label>
                    <input id="deskripsi" type="hidden" name="deskripsi" @error('deskripsi') is-invalid @enderror value="{{ $data->deskripsi }}" required>

                    @error('deskripsi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <trix-editor input="deskripsi"></trix-editor>
                </div>
                
                    <button type="submit" class="btn submit-login mb-5 mx-auto d-block">Edit</button>
                                
            </form>
          </div>

        </div>
      </div>
    </div>
    </section>


@endsection