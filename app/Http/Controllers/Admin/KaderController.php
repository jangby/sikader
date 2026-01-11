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
        // Eager load registrations yang PUNYA event saja untuk menghindari error data yatim (orphan)
        $query = User::where('role', 'user')
            ->with(['profile', 'registrations' => function($q) {
                $q->whereHas('event')->with('event');
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
            $data = $this->determineKaderStatus($user);
            
            $user->kader_status = $data['status'];
            $user->kader_badge = $data['badgeColor'];
            $user->last_event = $data['eventName'];
            $user->reg_status = $data['regStatus'];
            
            return $user;
        });

        // 4. HITUNG STATISTIK
        // Menggunakan method helper yang sama agar angkanya sinkron dengan tabel
        $allUsers = User::where('role', 'user')
            ->with(['registrations' => function($q) {
                $q->whereHas('event')->with('event');
            }])->get();
        
        $stats = [
            'total' => $allUsers->count(),
            'anggota' => 0,
            'kader_muda' => 0,
            'instruktur' => 0
        ];

        foreach ($allUsers as $u) {
            $statusData = $this->determineKaderStatus($u);
            
            // Hitung berdasarkan status text yang dikembalikan
            if ($statusData['status'] == 'Anggota') $stats['anggota']++;
            elseif ($statusData['status'] == 'Kader Muda') $stats['kader_muda']++;
            elseif ($statusData['status'] == 'Instruktur' || $statusData['status'] == 'Pelatih') $stats['instruktur']++;
        }

        return view('admin.kader.index', compact('users', 'stats'));
    }

    /**
     * Helper function untuk menentukan status kader
     * Agar logika tidak ditulis 2 kali (DRY Principle)
     */
    private function determineKaderStatus($user)
    {
        // Urutkan registrasi berdasarkan tanggal selesai event (terbaru diatas)
        $lastRegistration = $user->registrations->sortByDesc(function($reg) {
            return optional($reg->event)->tanggal_selesai;
        })->first();

        $status = 'Belum Kader';
        $badgeColor = 'bg-gray-100 text-gray-800';
        $eventName = '-';
        $regStatus = '';

        if ($lastRegistration && $lastRegistration->event) {
            // Ubah ke huruf besar semua untuk antisipasi input 'Makesta'/'makesta'
            $jenis = strtoupper($lastRegistration->event->jenis_kaderisasi);
            
            $eventName = $lastRegistration->event->nama_acara;
            $regStatus = $lastRegistration->status; 

            // OPSIONAL: Jika Anda ingin status kader HANYA berubah jika peserta "LULUS",
            // buka komentar if dibawah ini. Saat ini logika Anda "pernah ikut = kader".
            // if ($regStatus == 'lulus') { 

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
                        $status = 'Partisipan'; 
                        $badgeColor = 'bg-gray-100 text-gray-800';
                }

            // } // end if lulus check
        }

        return [
            'status' => $status,
            'badgeColor' => $badgeColor,
            'eventName' => $eventName,
            'regStatus' => $regStatus
        ];
    }
}