@extends('layouts.mainlayouts')

@section('tittle', 'Home')


@section('content')
<!-- DETAIL PRODUK -->
<section class="detailProduk">
    <hr>
    <div class="container m-0 p-0">
        <div class="row">
            {{-- Foto Produk --}}
            <div class="col-5 rounded-2 shadow me-5 ">
                <div class="square-container">
                <div class="aspect-ratio aspect-ratio-1x1">
                    <img src="{{ asset('img/product/1.jpg') }}" alt="y">
                </div>
                </div>
            </div>

            <div class="col-7">
                <div class="row ">
                    <h3 class="text-start mb-2 product-detail-name">JERUK PURUT ASLI SULAIMAN</h3>
                
                    
                    <div class="row ">
                        <div class="col">
                            <h5 class="card-price text-start productPrice">15.000/kg</h5>
                        </div>
                    </div>
                    <div class="row mt-2 mb-1">
                        <div class="col-12">
                            <a href="" class="tokoname"><i class="bi bi-shop">Toko Orang Aring</i>
                            </a>
                        </div>
                        
                    </div>

                    <div class="row mt-0">
                        <div class="description overflow-auto  shadow ">
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed varius justo ac lectus venenatis, non bibendum elit aliquet. Nulla facilisi. Integer eu orci sed turpis tristique ullamcorper. Quisque suscipit, lectus ut auctor lacinia, mauris ex volutpat justo, in dapibus tortor mauris sit amet eros. Nulla facilisi. Suspendisse potenti.
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed varius justo ac lectus venenatis, non bibendum elit aliquet. Nulla facilisi. Integer eu orci sed turpis tristique ullamcorper. Quisque suscipit, lectus ut auctor lacinia, mauris ex volutpat justo, in dapibus tortor mauris sit amet eros. Nulla facilisi. Suspendisse potenti.
                        </p>
                    </div>                            
                </div>
            </div>
        
        

            </div>
        </div>
        </div>
        
        
        <div class="row mt-5 mb-5">
            <div class="col-1 p-0 m-0 me-5">
                    <a href="" >
                        <button type="button" class="like-product rounded">
                            <i class="bi bi-heart-fill"></i>
                        </button>    
                    </a>
            </div>
            <div class="col-2 me-5">
                    <a href="" >
                        <button type="button" class="chat-product rounded">
                            <i class="bi bi-chat-dots-fill">Chat</i>
                        </button>    
                    </a>
            </div>
                      
            <div class="col-7">
                <form action="{{ route('cartdetail.store') }}" method="POST"                class="d-inline-block">
                    @csrf
                        <input type="hidden" name="produk_id" value={{$itemproduk->id}}>
                        <button type="submit" class="add-cart rounded">
                            <i class="bi bi-cart-fill">Add to chart</i>
                        </button> 
                                      
                </form>                             
            </div>   
                        
        </div>

        
        
    </div>
</section>
@endsection

<!-- AKHIR DETA