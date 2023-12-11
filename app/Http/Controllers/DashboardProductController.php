<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class DashboardProductController extends Controller
{
    public function index()
    {
        if (Gate::allows('is-admin')) {
            // If user is admin, retrieve all products
            $products = Product::all();
        } else {
            $user = auth()->user();
            $products = Product::where('user_id', $user->id)->get();
        }
        return view('dashboard.product.index', ['Products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.product.create',  ['product' => Product::all()], ['categories' => ProductCategory::all()]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|unique:products',
            'harga' => 'required',
            'description' => 'required',
            'jumlah_produk' => 'required',
            'foto' => 'max:255',   
            'slug' => 'required',
            'user_id' => 'required',
            // ... tambahkan aturan validasi lainnya sesuai kebutuhan
        ]);
    
        // Mengambil data yang relevan dari instance Request
        // $productData = [
        //     'name' => $validatedData['name'],
        //     'category_id' => $validatedData['category_id'],
        //     'harga' => $validatedData['harga'],
        //     'descripton' => $validatedData['description'],
        //     'jumlah_produk' => $validatedDa['jumlah_produk'],
        //     'foto' => $validatedData['foto'],
        //     'slug' => $validatedData['slug'],
        //     'user_id' => $validatedData['user_id'],
        // ];

        // return $productData;
    
        // Membuat produk baru
        Product::create($validatedData);
    
        // // Redirect atau lakukan tindakan lainnya setelah produk berhasil disimpan
        // return redirect('/dashboard/product');
    
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }

    public function checkSlug(Request $request){
        $slug = SlugService::createSlug(Product::class, 'slug', $request->namaproduk);
        return response()->json(['slug' => $slug]);
    }
}
