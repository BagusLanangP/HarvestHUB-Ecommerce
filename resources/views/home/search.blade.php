@extends('layouts.mainlayouts')

@section('tittle', 'Home')


@section('content')
<section class="produk vh-100 mb-5 produk-cari" id="produkhome">
    <div class="homeProduk">
      <div class="homeProdukTittle text-center mb-5" >
        <h1>Produk</h1>
        <h4>Mencari produk yang anda cari!</h4>
      </div>
      <div class="homeproduk-search-tittle text-start mb-2">
        <h1 class="">Produk yang anda cari : <span>%%%%%</span></h1>
      </div>
      <hr>
      <div class="homeProdukContent ">
        <div class="row-1 d-flex justify-content-start mb-3">
          @foreach($hasil as $produk)
            <a href="{{ URL::to('produk/'.$produk->slug ) }}"> 
            <div class="col-2 card me-3 shadow card-product ">
              <img src="{{ asset('img/home/pekerja2.jpg')}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text fw-medium">{{ $produk->name }}</p>
                <p class="productPrice">Rp {{ $produk->harga }}</p>
              </div>             
            </div>
            </a>
          @endforeach
          </div>
        </div>
            
      </div> 
    </div>
  </section>


@endsection
