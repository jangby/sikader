<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\User;
use App\Services\WahaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;
use Illuminate\Support\Facades\DB; // Untuk Database Transaction
use App\Models\UserProfile;
use App\Models\Registration;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver; // Driver Gambar
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PublicEventController extends Controller
{
    // 1. TAMPILKAN FORMULIR PENDAFTARAN AWAL
    public function showRegister(Event $event)
    {
        return view('auth.event-register', compact('event'));
    }

    // 2. PROSES PENDAFTARAN (SIMPAN USER & KIRIM KODE)
    public function processRegister(Request $request, Event $event, WahaService $waha)
    {
        // Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'no_hp' => 'required|string|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Gunakan Transaction: Jika ada error di tengah jalan, batalkan semua perubahan database
        DB::transaction(function () use ($request, $waha) {

            // A. Simpan User Baru
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password),
            ]);

            // B. Generate Kode Acak 6 Digit
            $emailCode = rand(100000, 999999);
            $waCode = rand(100000, 999999);

            // C. Simpan Kode ke Database
            DB::table('verification_codes')->insert([
                ['user_id' => $user->id, 'type' => 'email', 'code' => $emailCode, 'expires_at' => now()->addMinutes(15)],
                ['user_id' => $user->id, 'type' => 'whatsapp', 'code' => $waCode, 'expires_at' => now()->addMinutes(15)],
            ]);

            // D. Kirim Email (Pakai try catch agar jika email gagal, proses tidak error total)
            try {
                Mail::to($user->email)->send(new OtpMail($emailCode));
            } catch (\Exception $e) { 
                \Log::error('Gagal kirim email: '.$e->getMessage()); 
            }

            // E. Kirim WhatsApp
            $pesanWA = "*KODE VERIFIKASI SI-KADER*\n\nHalo {$user->name},\nKode WhatsApp Anda: *$waCode*\n\nJangan berikan kode ini kepada siapapun.";
            $waha->sendText($user->no_hp, $pesanWA);

            // F. Login User Otomatis (Status belum verified)
            Auth::login($user);
        });

        // G. Arahkan ke halaman input kode
        return redirect()->route('events.verify_page', $event->id);
    }

    // 3. TAMPILKAN HALAMAN INPUT KODE
    public function showVerify(Event $event)
    {
        $user = Auth::user();

        // Jika belum login, tendang ke login
        if (!$user) return redirect()->route('login');

        // Jika user sudah terverifikasi sebelumnya, langsung lanjut ke biodata
        if ($user->email_verified_at && $user->wa_verified_at) {
            return redirect()->route('events.form_biodata', $event->id);
        }

        return view('auth.event-verify', compact('event', 'user'));
    }

    // 4. CEK KODE YANG DIINPUT USER
    public function verify(Request $request, Event $event)
    {
        $request->validate([
            'email_code' => 'required|numeric',
            'wa_code' => 'required|numeric',
        ]);

        $user = Auth::user();

        // Cek Kode Email di Database
        $validEmail = DB::table('verification_codes')
            ->where('user_id', $user->id)
            ->where('type', 'email')
            ->where('code', $request->email_code)
            ->where('expires_at', '>', now()) // Pastikan belum kadaluarsa
            ->exists();

        // Cek Kode WA di Database
        $validWa = DB::table('verification_codes')
            ->where('user_id', $user->id)
            ->where('type', 'whatsapp')
            ->where('code', $request->wa_code)
            ->where('expires_at', '>', now())
            ->exists();

        if ($validEmail && $validWa) {
            // 1. Update User jadi Verified
            // Kita gunakan forceFill agar jika lupa set fillable, tetap maksa masuk
            $user->forceFill([
                'email_verified_at' => now(),
                'wa_verified_at' => now(),
            ])->save();

            // 2. Hapus kode bekas
            DB::table('verification_codes')->where('user_id', $user->id)->delete();

            // 3. PENTING: Refresh data user di sesi login
            // Agar saat redirect, sistem tahu user ini sudah update datanya
            Auth::setUser($user->fresh()); 

            return redirect()->route('events.form_biodata', $event->id)
                ->with('success', 'Verifikasi Berhasil! Silakan lengkapi biodata.');
        } else {
            return back()->with('error', 'Salah satu atau kedua kode verifikasi salah/kadaluarsa.');
        }
    }

    // 5. TAMPILKAN FORM BIODATA (TAHAP 3)
    public function showBiodata(Event $event)
    {
        $user = Auth::user();

        // Cek apakah sudah verified? (Security)
        if (!$user->email_verified_at || !$user->wa_verified_at) {
            return redirect()->route('events.verify_page', $event->id)
                ->with('error', 'Silakan verifikasi akun terlebih dahulu.');
        }

        // Cek apakah sudah pernah daftar di event ini?
        $existingReg = Registration::where('user_id', $user->id)->where('event_id', $event->id)->first();
        if ($existingReg) {
            return redirect()->route('dashboard')->with('success', 'Anda sudah terdaftar di acara ini.');
        }

        return view('auth.event-biodata', compact('event', 'user'));
    }

    // 6. PROSES SIMPAN BIODATA & UPLOAD
    public function processBiodata(Request $request, Event $event)
    {

        
        
        // A. Validasi Input
        $rules = [
            'tempat_lahir' => 'required|string',
            'tanggal_lahir'=> 'required|date',
            'alamat'       => 'required|string',
            'rt'           => 'required|string',
            'rw'           => 'required|string',
            'desa'         => 'required|string',
            'kecamatan'    => 'required|string',
            'kabupaten'    => 'required|string',
            'asal_delegasi'=> 'required|string',
            'ukuran_baju'  => 'required|string|in:S,M,L,XL,XXL,XXXL',
        ];

        // Validasi Dokumen Dinamis (Sesuai Config Event)
        if (!empty($event->config_dokumen)) {
            foreach ($event->config_dokumen as $index => $doc) {
                if ($doc['wajib']) {
                    // dokumen.0, dokumen.1, dst
                    $rules["dokumen.$index"] = 'required|file|mimes:jpg,jpeg,png,pdf|max:5120'; // Max 5MB
                } else {
                    $rules["dokumen.$index"] = 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120';
                }
            }
        }

        $request->validate($rules);

        DB::transaction(function () use ($request, $event) {
            $user = Auth::user();

            // B. Simpan/Update Profil User
            UserProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nama_lengkap'  => $user->name, // Ambil dari user table
                    'no_hp'         => $user->no_hp,
                    'jenis_kelamin' => $request->jenis_kelamin,
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

            // C. Proses Upload Dokumen & Kompresi
            $dataDokumen = [];
            
            // Siapkan Manager Gambar (Intervention Image v3)
            $manager = new ImageManager(new Driver());

            if ($request->hasFile('dokumen')) {
                foreach ($request->file('dokumen') as $index => $file) {
                    // Ambil nama dokumen dari config
                    $namaDoc = $event->config_dokumen[$index]['nama'] ?? 'Dokumen-' . $index;
                    
                    // Generate nama file unik
                    $extension = $file->getClientOriginalExtension();
                    $filename  = Str::slug($user->name) . '-' . Str::slug($namaDoc) . '-' . time() . '.' . $extension;
                    $path      = 'documents/' . $event->id . '/' . $filename;

                    // Cek Tipe File
                    if (in_array(strtolower($extension), ['jpg', 'jpeg', 'png'])) {
                        // JIKA GAMBAR: Kompres!
                        // Baca gambar
                        $image = $manager->read($file);
                        
                        // Resize jika lebar > 1000px (biar tidak terlalu besar dimensinya)
                        if ($image->width() > 1200) {
                            $image->scale(width: 1200);
                        }

                        // Simpan ke Storage dengan kualitas 75%
                        // Kita encode ulang jadi file stream
                        $encoded = $image->toJpeg(quality: 75); 
                        Storage::disk('public')->put($path, $encoded);
                    } else {
                        // JIKA PDF: Simpan biasa (tidak bisa dikompres library image)
                        Storage::disk('public')->putFileAs('documents/' . $event->id, $file, $filename);
                    }

                    // Simpan path ke array data
                    $dataDokumen[$namaDoc] = $path;
                }
            }

            // D. Buat Registrasi Event
            Registration::create([
                'user_id'       => $user->id,
                'event_id'      => $event->id,
                'status'        => 'pending', // Menunggu pembayaran/verifikasi
                'ukuran_baju'   => $request->ukuran_baju,
                'data_dokumen'  => $dataDokumen, // Simpan JSON path dokumen
            ]);
        });

        // E. Redirect ke Dashboard / Halaman Sukses
        return redirect()->route('dashboard')->with('success', 'Pendaftaran Berhasil! Silakan cek status pendaftaran Anda.');
    }
}