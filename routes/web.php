<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BiodataController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventManagementController;
use App\Models\Event;
use App\Http\Controllers\PublicEventController;

Route::get('/', function () {
    // Ambil acara yang tanggal mulainya hari ini atau masa depan
    // Urutkan dari yang paling dekat
    $events = Event::where('tanggal_mulai', '>=', now()->startOfDay())
                ->orderBy('tanggal_mulai', 'asc')
                ->take(6) // Tampilkan maksimal 6 acara di depan
                ->get();

    return view('welcome', compact('events'));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/biodata', [BiodataController::class, 'edit'])->name('biodata.edit');
    Route::post('/biodata', [BiodataController::class, 'update'])->name('biodata.update');
});

// GRUP ROUTE ADMIN (Hanya bisa diakses oleh role:admin)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Event (CRUD dasar)
    Route::resource('events', EventController::class);

    // --- PERBAIKAN DI SINI ---
    // Gunakan 'events.' saja, jangan 'admin.events.' karena sudah di dalam grup 'admin.'
    Route::prefix('events/{event}')->name('events.')->group(function () {
        
        // Hasilnya jadi: admin.events.manage (Sesuai yang dipanggil di View)
        Route::get('/manage', [EventManagementController::class, 'index'])->name('manage');

        Route::get('/participants', [EventManagementController::class, 'participants'])->name('participants');
        Route::post('/participants', [EventManagementController::class, 'storeParticipant'])->name('participants.store');
        Route::get('/qr-codes', [EventManagementController::class, 'showQrCodes'])->name('qr_codes');
        Route::get('/schedules', [EventManagementController::class, 'schedules'])->name('schedules');
        Route::post('/schedules', [EventManagementController::class, 'storeSchedule'])->name('schedules.store');

        // ROUTE DASHBOARD ABSENSI (MENU PILIH SESI)
        Route::get('/attendance', [EventManagementController::class, 'attendance'])->name('attendance');
        
        // ROUTE DETAIL & LAPORAN PER SESI (BARU)
        Route::get('/attendance/{schedule}', [EventManagementController::class, 'showAttendance'])->name('attendance.show');

        // ROUTE SCANNER
        Route::get('/attendance/{schedule}/scan', [EventManagementController::class, 'scan'])->name('scan');
        Route::post('/attendance/{schedule}/scan', [EventManagementController::class, 'processScan'])->name('scan.store');
        Route::get('/attendance/{schedule}/print', [EventManagementController::class, 'printAttendance'])->name('attendance.print');
        Route::get('/certificates', [EventManagementController::class, 'certificates'])->name('certificates');
        Route::get('/payments', [EventManagementController::class, 'payments'])->name('payments');

        // ROUTE MANAJEMEN DANA
        Route::get('/finances', [EventManagementController::class, 'finances'])->name('finances');
        Route::post('/finances', [EventManagementController::class, 'storeFinance'])->name('finances.store');
        Route::get('/finances/lpj', [EventManagementController::class, 'printLPJ'])->name('finances.lpj');
        Route::get('/participants/export', [EventManagementController::class, 'exportParticipants'])->name('participants.export');
    });

    Route::put('/participants/{registration}', [EventManagementController::class, 'updateParticipant'])->name('events.participants.update');
    Route::delete('/schedules/{schedule}', [EventManagementController::class, 'destroySchedule'])->name('events.schedules.destroy');
    Route::patch('/certificates/{registration}/save', [EventManagementController::class, 'saveCertificate'])->name('events.certificate.save');
    Route::patch('/payments/{registration}/verify', [EventManagementController::class, 'verifyPayment'])->name('events.payments.verify');
    Route::delete('/finances/{finance}', [EventManagementController::class, 'destroyFinance'])->name('events.finances.destroy');


    
});

// Route Grup untuk Pendaftaran Event
Route::prefix('register-event/{event}')->name('events.')->group(function () {

    // 1. Form Buat Akun
    Route::get('/', [PublicEventController::class, 'showRegister'])->name('register');
    Route::post('/', [PublicEventController::class, 'processRegister'])->name('process_register');

    // 2. Halaman Verifikasi Kode OTP
    Route::get('/verify', [PublicEventController::class, 'showVerify'])->name('verify_page');
    Route::post('/verify', [PublicEventController::class, 'verify'])->name('process_verify');

    // 3. Halaman Biodata & Upload (TAHAP 3)
    Route::get('/biodata', [PublicEventController::class, 'showBiodata'])->name('form_biodata');
    Route::post('/biodata', [PublicEventController::class, 'processBiodata'])->name('process_biodata');


});

require __DIR__.'/auth.php';