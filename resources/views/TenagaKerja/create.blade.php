@extends('layouts.mainlayouts')

@section('tittle', 'Lengkapi Profil')


@section('content')
    <section id="tenagakerja">
      <div class="container">
        <div class="row text-center">
            <div class="login-tittle">
                  <h2>Lengkapi Data Profil</h2>
                  <h4>ini klo ga dibutuhin hapus aja</h4>
        </div>
        </div>
        <div class="row justify-content-center">
          <div class="col col-8">
          <div class="tenagakerja-form shadow p-3 mb-3">
            <form action="/TenagaKerja" method="post" enctype="multipart/form-data">
              @csrf
                <div class="mb-4">
                    <label for="nama" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="nama" placeholder="Masukkan nama" name="nama"
                      @error('nama') is-invalid @enderror value="{{ old('nama') }}" required>

                      @error('nama')
                        <div class="alert alert-danger">{{ $message }}</div>
                      @enderror
                </div>
                <div class="mb-3">
                  <label for="foto" class="form-label">Upload Fotomu</label>
                  <img class="img-preview img-fluid mb-3 col-sm-5">
                  <input class="form-control" @error('foto') is-invalid @enderror type="file" id="foto" name="foto" onchange="previewImage()">
                  @error('foto')
                 <div class="alert alert-danger">
                  {{ $message }}
                 </div>
                  @enderror
                </div>
                <div class="mb-3">
                  <label for="foto_cv" class="form-label">Upload CV/Portofoliomu</label>
                  <img class="img-preview img-fluid mb-3 col-sm-5">
                  <input class="form-control" @error('foto_cv') is-invalid @enderror type="file" id="foto_cv" name="foto_cv" onchange="previewImage()">
                  @error('foto_cv')
                 <div class="alert alert-danger">
                  {{ $message }}
                 </div>
                  @enderror
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
                  <label for="keahlian" class="form-label">Keahlian</label>
                  <input type="text" class="form-control" id="keahlian"  name="keahlian" placeholder="Masukan keahlian"
                    @error('keahlian') is-invalid @enderror value="{{ old('keahlian') }}" required >

                    @error('alamat')
                      <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label for="pengalaman" class="form-label">pengalaman</label>
                    <input id="pengalaman" type="hidden" name="pengalaman" @error('pengalaman') is-invalid @enderror required>

                    @error('pengalaman')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <trix-editor input="pengalaman"></trix-editor>
                 </div>
                <div class="mb-4">
                    <label for="deskripsi" class="form-label">deskripsi</label>
                    <input id="deskripsi" type="hidden" name="deskripsi" @error('deskripsi') is-invalid @enderror required>

                    @error('deskripsi')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <trix-editor input="deskripsi"></trix-editor>
                </div>
                
                    <button type="submit" class="btn submit-login mb-5 mx-auto d-block">Login</button>
                                
            </form>
          </div>

        </div>
      </div>
    </div>
    </section>


@endsection