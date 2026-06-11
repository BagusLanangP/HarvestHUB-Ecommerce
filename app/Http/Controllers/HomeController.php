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
        $prodQuery = Product::query();
        $tkQuery = TenagaKerja::with('user');
        $ksQuery = Konsultan::with('user');

        if (session()->has('selected_location')) {
            $lokasi = session('selected_location');
            $prodQuery->whereHas('toko', function($q) use ($lokasi) {
                $q->where('alamat', 'like', '%' . $lokasi . '%')
                  ->orWhere('region', 'like', '%' . $lokasi . '%');
            });
            $tkQuery->where('alamat', 'like', '%' . $lokasi . '%');
            $ksQuery->where('alamat', 'like', '%' . $lokasi . '%');
        }

        $userAgent = request()->header('User-Agent', '');
        $isMobile = preg_match('/Mobile|Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i', $userAgent);
        $perPage = $isMobile ? 10 : 18;
        $produk = $prodQuery->paginate($perPage)->withQueryString();
        $kategori = ProductCategory::all();
        $tenagaKerja = $tkQuery->get();
        $konsultan = $ksQuery->get();

        // Menggabungkan data dari TenagaKerja dan Konsultan
        $service = $tenagaKerja->merge($konsultan);
        $data = array('produks' => $produk, 'kategoris' => $kategori, 'service' => $service);
        return view('home.index', $data);
    }

    public function redirectToCategorySlug($id)
    {
        $category = ProductCategory::findOrFail($id);
        $slug = \Illuminate\Support\Str::slug($category->productName);
        return redirect()->route('category.detail', ['slug' => $slug], 301);
    }

    public function categoryDetail($slug)
    {
        $categories = ProductCategory::all();
        $category = $categories->first(function ($cat) use ($slug) {
            return \Illuminate\Support\Str::slug($cat->productName) === $slug;
        });

        if (!$category) {
            // Check if $slug is numeric as a fallback
            if (is_numeric($slug)) {
                $category = ProductCategory::find($slug);
                if ($category) {
                    return redirect()->route('category.detail', ['slug' => \Illuminate\Support\Str::slug($category->productName)], 301);
                }
            }
            abort(404);
        }

        $prodQuery = $category->produk();
        if (session()->has('selected_location')) {
            $lokasi = session('selected_location');
            $prodQuery->whereHas('toko', function ($q) use ($lokasi) {
                $q->where('alamat', 'like', '%' . $lokasi . '%')
                  ->orWhere('region', 'like', '%' . $lokasi . '%');
            });
        }
        $userAgent = request()->header('User-Agent', '');
        $isMobile = preg_match('/Mobile|Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i', $userAgent);
        $perPage = $isMobile ? 10 : 18;
        $products = $prodQuery->paginate($perPage)->withQueryString();
        return view('home.kategori.index', [
            'category' => $category,
            'productCat' => $products
        ]);
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
        $filters = request(['cari', 'lokasi']);
        if (!isset($filters['lokasi']) && session()->has('selected_location')) {
            $filters['lokasi'] = session('selected_location');
        }
        $userAgent = request()->header('User-Agent', '');
        $isMobile = preg_match('/Mobile|Android|BlackBerry|iPhone|iPad|iPod|Opera Mini|IEMobile/i', $userAgent);
        $perPage = $isMobile ? 10 : 18;
        $itemproduk = Product::latest()->filter($filters)->paginate($perPage)->withQueryString();
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

    public function setLocation(Request $request)
    {
        $request->validate([
            'lokasi' => 'nullable|string|max:100'
        ]);

        if ($request->filled('lokasi')) {
            session(['selected_location' => $request->lokasi]);
        } else {
            session()->forget('selected_location');
        }

        return response()->json(['success' => true]);
    }
}
