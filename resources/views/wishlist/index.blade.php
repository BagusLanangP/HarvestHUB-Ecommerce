@extends('layouts.mainlayouts')

@section('tittle', 'Home')


@section('content')
<section class="produk vh-100 mb-5 produk-cari" id="produkhome">
    <div class="homeProduk">
      <div class="homeProdukTittle text-center mb-5" >
        <h1>Produk Favorit Anda</h1>
        <h4>Masukan ke cart untuk mencheckout!</h4>
      </div>
      <hr>
      <div class="homeProdukContent ">
        <div class="row-1 d-flex justify-content-start mb-3">
          @foreach($itemwishlist as $wl)
            <a href="{{ URL::to('produk/'.$wl->produk->slug ) }}"> 
            <div class="col-3 card me-3 shadow card-product ">
              <img src="{{ asset('storage/' . $wl->produk->foto)}}" class="card-img-top" alt="...">
              <div class="card-body">
                <p class="card-text fw-medium">{{ $wl->produk->name }}</p>
                <p class="productPrice">Rp {{ $wl->produk->harga }}</p>
                <div class="row mt-0 mb-0">
                    <div class="col">
                        <form action="{{ route('wishlist.store') }}" method="post" class="d-inline-block">
                            @csrf
                              <input type="hidden" name="produk_id" value={{ $wl->id }}>
                              <button type="submit" class="button btn-warning like-button-wishlist rounded">
                            @if(isset($itemwishlist) && $itemwishlist)
                                <i class="bi bi-heart-fill"></i>
                            @else
                                <i class="bi bi-heart-fill"></i>
                            @endif
                            </button>                    
                        </form>
                    </div>
                    <div class="col text-end">
                        <form action="{{ route('cartdetail.store') }}" method="POST"                class="d-inline-block">
                            @csrf
                                <input type="hidden" name="produk_id" value={{$wl->id}}>
                                <button type="submit" class="cart-button-wishlist rounded ">
                                    <i class="bi bi-cart-fill"></i>
                                </button>                       
                        </form>  
                    </div>
                </div>
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
