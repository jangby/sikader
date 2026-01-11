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
            
            // Validasi Dokumen
            'dokumen_nama'     => 'nullable|array',
            'dokumen_nama.*'   => 'nullable|string',
            
            // Validasi Info Pembayaran (Baru)
            'rek_provider'     => 'nullable|array',
            'rek_number'       => 'nullable|array',
            'rek_name'         => 'nullable|array',

            'banner'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi Banner
        ]);

        // 2. Proses Array Dokumen
        $configDokumen = [];
        if ($request->has('dokumen_nama')) {
            foreach ($request->dokumen_nama as $index => $nama) {
                if (!empty($nama)) {
                    $configDokumen[] = [
                        'nama'  => $nama,
                        'wajib' => isset($request->dokumen_wajib[$index]) && $request->dokumen_wajib[$index] == '1',
                    ];
                }
            }
        }

        // 3. Proses Array Info Pembayaran (LOGIKA BARU)
        $infoPembayaran = [];
        if ($request->has('rek_provider')) {
            foreach ($request->rek_provider as $index => $provider) {
                if (!empty($provider)) {
                    $infoPembayaran[] = [
                        'provider' => $provider, // Misal: BRI, DANA, OVO
                        'number'   => $request->rek_number[$index] ?? '',
                        'owner'    => $request->rek_name[$index] ?? '',
                    ];
                }
            }
        }

        // 2. Upload Banner
        $bannerPath = null;
        if ($request->hasFile('banner')) {
            // Simpan di folder public/banners
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        // 4. Simpan ke Database
        Event::create([
            'nama_acara'       => $request->nama_acara,
            'slug'             => Str::slug($request->nama_acara) . '-' . time(),
            'banner'           => $bannerPath,
            'jenis_kaderisasi' => $request->jenis_kaderisasi,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_selesai'  => $request->tanggal_selesai,
            'lokasi'           => $request->lokasi,
            'kuota'            => $request->kuota,
            'biaya'            => $request->biaya,
            'config_dokumen'   => $configDokumen,
            'info_pembayaran'  => $infoPembayaran, // <--- Simpan disini
            'is_active'        => true,
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil dibuat!');
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
            
            // Validasi Dokumen
            'dokumen_nama'     => 'nullable|array',
            'dokumen_nama.*'   => 'nullable|string',
            
            // Validasi Info Pembayaran (Baru)
            'rek_provider'     => 'nullable|array',
            'rek_number'       => 'nullable|array',
            'rek_name'         => 'nullable|array',

            'banner'           => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi Banner
        ]);

        // 2. Proses Array Dokumen (Sama seperti store)
        $configDokumen = [];
        if ($request->has('dokumen_nama')) {
            foreach ($request->dokumen_nama as $index => $nama) {
                if (!empty($nama)) {
                    $configDokumen[] = [
                        'nama'  => $nama,
                        'wajib' => isset($request->dokumen_wajib[$index]) && $request->dokumen_wajib[$index] == '1',
                    ];
                }
            }
        }

        // 3. Proses Info Pembayaran (Sama seperti store)
        $infoPembayaran = [];
        if ($request->has('rek_provider')) {
            foreach ($request->rek_provider as $index => $provider) {
                if (!empty($provider)) {
                    $infoPembayaran[] = [
                        'provider' => $provider,
                        'number'   => $request->rek_number[$index] ?? '',
                        'owner'    => $request->rek_name[$index] ?? '',
                    ];
                }
            }
        }

        // 2. Handle Banner Update
        $bannerPath = $event->banner; // Pakai banner lama dulu
        
        if ($request->hasFile('banner')) {
            // Hapus banner lama jika ada
            if ($event->banner && Storage::disk('public')->exists($event->banner)) {
                Storage::disk('public')->delete($event->banner);
            }
            // Upload banner baru
            $bannerPath = $request->file('banner')->store('banners', 'public');
        }

        // 4. Update Database
        $event->update([
            'nama_acara'       => $request->nama_acara,
            'banner'           => $bannerPath,
            'jenis_kaderisasi' => $request->jenis_kaderisasi,
            'tanggal_mulai'    => $request->tanggal_mulai,
            'tanggal_selesai'  => $request->tanggal_selesai,
            'lokasi'           => $request->lokasi,
            'kuota'            => $request->kuota,
            'biaya'            => $request->biaya,
            'config_dokumen'   => $configDokumen,
            'info_pembayaran'  => $infoPembayaran, // <--- Update disini
        ]);

        return redirect()->route('admin.events.index')->with('success', 'Acara diperbarui!');
    }

    // 6. HAPUS ACARA
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('admin.events.index')->with('success', 'Acara berhasil dihapus!');
    }
}