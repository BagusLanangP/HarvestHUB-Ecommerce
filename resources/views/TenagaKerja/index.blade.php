@extends('layouts.mainlayouts')

@section('tittle', 'Profile Tenaga Kerja')


@section('content')
    <section id="tenagakerja">
      <div class="container">
        <div class="row text-center mb-2">
            <div class="login-tittle">
                  <h2>Biodata Tenaga Kerja</h2>
            </div>
        </div>
        <div class="row mt-3">
          <div class="col-6">
            <div class="subtittle text-start">
              <h4>
                Identitas
              </h4>
            </div>
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
            <div class="subtittle text-start">
              <h4>
                CV
              </h4>
            </div>
            <hr>
            <div class="img-cv-konsultan">
              <img src="{{ asset('storage/' . $data->foto_cv)}}" alt="">
            </div>
          </div>
        </div>
        <div class="row mt-4 mb-4 justify-content-center">
          <div class="col-md-6 d-flex justify-content-center gap-3">
            <a href="{{ route('TenagaKerja.edit', $data->id) }}" class="btn btn-warning px-4 py-2 rounded-pill fw-semibold shadow-sm text-white">
              <i class="bi bi-pencil-square me-1"></i> Edit Profil
            </a>
            
            <form action="{{ route('TenagaKerja.destroy', $data->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus profil Tenaga Kerja Anda? Akun Anda akan otomatis kembali menjadi user biasa.')">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn btn-danger px-4 py-2 rounded-pill fw-semibold shadow-sm">
                <i class="bi bi-trash-fill me-1"></i> Hapus Profil
              </button>
            </form>
          </div>
        </div>{{-- <div class="tampil-data"> --}}
        {{-- <table class="table table-borderless align-middle table-responsive mt-5">
          <tbody>
            <tr>
            <td style="width: 15%;"> Nama : </td>
            <td style="width: 35%;"> {{ $data->nama }}</td>
              <td rowspan='6' style="text-align: center;">
                <img src="{{ asset('img/cv.jpg') }}" alt="paktani" style="max-width: 300px; max-height: 600px;">
              </td>
            </tr>
            <tr>
            <td style="width: 15%;"> Email : </td>
            <td  style="width: 35%;"> {{ $data->email }}</td>
            </tr>
            <tr>
            <td style="width: 15%;"> No. Telpon : </td>
            <td  style="width: 35%;"> {{ $data->phone }}</td>
            </tr>
            <tr>
            <td style="width: 15%;"> Alamat : </td>
            <td  style="width: 35%;"> {{ $data->alamat }}</td>
            </tr>
            <tr>
            <td style="width: 15%;"> Pengalaman : </td>
            <td  style="width: 35%;"> {!! $data->pengalaman !!}</td>
            </tr>
            <tr>
            <td style="width: 15%;"> Deskripsi : </td>
            <td  style="width: 35%;"> {!! $data->deskripsi !!}</td>
            </tr>
            <tr>
            <td colspan="2" class="text-center"><a href="/TenagaKerja/{{ $data->id }}/edit"><button type="submit" class="btn submit-login">Edit</button></a></td>
            <td class="text-center"> <button type="submit" class="btn submit-login ">Upload</button></td>
            </tr>
          </tbody>
        </table> --}}


        
        {{-- <div class="image col-6">
        <img src="{{ asset('img/cv.jpg') }}" alt="paktani">
        <h3 class="d-inline">Nama : </h3><h4  class="d-inline border border-secondary border-2 rounded p-2" >{{ $data->nama }}</h4>  
        </div> --}}
          {{-- </div> --}}
      </div>
    </section>


@endsection