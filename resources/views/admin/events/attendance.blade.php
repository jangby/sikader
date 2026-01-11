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
                                <a href="{{ route('admin.events.manage', $event->id) }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-emerald-600 md:ml-2">{{ Str::limit($event->nama_acara, 20) }}</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-sm font-medium text-emerald-600 md:ml-2">Absensi</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="mt-2 font-bold text-3xl text-gray-800 leading-tight">
                    Dashboard Absensi
                </h2>
                <p class="text-sm text-gray-500 mt-1">Monitoring kehadiran peserta per sesi acara.</p>
            </div>
            <a href="{{ route('admin.events.manage', $event->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Kembali ke Menu
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="relative overflow-hidden bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Peserta Terdaftar</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 mt-2">{{ $totalPeserta }} <span class="text-sm font-normal text-gray-400">Orang</span></h3>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-xl text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-blue-500 rounded-b-2xl"></div>
                </div>

                <div class="relative overflow-hidden bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Jumlah Sesi / Materi</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 mt-2">{{ $totalSesi }} <span class="text-sm font-normal text-gray-400">Sesi</span></h3>
                        </div>
                        <div class="p-3 bg-purple-50 rounded-xl text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-purple-500 rounded-b-2xl"></div>
                </div>

                <div class="relative overflow-hidden bg-white p-6 rounded-2xl shadow-sm border border-gray-100 hover:shadow-md transition duration-300 group">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Total Aktivitas Scan</p>
                            <h3 class="text-3xl font-extrabold text-gray-800 mt-2">{{ $totalCheckIn }} <span class="text-sm font-normal text-gray-400">x Scan</span></h3>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-xl text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 16H4v4h2v-4zM6 10H4v2h2v-2zm0-4H4v2h2V6zM10 6H8v2h2V6zm0 4H8v2h2v-2zm0 4H8v4h2v-4zm6-8h-2v2h2V6zm-6 0h-2v2h2V6zm4 8h-2v4h2v-4zm0-4h-2v2h2v-2z"></path></svg>
                        </div>
                    </div>
                    <div class="absolute bottom-0 left-0 w-full h-1 bg-emerald-500 rounded-b-2xl"></div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex flex-col md:flex-row justify-between items-center gap-4">
                    <h3 class="text-lg font-bold text-gray-800">Monitoring Sesi</h3>
                    @if($schedules->isEmpty())
                        <a href="{{ route('admin.events.schedules', $event->id) }}" class="text-sm text-emerald-600 hover:text-emerald-800 font-medium hover:underline">
                            + Buat Jadwal Dulu
                        </a>
                    @endif
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Informasi Sesi</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">PJ / Pemateri</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tingkat Kehadiran</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($schedules as $schedule)
                                @php
                                    $percent = $totalPeserta > 0 ? ($schedule->attendances_count / $totalPeserta) * 100 : 0;
                                    
                                    // Warna Progress Bar
                                    $barColor = 'bg-red-500';
                                    $textColor = 'text-red-600';
                                    if($percent > 50) { $barColor = 'bg-yellow-500'; $textColor = 'text-yellow-600'; }
                                    if($percent > 80) { $barColor = 'bg-emerald-500'; $textColor = 'text-emerald-600'; }
                                    
                                    // Status Waktu
                                    $isNow = $schedule->waktu_mulai <= now() && $schedule->waktu_selesai >= now();
                                @endphp
                            <tr class="hover:bg-gray-50 transition duration-150 {{ $isNow ? 'bg-emerald-50/30' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="flex items-start">
                                        <div class="flex-shrink-0 mt-1 mr-3">
                                            @if($isNow)
                                                <span class="relative flex h-3 w-3">
                                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                                  <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
                                                </span>
                                            @else
                                                <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900">{{ $schedule->nama_sesi }}</div>
                                            <div class="text-xs text-gray-500 mt-0.5">
                                                {{ $schedule->waktu_mulai->format('d M') }} • {{ $schedule->waktu_mulai->format('H:i') }} - {{ $schedule->waktu_selesai->format('H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($schedule->penanggung_jawab)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            {{ $schedule->penanggung_jawab }}
                                        </span>
                                    @else
                                        <span class="text-xs text-gray-400 italic">-</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 align-middle" style="min-width: 200px;">
                                    <div class="flex justify-between text-xs mb-1">
                                        <span class="font-bold {{ $textColor }}">{{ $schedule->attendances_count }} Hadir</span>
                                        <span class="text-gray-400">Target: {{ $totalPeserta }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="{{ $barColor }} h-2 rounded-full transition-all duration-1000 ease-out" style="width: {{ $percent }}%"></div>
                                    </div>
                                    <div class="text-right text-[10px] text-gray-400 mt-1">{{ round($percent) }}% Partisipasi</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end gap-2">
                                        <a href="{{ route('admin.events.scan', [$event->id, $schedule->id]) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm"
                                           title="Buka Scanner QR">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 16H4v4h2v-4zM6 10H4v2h2v-2zm0-4H4v2h2V6zM10 6H8v2h2V6zm0 4H8v2h2v-2zm0 4H8v4h2v-4zm6-8h-2v2h2V6zm-6 0h-2v2h2V6zm4 8h-2v4h2v-4zm0-4h-2v2h2v-2z"></path></svg>
                                            Scan
                                        </a>
                                        
                                        <a href="{{ route('admin.events.attendance.show', [$event->id, $schedule->id]) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm"
                                           title="Lihat Detail Absensi">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                            @if($schedules->isEmpty())
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-gray-500 bg-white">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        <p class="text-gray-500 italic">Belum ada jadwal sesi yang dibuat.</p>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>