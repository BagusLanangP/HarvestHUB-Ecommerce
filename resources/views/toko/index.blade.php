@extends('layouts.mainlayouts')

@section('tittle', 'Profil Toko')


@section('content')
    <section id="tenagakerja">
      <div class="container">
        <div class="row text-center">
            <div class="login-tittle">
                  <h2>Profil Toko</h2>
                  <h4>ini klo ga dibutuhin hapus aja</h4>
        </div>
        </div>
        <div class="tampil-data">
<table class="table table-borderless align-middle table-responsive mt-5">
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

      </div>
    </div>
    </section>


@endsection