<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;

class BiodataController extends Controller
{
    // 1. Tampilkan Form
    public function edit()
    {
        // Ambil user yang sedang login
        $user = Auth::user();
        
        // Ambil data profilnya (jika ada)
        $profile = $user->profile;

        return view('biodata.edit', compact('user', 'profile'));
    }

    // 2. Simpan Data
    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'rt'            => 'required|string|max:5',
            'rw'            => 'required|string|max:5',
            'desa'          => 'required|string|max:100',
            'kecamatan'     => 'required|string|max:100',
            'kabupaten'     => 'required|string|max:100',
            'asal_delegasi' => 'required|string|max:100',
        ]);

        // Simpan atau Update data (updateOrCreate)
        // Logikanya: Cari profile milik user ini, kalau ada update, kalau belum ada buat baru.
        Profile::updateOrCreate(
            ['user_id' => Auth::id()], // Kunci pencarian
            [
                'nama_lengkap'  => $request->nama_lengkap,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'alamat'        => $request->alamat,
                'rt'            => $request->rt,
                'rw'            => $request->rw,
                'desa'          => $request->desa,
                'kecamatan'     => $request->kecamatan,
                'kabupaten'     => $request->kabupaten,
                'asal_delegasi' => $request->asal_delegasi,
            ]
        );

        return redirect()->route('biodata.edit')->with('success', 'Biodata berhasil disimpan!');
    }
}