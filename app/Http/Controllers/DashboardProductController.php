<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\User;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class DashboardProductController extends Controller
{
    public function index()
    {
        $itemuser = Auth::user();  
        $toko = Toko::where('user_id', $itemuser->id)->get();
        

        if ($toko->isNotEmpty() || Gate::allows('is-admin')) {
                
            if (Gate::allows('is-admin')) {
                // If user is admin, retrieve all products
                $products = Product::all();
                $namatoko = "Selamat Datang : ". $itemuser->nama ;
            } else { 
                $toko = Toko::where('user_id', $itemuser->id)->first();
                $namatoko = "Toko : " . $toko->nama;
                $products = Product::where('user_id', $itemuser->id)->get();
            }
            
            $data = array('title' => $namatoko,
                       'Products' => $products,);
            return view('dashboard.product.index', $data);
            
        } else {
            return redirect('/Toko/create');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.product.create',  ['product' => Product::all()], ['categories' => ProductCategory::all()]);
    }

    /**
     * Store a newly created resource in storage
     */
    public function store(Request $request)
    {
        // ddd($request);
        // return $request->file('foto')->store('product-images');

        $itemuser = Auth::user();  
        $toko = Toko::where('user_id', $itemuser->id)->first();

        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required',
            'harga' => 'required',
            'description' => 'required',
            'jumlah_produk' => 'required',
            'foto' => 'image|file',  
            'slug' => 'required|unique:products',
            
        ]);
         
        if($request->file('foto')){
            $validatedData['foto'] = $request->file('foto')->store('product-images');
        }

        $validatedData['user_id'] = $itemuser->id;
        $validatedData['toko_id'] = $toko->id;
        
        // Membuat produk baru
        Product::create($validatedData);
        return redirect('/dashboard/product')->with('success',  'Data Anda Tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $kategori = ProductCategory::all();
        $item = Product::findOrFail($id);
            $data = array('data' => $item,
                          'kategoris' => $kategori);
        return view('dashboard.product.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $itemuser = Auth::user();  
        $toko = Toko::where('user_id', $itemuser->id)->first();
        $rules = [
            'name' => 'required|max:255',
            'category_id' => 'required',
            'harga' => 'required',
            'description' => 'required',
            'jumlah_produk' => 'required',
            'foto' => 'image|file',  
        ];

        if($request->slug != $product->slug){
            $rules['slug'] = 'required|unique:products';
        }

        $rules['user_id'] = $itemuser->id;
        $rules['toko_id'] = $toko->id;

        $validatedData = $request->validate($rules);

        if($request->file('foto')){
            $validatedData['foto'] = $request->file('foto')->store('product-images');
        }
        
        // Membuat produk baru
        
        Product::where('id',  $product->id)->update($validatedData);

        return redirect('/dashboard/product')->with('success',  'Data Anda Tersimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $itemproduk = Product::findOrFail($id);//cari berdasarkan id = $id, 
        // kalo ga ada error page not found 404
        if ($itemproduk->delete()) {
            return back()->with('success', 'Data berhasil dihapus');
        } else {
            return back()->with('error', 'Data gagal dihapus');
        }
    }

    public function checkSlug(Request $request){
        $slug = SlugService::createSlug(Product::class, 'slug', $request->namaproduk);
        return response()->json(['slug' => $slug]);
    }
}
