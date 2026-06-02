<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $itemuser = Auth::user();

        if ($itemuser->role_id == 5) {
            $item = Toko::where('user_id', $itemuser->id)->first();
            
            if (!$item) {
                return redirect()->route('Toko.create')->with('info', 'Silakan buat profil toko Anda terlebih dahulu.');
            }

            // Query produk toko milik user
            $query = Product::where('toko_id', $item->id);

            // Filter Pencarian
            if ($request->filled('search')) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            // Filter Urutan/Sorting
            if ($request->filled('sort')) {
                if ($request->sort == 'termurah') {
                    $query->orderBy('harga', 'asc');
                } elseif ($request->sort == 'termahal') {
                    $query->orderBy('harga', 'desc');
                } elseif ($request->sort == 'terlaris') {
                    $query->select('products.*')
                          ->selectRaw('COALESCE(SUM(cart_details.qty), 0) as total_sold')
                          ->leftJoin('cart_details', 'products.id', '=', 'cart_details.produk_id')
                          ->groupBy('products.id')
                          ->orderByDesc('total_sold');
                } elseif ($request->sort == 'terlama') {
                    $query->orderBy('id', 'asc');
                } else {
                    $query->orderBy('id', 'desc');
                }
            } else {
                $query->orderBy('id', 'desc');
            }

            $products = $query->get();

            $data = array(
                'data' => $item,
                'products' => $products
            );
            return view('Toko.index', $data);
        } else {
            // Handle a situation where the logged-in user does not have role_id 2
            // You can redirect or show an error message, for example.
            return redirect()->route('home')->with('error', 'You do not have the required role.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $latestRequest = \App\Models\RoleRequest::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->latest()
            ->first();
        return view('Toko.create', compact('latestRequest'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:50',
            'email' => 'required|email:dns|unique:tenaga_kerjas',
            'phone' => 'required|min:10',
            'alamat' => 'required',
            'deskripsi' =>'required',
            'foto' => 'image|file',  
            'foto_syarat' => 'image|file',  
        ]);

        if($request->file('foto')){
            $validatedData['foto'] = $request->file('foto')->store('toko-foto', 'public');
        }

        if($request->file('foto_syarat')){
            $validatedData['foto_cv'] = $request->file('foto_syarat')->store('toko-foto-syarat', 'public');
        }
        $itemuser = $request->user();
        $validatedData['user_id'] = $itemuser->id;

        // $this->validate($request, [
        //     'nama' => 'required|max:50|unique:tokos',
        //     'email' => 'required|email:dns|unique:tokos',
        //     'phone' => 'required|min:10|unique:tokos',
        //     'alamat' => 'required',
        //     'deskripsi' =>'required',
            
        // ]);
        Toko::create($validatedData);

        

        return redirect('/Toko')->with('success',  'Data Anda Tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id)
    {
        $toko = Toko::findOrFail($id);
        
        $query = Product::where('toko_id', $id);
        
        // Search filter
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        // Sort filter
        if ($request->filled('sort')) {
            if ($request->sort == 'termurah') {
                $query->orderBy('harga', 'asc');
            } elseif ($request->sort == 'termahal') {
                $query->orderBy('harga', 'desc');
            } elseif ($request->sort == 'terlaris') {
                $query->select('products.*')
                      ->selectRaw('COALESCE(SUM(cart_details.qty), 0) as total_sold')
                      ->leftJoin('cart_details', 'products.id', '=', 'cart_details.produk_id')
                      ->groupBy('products.id')
                      ->orderByDesc('total_sold');
            } elseif ($request->sort == 'terlama') {
                $query->orderBy('id', 'asc');
            } else {
                $query->orderBy('id', 'desc');
            }
        } else {
            $query->orderBy('id', 'desc');
        }
        
        $products = $query->get();
        
        return view('Toko.view', compact('toko', 'products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = Toko::findOrFail($id);
            $data = array('data' => $item);
        return view('Toko.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:50|unique:tokos,nama,' . $id,
            'email' => 'required|email|unique:tokos,email,' . $id,
            'phone' => 'required|min:10|unique:tokos,phone,' . $id,
            'alamat' => 'required',
            'deskripsi' =>'required',
            'year_started' => 'nullable|integer',
            'region' => 'nullable|string|max:255',
            'link_tiktok' => 'nullable|url',
            'link_ig' => 'nullable|url',
            'link_fb' => 'nullable|url',
            'foto' => 'image|file|max:2048',  
            'foto_syarat' => 'image|file|max:2048',  
        ]);

        $item = Toko::findOrFail($id);
        
        if($request->file('foto')){
            if ($item->foto && \Storage::disk('public')->exists($item->foto)) {
                \Storage::disk('public')->delete($item->foto);
            }
            $validatedData['foto'] = $request->file('foto')->store('toko-foto', 'public');
        }

        if($request->file('foto_syarat')){
            if ($item->foto_cv && \Storage::disk('public')->exists($item->foto_cv)) {
                \Storage::disk('public')->delete($item->foto_cv);
            }
            $validatedData['foto_cv'] = $request->file('foto_syarat')->store('toko-foto-syarat', 'public');
        }

        $itemuser = $request->user();
        $validatedData['user_id'] = $itemuser->id;

        $item->update($validatedData);   
        return redirect('/Toko')->with('success',  'Data Anda Tersimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Toko $toko)
    {
        //
    }
}
