<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
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
}
