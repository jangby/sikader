<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use App\Models\Registration;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Kita ambil data ringkasan untuk ditampilkan di dashboard
        $totalEvents = Event::count();
        $activeEvents = Event::where('is_active', true)->count();
        $totalKader = User::where('role', 'member')->count();
        $pendingRegistrations = Registration::where('status', 'pending')->count();

        return view('admin.dashboard', compact('totalEvents', 'activeEvents', 'totalKader', 'pendingRegistrations'));
    }
}