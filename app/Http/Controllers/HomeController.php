<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

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

    public function produkdetail($id) {
        $itemproduk = Product::where('slug', $id)
                            
                            ->first();
        if ($itemproduk) {
            if (Auth::user()) {//cek kalo user login
                $itemuser = Auth::user();
                // $itemwishlist = Wishlist::where('produk_id', $itemproduk->id)
                //                         ->where('user_id', $itemuser->id)
                //                         ->first();
                $data = array('title' => $itemproduk->name,
                        'itemproduk' => $itemproduk
                        // 'itemwishlist' => $itemwishlist
                    );
            } else {
                $data = array('title' => $itemproduk->name,
                            'itemproduk' => $itemproduk);
            }
            return view('home.produk.index', $data);            
        } else {
            // kalo produk ga ada, jadinya tampil halaman tidak ditemukan (error 404)
            return abort('404');
        }
    }


}
