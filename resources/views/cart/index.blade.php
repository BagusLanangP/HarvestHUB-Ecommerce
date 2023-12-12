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
        <div class="table-responsive small">
            <table class="table table-striped table-sm">
              <thead>
                <tr>
                    <th scope="col"  style="width: 10%;">
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
                    <td class="d-flex justify-content-center align-items-center">
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
                <tr>
                    <td class="d-flex justify-content-center align-items-center">
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
    <div class="cart-checkout vh-20 mt-4 shadow">
        <div class="container">
            <div class="row">
                <div class="col checkout-border">
                    <h1>Checkout Now!</h1>
                </div>
                <hr>
                <div class="col">

                </div>
            </div>
            <div class="row"></div>
        </div>
    </div>
</section>
@endsection