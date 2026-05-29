<?php

namespace App\Http\Controllers;

use App\Models\AlamatPengiriman;
use Illuminate\Http\Request;

class AlamatPengirimanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AlamatPengiriman $alamatPengiriman)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlamatPengiriman $alamatPengiriman)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlamatPengiriman $alamatPengiriman)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlamatPengiriman $alamatPengiriman)
    {
        //
    }

    public function storeAjax(Request $request)
    {
        $validatedData = $request->validate([
            'namapenerima' => 'required|string|max:255',
            'Telp' => 'required|string|max:20',
            'alamat' => 'required|string',
            'kodepos' => 'required|string|max:10',
            'kelurahan' => 'required|string|max:255',
            'kecamatan' => 'required|string|max:255',
            'kota' => 'required|string|max:255',
            'provinsi' => 'required|string|max:255',
        ]);

        $alamat = AlamatPengiriman::where('user_id', auth()->id())
                    ->where('status', 'utama')
                    ->first();

        if ($alamat) {
            $alamat->update([
                'nama_penerima' => $validatedData['namapenerima'],
                'no_tlp' => $validatedData['Telp'],
                'alamat' => $validatedData['alamat'],
                'kodepos' => $validatedData['kodepos'],
                'kelurahan' => $validatedData['kelurahan'],
                'kecamatan' => $validatedData['kecamatan'],
                'kota' => $validatedData['kota'],
                'provinsi' => $validatedData['provinsi'],
            ]);
        } else {
            AlamatPengiriman::create([
                'user_id' => auth()->id(),
                'status' => 'utama',
                'nama_penerima' => $validatedData['namapenerima'],
                'no_tlp' => $validatedData['Telp'],
                'alamat' => $validatedData['alamat'],
                'kodepos' => $validatedData['kodepos'],
                'kelurahan' => $validatedData['kelurahan'],
                'kecamatan' => $validatedData['kecamatan'],
                'kota' => $validatedData['kota'],
                'provinsi' => $validatedData['provinsi'],
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Alamat berhasil disimpan'
        ]);
    }
}
