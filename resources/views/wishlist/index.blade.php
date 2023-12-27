@extends('layouts.mainlayouts')

@section('tittle', 'cart')

@section('content')
<section id="cart">
    <div class="cart-content">
        <div class="cart-tittle text-center mb-5">
            <h1>Keranjang Belanjamu!</h1>
            <h4>Ayok Checkout barangmu sebelum kehabisan!</h4>
        </div>
        <hr>
        <div class="">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                    <th scope="col"  style="width: 10%;">No</th>
                    <th scope="col"  style="width: 40%;">Produk</th>
                    <th scope="col"  style="width: 15%;" class="text-center">Harga</th>
                    <th scope="col"  style="width: 10%;" class="text-center">Kuantitas</th>
                    <th scope="col"  style="width: 15%;" class="text-center">Total</th>
                    <th scope="col"  style="width: 10%;" class="text-center">Hapus</th>
                </tr>
              </thead>
              <tbody>
                @foreach($itemcart->detail as $detail)
                    <tr>
                        <td class="cart-check pt-3 pb-3 text-start">
                            {{  $loop->iteration }}
                        </td>
                        <td class="product-info">
                            <img src="{{ asset('img/home/ahlipakar2.jpg') }}" alt="Product Image" style="max-width: 30%;  display: block; margin-right: 10px; float: left;">
                            <!-- Nama Produk -->
                            <span class="product-name">{{  $detail->produk->name }}</span>
                        </td>
                        <td class="text-center align-items-center ">
                            <div class="row ">
                                <div class="col"><span class="product-name">{{   $detail->produk->harga  }}</span></div>   
                            </div>
                            
                        </td>
                        <td class="cart-jml text-center pb-3 ps-2">
                            <div class="btn-group" role="group">
                                <form action="{{ route('cartdetail.update',$detail->id) }}" method="post">
                                @method('patch')
                                @csrf()
                                  <input type="hidden" name="param" value="kurang">
                                  <button class="tombol-kurang-cart rounded">
                                  -
                                  </button>
                                </form>
                                <button class="tombol-qty me-1 ms-1" disabled="true">
                                {{ number_format($detail->qty, 0) }}
                                </button>
                                <form action="{{ route('cartdetail.update',$detail->id) }}" method="post">
                                @method('patch')
                                @csrf()
                                  <input type="hidden" name="param" value="tambah">
                                  <button class="tombol-tambah-cart rounded">
                                  +
                                  </button>
                                </form>
                              </div>        
                        </td>
                        <td class="text-center">
                            <span class="product-name">               
                                {{ number_format($detail->subtotal, 2) }}
                            </span>
                        </td>
                        <td class="text-center rounded">
                            <form action="{{ route('cartdetail.destroy', $detail->id) }}" method="post" style="display:inline;">
                                @csrf
                                {{ method_field('delete') }}
                                <button type="submit" class="tombol-hapus-cart rounded">
                                  Hapus
                                </button>                    
                            </form>
                        </td>
                    </tr>
                @endforeach
              </tbody>
            </table>
        </div>
    </div>
    <div class="cart-checkout vh-20 mt-4 shadow rounded mb-3">
        <div class="container">
            <div class="row pt-3 pb-3">
                <div class="col checkout-border">
                    <h1>Checkout Now!</h1>
                </div>
            </div>
            <hr class="mb-0 mt-0">
            <div class="row pt-5 pb-5">
                <div class="col-3">
                    <span>Total Produk : {{ $itemcart->detail->count() }}</span>
                </div>
                <div class="col-2">
                    <span><a href="">Hapus</a></span>
                </div>
                <div class="col-3">
                    <span>{{ $itemcart->total }}</span>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn submit-login d-flex justify-content-center">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection