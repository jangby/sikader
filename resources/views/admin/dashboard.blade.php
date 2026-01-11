<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-2xl text-emerald-900 leading-tight">
                    {{ __('Dashboard Overview') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</p>
            </div>
            <div class="hidden md:flex items-center space-x-2">
                <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold border border-emerald-200">
                    Administrator
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="bg-gradient-to-r from-emerald-800 to-emerald-600 rounded-2xl p-6 text-white shadow-lg relative overflow-hidden">
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <h1 class="text-2xl font-bold">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                        <p class="text-emerald-100 mt-2 text-sm max-w-xl">
                            Ini adalah pusat kontrol sistem kaderisasi. Pantau perkembangan acara, kelola data peserta, dan validasi pendaftaran dengan mudah dari sini.
                        </p>
                        <div class="mt-6 flex gap-3">
                            <a href="{{ route('admin.events.create') }}" class="bg-white text-emerald-700 px-4 py-2 rounded-lg text-sm font-bold shadow-sm hover:bg-emerald-50 transition">
                                + Buat Acara Baru
                            </a>
                            <a href="{{ route('profile.edit') }}" class="bg-emerald-700 text-white px-4 py-2 rounded-lg text-sm font-medium border border-emerald-500 hover:bg-emerald-600 transition">
                                Edit Profil
                            </a>
                        </div>
                    </div>
                    <div class="hidden md:block opacity-20 transform translate-x-4">
                        <svg class="w-40 h-40" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L1 21h22L12 2zm0 3.99L19.53 19H4.47L12 5.99zM11 16h2v2h-2v-2zm0-6h2v4h-2v-4z"/></svg>
                    </div>
                </div>
                <div class="absolute top-0 right-0 -mt-10 -mr-10 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-10 -ml-10 w-40 h-40 bg-emerald-400 opacity-20 rounded-full blur-2xl"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Acara</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 mt-1 group-hover:text-emerald-600 transition">{{ $totalEvents }}</h3>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-gray-500">
                        <span class="text-blue-600 font-bold bg-blue-50 px-1.5 py-0.5 rounded mr-2">Info</span>
                        Semua riwayat kegiatan
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Sedang Aktif</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 mt-1 group-hover:text-emerald-600 transition">{{ $activeEvents }}</h3>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-lg text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-gray-500">
                        <span class="text-emerald-600 font-bold bg-emerald-50 px-1.5 py-0.5 rounded mr-2">Live</span>
                        Pendaftaran dibuka
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Perlu Verifikasi</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 mt-1 group-hover:text-amber-500 transition">{{ $pendingRegistrations }}</h3>
                        </div>
                        <div class="p-3 bg-amber-50 rounded-lg text-amber-600 group-hover:bg-amber-500 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-gray-500">
                        @if($pendingRegistrations > 0)
                            <span class="text-amber-600 font-bold bg-amber-50 px-1.5 py-0.5 rounded mr-2">Action</span>
                            Segera proses data
                        @else
                            <span class="text-green-600 font-bold bg-green-50 px-1.5 py-0.5 rounded mr-2">Aman</span>
                            Semua data bersih
                        @endif
                    </div>
                </div>

                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 hover:shadow-md transition group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Kader</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 mt-1 group-hover:text-indigo-600 transition">{{ $totalKader }}</h3>
                        </div>
                        <div class="p-3 bg-indigo-50 rounded-lg text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-xs text-gray-500">
                        <span class="text-indigo-600 font-bold bg-indigo-50 px-1.5 py-0.5 rounded mr-2">User</span>
                        Database anggota
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-2 space-y-8">
                    
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 text-lg mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Menu Cepat
                        </h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <a href="{{ route('admin.events.create') }}" class="group flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-emerald-50 hover:border-emerald-200 transition duration-200">
                                <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-emerald-600 group-hover:scale-110 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                </div>
                                <span class="mt-3 text-xs font-bold text-gray-600 group-hover:text-emerald-700">Buat Acara</span>
                            </a>

                            <a href="{{ route('admin.events.index') }}" class="group flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-blue-50 hover:border-blue-200 transition duration-200">
                                <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-blue-600 group-hover:scale-110 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                                </div>
                                <span class="mt-3 text-xs font-bold text-gray-600 group-hover:text-blue-700">Kelola Data</span>
                            </a>

                            <a href="#" class="group flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-amber-50 hover:border-amber-200 transition duration-200">
                                <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-amber-500 group-hover:scale-110 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <span class="mt-3 text-xs font-bold text-gray-600 group-hover:text-amber-700">Verifikasi</span>
                            </a>

                            <a href="#" class="group flex flex-col items-center justify-center p-4 rounded-xl border border-gray-100 bg-gray-50 hover:bg-indigo-50 hover:border-indigo-200 transition duration-200">
                                <div class="w-10 h-10 rounded-full bg-white shadow-sm flex items-center justify-center text-indigo-500 group-hover:scale-110 transition">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <span class="mt-3 text-xs font-bold text-gray-600 group-hover:text-indigo-700">Data Kader</span>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800">Pendaftaran Terbaru</h3>
                            <a href="{{ route('admin.events.index') }}" class="text-xs text-emerald-600 hover:text-emerald-800 font-medium">Lihat Semua &rarr;</a>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm text-left">
                                <thead class="bg-gray-50 text-gray-500 uppercase font-bold text-xs">
                                    <tr>
                                        <th class="px-6 py-3">Nama Peserta</th>
                                        <th class="px-6 py-3">Acara</th>
                                        <th class="px-6 py-3">Status</th>
                                        <th class="px-6 py-3">Waktu</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @forelse($recentRegistrations as $reg)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-3 font-medium text-gray-900">
                                            {{ $reg->user->profile->nama_lengkap ?? $reg->user->name }}
                                        </td>
                                        <td class="px-6 py-3 text-gray-500">
                                            {{ Str::limit($reg->event->nama_acara, 20) }}
                                        </td>
                                        <td class="px-6 py-3">
                                            @if($reg->status == 'pending')
                                                <span class="bg-yellow-100 text-yellow-800 text-[10px] font-bold px-2 py-0.5 rounded-full">PENDING</span>
                                            @elseif($reg->status == 'verified')
                                                <span class="bg-blue-100 text-blue-800 text-[10px] font-bold px-2 py-0.5 rounded-full">VERIFIED</span>
                                            @elseif($reg->status == 'lulus')
                                                <span class="bg-green-100 text-green-800 text-[10px] font-bold px-2 py-0.5 rounded-full">LULUS</span>
                                            @else
                                                <span class="bg-red-100 text-red-800 text-[10px] font-bold px-2 py-0.5 rounded-full">{{ strtoupper($reg->status) }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-3 text-gray-400 text-xs">
                                            {{ $reg->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 italic">Belum ada pendaftaran baru.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

                <div class="space-y-8">
                    
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-800 mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Segera Datang
                        </h3>
                        <div class="space-y-4">
                            @forelse($upcomingEvents as $event)
                            <div class="flex items-start p-3 rounded-lg hover:bg-gray-50 border border-transparent hover:border-gray-200 transition cursor-pointer">
                                <div class="bg-indigo-50 text-indigo-700 rounded-lg p-2 text-center min-w-[50px]">
                                    <span class="block text-xs font-bold uppercase">{{ $event->tanggal_mulai->format('M') }}</span>
                                    <span class="block text-lg font-extrabold">{{ $event->tanggal_mulai->format('d') }}</span>
                                </div>
                                <div class="ml-3">
                                    <h4 class="text-sm font-bold text-gray-800 leading-tight">{{ $event->nama_acara }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ $event->lokasi }}</p>
                                    <div class="mt-1 flex items-center text-[10px] text-gray-400">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 mr-1"></span>
                                        {{ $event->jenis_kaderisasi }}
                                    </div>
                                </div>
                            </div>
                            @empty
                            <p class="text-sm text-gray-400 italic text-center py-4">Tidak ada agenda dekat.</p>
                            @endforelse
                        </div>
                        <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                            <a href="{{ route('admin.events.create') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 hover:underline">+ Jadwalkan Acara</a>
                        </div>
                    </div>

                    <div class="bg-gradient-to-br from-gray-800 to-gray-900 p-6 rounded-2xl shadow-lg text-white">
                        <h3 class="font-bold mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Status Sistem
                        </h3>
                        <div class="space-y-3">
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-400">Database</span>
                                    <span class="text-green-400 font-bold">Optimal</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-1.5">
                                    <div class="bg-green-500 h-1.5 rounded-full" style="width: 95%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="flex justify-between text-xs mb-1">
                                    <span class="text-gray-400">Storage</span>
                                    <span class="text-blue-400 font-bold">24% Used</span>
                                </div>
                                <div class="w-full bg-gray-700 rounded-full h-1.5">
                                    <div class="bg-blue-500 h-1.5 rounded-full" style="width: 24%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>