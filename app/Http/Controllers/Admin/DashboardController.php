<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    // app/Http/Controllers/Admin/DashboardController.php

public function index()
{
    // Data Statistik Utama
    $totalEvents = \App\Models\Event::count();
    $activeEvents = \App\Models\Event::where('is_active', 1)->count();
    $totalKader = \App\Models\User::where('role', 'user')->count(); // Asumsi role user adalah kader
    
    // Menghitung pendaftar yang statusnya 'pending'
    $pendingRegistrations = \App\Models\Registration::where('status', 'pending')->count();

    // TAMBAHAN: Data untuk Tabel Aktivitas Terbaru (5 Pendaftar Terakhir)
    $recentRegistrations = \App\Models\Registration::with(['user.profile', 'event'])
                            ->latest()
                            ->take(5)
                            ->get();

    // TAMBAHAN: Acara yang akan datang (segera)
    $upcomingEvents = \App\Models\Event::where('tanggal_mulai', '>=', now())
                        ->where('is_active', 1)
                        ->orderBy('tanggal_mulai', 'asc')
                        ->take(3)
                        ->get();

    return view('admin.dashboard', compact(
        'totalEvents', 
        'activeEvents', 
        'totalKader', 
        'pendingRegistrations',
        'recentRegistrations',
        'upcomingEvents'
    ));
}
}