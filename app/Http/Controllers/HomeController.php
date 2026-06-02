<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Konsultan;
use App\Models\TenagaKerja;
use Illuminate\Http\Request;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index(){
        $produk = Product::all();
        $kategori = ProductCategory::all();
        $tenagaKerja = TenagaKerja::with('user')->get();
        $konsultan = Konsultan::with('user')->get();

    // Menggabungkan data dari TenagaKerja dan Konsultan
        $service = $tenagaKerja->merge($konsultan);
        // return $service;
        $data = array('produks' => $produk, 'kategoris' => $kategori, 'service' => $service);
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

    public function ahlipakardetail($slug) {
        $itemAP = Konsultan::whereHas('user', function($q) use ($slug) {
            $q->where('slug', $slug);
        })->first();

        if ($itemAP) {
            if (Auth::user()) {//cek kalo user login
                $itemuser = Auth::user();
                $data = array('title' => $itemAP->nama,
                        'itemproduk' => $itemAP
                    );
            } else {
                $data = array('title' => $itemAP->nama,
                            'itemproduk' => $itemAP);
            }
            return view('home.ahlipakar.detail', $data);            
        } else {
            return abort('404');
        }
    }

    public function tenagakerjadetail($slug) {
        $itemAP = TenagaKerja::whereHas('user', function($q) use ($slug) {
            $q->where('slug', $slug);
        })->first();

        if ($itemAP) {
            if (Auth::user()) {//cek kalo user login
                $itemuser = Auth::user();
                $data = array('title' => $itemAP->nama,
                        'itemproduk' => $itemAP
                    );
            } else {
                $data = array('title' => $itemAP->nama,
                            'itemproduk' => $itemAP);
            }
            return view('home.tenagakerja.detail', $data);            
        } else {
            return abort('404');
        }
    }

    public function cari() 
    {    
      $itemproduk = Product::latest()->filter(request(['cari']))->get();
        return view('home.search', [ 
          "judul" => 'Hasil Pencarian',
          "hasil" =>  $itemproduk,
        ]);
    }

    public function tenagakerja(){
        $data = TenagaKerja::with('user')->get();
        return view('home.tenagakerja.index', compact('data'));
    } 
    public function ahlipakar(){
        $data = Konsultan::with('user')->get();
        return view('home.ahlipakar.index', compact('data'));
    }

    public function chat() {
        $tokos = \App\Models\Toko::with('user')->get();
        $konsultans = \App\Models\Konsultan::with('user')->get();
        $tenagaKerjas = \App\Models\TenagaKerja::with('user')->get();

        return view('home.chat', compact('tokos', 'konsultans', 'tenagaKerjas'));
    }

}
