<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="text-gray-400 hover:text-emerald-600 transition">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <a href="{{ route('admin.events.index') }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-emerald-600 md:ml-2">Events</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-sm font-medium text-emerald-600 md:ml-2">Kelola</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="mt-2 font-bold text-3xl text-gray-800 leading-tight">
                    {{ $event->nama_acara }}
                </h2>
                <div class="flex items-center gap-3 mt-2 text-sm">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700 border border-emerald-200">
                        {{ $event->jenis_kaderisasi }}
                    </span>
                    <span class="text-gray-500 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        {{ $event->lokasi }}
                    </span>
                </div>
            </div>
            
            <div class="flex gap-2">
                <a href="{{ route('admin.events.edit', $event->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-medium text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                    Edit Info
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-6 group hover:shadow-md transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Pendaftar</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 mt-2">{{ $totalPeserta }}</h3>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-emerald-600 font-medium">
                        <span class="flex h-2 w-2 rounded-full bg-emerald-500 mr-2"></span>
                        Data Realtime
                    </div>
                    <div class="absolute -bottom-4 -right-4 w-24 h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-110 transition duration-500"></div>
                </div>

                <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-6 group hover:shadow-md transition duration-300">
                    <div class="flex justify-between items-start">
                        <div class="w-full">
                            <p class="text-sm font-medium text-gray-500">Peserta Lulus</p>
                            <div class="flex items-end gap-2 mt-2">
                                <h3 class="text-3xl font-extrabold text-gray-800">{{ $pesertaLulus }}</h3>
                                <span class="text-sm text-gray-400 mb-1">/ {{ $totalPeserta }}</span>
                            </div>
                            <div class="w-full bg-gray-100 rounded-full h-1.5 mt-3 overflow-hidden">
                                @php $persen = $totalPeserta > 0 ? ($pesertaLulus / $totalPeserta) * 100 : 0; @endphp
                                <div class="bg-emerald-500 h-1.5 rounded-full transition-all duration-1000" style="width: {{ $persen }}%"></div>
                            </div>
                        </div>
                        <div class="ml-4 p-3 bg-blue-50 rounded-xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-2 text-xs text-gray-500">
                        {{ round($persen) }}% Tingkat Kelulusan
                    </div>
                </div>

                <div class="relative overflow-hidden bg-white rounded-2xl shadow-sm border border-gray-100 p-6 group hover:shadow-md transition duration-300">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Status Pendaftaran</p>
                            @if($event->is_active)
                                <h3 class="text-3xl font-extrabold text-emerald-600 mt-2">DIBUKA</h3>
                                <p class="text-xs text-gray-400 mt-1">Peserta dapat mendaftar</p>
                            @else
                                <h3 class="text-3xl font-extrabold text-red-500 mt-2">DITUTUP</h3>
                                <p class="text-xs text-gray-400 mt-1">Pendaftaran dinonaktifkan</p>
                            @endif
                        </div>
                        <div class="p-3 {{ $event->is_active ? 'bg-emerald-100 text-emerald-600' : 'bg-red-50 text-red-500' }} rounded-xl transition duration-300">
                            @if($event->is_active)
                                <div class="relative">
                                    <span class="absolute top-0 right-0 flex h-3 w-3">
                                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                      <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                    </span>
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 11V7a4 4 0 118 0m-4 8v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2z"></path></svg>
                                </div>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            @endif
                        </div>
                    </div>
                    <a href="{{ route('admin.events.edit', $event->id) }}" class="absolute bottom-4 right-6 text-xs font-semibold text-emerald-600 hover:text-emerald-800 hover:underline">
                        Ubah Status &rarr;
                    </a>
                </div>
            </div>

            <div>
                <div class="flex items-center gap-3 mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Menu Pengelolaan</h3>
                    <div class="flex-grow border-t border-gray-200"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <a href="{{ route('admin.events.participants', $event->id) }}" class="group relative bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="flex items-start gap-4">
                            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 group-hover:text-emerald-700 transition">Data Peserta</h4>
                                <p class="text-sm text-gray-500 mt-1 leading-relaxed">Verifikasi pendaftar, cek berkas persyaratan, dan ekspor data.</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.events.schedules', $event->id) }}" class="group relative bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="flex items-start gap-4">
                            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 group-hover:text-emerald-700 transition">Jadwal & Materi</h4>
                                <p class="text-sm text-gray-500 mt-1 leading-relaxed">Susun rundown acara, upload materi digital, dan penanggung jawab.</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.events.attendance', $event->id) }}" class="group relative bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="flex items-start gap-4">
                            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 16H4v4h2v-4zM6 10H4v2h2v-2zm0-4H4v2h2V6zM10 6H8v2h2V6zm0 4H8v2h2v-2zm0 4H8v4h2v-4zm6-8h-2v2h2V6zm-6 0h-2v2h2V6zm4 8h-2v4h2v-4zm0-4h-2v2h2v-2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 group-hover:text-emerald-700 transition">Absensi Digital</h4>
                                <p class="text-sm text-gray-500 mt-1 leading-relaxed">Cetak kartu peserta (QR) dan buka scanner kehadiran.</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.events.certificates', $event->id) }}" class="group relative bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="flex items-start gap-4">
                            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 group-hover:text-emerald-700 transition">E-Sertifikat</h4>
                                <p class="text-sm text-gray-500 mt-1 leading-relaxed">Generate otomatis dan publikasi sertifikat untuk peserta lulus.</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.events.payments', $event->id) }}" class="group relative bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="flex items-start gap-4">
                            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 group-hover:text-emerald-700 transition">Verifikasi Pembayaran</h4>
                                <p class="text-sm text-gray-500 mt-1 leading-relaxed">Cek bukti transfer dan validasi pembayaran peserta.</p>
                            </div>
                        </div>
                    </a>

                    <a href="{{ route('admin.events.finances', $event->id) }}" class="group relative bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl hover:border-emerald-200 transition-all duration-300 hover:-translate-y-1">
                        <div class="absolute top-0 left-0 w-1.5 h-full bg-emerald-500 rounded-l-2xl opacity-0 group-hover:opacity-100 transition-opacity"></div>
                        <div class="flex items-start gap-4">
                            <div class="p-3.5 bg-emerald-50 text-emerald-600 rounded-xl group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300 shadow-sm">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-gray-800 group-hover:text-emerald-700 transition">Laporan Keuangan</h4>
                                <p class="text-sm text-gray-500 mt-1 leading-relaxed">Rekap pemasukan, pengeluaran, dan cetak LPJ dana.</p>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>