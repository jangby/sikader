<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use App\Models\Registration;
use Illuminate\Support\Facades\Hash;
use App\Models\EventSchedule;
use Illuminate\Support\Facades\Storage;
use App\Models\ScheduleAttendance;
use App\Models\EventFinance;
use App\Exports\ParticipantsExport;
use Maatwebsite\Excel\Facades\Excel;

class EventManagementController extends Controller
{
    // Halaman Utama Dashboard Acara (Pusat Kontrol)
    public function index(Event $event)
    {
        // Kita hitung data ringkas untuk ditampilkan di dashboard acara
        $totalPeserta = $event->registrations()->count();
        $pesertaLulus = $event->registrations()->where('status', 'lulus')->count();
        // $totalSesi = $event->schedules()->count(); // Nanti jika model Schedule sudah dibuat

        return view('admin.events.manage', compact('event', 'totalPeserta', 'pesertaLulus'));
    }

    // 1. HALAMAN DAFTAR PESERTA (DENGAN STATISTIK)
    public function participants(Request $request, Event $event)
    {
        // A. LOGIKA UTAMA (FILTER & SEARCH)
        $query = $event->registrations()->with('user.profile');

        if ($request->has('gender') && $request->gender != '') {
            $query->whereHas('user.profile', function($q) use ($request) {
                $q->where('jenis_kelamin', $request->gender);
            });
        }

        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user.profile', function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
            });
        }

        $registrations = $query->latest()->paginate(20)->withQueryString();

        // B. HITUNG STATISTIK (UNTUK DASHBOARD)
        // Kita hitung dari base query event agar tidak terpengaruh filter pagination
        $allRegs = $event->registrations()->with('user.profile')->get();
        
        $stats = [
            'total' => $allRegs->count(),
            'laki'  => $allRegs->filter(fn($r) => optional($r->user->profile)->jenis_kelamin == 'Laki-laki')->count(),
            'perempuan' => $allRegs->filter(fn($r) => optional($r->user->profile)->jenis_kelamin == 'Perempuan')->count(),
            'lulus' => $allRegs->where('status', 'lulus')->count(),
        ];

        return view('admin.events.participants', compact('event', 'registrations', 'stats'));
    }

    // 2. EXPORT KE EXCEL (MENGGUNAKAN LIBRARY)
    public function exportParticipants(Request $request, Event $event)
    {
        $filter = $request->query('filter', 'all'); // Default all

        // Nama File
        $fileName = 'Data_Peserta_' . str_replace(' ', '_', substr($event->nama_acara, 0, 20)) . '_' . $filter . '.xlsx';

        // Download Excel
        return Excel::download(new ParticipantsExport($event->id, $filter), $fileName);
    }

    // 2. SIMPAN PESERTA MANUAL (OFFLINE) - LENGKAP
    public function storeParticipant(Request $request, Event $event)
    {
        // 1. Validasi Input Lengkap
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'no_hp'         => 'required|numeric',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'tempat_lahir'  => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',
            'alamat'        => 'required|string',
            'rt'            => 'required|string|max:5',
            'rw'            => 'required|string|max:5',
            'desa'          => 'required|string|max:100',
            'kecamatan'     => 'required|string|max:100',
            'kabupaten'     => 'required|string|max:100',
            'asal_delegasi' => 'required|string|max:100',
        ]);

        // 2. Buat Akun User Baru (Dummy Email dari No HP)
        $dummyEmail = $request->no_hp . '@offline.com';
        
        $user = User::firstOrCreate(
            ['email' => $dummyEmail],
            [
                'name'     => $request->nama_lengkap,
                'password' => Hash::make('12345678'), // Password default
                'role'     => 'member',
            ]
        );

        // 3. Simpan Profil Lengkap
        Profile::updateOrCreate(
            ['user_id' => $user->id],
            [
                'nama_lengkap'  => $request->nama_lengkap,
                'no_hp'         => $request->no_hp,
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

        // 4. Daftarkan ke Event (Status: Verified)
        Registration::firstOrCreate(
            ['user_id' => $user->id, 'event_id' => $event->id],
            [
                'status' => 'verified', // Langsung Lulus Verifikasi
                'bukti_pembayaran' => 'manual_offline', // Tanda bahwa ini bayar tunai/offline
            ]
        );

        return redirect()->back()->with('success', 'Peserta offline berhasil ditambahkan dan status pembayaran otomatis LUNAS (Verified)!');
    }

    // 3. UPDATE DATA PESERTA (Termasuk Status Kelulusan)
    public function updateParticipant(Request $request, Registration $registration)
    {
        $request->validate([
            'nama_lengkap'  => 'required|string|max:255',
            'no_hp'         => 'required|numeric',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'status'        => 'required|in:pending,verified,rejected,lulus,tidak_lulus', // Validasi status
        ]);

        // 1. Update Data Profil User
        $registration->user->profile->update([
            'nama_lengkap'  => $request->nama_lengkap,
            'no_hp'         => $request->no_hp,
            'jenis_kelamin' => $request->jenis_kelamin,
            // Opsional: update data lain jika form edit lengkap dipakai
            'tempat_lahir'  => $request->tempat_lahir ?? $registration->user->profile->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir ?? $registration->user->profile->tanggal_lahir,
            'alamat'        => $request->alamat ?? $registration->user->profile->alamat,
            'asal_delegasi' => $request->asal_delegasi ?? $registration->user->profile->asal_delegasi,
        ]);

        // 2. Update Status Pendaftaran (Disini proses meluluskannya)
        $registration->update([
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'Data peserta & status kelulusan berhasil diperbarui.');
    }

    // 4. HALAMAN LIHAT SEMUA QR CODE
    public function showQrCodes(Request $request, Event $event)
    {
        $query = $event->registrations()->with('user.profile');

        // Filter Gender
        if ($request->has('gender') && $request->gender != '') {
            $query->whereHas('user.profile', function($q) use ($request) {
                $q->where('jenis_kelamin', $request->gender);
            });
        }

        // Ambil semua data (tanpa pagination biar bisa diprint semua)
        $registrations = $query->get();

        return view('admin.events.qr_codes', compact('event', 'registrations'));
    }

    // 5. HALAMAN JADWAL & MATERI
    public function schedules(Event $event)
    {
        // Ambil jadwal urut berdasarkan waktu mulai
        $schedules = $event->schedules()->orderBy('waktu_mulai', 'asc')->get();
        return view('admin.events.schedules', compact('event', 'schedules'));
    }

    // 6. SIMPAN JADWAL BARU
    public function storeSchedule(Request $request, Event $event)
    {
        $request->validate([
            'nama_sesi' => 'required|string',
            'waktu_mulai' => 'required|date',
            'waktu_selesai' => 'required|date|after:waktu_mulai',
            'penanggung_jawab' => 'nullable|string',
            'file_materi' => 'nullable|file|mimes:pdf,ppt,pptx,doc,docx|max:10240', // Max 10MB
        ]);

        $filePath = null;
        if ($request->hasFile('file_materi')) {
            // Simpan di folder public/materi
            $filePath = $request->file('file_materi')->store('materi', 'public');
        }

        EventSchedule::create([
            'event_id' => $event->id,
            'nama_sesi' => $request->nama_sesi,
            'waktu_mulai' => $request->waktu_mulai,
            'waktu_selesai' => $request->waktu_selesai,
            'penanggung_jawab' => $request->penanggung_jawab,
            'file_materi' => $filePath,
        ]);

        return redirect()->back()->with('success', 'Jadwal sesi berhasil ditambahkan!');
    }

    // 7. HAPUS JADWAL
    public function destroySchedule(EventSchedule $schedule)
    {
        // Hapus file fisik jika ada
        if ($schedule->file_materi) {
            Storage::disk('public')->delete($schedule->file_materi);
        }
        
        $schedule->delete();

        return redirect()->back()->with('success', 'Jadwal sesi dihapus.');
    }

    // 8. MENU UTAMA ABSENSI (DASHBOARD & TABEL)
    public function attendance(Event $event)
    {
        // 1. Ambil Jadwal beserta hitungan jumlah yang hadir (attendances_count)
        $schedules = $event->schedules()
            ->withCount('attendances') // Fitur magic Laravel hitung relasi
            ->orderBy('waktu_mulai', 'asc')
            ->get();

        // 2. Statistik Dashboard
        $totalPeserta = $event->registrations()->where('status', 'verified')->count(); // Target peserta
        $totalSesi = $schedules->count();
        
        // Hitung total aktivitas scan (akumulasi semua sesi)
        $totalCheckIn = $schedules->sum('attendances_count');

        return view('admin.events.attendance', compact(
            'event', 'schedules', 'totalPeserta', 'totalSesi', 'totalCheckIn'
        ));
    }

    // 9. HALAMAN SCANNER KAMERA
    public function scan(Event $event, EventSchedule $schedule)
    {
        // Ambil data kehadiran yang sudah masuk hari ini (untuk list history di kanan)
        $recentAttendances = $schedule->attendances()
            ->with('registration.user.profile')
            ->latest('scanned_at')
            ->take(10)
            ->get();

        return view('admin.events.scan', compact('event', 'schedule', 'recentAttendances'));
    }

    // 10. PROSES SCAN (AJAX REQUEST)
    public function processScan(Request $request, Event $event, EventSchedule $schedule)
    {
        $request->validate([
            'registration_id' => 'required|exists:registrations,id',
        ]);

        // Cek apakah peserta ini benar-benar terdaftar di EVENT ini?
        $registration = Registration::where('id', $request->registration_id)
            ->where('event_id', $event->id)
            ->first();

        if (!$registration) {
            return response()->json([
                'status' => 'error',
                'message' => 'Peserta tidak terdaftar di acara ini!',
            ], 404);
        }

        // Cek apakah sudah absen sebelumnya?
        $exists = ScheduleAttendance::where('event_schedule_id', $schedule->id)
            ->where('registration_id', $registration->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Peserta sudah absen sebelumnya.',
                'user' => $registration->user->profile->nama_lengkap ?? $registration->user->name
            ]);
        }

        // Simpan Kehadiran
        ScheduleAttendance::create([
            'event_schedule_id' => $schedule->id,
            'registration_id'   => $registration->id,
            'scanned_at'        => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Absensi Berhasil!',
            'user' => $registration->user->profile->nama_lengkap ?? $registration->user->name,
            'time' => now()->format('H:i:s')
        ]);
    }

    // 11. HALAMAN DETAIL & LAPORAN ABSENSI (Per Sesi)
    public function showAttendance(Event $event, EventSchedule $schedule)
    {
        // 1. Ambil data yang SUDAH HADIR
        $attendees = $schedule->attendances()
            ->with('registration.user.profile')
            ->get();

        // Pisahkan Laki-laki dan Perempuan yang HADIR
        $hadirLk = $attendees->filter(fn($a) => optional($a->registration->user->profile)->jenis_kelamin == 'Laki-laki');
        $hadirPr = $attendees->filter(fn($a) => optional($a->registration->user->profile)->jenis_kelamin == 'Perempuan');

        // 2. Ambil data yang BELUM HADIR
        // Logikanya: Ambil semua pendaftar event ini, kecualikan yang ID-nya ada di daftar hadir
        $hadirIds = $attendees->pluck('registration_id')->toArray();
        
        $absentees = $event->registrations()
            ->whereNotIn('id', $hadirIds)
            ->whereIn('status', ['verified', 'lulus']) // Hanya yang statusnya oke
            ->with('user.profile')
            ->get();

        return view('admin.events.attendance_show', compact(
            'event', 'schedule', 'attendees', 'absentees', 'hadirLk', 'hadirPr'
        ));
    }

    // 12. CETAK LAPORAN ABSENSI (KHUSUS PRINT)
    public function printAttendance(Event $event, EventSchedule $schedule)
    {
        // Ambil data (Sama seperti method showAttendance)
        $attendees = $schedule->attendances()
            ->with('registration.user.profile')
            ->get();

        $hadirLk = $attendees->filter(fn($a) => optional($a->registration->user->profile)->jenis_kelamin == 'Laki-laki');
        $hadirPr = $attendees->filter(fn($a) => optional($a->registration->user->profile)->jenis_kelamin == 'Perempuan');

        // Untuk cetak, biasanya kita hanya butuh daftar yang hadir saja.
        // Tapi kalau mau menampilkan yang belum hadir juga, bisa ditambahkan logic-nya disini.

        return view('admin.events.pdf_attendance', compact(
            'event', 'schedule', 'attendees', 'hadirLk', 'hadirPr'
        ));
    }

    // 13. MENU DAFTAR SERTIFIKAT (Hanya yang Lulus)
    public function certificates(Event $event)
    {
        // Ambil peserta yang statusnya 'lulus'
        $graduates = $event->registrations()
            ->where('status', 'lulus')
            ->with('user.profile')
            ->get();

        return view('admin.events.certificates', compact('event', 'graduates'));
    }

    // 14. SIMPAN LINK SERTIFIKAT (GOOGLE DRIVE)
    public function saveCertificate(Request $request, Registration $registration)
    {
        $request->validate([
            'certificate_link' => 'required|url', // Wajib format URL (http/https)
        ]);

        $registration->update([
            'certificate_link' => $request->certificate_link
        ]);

        return redirect()->back()->with('success', 'Link sertifikat berhasil disimpan!');
    }

    // 15. MENU CEK PEMBAYARAN (FILTER & STATS)
    public function payments(Request $request, Event $event)
    {
        // 1. Query Dasar (Peserta yang sudah ada status pembayaran)
        $query = $event->registrations()
            ->whereNotNull('bukti_pembayaran')
            ->with('user.profile');

        // 2. Filter Jenis Kelamin
        if ($request->has('gender') && $request->gender != '') {
            $query->whereHas('user.profile', function($q) use ($request) {
                $q->where('jenis_kelamin', $request->gender);
            });
        }

        // 3. Filter Pencarian Nama
        if ($request->has('search') && $request->search != '') {
            $query->whereHas('user.profile', function($q) use ($request) {
                $q->where('nama_lengkap', 'like', '%' . $request->search . '%');
            });
        }

        // 4. Hitung Statistik untuk Dashboard Atas
        // Kita clone query agar filternya tidak mengganggu hitungan total global
        // Atau kita hitung raw dari event saja biar statistiknya global
        $stats = [
            'total'     => $event->registrations()->whereNotNull('bukti_pembayaran')->count(),
            'pending'   => $event->registrations()->where('status', 'pending')->whereNotNull('bukti_pembayaran')->count(),
            'verified'  => $event->registrations()->where('status', 'verified')->whereNotNull('bukti_pembayaran')->count(),
            'rejected'  => $event->registrations()->where('status', 'rejected')->whereNotNull('bukti_pembayaran')->count(),
        ];

        // 5. Ambil Data (Urutkan Pending di atas)
        $registrations = $query->orderByRaw("FIELD(status, 'pending', 'verified', 'rejected')")
            ->latest()
            ->paginate(15) // Tampilkan 15 per halaman di tabel
            ->withQueryString(); // Agar filter tetap ada saat ganti halaman

        return view('admin.events.payments', compact('event', 'registrations', 'stats'));
    }

    // 16. PROSES VERIFIKASI PEMBAYARAN (Terima/Tolak)
    public function verifyPayment(Request $request, Registration $registration)
    {
        $request->validate([
            'action' => 'required|in:accept,reject',
            'alasan' => 'nullable|string' // Jika ditolak
        ]);

        if ($request->action == 'accept') {
            $registration->update(['status' => 'verified']);
            $message = 'Pembayaran diterima. Peserta resmi terdaftar.';
        } else {
            // Jika ditolak, status jadi rejected, dan bukti pembayaran dihapus agar user upload ulang
            // (Opsional: hapus file fisik jika mau hemat storage)
            // Storage::disk('public')->delete($registration->bukti_pembayaran);
            
            $registration->update([
                'status' => 'rejected',
                'bukti_pembayaran' => null // Reset bukti agar bisa upload lagi
            ]);
            $message = 'Pembayaran ditolak. Peserta diminta upload ulang.';
        }

        return redirect()->back()->with('success', $message);
    }

    // 17. HALAMAN MANAJEMEN DANA
    public function finances(Event $event)
    {
        // 1. Hitung Pemasukan Otomatis dari Peserta
        // Hanya hitung peserta yang statusnya VERIFIED (Lunas)
        $jumlahPesertaBayar = $event->registrations()->where('status', 'verified')->count();
        $totalPemasukanPeserta = $jumlahPesertaBayar * $event->biaya;

        // 2. Ambil Transaksi Manual (Sponsor & Pengeluaran)
        $transaksiLain = $event->finances()->orderBy('tanggal', 'desc')->get();

        // 3. Hitung Rekapitulasi
        $pemasukanLain = $transaksiLain->where('jenis', 'pemasukan')->sum('nominal');
        $totalPengeluaran = $transaksiLain->where('jenis', 'pengeluaran')->sum('nominal');

        $totalPemasukan = $totalPemasukanPeserta + $pemasukanLain;
        $saldoAkhir = $totalPemasukan - $totalPengeluaran;

        return view('admin.events.finances', compact(
            'event', 'transaksiLain', 
            'totalPemasukanPeserta', 'jumlahPesertaBayar',
            'pemasukanLain', 'totalPengeluaran', 
            'totalPemasukan', 'saldoAkhir'
        ));
    }

    // 18. SIMPAN TRANSAKSI (Sponsor/Pengeluaran)
    public function storeFinance(Request $request, Event $event)
    {
        $request->validate([
            'jenis' => 'required|in:pemasukan,pengeluaran',
            'keterangan' => 'required|string',
            'nominal' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
        ]);

        EventFinance::create([
            'event_id' => $event->id,
            'jenis' => $request->jenis,
            'keterangan' => $request->keterangan,
            'nominal' => $request->nominal,
            'tanggal' => $request->tanggal,
        ]);

        return redirect()->back()->with('success', 'Data keuangan berhasil dicatat!');
    }

    // 19. HAPUS TRANSAKSI
    public function destroyFinance(EventFinance $finance)
    {
        $finance->delete();
        return redirect()->back()->with('success', 'Data transaksi dihapus.');
    }

    // 20. HALAMAN CETAK LPJ KEUANGAN
    public function printLPJ(Event $event)
    {
        // Logika sama dengan method finances
        $jumlahPesertaBayar = $event->registrations()->where('status', 'verified')->count();
        $totalPemasukanPeserta = $jumlahPesertaBayar * $event->biaya;

        $pemasukan = $event->finances()->where('jenis', 'pemasukan')->orderBy('tanggal')->get();
        $pengeluaran = $event->finances()->where('jenis', 'pengeluaran')->orderBy('tanggal')->get();

        $totalPemasukanLain = $pemasukan->sum('nominal');
        $totalPengeluaran = $pengeluaran->sum('nominal');
        $grandTotalPemasukan = $totalPemasukanPeserta + $totalPemasukanLain;
        $saldoAkhir = $grandTotalPemasukan - $totalPengeluaran;

        return view('admin.events.pdf_lpj', compact(
            'event', 'jumlahPesertaBayar', 'totalPemasukanPeserta',
            'pemasukan', 'pengeluaran', 'totalPengeluaran', 
            'grandTotalPemasukan', 'saldoAkhir'
        ));
    }
}