<?php

namespace App\Http\Controllers;

use App\Models\Konsultan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class KonsultanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $itemuser = Auth::user();

        if ($itemuser->role_id == 4) {
            $item = Konsultan::where('user_id', $itemuser->id)->first();
            $data = array('data' => $item);
            return view('Konsultan.index', $data);
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
        return view('Konsultan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'nama' => 'required|max:50',
            'email' => 'required|email:dns|unique:konsultans',
            'phone' => 'required|min:10',
            'alamat' => 'required',
            'pengalaman' =>'required',
            'deskripsi' =>'required',
            
        ]);

        $itemuser = $request->user();//ambil data user yang login
        $inputan = $request->all();
        $inputan['user_id'] = $itemuser->id;
        
        Konsultan::create($inputan);

        

        return redirect('/Konsultan')->with('success',  'Data Anda Tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Konsultan $konsultan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Konsultan $id)
    {
        $item = Konsulatan::findOrFail($id);
            $data = array('data' => $item);
        return view('Konsulatan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Konsultan $konsultan)
    {
        $this->validate($request, [
            'nama' => 'required|max:50',
            'email' => 'required|email|unique:konsultans,email,' . $id,
            'phone' => 'required|min:10',
            'alamat' => 'required',
            'pengalaman' =>'required',
            'deskripsi' =>'required',
        ]);

        $item = Konsultan::findOrFail($id);
        // kalo ga ada error page not found 404
        
        $inputan = $request->all();
        $itemuser = $request->user();//ambil data user yang login
        $inputan['user_id'] = $itemuser->id;
        $item->update($inputan);   
            return redirect('/Konsultan')->with('success',  'Data Anda Tersimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Konsultan $konsultan)
    {
        //
    }
}
