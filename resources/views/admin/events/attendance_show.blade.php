<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center no-print">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Laporan Absensi
                </h2>
                <p class="text-sm text-gray-500">{{ $schedule->nama_sesi }} | {{ $schedule->waktu_mulai->format('d M Y') }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.events.attendance', $event->id) }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-300 text-sm">
                    &larr; Kembali
                </a>
                <a href="{{ route('admin.events.attendance.print', [$event->id, $schedule->id]) }}" target="_blank" class="bg-green-700 text-white px-4 py-2 rounded-md hover:bg-green-800 text-sm flex items-center shadow-sm">
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
    Cetak Laporan (PDF)
</a>
            </div>
        </div>
    </x-slot>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white; font-size: 12pt; }
            .print-header { display: block !important; text-align: center; margin-bottom: 20px; border-bottom: 2px solid black; padding-bottom: 10px; }
            table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
            th, td { border: 1px solid black; padding: 8px; text-align: left; }
            .page-break { page-break-before: always; }
        }
        .print-header { display: none; }
    </style>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="print-header">
                <h1 class="text-2xl font-bold uppercase">{{ $event->nama_acara }}</h1>
                <p>Laporan Absensi Sesi: {{ $schedule->nama_sesi }}</p>
                <p>Waktu: {{ $schedule->waktu_mulai->format('d F Y, H:i') }} WIB</p>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6 no-print">
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-green-500">
                    <div class="text-xs text-gray-500 uppercase">Total Hadir</div>
                    <div class="text-2xl font-bold text-green-700">{{ $attendees->count() }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-blue-500">
                    <div class="text-xs text-gray-500 uppercase">Laki-laki Hadir</div>
                    <div class="text-2xl font-bold text-blue-700">{{ $hadirLk->count() }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-pink-500">
                    <div class="text-xs text-gray-500 uppercase">Perempuan Hadir</div>
                    <div class="text-2xl font-bold text-pink-700">{{ $hadirPr->count() }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow border-l-4 border-red-500">
                    <div class="text-xs text-gray-500 uppercase">Belum Hadir</div>
                    <div class="text-2xl font-bold text-red-700">{{ $absentees->count() }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4">Daftar Peserta Hadir ({{ $attendees->count() }})</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Lengkap</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">L/P</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Delegasi</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Waktu Scan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @foreach($attendees as $index => $attendance)
                            <tr>
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 font-bold">{{ $attendance->registration->user->profile->nama_lengkap ?? 'User' }}</td>
                                <td class="px-4 py-2">{{ $attendance->registration->user->profile->jenis_kelamin ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $attendance->registration->user->profile->asal_delegasi ?? '-' }}</td>
                                <td class="px-4 py-2 text-green-600 font-mono">{{ $attendance->scanned_at->format('H:i:s') }}</td>
                            </tr>
                            @endforeach
                            @if($attendees->isEmpty())
                                <tr><td colspan="5" class="text-center py-4 text-gray-500">Belum ada peserta yang absen.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-800 mb-4 text-red-600">Belum Hadir / Tidak Absen ({{ $absentees->count() }})</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-red-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nama Lengkap</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">L/P</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Delegasi</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status Reg</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @foreach($absentees as $index => $reg)
                            <tr>
                                <td class="px-4 py-2">{{ $index + 1 }}</td>
                                <td class="px-4 py-2">{{ $reg->user->profile->nama_lengkap ?? $reg->user->name }}</td>
                                <td class="px-4 py-2">{{ $reg->user->profile->jenis_kelamin ?? '-' }}</td>
                                <td class="px-4 py-2">{{ $reg->user->profile->asal_delegasi ?? '-' }}</td>
                                <td class="px-4 py-2">
                                    <span class="px-2 text-xs rounded-full bg-gray-100 text-gray-800">Belum Scan</span>
                                </td>
                            </tr>
                            @endforeach
                            @if($absentees->isEmpty())
                                <tr><td colspan="5" class="text-center py-4 text-green-600 font-bold">Luar Biasa! Semua peserta hadir.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="print-header mt-10 text-right" style="border:none; text-align: right; page-break-inside: avoid;">
                <p class="mb-20">{{ $event->lokasi }}, {{ date('d F Y') }}</p>
                <p class="font-bold underline">Panitia Pelaksana</p>
            </div>

        </div>
    </div>
</x-app-layout>