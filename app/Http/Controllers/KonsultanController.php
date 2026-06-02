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
            if (!$item) {
                return redirect()->route('Konsultan.create')->with('info', 'Silakan lengkapi profil pakar/konsultan Anda terlebih dahulu.');
            }
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
        $latestRequest = \App\Models\RoleRequest::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->latest()
            ->first();
        return view('Konsultan.create', compact('latestRequest'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       
        $validatedData = $request->validate([
            'nama' => 'required|max:50',
            'email' => 'required|email:dns|unique:konsultans',
            'phone' => 'required|min:10',
            'keahlian' => 'required',
            'alamat' => 'required',
            'pengalaman' =>'required',
            'deskripsi' =>'required',
            'foto' => 'image|file',
            'foto_cv' => 'image|file',    
        ]);
        // $this->validate($request, [
        //     'nama' => 'required|max:50',
        //     'email' => 'required|email:dns|unique:konsultans',
        //     'phone' => 'required|min:10',
        //     'keahlian' => 'required',
        //     'alamat' => 'required',
        //     'pengalaman' =>'required',
        //     'deskripsi' =>'required',
        //     'foto' => 'image|file',
        //     'foto_cv' => 'image|file',    
        // ]);
        if($request->file('foto')){
            $validatedData['foto'] = $request->file('foto')->store('konsultan-foto', 'public');
        }

        if($request->file('foto_cv')){
            $validatedData['foto_cv'] = $request->file('foto_cv')->store('konsultan-foto-cv', 'public');
        }
        $itemuser = $request->user();
        $validatedData['user_id'] = $itemuser->id;
        //ambil data user yang login
       
        
        Konsultan::create($validatedData);

        

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
    public function edit($id)
    {
        $item = Konsultan::findOrFail($id);
        $data = array('data' => $item);
        return view('Konsultan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'nama' => 'required|max:50',
            'email' => 'required|email|unique:konsultans,email,' . $id,
            'phone' => 'required|min:10',
            'alamat' => 'required',
            'pengalaman' =>'required',
            'deskripsi' =>'required',
            'foto' => 'nullable|image|file|max:2048',
            'foto_cv' => 'nullable|image|file|max:2048',
        ]);

        $item = Konsultan::findOrFail($id);
        
        $inputan = $request->except(['foto', 'foto_cv']);
        $itemuser = $request->user();
        $inputan['user_id'] = $itemuser->id;

        if ($request->hasFile('foto')) {
            if ($item->foto && \Storage::disk('public')->exists($item->foto)) {
                \Storage::disk('public')->delete($item->foto);
            }
            $inputan['foto'] = $request->file('foto')->store('konsultan-foto', 'public');
        }

        if ($request->hasFile('foto_cv')) {
            if ($item->foto_cv && \Storage::disk('public')->exists($item->foto_cv)) {
                \Storage::disk('public')->delete($item->foto_cv);
            }
            $inputan['foto_cv'] = $request->file('foto_cv')->store('konsultan-foto-cv', 'public');
        }

        $item->update($inputan);   
        return redirect('/Konsultan')->with('success', 'Data Anda Tersimpan');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $item = Konsultan::findOrFail($id);
        
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
        
        return redirect('/')->with('success', 'Profil Konsultan berhasil dihapus.');
    }
}
