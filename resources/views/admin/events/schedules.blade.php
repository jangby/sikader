<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Jadwal & Materi: {{ $event->nama_acara }}
            </h2>
            <a href="{{ route('admin.events.manage', $event->id) }}" class="text-sm text-gray-600 hover:text-gray-900">&larr; Kembali ke Menu</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4">{{ session('success') }}</div>
            @endif

            <div class="flex justify-end mb-6">
                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-schedule-modal')" 
                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm shadow-sm flex items-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Sesi / Materi
                </button>
            </div>

            <div class="relative border-l-2 border-indigo-200 ml-3 md:ml-6 space-y-8">
                
                @foreach($schedules as $schedule)
                <div class="relative pl-8 md:pl-12 group">
                    <div class="absolute -left-2.5 top-0 w-5 h-5 bg-indigo-600 rounded-full border-4 border-white shadow-sm"></div>
                    
                    <div class="bg-white p-5 rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition">
                        <div class="flex flex-col md:flex-row justify-between md:items-start">
                            
                            <div>
                                <span class="text-xs font-bold uppercase text-indigo-500 mb-1 block">
                                    {{ $schedule->waktu_mulai->format('d M Y') }} • {{ $schedule->waktu_mulai->format('H:i') }} - {{ $schedule->waktu_selesai->format('H:i') }}
                                </span>
                                <h3 class="text-lg font-bold text-gray-900">{{ $schedule->nama_sesi }}</h3>
                                @if($schedule->penanggung_jawab)
                                    <p class="text-sm text-gray-500 mt-1 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        {{ $schedule->penanggung_jawab }}
                                    </p>
                                @endif
                            </div>

                            <div class="mt-4 md:mt-0 flex items-center gap-3">
                                
                                @if($schedule->file_materi)
                                    <a href="{{ asset('storage/' . $schedule->file_materi) }}" target="_blank" class="flex items-center text-sm text-blue-600 hover:text-blue-800 bg-blue-50 px-3 py-1 rounded-full border border-blue-100">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Download Materi
                                    </a>
                                @else
                                    <span class="text-xs text-gray-400 italic">Belum ada materi</span>
                                @endif

                                <form action="{{ route('admin.events.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Hapus sesi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 p-1">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @if($schedules->isEmpty())
                    <div class="pl-12 text-gray-500 italic">Belum ada jadwal yang dibuat.</div>
                @endif
            </div>

        </div>
    </div>

    <x-modal name="add-schedule-modal" focusable>
        <form method="POST" action="{{ route('admin.events.schedules.store', $event->id) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h2 class="text-lg font-bold text-gray-900">Tambah Sesi Acara</h2>
                <button type="button" x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>

            <div class="mb-4">
                <x-input-label value="Nama Sesi / Materi" />
                <x-text-input name="nama_sesi" type="text" class="mt-1 block w-full" placeholder="Contoh: Materi 1 - Ahlussunnah Wal Jamaah" required />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label value="Waktu Mulai" />
                    <x-text-input name="waktu_mulai" type="datetime-local" class="mt-1 block w-full" required />
                </div>
                <div>
                    <x-input-label value="Waktu Selesai" />
                    <x-text-input name="waktu_selesai" type="datetime-local" class="mt-1 block w-full" required />
                </div>
            </div>

            <div class="mb-4">
                <x-input-label value="Penanggung Jawab / Pemateri" />
                <x-text-input name="penanggung_jawab" type="text" class="mt-1 block w-full" placeholder="Contoh: Rekan Ahmad (Ketua PC)" />
            </div>

            <div class="mb-4">
                <x-input-label value="Upload File Materi (Opsional)" />
                <input type="file" name="file_materi" class="block w-full text-sm text-gray-500 mt-1
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-indigo-50 file:text-indigo-700
                    hover:file:bg-indigo-100 border border-gray-300 rounded-lg p-1"
                >
                <p class="text-xs text-gray-500 mt-1">PDF, PPT, DOC (Max 10MB)</p>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button class="ml-3">Simpan Sesi</x-primary-button>
            </div>
        </form>
    </x-modal>

</x-app-layout>