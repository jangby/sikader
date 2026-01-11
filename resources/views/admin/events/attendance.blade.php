<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard Absensi
                </h2>
                <p class="text-sm text-gray-500">{{ $event->nama_acara }}</p>
            </div>
            <a href="{{ route('admin.events.manage', $event->id) }}" class="text-sm text-gray-600 hover:text-gray-900 border border-gray-300 px-3 py-1 rounded-md bg-white shadow-sm">
                &larr; Kembali ke Menu
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Peserta Terdaftar</div>
                        <div class="text-2xl font-bold text-gray-900 mt-1">{{ $totalPeserta }} <span class="text-sm font-normal text-gray-500">Orang</span></div>
                    </div>
                    <div class="p-3 bg-blue-50 rounded-full text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Jumlah Sesi / Materi</div>
                        <div class="text-2xl font-bold text-gray-900 mt-1">{{ $totalSesi }} <span class="text-sm font-normal text-gray-500">Sesi</span></div>
                    </div>
                    <div class="p-3 bg-purple-50 rounded-full text-purple-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500 flex items-center justify-between">
                    <div>
                        <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Aktivitas Scan</div>
                        <div class="text-2xl font-bold text-gray-900 mt-1">{{ $totalCheckIn }} <span class="text-sm font-normal text-gray-500">x Scan</span></div>
                    </div>
                    <div class="p-3 bg-green-50 rounded-full text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 16H4v4h2v-4zM6 10H4v2h2v-2zm0-4H4v2h2V6zM10 6H8v2h2V6zm0 4H8v2h2v-2zm0 4H8v4h2v-4zm6-8h-2v2h2V6zm-6 0h-2v2h2V6zm4 8h-2v4h2v-4zm0-4h-2v2h2v-2z"></path></svg>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Jadwal Sesi & Monitoring</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Informasi Sesi</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pemateri / PJ</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tingkat Kehadiran</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($schedules as $schedule)
                                    @php
                                        // Hitung Persentase Kehadiran
                                        $percent = $totalPeserta > 0 ? ($schedule->attendances_count / $totalPeserta) * 100 : 0;
                                        
                                        // Warna Bar berdasarkan persentase
                                        $barColor = 'bg-red-500';
                                        if($percent > 50) $barColor = 'bg-yellow-500';
                                        if($percent > 80) $barColor = 'bg-green-500';
                                        
                                        // Status Waktu
                                        $isPast = $schedule->waktu_selesai < now();
                                        $isNow = $schedule->waktu_mulai <= now() && $schedule->waktu_selesai >= now();
                                    @endphp
                                <tr class="hover:bg-gray-50 transition {{ $isNow ? 'bg-indigo-50' : '' }}">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            @if($isNow)
                                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse" title="Sedang Berlangsung"></div>
                                            @elseif($isPast)
                                                <div class="w-2 h-2 bg-gray-400 rounded-full mr-2" title="Selesai"></div>
                                            @else
                                                <div class="w-2 h-2 bg-blue-400 rounded-full mr-2" title="Akan Datang"></div>
                                            @endif
                                            
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">{{ $schedule->nama_sesi }}</div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $schedule->waktu_mulai->format('d M, H:i') }} - {{ $schedule->waktu_selesai->format('H:i') }}
                                                </div>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $schedule->penanggung_jawab ?? '-' }}
                                    </td>

                                    <td class="px-6 py-4 align-middle" style="min-width: 200px;">
                                        <div class="flex justify-between text-xs mb-1">
                                            <span class="font-bold text-gray-700">{{ $schedule->attendances_count }} Hadir</span>
                                            <span class="text-gray-500">dari {{ $totalPeserta }} Total</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                                            <div class="{{ $barColor }} h-2.5 rounded-full transition-all duration-500" style="width: {{ $percent }}%"></div>
                                        </div>
                                        <div class="text-right text-xs text-gray-400 mt-1">{{ round($percent) }}%</div>
                                    </td>

                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end gap-2">
                                            <a href="{{ route('admin.events.scan', [$event->id, $schedule->id]) }}" class="inline-flex items-center px-3 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 16H4v4h2v-4zM6 10H4v2h2v-2zm0-4H4v2h2V6zM10 6H8v2h2V6zm0 4H8v2h2v-2zm0 4H8v4h2v-4zm6-8h-2v2h2V6zm-6 0h-2v2h2V6zm4 8h-2v4h2v-4zm0-4h-2v2h2v-2z"></path></svg>
                                                Scan
                                            </a>
                                            
                                            <a href="{{ route('admin.events.attendance.show', [$event->id, $schedule->id]) }}" class="inline-flex items-center px-3 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                Laporan
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        
                        @if($schedules->isEmpty())
                            <div class="text-center py-10 text-gray-500">
                                Belum ada jadwal dibuat. <a href="{{ route('admin.events.schedules', $event->id) }}" class="text-indigo-600 underline">Buat Jadwal Dulu</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>