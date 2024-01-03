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
      <div class="row mt-3">
        <div class="col-6 p-3">
          <button type="submit" class="btn submit-login d-flex justify-content-center" id="edit-konsultan">
            <a href="{{ URL::to('checkout') }}" class="btn">Edit</a></button>
        </div>
        <div class="col-6 p-3">
          <button type="submit" class="btn submit-login d-flex justify-content-center" id="hapus-konsultan">
            <a href="{{ URL::to('checkout') }}" class="btn">Hapus</a></button>
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