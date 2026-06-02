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
            if (!$item) {
                return redirect()->route('TenagaKerja.create')->with('info', 'Silakan lengkapi profil tenaga kerja Anda terlebih dahulu.');
            }
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
    public function create()
    {
        $latestRequest = \App\Models\RoleRequest::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->latest()
            ->first();
        return view('TenagaKerja.create', compact('latestRequest'));
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
            'keahlian' => 'required',
            'alamat' => 'required',
            'pengalaman' =>'required',
            'deskripsi' =>'required',
            'foto' => 'image|file',
            'foto_cv' => 'file|mimes:pdf|max:2048',    
        ]);

        if($request->file('foto')){
            $validatedData['foto'] = $request->file('foto')->store('tenagakerja-foto', 'public');
        }

        if($request->file('foto_cv')){
            $validatedData['foto_cv'] = $request->file('foto_cv')->store('tenagakerja-foto-cv', 'public');
        }
        $itemuser = $request->user();
        $validatedData['user_id'] = $itemuser->id;
        //ambil data user yang login
       
        
        TenagaKerja::create($validatedData);


        // $this->validate($request, [
        //     'nama' => 'required|max:50',
        //     'email' => 'required|email:dns|unique:tenaga_kerjas',
        //     'phone' => 'required|min:10',
        //     'alamat' => 'required',
        //     'pengalaman' =>'required',
        //     'deskripsi' =>'required',      
        // ]);

        // $itemuser = $request->user();//ambil data user yang login
        // $inputan = $request->all();
        // $inputan['user_id'] = $itemuser->id;
        
        // TenagaKerja::create($inputan);

        

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
            'foto' => 'nullable|image|file',
            'foto_cv' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        $item = TenagaKerja::findOrFail($id);
        
        $inputan = $request->except(['foto', 'foto_cv']);
        $itemuser = $request->user();
        $inputan['user_id'] = $itemuser->id;

        if ($request->hasFile('foto')) {
            $inputan['foto'] = $request->file('foto')->store('tenagakerja-foto', 'public');
        }

        if ($request->hasFile('foto_cv')) {
            $inputan['foto_cv'] = $request->file('foto_cv')->store('tenagakerja-foto-cv', 'public');
        }

        $item->update($inputan);   
        return redirect('/TenagaKerja')->with('success',  'Data Anda Tersimpan');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = TenagaKerja::findOrFail($id);
        
        // Delete associated files from storage disk public
        if ($item->foto && \Storage::disk('public')->exists($item->foto)) {
            \Storage::disk('public')->delete($item->foto);
        }
        if ($item->foto_cv && \Storage::disk('public')->exists($item->foto_cv)) {
            \Storage::disk('public')->delete($item->foto_cv);
        }
        
        // Revert user role back to 'user' (role_id = 2)
        $item->user->update(['role_id' => 2]);
        
        $item->delete();
        
        return redirect('/')->with('success', 'Profil Tenaga Kerja berhasil dihapus.');
    }
}
