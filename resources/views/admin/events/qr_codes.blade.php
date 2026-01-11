<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center no-print">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                QR Code Peserta: {{ $event->nama_acara }}
            </h2>
            <a href="{{ route('admin.events.participants', $event->id) }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; Kembali</a>
        </div>
    </x-slot>

    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: white; }
            .print-area { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; }
            .card-qr { border: 1px solid #000; break-inside: avoid; page-break-inside: avoid; }
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white p-4 rounded-lg shadow-sm mb-6 flex justify-between items-center no-print">
                <form method="GET" class="flex gap-2">
                    <select name="gender" class="rounded-md border-gray-300 text-sm focus:ring-indigo-500" onchange="this.form.submit()">
                        <option value="">Semua Gender</option>
                        <option value="Laki-laki" {{ request('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ request('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </form>

                <button onclick="window.print()" class="bg-gray-800 text-white px-4 py-2 rounded-md hover:bg-gray-700 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak / Print PDF
                </button>
            </div>

            <div class="print-area grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($registrations as $reg)
                <div class="card-qr bg-white p-4 rounded-lg shadow-sm border border-gray-200 flex flex-col items-center text-center">
                    
                    <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">{{ $event->nama_acara }}</div>
                    
                    <div class="mb-3">
                        {!! QrCode::size(120)->generate($reg->id) !!}
                    </div>

                    <h3 class="font-bold text-gray-900 text-sm">{{ $reg->user->profile->nama_lengkap ?? $reg->user->name }}</h3>
                    
                    <div class="text-xs text-gray-500 mt-1">
                        {{ $reg->user->profile->jenis_kelamin ?? '-' }} | {{ $reg->user->profile->asal_delegasi ?? '-' }}
                    </div>
                    <div class="text-xs font-mono bg-gray-100 px-2 py-0.5 rounded mt-2">
                        ID: #{{ $reg->id }}
                    </div>

                </div>
                @endforeach
            </div>

            @if($registrations->isEmpty())
                <div class="text-center py-10 text-gray-500 bg-white rounded-lg">Tidak ada peserta ditemukan.</div>
            @endif

        </div>
    </div>
</x-app-layout>