<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TokoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $itemuser = Auth::user();

        if ($itemuser->role_id == 5) {
            $item = Toko::where('user_id', $itemuser->id)->first();
            $data = array('data' => $item);
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
        return view('Toko.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'nama' => 'required|max:50|unique:tokos',
            'email' => 'required|email:dns|unique:tokos',
            'phone' => 'required|min:10|unique:tokos',
            'alamat' => 'required',
            'deskripsi' =>'required',
            
        ]);

        $itemuser = $request->user();//ambil data user yang login
        $inputan = $request->all();
        $inputan['user_id'] = $itemuser->id;
        
        Toko::create($inputan);

        

        return redirect('/Toko')->with('success',  'Data Anda Tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Toko $toko)
    {
        //
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
        $this->validate($request, [
            'nama' => 'required|max:50|unique:tokos,nama,' . $id,
            'email' => 'required|email|unique:tokos,email,' . $id,
            'phone' => 'required|min:10|unique:tokos,phone,' . $id,
            'alamat' => 'required',
            'deskripsi' =>'required',
        ]);

        $item = Toko::findOrFail($id);
        // kalo ga ada error page not found 404
        
        $inputan = $request->all();
        $itemuser = $request->user();//ambil data user yang login
        $inputan['user_id'] = $itemuser->id;
        $item->update($inputan);   
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
