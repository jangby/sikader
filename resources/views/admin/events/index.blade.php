<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h2 class="font-bold text-2xl text-emerald-900 leading-tight">
                    {{ __('Daftar Acara Kaderisasi') }}
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola semua jadwal dan data acara di sini.</p>
            </div>
            
            <a href="{{ route('admin.events.create') }}" 
               class="inline-flex items-center px-4 py-2 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                </svg>
                Buat Acara Baru
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            {{-- Alert Success --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex justify-between items-center">
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

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-emerald-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Nama Acara & Lokasi</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Jenis</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Jadwal Pelaksanaan</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Biaya & Kuota</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-emerald-800 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($events as $event)
                            <tr class="hover:bg-emerald-50/30 transition duration-150 ease-in-out">
                                {{-- Kolom Nama & Lokasi --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex flex-col">
                                        <span class="text-sm font-bold text-gray-900">{{ $event->nama_acara }}</span>
                                        <div class="flex items-center mt-1 text-xs text-gray-500">
                                            <svg class="w-3 h-3 mr-1 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            {{Str::limit($event->lokasi, 30)}}
                                        </div>
                                    </div>
                                </td>

                                {{-- Kolom Jenis --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full border 
                                        {{ $event->jenis_kaderisasi == 'MAKESTA' ? 'bg-emerald-100 text-emerald-800 border-emerald-200' : 
                                          ($event->jenis_kaderisasi == 'LAKMUD' ? 'bg-amber-100 text-amber-800 border-amber-200' : 'bg-blue-100 text-blue-800 border-blue-200') }}">
                                        {{ $event->jenis_kaderisasi }}
                                    </span>
                                </td>

                                {{-- Kolom Jadwal --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-600 flex flex-col">
                                        <span class="font-medium">{{ $event->tanggal_mulai->format('d M Y') }}</span>
                                        <span class="text-xs text-gray-400">s/d {{ $event->tanggal_selesai->format('d M Y') }}</span>
                                    </div>
                                </td>

                                {{-- Kolom Biaya & Kuota --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 font-medium">Rp {{ number_format($event->biaya, 0, ',', '.') }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">
                                        @if($event->kuota == 0)
                                            <span class="text-emerald-600">∞ Unlimited</span>
                                        @else
                                            Kuota: {{ $event->kuota }}
                                        @endif
                                    </div>
                                </td>

                                {{-- Kolom Status --}}
                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($event->is_active)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                            <span class="w-1.5 h-1.5 mr-1.5 bg-green-500 rounded-full"></span>
                                            Buka
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                            <span class="w-1.5 h-1.5 mr-1.5 bg-red-500 rounded-full"></span>
                                            Tutup
                                        </span>
                                    @endif
                                </td>

                                {{-- Kolom Aksi --}}
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex items-center justify-end gap-2">
                                        
                                        {{-- Tombol Kelola --}}
                                        <a href="{{ route('admin.events.manage', $event->id) }}" 
                                           class="inline-flex items-center px-3 py-1.5 bg-emerald-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-800 transition ease-in-out duration-150"
                                           title="Kelola Acara">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            Kelola
                                        </a>

                                        {{-- Tombol Edit --}}
                                        <a href="{{ route('admin.events.edit', $event->id) }}" 
                                           class="p-1.5 text-amber-600 hover:text-amber-800 hover:bg-amber-50 rounded-md transition" 
                                           title="Edit Acara">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        </a>
                                        
                                        {{-- Form Hapus --}}
                                        <form action="{{ route('admin.events.destroy', $event->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus acara ini? Data yang dihapus tidak dapat dikembalikan.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="p-1.5 text-red-600 hover:text-red-800 hover:bg-red-50 rounded-md transition" 
                                                    title="Hapus Acara">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach

                            {{-- Empty State --}}
                            @if($events->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500 bg-white">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-16 h-16 text-emerald-200 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <p class="text-lg font-medium text-gray-900">Belum ada acara</p>
                                        <p class="text-sm text-gray-500 mb-4">Mulai buat acara kaderisasi pertama Anda sekarang.</p>
                                        <a href="{{ route('admin.events.create') }}" class="text-emerald-600 hover:text-emerald-800 font-medium hover:underline">
                                            + Buat Acara Baru
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
            {{-- Pagination (Optional jika ada pagination link) --}}
            {{-- <div class="mt-4">
                {{ $events->links() }}
            </div> --}}
            
        </div>
    </div>
</x-app-layout>