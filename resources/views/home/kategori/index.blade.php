@extends('layouts.mainlayouts')

@section('tittle', 'Home Category')


@section('content')


<section class="categoryselect">
    <div class="container">
        <div class="row text-center mb-3 ">
            <div class="col category-tittle">
              <h1>Kategori</h1>
              <h4>Temukan produk berdasarkan kategori yang anda pilih!</h3>
            </div>   
        </div>
        <hr>
        <div class="row text-start category-name mb-3">
            <h1>Sayur :</h1>
        </div>
        <div class="row  mb-3">
            @foreach($productCat as $pc)
            <div class="col-2 card me-2 shadow card-product">
                <a href="">
                    <img src="{{ asset('storage/' .  $pc->foto)}}" class="card-img-top responsive-image shadow-sm d-flex justify-content-center"  alt="...">
                    <div class="card-body">
                    <p class="card-text fw-medium">{{ $pc->name }}</p>
                    <p class="productPrice">{{ $pc->harga }}</p>
                    </div>    
                </a>                         
            </div>
            @endforeach
        </div>
        

    </div>




</section>



@endsection