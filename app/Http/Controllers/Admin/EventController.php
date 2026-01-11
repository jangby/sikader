<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    // 1. TAMPILKAN DAFTAR ACARA
    public function index()
    {
        $events = Event::latest()->get();
        return view('admin.events.index', compact('events'));
    }

    // 2. FORM TAMBAH ACARA
    public function create()
    {
        return view('admin.events.create');
    }

    // 3. SIMPAN ACARA BARU (UPDATED)
    public function store(Request $request)
    {
        // 1. Validasi
        $request->validate([
            'nama_acara'       => 'required|string|max:255',
            'jenis_kaderisasi' => 'required|string',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi'           => 'required|string',
            'kuota'            => 'required|numeric|min:0',
            'biaya'            => 'required|numeric|min:0',
            // Validasi Input Dinamis Dokumen
            'dokumen_nama'     => 'nullable|array',
            'dokumen_nama.*'   => 'nullable|string',
            'dokumen_wajib'    => 'nullable|array',
        ]);

        // 2. Proses Array Dokumen menjadi format JSON
        $configDokumen = [];
        if ($request->has('dokumen_nama')) {
            foreach ($request->dokumen_nama as $index => $nama) {
                if (!empty($nama)) {
                    $configDokumen[] = [
                        'nama'  => $nama,
                        // Cek apakah di index tersebut wajib bernilai '1'
                        'wajib' => isset($request->dokumen_wajib[$index]) && $request->dokumen_wajib[$index] == '1' ? true : false,
                    ];
                }
            }
        }

        // 3. Simpan ke Database
        Event::create([
            'nama_acara'       => $request->nama_acara,
            'slug'             => Str::slug($request->nama_acara) . '-' . time(),
            'jenis_kaderisasi' => $request->jenis_kaderisasi,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_selesai'  => $request->tanggal_selesai,
            'lokasi'           => $request->lokasi,
            'kuota'            => $request->kuota,
            'biaya'            => $request->biaya,
            'config_dokumen'   => $configDokumen, // <--- Data persyaratan masuk di sini
            'is_active'        => true,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil dibuat beserta persyaratan dokumennya!');
    }

    // 4. FORM EDIT ACARA
    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    // 5. UPDATE DATA ACARA (UPDATED)
    public function update(Request $request, Event $event)
    {
        // 1. Validasi
        $request->validate([
            'nama_acara'       => 'required|string|max:255',
            'jenis_kaderisasi' => 'required|string',
            'tanggal_mulai'    => 'required|date',
            'tanggal_selesai'  => 'required|date|after_or_equal:tanggal_mulai',
            'lokasi'           => 'required|string',
            'kuota'            => 'required|numeric|min:0',
            'biaya'            => 'required|numeric|min:0',
            // Validasi Input Dinamis Dokumen
            'dokumen_nama'     => 'nullable|array',
            'dokumen_nama.*'   => 'nullable|string',
            'dokumen_wajib'    => 'nullable|array',
        ]);

        // 2. Proses Array Dokumen menjadi format JSON
        $configDokumen = [];
        if ($request->has('dokumen_nama')) {
            foreach ($request->dokumen_nama as $index => $nama) {
                if (!empty($nama)) {
                    $configDokumen[] = [
                        'nama'  => $nama,
                        'wajib' => isset($request->dokumen_wajib[$index]) && $request->dokumen_wajib[$index] == '1' ? true : false,
                    ];
                }
            }
        }

        // 3. Update Database
        $event->update([
            'nama_acara'       => $request->nama_acara,
            // 'slug'          => Str::slug($request->nama_acara) . '-' . time(), // Optional jika slug mau diupdate
            'jenis_kaderisasi' => $request->jenis_kaderisasi,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_selesai'  => $request->tanggal_selesai,
            'lokasi'           => $request->lokasi,
            'kuota'            => $request->kuota,
            'biaya'            => $request->biaya,
            'config_dokumen'   => $configDokumen, // <--- Update data persyaratan
            'is_active'     => $request->is_active, // Jika ada input is_active di form edit
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Data acara dan persyaratan dokumen berhasil diperbarui!');
    }

    // 6. HAPUS ACARA
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil dihapus!');
    }
}