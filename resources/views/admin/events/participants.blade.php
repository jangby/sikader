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
                                <span class="ml-1 text-sm font-medium text-emerald-600 md:ml-2">Peserta</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="mt-2 font-bold text-3xl text-gray-800 leading-tight">
                    Data Peserta
                </h2>
            </div>
            <a href="{{ route('admin.events.manage', $event->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Kembali ke Menu
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex justify-between items-center animate-fade-in-down">
                    <div class="flex items-center">
                        <svg class="h-6 w-6 text-emerald-500 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <div>
                            <p class="font-bold text-emerald-800">Berhasil!</p>
                            <p class="text-sm text-emerald-700">{{ session('success') }}</p>
                        </div>
                    </div>
                    <button @click="show = false" class="text-emerald-500 hover:text-emerald-700">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
            @endif

            {{-- STATISTIK CARDS --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-wider">Total Peserta</div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="text-3xl font-extrabold text-gray-800">{{ $stats['total'] }}</div>
                        <div class="p-2 bg-indigo-50 rounded-lg text-indigo-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-wider">Laki-laki</div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="text-3xl font-extrabold text-gray-800">{{ $stats['laki'] }}</div>
                        <div class="p-2 bg-blue-50 rounded-lg text-blue-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-wider">Perempuan</div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="text-3xl font-extrabold text-gray-800">{{ $stats['perempuan'] }}</div>
                        <div class="p-2 bg-pink-50 rounded-lg text-pink-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col justify-between hover:shadow-md transition">
                    <div class="text-gray-400 text-xs font-bold uppercase tracking-wider">Lulus / Alumni</div>
                    <div class="flex items-center justify-between mt-2">
                        <div class="text-3xl font-extrabold text-emerald-600">{{ $stats['lulus'] }}</div>
                        <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>
            </div>

            {{-- FILTER DAN PENCARIAN --}}
            <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col lg:flex-row justify-between gap-4 items-center">
                
                <form method="GET" class="flex flex-col sm:flex-row gap-3 w-full lg:w-auto flex-grow">
                    <div class="relative w-full sm:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau delegasi..." class="pl-10 rounded-lg border-gray-300 text-sm w-full focus:ring-emerald-500 focus:border-emerald-500 shadow-sm transition">
                    </div>
                    
                    <select name="gender" class="rounded-lg border-gray-300 text-sm focus:ring-emerald-500 focus:border-emerald-500 shadow-sm" onchange="this.form.submit()">
                        <option value="">Semua Gender</option>
                        <option value="Laki-laki" {{ request('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ request('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </form>

                <div class="flex flex-wrap gap-2 w-full lg:w-auto justify-end">
                    
                    <a href="{{ route('admin.events.qr_codes', $event->id) }}" class="inline-flex items-center px-4 py-2 bg-gray-50 border border-gray-300 rounded-lg font-medium text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150" title="Lihat QR Code">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 16H4v4h2v-4zM6 10H4v2h2v-2zm0-4H4v2h2V6zM10 6H8v2h2V6zm0 4H8v2h2v-2zm0 4H8v4h2v-4zm6-8h-2v2h2V6zm-6 0h-2v2h2V6zm4 8h-2v4h2v-4zm0-4h-2v2h2v-2z"></path></svg>
                        QR Code
                    </a>

                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-emerald-100 border border-transparent rounded-lg font-medium text-xs text-emerald-700 uppercase tracking-widest hover:bg-emerald-200 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Export
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-xl z-50 py-1 border border-gray-100 ring-1 ring-black ring-opacity-5 animate-fade-in-down" style="display: none;">
                            <a href="{{ route('admin.events.participants.export', ['event' => $event->id, 'filter' => 'all']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-emerald-600 transition">Semua Data</a>
                            <a href="{{ route('admin.events.participants.export', ['event' => $event->id, 'filter' => 'Laki-laki']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-emerald-600 transition">Khusus Laki-laki</a>
                            <a href="{{ route('admin.events.participants.export', ['event' => $event->id, 'filter' => 'Perempuan']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50 hover:text-emerald-600 transition">Khusus Perempuan</a>
                        </div>
                    </div>

                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-participant-modal')" class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-medium text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Peserta
                    </button>
                </div>
            </div>

            {{-- TABEL DATA --}}
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Nama & ID</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">L/P</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Kontak</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Delegasi</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($registrations as $index => $reg)
                            @php $profile = $reg->user->profile; @endphp
                            <tr class="hover:bg-gray-50/80 transition duration-150 ease-in-out">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $registrations->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900">{{ $profile->nama_lengkap ?? $reg->user->name }}</span>
                                        <span class="text-xs font-mono text-gray-400 mt-0.5">#{{ $reg->id }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(($profile->jenis_kelamin ?? '') == 'Laki-laki')
                                        <span class="inline-flex items-center justify-center w-6 h-6 bg-blue-100 text-blue-600 rounded-full text-xs font-bold" title="Laki-laki">L</span>
                                    @elseif(($profile->jenis_kelamin ?? '') == 'Perempuan')
                                        <span class="inline-flex items-center justify-center w-6 h-6 bg-pink-100 text-pink-600 rounded-full text-xs font-bold" title="Perempuan">P</span>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm text-gray-700">
                                        {{ $profile->no_hp ?? '-' }}
                                        @if($profile->no_hp)
                                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $profile->no_hp)) }}" target="_blank" class="ml-2 text-green-500 hover:text-green-700 bg-green-50 hover:bg-green-100 p-1 rounded-md transition" title="Chat WhatsApp">
                                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.017-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $profile->asal_delegasi ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($reg->status == 'lulus')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 border border-emerald-200">Lulus</span>
                                    @elseif($reg->status == 'verified')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 border border-blue-200">Verified</span>
                                    @elseif($reg->status == 'pending')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 border border-amber-200">Pending</span>
                                    @elseif($reg->status == 'tidak_lulus')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">Tidak Lulus</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">{{ ucfirst($reg->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-user-{{ $reg->id }}')" class="text-emerald-600 hover:text-emerald-900 font-semibold bg-emerald-50 hover:bg-emerald-100 px-3 py-1.5 rounded-md transition duration-150">
                                        Edit / Detail
                                    </button>
                                </td>
                            </tr>

                            {{-- MODAL EDIT PESERTA & LIHAT BERKAS (UPDATED) --}}
                            <x-modal name="edit-user-{{ $reg->id }}" focusable maxWidth="4xl">
                                <form method="POST" action="{{ route('admin.events.participants.update', $reg->id) }}" class="p-6 text-left">
                                    @csrf
                                    @method('PUT')
                                    
                                    {{-- Header Modal --}}
                                    <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                                        <div class="flex items-center">
                                            <div class="h-10 w-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center font-bold mr-4">
                                                {{ substr($reg->user->name, 0, 1) }}
                                            </div>
                                            <div>
                                                <h2 class="text-xl font-bold text-gray-800">Detail & Edit Peserta</h2>
                                                <p class="text-sm text-gray-500 mt-0.5">{{ $reg->user->name }} - #{{ $reg->id }}</p>
                                            </div>
                                        </div>
                                        <button type="button" x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600 transition p-2 hover:bg-gray-100 rounded-full">
                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                    
                                    <div class="h-[500px] overflow-y-auto pr-2 custom-scrollbar"> 
                                        
                                        {{-- GRID LAYOUT: 2 KOLOM --}}
                                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                            
                                            {{-- KOLOM KIRI: FORM EDIT STATUS & BIODATA --}}
                                            <div class="space-y-6">
                                                
                                                {{-- 1. Status Section --}}
                                                <div class="bg-amber-50 p-5 rounded-xl border border-amber-200">
                                                    <h3 class="text-sm font-bold text-amber-800 mb-3 uppercase tracking-wider flex items-center">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        Status Keikutsertaan
                                                    </h3>
                                                    <div>
                                                        <x-input-label value="Update Status" class="text-amber-900" />
                                                        <select name="status" class="mt-1 block w-full border-amber-300 rounded-lg shadow-sm focus:border-amber-500 focus:ring-amber-500 font-bold text-gray-700">
                                                            <option value="pending" {{ $reg->status == 'pending' ? 'selected' : '' }}>⏳ Pending (Menunggu)</option>
                                                            <option value="verified" {{ $reg->status == 'verified' ? 'selected' : '' }}>✔️ Verified (Sah)</option>
                                                            <option value="lulus" {{ $reg->status == 'lulus' ? 'selected' : '' }}>🏆 LULUS</option>
                                                            <option value="tidak_lulus" {{ $reg->status == 'tidak_lulus' ? 'selected' : '' }}>❌ TIDAK LULUS</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                {{-- 2. Biodata Section --}}
                                                <div>
                                                    <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase border-b pb-2 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                        Data Diri
                                                    </h3>
                                                    <div class="space-y-4">
                                                        <div>
                                                            <x-input-label value="Nama Lengkap" />
                                                            <x-text-input name="nama_lengkap" type="text" class="mt-1 block w-full" :value="$profile->nama_lengkap ?? ''" required />
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div>
                                                                <x-input-label value="No HP" />
                                                                <x-text-input name="no_hp" type="number" class="mt-1 block w-full" :value="$profile->no_hp ?? ''" required />
                                                            </div>
                                                            <div>
                                                                <x-input-label value="Gender" />
                                                                <select name="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                                                    <option value="Laki-laki" {{ ($profile->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                                                    <option value="Perempuan" {{ ($profile->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <div>
                                                                <x-input-label value="Tempat Lahir" />
                                                                <x-text-input name="tempat_lahir" type="text" class="mt-1 block w-full" :value="$profile->tempat_lahir ?? ''" required />
                                                            </div>
                                                            <div>
                                                                <x-input-label value="Tanggal Lahir" />
                                                                <x-text-input name="tanggal_lahir" type="date" class="mt-1 block w-full" :value="$profile->tanggal_lahir ?? ''" required />
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <x-input-label value="Asal Delegasi" />
                                                            <x-text-input name="asal_delegasi" type="text" class="mt-1 block w-full" :value="$profile->asal_delegasi ?? ''" required />
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                {{-- 3. Alamat Section --}}
                                                <div>
                                                    <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase border-b pb-2 flex items-center">
                                                        <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                        Alamat
                                                    </h3>
                                                    <div class="space-y-4">
                                                        <textarea name="alamat" rows="2" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500" placeholder="Jalan/Dusun">{{ $profile->alamat ?? '' }}</textarea>
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <x-text-input name="rt" placeholder="RT" class="block w-full" :value="$profile->rt ?? ''" />
                                                            <x-text-input name="rw" placeholder="RW" class="block w-full" :value="$profile->rw ?? ''" />
                                                        </div>
                                                        <div class="grid grid-cols-2 gap-4">
                                                            <x-text-input name="desa" placeholder="Desa" class="block w-full" :value="$profile->desa ?? ''" />
                                                            <x-text-input name="kecamatan" placeholder="Kecamatan" class="block w-full" :value="$profile->kecamatan ?? ''" />
                                                        </div>
                                                        <x-text-input name="kabupaten" placeholder="Kabupaten" class="block w-full" :value="$profile->kabupaten ?? ''" />
                                                    </div>
                                                </div>

                                            </div> {{-- End Kolom Kiri --}}

                                            {{-- KOLOM KANAN: DOKUMEN & BUKTI (BARU) --}}
                                            <div class="space-y-6">
                                                
                                                {{-- 1. Bukti Pembayaran --}}
                                                <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                                                    <h3 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wider flex items-center">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                                        Bukti Pembayaran
                                                    </h3>
                                                    
                                                    @if($reg->bukti_pembayaran)
                                                        <div class="relative group rounded-lg overflow-hidden border border-gray-300 shadow-sm bg-white">
                                                            <img src="{{ asset('storage/' . $reg->bukti_pembayaran) }}" alt="Bukti Transfer" class="w-full h-48 object-cover object-top transition duration-300 group-hover:opacity-90">
                                                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 bg-black/30">
                                                                <a href="{{ asset('storage/' . $reg->bukti_pembayaran) }}" target="_blank" class="px-4 py-2 bg-white text-gray-800 text-xs font-bold rounded-full shadow-lg hover:bg-gray-100">
                                                                    Lihat Ukuran Penuh
                                                                </a>
                                                            </div>
                                                        </div>
                                                        <p class="text-xs text-center text-gray-400 mt-2">Klik gambar untuk memperbesar</p>
                                                    @else
                                                        <div class="flex flex-col items-center justify-center h-32 border-2 border-dashed border-gray-300 rounded-lg bg-gray-50 text-gray-400">
                                                            <svg class="w-8 h-8 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                            <span class="text-xs">Tidak ada bukti pembayaran</span>
                                                        </div>
                                                    @endif
                                                </div>

                                                {{-- 2. List Dokumen Persyaratan --}}
                                                <div class="bg-gray-50 p-5 rounded-xl border border-gray-200">
                                                    <h3 class="text-sm font-bold text-gray-800 mb-3 uppercase tracking-wider flex items-center">
                                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                        Berkas Persyaratan
                                                    </h3>

                                                    @if(!empty($reg->data_dokumen))
                                                        <div class="space-y-2">
                                                            @foreach($reg->data_dokumen as $namaDoc => $path)
                                                                <div class="flex items-center justify-between p-3 bg-white border border-gray-200 rounded-lg hover:border-emerald-400 transition shadow-sm group">
                                                                    <div class="flex items-center overflow-hidden">
                                                                        <div class="flex-shrink-0 w-8 h-8 bg-emerald-100 text-emerald-600 rounded flex items-center justify-center mr-3">
                                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                                                        </div>
                                                                        <div class="truncate">
                                                                            <p class="text-sm font-medium text-gray-700 truncate" title="{{ $namaDoc }}">{{ $namaDoc }}</p>
                                                                            <p class="text-[10px] text-gray-400">Terupload</p>
                                                                        </div>
                                                                    </div>
                                                                    <a href="{{ asset('storage/' . $path) }}" target="_blank" class="flex-shrink-0 ml-2 text-xs font-bold text-emerald-600 bg-emerald-50 hover:bg-emerald-600 hover:text-white px-3 py-1.5 rounded-md transition duration-200">
                                                                        Buka
                                                                    </a>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @else
                                                        <div class="text-center py-6 text-gray-400 bg-white border border-dashed border-gray-300 rounded-lg">
                                                            <p class="text-xs italic">Belum ada berkas yang diunggah</p>
                                                        </div>
                                                    @endif
                                                </div>
                                                
                                                {{-- 3. Ukuran Baju --}}
                                                <div class="bg-gray-50 p-4 rounded-xl border border-gray-200 flex justify-between items-center">
                                                    <span class="text-sm font-bold text-gray-700">Ukuran Baju</span>
                                                    <span class="px-3 py-1 bg-gray-200 text-gray-800 font-bold rounded text-sm">{{ $reg->ukuran_baju ?? '-' }}</span>
                                                </div>

                                            </div> {{-- End Kolom Kanan --}}

                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end pt-4 border-t border-gray-100 gap-3">
                                        <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                                        <x-primary-button class="bg-emerald-600 hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800">
                                            Simpan Perubahan
                                        </x-primary-button>
                                    </div>
                                </form>
                            </x-modal>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @if($registrations->hasPages())
                <div class="p-4 border-t border-gray-200 bg-gray-50">
                    {{ $registrations->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- MODAL TAMBAH PESERTA (TETAP SAMA) --}}
    <x-modal name="add-participant-modal" focusable>
        <form method="POST" action="{{ route('admin.events.participants.store', $event->id) }}" class="p-6">
            @csrf
            
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Tambah Peserta Offline</h2>
                    <p class="text-sm text-gray-500 mt-1">Input manual untuk peserta yang mendaftar di lokasi.</p>
                </div>
                <button type="button" x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="space-y-6 h-96 overflow-y-auto pr-2 custom-scrollbar"> 
                <div>
                    <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase border-b pb-2">Identitas Diri</h3>
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="nama_lengkap" value="Nama Lengkap" />
                            <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" placeholder="Sesuai KTP/Identitas" required />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="no_hp" value="No HP (WhatsApp)" />
                                <x-text-input id="no_hp" name="no_hp" type="number" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" placeholder="0812..." required />
                            </div>
                            <div>
                                <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                                <select name="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                                    <option value="">- Pilih -</option>
                                    <option value="Laki-laki">Laki-laki</option>
                                    <option value="Perempuan">Perempuan</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                                <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" required />
                            </div>
                            <div>
                                <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                                <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" required />
                            </div>
                        </div>

                        <div>
                            <x-input-label for="asal_delegasi" value="Asal Delegasi" />
                            <x-text-input id="asal_delegasi" name="asal_delegasi" type="text" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: PR IPNU Desa Sukamaju" required />
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-sm font-bold text-gray-700 mb-4 uppercase border-b pb-2">Alamat Domisili</h3>
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="alamat" value="Jalan / Dusun / Blok" />
                            <textarea id="alamat" name="alamat" rows="2" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required></textarea>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <x-input-label for="rt" value="RT" />
                                <x-text-input id="rt" name="rt" type="text" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" required />
                            </div>
                            <div>
                                <x-input-label for="rw" value="RW" />
                                <x-text-input id="rw" name="rw" type="text" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <x-input-label for="desa" value="Desa/Kel" />
                                <x-text-input id="desa" name="desa" type="text" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" required />
                            </div>
                            <div>
                                <x-input-label for="kecamatan" value="Kecamatan" />
                                <x-text-input id="kecamatan" name="kecamatan" type="text" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" required />
                            </div>
                            <div>
                                <x-input-label for="kabupaten" value="Kabupaten" />
                                <x-text-input id="kabupaten" name="kabupaten" type="text" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" required />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-6 flex justify-end pt-4 border-t border-gray-100 gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button class="bg-emerald-600 hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800">Simpan Peserta</x-primary-button>
            </div>
        </form>
    </x-modal>
    
    <style>
        .animate-fade-in-down {
            animation: fadeInDown 0.3s ease-out;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>

</x-app-layout>