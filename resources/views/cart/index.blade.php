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
                    <th scope="col"  style="width: 10%;" class="text-center">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label" for="flexCheckDefault">
                                </label>
                    </th>
                    <th scope="col"  style="width: 40%;">Produk</th>
                    <th scope="col"  style="width: 15%;" class="text-center">Harga</th>
                    <th scope="col"  style="width: 10%;" class="text-center">Kuantitas</th>
                    <th scope="col"  style="width: 15%;" class="text-center">Total</th>
                    <th scope="col"  style="width: 10%;" class="text-center">Hapus</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                    <td class="cart-check pt-3 pb-3 text-center">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                        </label>
                    </td>
                    <td class="product-info">
                        <img src="{{ asset('img/home/ahlipakar2.jpg') }}" alt="Product Image" style="max-width: 30%;  display: block; margin-right: 10px; float: left;">
                        <!-- Nama Produk -->
                        <span class="product-name">Nama Produk 1</span>
                    </td>
                    <td class="text-center align-items-center ">
                        <div class="row ">
                            <div class="col"><span class="product-name">15.000</span></div>
                            
                        </div>
                        
                    </td>
                    <td class="cart-jml text-center pb-3 ps-2">
                        <div class="div">
                            <label for="jumlah_produk" class="form-label" ></label>
                            <input type="number" class="form-control" id="jumlah_produk" name="jumlah_produk"  style="width: 60px;" value="1"  required>
                        </div>
                        
                    </td>
                    <td class="text-center">
                        <span class="product-name">15.000</span>
                    </td>
                    <td>
                        <a href="" class=" badge bg-danger">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </td>
                </tr>
                <tr>
                    <td class="pt-3 pb-3 text-center">
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                        <label class="form-check-label" for="flexCheckDefault">
                        </label>
                    </td>
                    <td class="product-info">
                        <img src="{{ asset('img/home/ahlipakar2.jpg') }}" alt="Product Image" style="max-width: 30%;  display: block; margin-right: 10px; float: left;">
                        <!-- Nama Produk -->
                        <span class="product-name">Nama Produk 1</span>
                    </td>
                    <td class="text-center align-items-center ">
                        <div class="row ">
                            <div class="col"><span class="product-name">15.000</span></div>
                            
                        </div>
                        
                    </td>
                    <td class="d-flex justify-content-center" style="height: 100%">
                        <div class="div">
                            <label for="jumlah_produk" class="form-label" ></label>
                            <input type="number" class="form-control" id="jumlah_produk" name="jumlah_produk"  style="width: 60px;" value="1"  required>
                        </div>
                        
                    </td>
                    <td class="text-center">
                        <span class="product-name">15.000</span>
                    </td>
                    <td>
                        <a href="" class=" badge bg-danger">
                            <i class="bi bi-x-circle"></i>
                        </a>
                    </td>
                </tr>
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
                    <span>Total Produk : 12 Produk</span>
                </div>
                <div class="col-2">
                    <span><a href="">Hapus</a></span>
                </div>
                <div class="col-3">
                    <span>Rp. 20.000</span>
                </div>
                <div class="col-4">
                    <button type="submit" class="btn submit-login d-flex justify-content-center">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection