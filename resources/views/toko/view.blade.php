@extends('layouts.mainlayouts')

@section('tittle', 'Lihat Toko')


@section('content')

    <section class="tokodetail">
        <div class="hero-toko">
            <div class="row">
                <div class="col-7">
                    <div class="card mb-3 p-1 shadow-sm">
                        <div class="row g-0">
                          <div class="col-md-4">
                            <img src="{{ asset('img/home/ahlipakar.jpg')}}" class="img-fluid rounded-start" alt="...">
                          </div>
                          <div class="col-md-8 p-0 ps-4">
                            <div class="row">
                                <div class="col-12 ps-0">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $toko->nama }}</h5>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <div class="toko-rate-star">
                                        <h6>Our rate : <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i></h6>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex align-items-end">
                                <div class="col-6 pe-1">
                                    <button type="button" class="follow-toko rounded">
                                        <i class="bi bi-plus">Ikuti</i>
                                    </button>   
                                </div>
                                <div class="col-6">
                                    <button type="button" class="chat-product rounded">
                                        <i class="bi bi-chat-dots-fill">Chat</i>
                                    </button>   
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    
                                </div>
                            </div>
                          </div>
                        </div>
                      </div>
                </div>
                <div class="col-5 pt-3">
                    <div class="row mb-4">
                        <div class="col-6">Produk    : {{ $products->count() }}</div>
                        <div class="col-6">Pengikut  : -</div>
                    </div>
                    <div class="row">
                        <div class="col-6">Mengikuti :</div>
                        <div class="col-6">Tahun     :<span>{{ \Carbon\Carbon::parse($toko->created_at)->format('Y') }}</span> </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="produk-toko">
            <div class="produk-toko-tittle">
                <h4 class="">PRODUK</h4>
            </div>
            <div class="produk-toko-content">
                <div class="row-1 d-flex justify-content-start mb-3">
                    @foreach($products as $produk)
                      <a href="{{ URL::to('produk/'.$produk->slug ) }}"> 
                      <div class="col-2 card me-3 shadow card-product d-flex justify-content-start ">
                        <img src="{{asset('storage/' . $produk->foto)}}" class="card-img-top shadow-sm" alt="...">
                        <div class="card-body">
                          <p class="card-text fw-medium mb-1">{{ $produk->name }}</p>
                          <p class="productPrice mb-0">Rp {{ $produk->harga }}</p>
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