<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class KaderController extends Controller
{
    public function index(Request $request)
    {
        // 1. QUERY UTAMA
        // Ambil user dengan role 'user'
        // HAPUS filter 'where status lulus' agar semua riwayat muncul
        $query = User::where('role', 'user')
            ->with(['profile', 'registrations' => function($q) {
                $q->whereHas('event')
                  ->with('event');
            }]);

        // 2. FITUR PENCARIAN
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhereHas('profile', function($p) use ($search) {
                      $p->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('asal_delegasi', 'like', "%{$search}%");
                  });
            });
        }

        $users = $query->paginate(10);

        // 3. TRANSFORMASI DATA (LOGIKA PENENTUAN KELOMPOK)
        $users->getCollection()->transform(function($user) {
            // Ambil event terakhir yang diikuti (berdasarkan tanggal selesai event)
            // Tidak peduli statusnya (pending/lulus/gagal), yang penting pernah ikut/daftar
            $lastRegistration = $user->registrations->sortByDesc(function($reg) {
                return $reg->event->tanggal_selesai;
            })->first();

            $status = 'Belum Kader';
            $badgeColor = 'bg-gray-100 text-gray-800';
            $eventName = '-';
            $regStatus = '';

            if ($lastRegistration) {
                $jenis = $lastRegistration->event->jenis_kaderisasi;
                $eventName = $lastRegistration->event->nama_acara;
                $regStatus = $lastRegistration->status; // pending, verified, lulus, tidak_lulus
                
                // LOGIKA PENGELOMPOKAN (Berdasarkan Jenjang Terakhir)
                switch ($jenis) {
                    case 'MAKESTA':
                        $status = 'Anggota';
                        $badgeColor = 'bg-emerald-100 text-emerald-800';
                        break;
                    case 'LAKMUD':
                        $status = 'Kader Muda';
                        $badgeColor = 'bg-blue-100 text-blue-800';
                        break;
                    case 'LAKUT': 
                    case 'LATIN':
                        $status = 'Instruktur';
                        $badgeColor = 'bg-purple-100 text-purple-800';
                        break;
                    case 'LATPEL':
                        $status = 'Pelatih';
                        $badgeColor = 'bg-orange-100 text-orange-800';
                        break;
                    default:
                        $status = 'Partisipan'; // Untuk acara non-formal
                        $badgeColor = 'bg-gray-100 text-gray-800';
                }
            }

            // Simpan data tambahan ke object user untuk ditampilkan di View
            $user->kader_status = $status;
            $user->kader_badge = $badgeColor;
            $user->last_event = $eventName;
            $user->reg_status = $regStatus; // Kita kirim status reg juga untuk info tambahan
            
            return $user;
        });

        // 4. HITUNG STATISTIK (DIPERBAIKI)
        // Hitung berdasarkan user, bukan sekadar jumlah registrasi
        $allUsers = User::where('role', 'user')->with(['registrations.event'])->get();
        
        $stats = [
            'total' => $allUsers->count(),
            'anggota' => 0,
            'kader_muda' => 0,
            'instruktur' => 0
        ];

        foreach ($allUsers as $u) {
            // Cari jenjang terakhir orang ini
            $lastReg = $u->registrations->sortByDesc(fn($r) => $r->event->tanggal_selesai)->first();
            
            if ($lastReg) {
                $j = $lastReg->event->jenis_kaderisasi;
                if ($j == 'MAKESTA') $stats['anggota']++;
                elseif ($j == 'LAKMUD') $stats['kader_muda']++;
                elseif (in_array($j, ['LAKUT', 'LATIN'])) $stats['instruktur']++;
            }
        }

        return view('admin.kader.index', compact('users', 'stats'));
    }
}