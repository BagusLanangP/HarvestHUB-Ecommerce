<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index(){
        $produk = Product::all();
        $kategori = ProductCategory::all();
        $data = array('produks' => $produk,
                       'kategoris' => $kategori   );
        return view('home.index', $data);

    }

    public function categoryDetail($id){
        $category = ProductCategory::findOrFail($id);
        $products = $category->produk;
        return view('home.kategori.index', ['productCat' => $products]);
    }


}
