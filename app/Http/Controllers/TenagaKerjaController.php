<?php

namespace App\Http\Controllers;

use App\Models\TenagaKerja;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TenagaKerjaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $itemuser = Auth::user();

        if ($itemuser->role_id == 3) {
            $item = TenagaKerja::where('user_id', $itemuser->id)->first();
            $data = array('data' => $item);
            return view('TenagaKerja.index', $data);
        } else {
            // Handle a situation where the logged-in user does not have role_id 2
            // You can redirect or show an error message, for example.
            return redirect()->route('home')->with('error', 'You do not have the required role.');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(User $user)
    {
        return view('TenagaKerja.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'nama' => 'required|max:50',
            'email' => 'required|email:dns|unique:tenaga_kerjas',
            'phone' => 'required|min:10',
            'alamat' => 'required',
            'pengalaman' =>'required',
            'deskripsi' =>'required',
            
        ]);

        $itemuser = $request->user();//ambil data user yang login
        $inputan = $request->all();
        $inputan['user_id'] = $itemuser->id;
        $inputan['isi'] = 1;
        
        TenagaKerja::create($inputan);

        

        return redirect('/TenagaKerja')->with('success',  'Data Anda Tersimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(TenagaKerja $tenagaKerja)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = TenagaKerja::findOrFail($id);
            $data = array('data' => $item);
       return view('TenagaKerja.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'nama' => 'required|max:50',
            'email' => 'required|email|unique:tenaga_kerjas,email,' . $id,
            'phone' => 'required|min:10',
            'alamat' => 'required',
            'pengalaman' =>'required',
            'deskripsi' =>'required',
        ]);

        $item = TenagaKerja::findOrFail($id);
        // kalo ga ada error page not found 404
        
        $inputan = $request->all();
        $itemuser = $request->user();//ambil data user yang login
        $inputan['user_id'] = $itemuser->id;
        $item->update($inputan);   
            return redirect('/TenagaKerja')->with('success',  'Data Anda Tersimpan');
        
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TenagaKerja $tenagaKerja)
    {
        //
    }
}
