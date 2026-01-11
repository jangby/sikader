<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Kelola Acara') }}: {{ $event->nama_acara }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    {{ $event->jenis_kaderisasi }} | {{ $event->lokasi }}
                </p>
            </div>
            <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-900 text-sm">
                &larr; Kembali ke Daftar
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-xs uppercase font-bold">Total Pendaftar</div>
                    <div class="text-2xl font-bold">{{ $totalPeserta }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-xs uppercase font-bold">Peserta Lulus</div>
                    <div class="text-2xl font-bold">{{ $pesertaLulus }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 text-xs uppercase font-bold">Status Acara</div>
                    <div class="text-2xl font-bold">{{ $event->is_active ? 'Buka' : 'Tutup' }}</div>
                </div>
            </div>

            <h3 class="font-bold text-lg mb-4 text-gray-700">Menu Pengelolaan</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                
                <a href="{{ route('admin.events.participants', $event->id) }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border hover:border-indigo-300 group">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-indigo-100 text-indigo-600 group-hover:bg-indigo-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h4 class="ml-3 font-bold text-gray-800">Data Peserta</h4>
                    </div>
                    <p class="text-sm text-gray-500">Lihat data pendaftar, verifikasi berkas, dan tambah peserta manual (offline).</p>
                </a>

                <a href="{{ route('admin.events.schedules', $event->id) }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border hover:border-yellow-300 group">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600 group-hover:bg-yellow-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h4 class="ml-3 font-bold text-gray-800">Jadwal & Materi</h4>
                    </div>
                    <p class="text-sm text-gray-500">Atur sesi acara, input materi digital, dan penanggung jawab sesi.</p>
                </a>

                <a href="{{ route('admin.events.attendance', $event->id) }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border hover:border-red-300 group">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-red-100 text-red-600 group-hover:bg-red-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 16H4v4h2v-4zM6 10H4v2h2v-2zm0-4H4v2h2V6zM10 6H8v2h2V6zm0 4H8v2h2v-2zm0 4H8v4h2v-4zm6-8h-2v2h2V6zm-6 0h-2v2h2V6zm4 8h-2v4h2v-4zm0-4h-2v2h2v-2z"></path></svg>
                        </div>
                        <h4 class="ml-3 font-bold text-gray-800">Absensi (Scan QR)</h4>
                    </div>
                    <p class="text-sm text-gray-500">Lihat Barcode peserta dan buka scanner untuk absensi per sesi.</p>
                </a>

                <a href="{{ route('admin.events.certificates', $event->id) }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border hover:border-blue-300 group">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="ml-3 font-bold text-gray-800">Sertifikat</h4>
                    </div>
                    <p class="text-sm text-gray-500">Generate sertifikat otomatis dan publish untuk peserta lulus.</p>
                </a>

                 <a href="{{ route('admin.events.payments', $event->id) }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border hover:border-green-300 group">
                    <div class="flex items-center mb-4">
                        <div class="p-3 rounded-full bg-green-100 text-green-600 group-hover:bg-green-600 group-hover:text-white transition">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h4 class="ml-3 font-bold text-gray-800">Cek Pembayaran</h4>
                    </div>
                    <p class="text-sm text-gray-500">Verifikasi bukti transfer peserta.</p>
                </a>

                <a href="{{ route('admin.events.finances', $event->id) }}" class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition border hover:border-emerald-300 group">
    <div class="flex items-center mb-4">
        <div class="p-3 rounded-full bg-emerald-100 text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white transition">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <h4 class="ml-3 font-bold text-gray-800">Manajemen Dana</h4>
    </div>
    <p class="text-sm text-gray-500">Kelola pemasukan, pengeluaran, dan cetak LPJ Keuangan.</p>
</a>

            </div>
        </div>
    </div>
</x-app-layout>