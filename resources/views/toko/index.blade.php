@extends('layouts.mainlayouts')

@section('tittle', 'Profil Toko')


@section('content')
    <section id="tenagakerja">
      <div class="container">
        <div class="row text-center">
            <div class="login-tittle">
                  <h2>Profil Toko</h2>
            </div>
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
        <div class="row mt-3">
          <div class="col-6 p-3">
            <button type="submit" class="btn submit-login d-flex justify-content-center" id="edit-konsultan">
              <a href="{{ URL::to('checkout') }}" class="btn">Edit</a></button>
          </div>
          <div class="col-6 p-3">
            <button type="submit" class="btn submit-login d-flex justify-content-center" id="hapus-konsultan">
              <a href="{{ URL::to('checkout') }}" class="btn">Hapus</a></button>
        </div>

                    {{-- <div class="tampil-data"> --}}
            {{-- <table class="table table-borderless align-middle table-responsive mt-5">
              <tbody>
                <tr>
                <td style="width: 15%;"> Nama Toko : </td>
                <td style="width: 35%;"> {{ $data->nama }}</td>
                  <td rowspan='5' style="text-align: center;">
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
                <td style="width: 15%;"> Deskripsi : </td>
                <td  style="width: 35%;"> {!! $data->deskripsi !!}</td>
                </tr>
                <tr>
                <td colspan="2" class="text-center"><a href="/Toko/{{ $data->id }}/edit"><button type="submit" class="btn submit-login">Edit</button></a></td>
                <td class="text-center"> <button type="submit" class="btn submit-login ">Upload</button></td>
                </tr>
              </tbody>
            </table>

                  </div> --}}
    </div>
    </section>


@endsection