@extends('dashboard.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">{{ $title }} </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
      <div class="btn-group me-2">
        <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
        <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
      </div>
      <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle d-flex align-items-center gap-1">
        <svg class="bi"><use xlink:href="#calendar3"/></svg>
        This week
      </button>
    </div>
  </div>
  <div class="table-responsive small">
    @can('toko1')
    <a href="/dashboard/product/create" class="btn btn-primary mb-3 mt-4">New Product</a>
    @endcan
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">Id Produk</th>
          <th scope="col">Name</th>
          <th scope="col">Kategori</th>
          <th scope="col">Harga</th>
          <th scope="col">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach( $Products as $product)
        <tr>
          <td class="pt-2 pb-2">{{ $loop->iteration }}</td>
          <td class="pt-2 pb-2">
            <div class="">
              <img src="{{ asset('storage/' . $product->foto) }}" alt="Png/jpg"  style="width:5rem; height:5rem;  display: block; margin-right: 10px; float: left;" >
              <span class="product-name">{{ $product->name }}</span>
            </div>
            
            
          </td>
          <td class="pt-2 pb-2 product-name" >{{ $product->kategori->productName}}</td>
          <td class="pt-2 pb-2 product-name ">{{ $product->harga}}</td>
          <td class="pt-2 pb-2 product-name">
            <a href="/dashboard/product/{{ $product->id}}" class=" badge bg-info">
                <i class="bi bi-eye"></i>
            </a>
             @can('toko1') 
            <a href="/dashboard/product/{{ $product->id }}/edit" class=" badge bg-warning">
                <i class="bi bi-pencil-square"></i>
            </a>
            <form action="{{ route('product.destroy', $product->id) }}" method="post" style="display:inline;">
              @csrf
             @method('delete')
                <button type="submit" class="badge bg-danger"><i class="bi bi-x-circle"></i>
                </button>                    
            </form>
            @endcan
          </td>
          
        </tr>
        
        @endforeach
        
      </tbody>
    </table>
  </div>


@endsection