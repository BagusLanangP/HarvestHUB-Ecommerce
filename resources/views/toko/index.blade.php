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
                  <img src="{{ $data->foto_url }}" alt="{{ $data->nama }}" style="width: 200px; height: 200px; object-fit: cover; border-radius: 50%; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
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
                  <div class="col-4">Tahun Berdiri</div>
                  <div class="col-8">:{{ $data->year_started ?? '-' }}</div>
                </div>
                <div class="row text-start mb-1">
                  <div class="col-4">Wilayah</div>
                  <div class="col-8">:{{ $data->region ?? '-' }}</div>
                </div>
                <div class="row text-start mb-1">
                  <div class="col-4">Sosial Media</div>
                  <div class="col-8">
                      @if($data->link_tiktok)
                          <a href="{{ $data->link_tiktok }}" target="_blank" class="badge bg-dark text-decoration-none me-1">TikTok</a>
                      @endif
                      @if($data->link_ig)
                          <a href="{{ $data->link_ig }}" target="_blank" class="badge bg-danger text-decoration-none me-1">Instagram</a>
                      @endif
                      @if($data->link_fb)
                          <a href="{{ $data->link_fb }}" target="_blank" class="badge bg-primary text-decoration-none me-1">Facebook</a>
                      @endif
                      @if(!$data->link_tiktok && !$data->link_ig && !$data->link_fb)
                          -
                      @endif
                  </div>
                </div>
                <div class="row text-start mb-1">
                  <div class="col-4">Rating Keseluruhan</div>
                  <div class="col-8">:⭐ {{ $data->overall_rating }} / 5</div>
                </div>
                <div class="row text-start mb-1">
                  <div class="col-4">Jumlah Produk</div>
                  <div class="col-8">: {{ $data->total_products }} produk</div>
                </div>
                <div class="row text-start mb-1">
                  <div class="col-4">Produk Terlaris</div>
                  <div class="col-8">: 
                    @if($data->best_selling_product)
                      <strong>{{ $data->best_selling_product->name }}</strong> ({{ $data->best_selling_product->total_sold }} terjual)
                    @else
                      Belum ada produk terjual
                    @endif
                  </div>
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
            <button class="btn submit-login d-flex justify-content-center w-100" id="edit-konsultan">
              <a href="{{ route('Toko.edit', $data->id) }}" class="btn text-white w-100">Edit Profil</a>
            </button>
          </div>
          <div class="col-6 p-3">
            <form action="{{ route('Toko.destroy', $data->id) }}" method="POST" class="w-100">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger d-flex justify-content-center w-100" onclick="return confirm('Apakah Anda yakin ingin menghapus toko ini?')">Hapus Toko</button>
            </form>
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