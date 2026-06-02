@extends('layouts.mainlayouts')

@section('tittle', 'Home')


@section('content')
    <section id="tenagakerja">
      <div class="container">
        <div class="row text-center">
            <div class="login-tittle">
                  <h2>Biodata Konsultan</h2>
        </div>
        <div class="row mt-3">
          <div class="col-6">
            <hr>
            <div class="konsultan-data shadow p-2">
                <div class="img-consultan d-flex justify-content-center" >
                  <img src="{{ asset('storage/' . $data->foto)}}" alt="air" style="width: 20rem">
                </div>
                <hr>               
                <div class="row text-start mb-1">
                  <div class="col-4">Nama</div>
                  <div class="col-8">:{{ $data->nama }}</div>
                </div>
                <div class="row text-start mb-1">
                  <div class="col-4">Email</div>
                  <div class="col-8">:{{ $data->email }}</div>
                </div>
                <div class="row text-start mb-1">
                  <div class="col-4">No. Telpon</div>
                  <div class="col-8">:{{ $data->phone }}</div>
                </div>
                <div class="row text-start mb-1">
                  <div class="col-4">Alamat</div>
                  <div class="col-8">:{{  $data->alamat }}</div>
                </div>
                <div class="row text-start mb-1">
                  <div class="col-4">Keahlian</div>
                  <div class="col-8">:{{   $data->keahlian  }}</div>
                </div>
                <hr>
                <div class="row text-center">
                  <div class="col">Pengalaman</div>
                </div>
                <div class="row text-start mb-1">
                  <div class="col">{!! $data->pengalaman !!}</div>
                </div>
                <hr>
                <div class="row text-center">
                  <div class="col">Deskripsi</div>
                </div>
                <div class="row text-start">
                  <div class="col">{!! $data->deskripsi !!}</div>
                </div>

                
            </div>
          </div>
          <div class="col-6">
            <hr>
            <div class="img-cv-konsultan">
              <img src="{{ asset('storage/' . $data->foto_cv)}}" alt="">
            </div>
          </div>
        </div>
      </div>
      <div class="row mt-4 mb-4 justify-content-center">
        <div class="col-md-6 d-flex justify-content-center gap-3">
          <a href="{{ route('Konsultan.edit', $data->id) }}" class="btn btn-warning px-4 py-2 rounded-pill fw-semibold shadow-sm text-white">
            <i class="bi bi-pencil-square me-1"></i> Edit Profil
          </a>
          
          <form action="{{ route('Konsultan.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil pakar/konsultan Anda? Akun Anda akan otomatis kembali menjadi user biasa.')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill fw-semibold shadow-sm">
              <i class="bi bi-trash-fill me-1"></i> Hapus Profil
            </button>
          </form>
        </div>
      </div>
        


        
        {{-- <div class="image col-6">
        <img src="{{ asset('img/cv.jpg') }}" alt="paktani">
        <h3 class="d-inline">Nama : </h3><h4  class="d-inline border border-secondary border-2 rounded p-2" >{{ $data->nama }}</h4>  
        </div> --}}
      </div>
    </div>
    </section>


@endsection