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
                                <span class="ml-1 text-sm font-medium text-emerald-600 md:ml-2">Jadwal</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="mt-2 font-bold text-3xl text-gray-800 leading-tight">
                    Jadwal & Materi
                </h2>
                <p class="text-sm text-gray-500 mt-1">Atur rundown acara dan upload materi digital.</p>
            </div>
            <a href="{{ route('admin.events.manage', $event->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                &larr; Kembali ke Menu
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 bg-emerald-50 border-l-4 border-emerald-500 p-4 rounded-r-lg shadow-sm flex justify-between items-center animate-fade-in-down">
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

            <div class="flex justify-between items-center mb-8">
                <div>
                    <h3 class="text-lg font-bold text-gray-800">Timeline Acara</h3>
                    <p class="text-sm text-gray-500">Urutan kegiatan dari awal hingga akhir.</p>
                </div>
                <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-schedule-modal')" 
                    class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 text-sm font-semibold shadow-md flex items-center transition duration-150 transform hover:-translate-y-0.5">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Sesi
                </button>
            </div>

            <div class="relative border-l-2 border-emerald-200 ml-3 md:ml-6 space-y-10 pb-10">
                
                @foreach($schedules as $schedule)
                <div class="relative pl-8 md:pl-12 group animate-fade-in-up" style="animation-delay: {{ $loop->index * 100 }}ms">
                    <div class="absolute -left-2.5 top-5 w-5 h-5 bg-emerald-500 rounded-full border-4 border-white shadow-md group-hover:bg-emerald-600 transition duration-300"></div>
                    
                    <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100 hover:shadow-lg hover:border-emerald-200 transition-all duration-300 relative">
                        <div class="flex flex-col md:flex-row justify-between md:items-start gap-4">
                            <div class="flex-grow">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="px-2 py-0.5 rounded text-xs font-bold uppercase bg-emerald-100 text-emerald-700">
                                        {{ $schedule->waktu_mulai->format('d M') }}
                                    </span>
                                    <span class="text-xs font-bold text-gray-500">
                                        {{ $schedule->waktu_mulai->format('H:i') }} - {{ $schedule->waktu_selesai->format('H:i') }} WIB
                                    </span>
                                </div>
                                <h3 class="text-xl font-bold text-gray-800 group-hover:text-emerald-700 transition duration-300">
                                    {{ $schedule->nama_sesi }}
                                </h3>
                                
                                @if($schedule->penanggung_jawab)
                                    <div class="mt-2 flex items-center text-sm text-gray-600 bg-gray-50 p-2 rounded-lg w-fit">
                                        <div class="flex-shrink-0 h-6 w-6 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-700 font-bold text-xs mr-2">
                                            {{ substr($schedule->penanggung_jawab, 0, 1) }}
                                        </div>
                                        <span>{{ $schedule->penanggung_jawab }}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="flex flex-col items-end gap-2">
                                @if($schedule->file_materi)
                                    <a href="{{ asset('storage/' . $schedule->file_materi) }}" target="_blank" class="flex items-center text-xs font-medium text-white bg-blue-500 hover:bg-blue-600 px-3 py-1.5 rounded-lg shadow-sm transition">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Download Materi
                                    </a>
                                @endif

                                <form action="{{ route('admin.events.schedules.destroy', $schedule->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus sesi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="flex items-center text-xs font-medium text-red-500 hover:text-red-700 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition" title="Hapus Sesi">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                @if($schedules->isEmpty())
                <div class="pl-12 py-8">
                    <div class="bg-white p-8 rounded-xl border border-dashed border-gray-300 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada jadwal</h3>
                        <p class="mt-1 text-sm text-gray-500">Mulai dengan menambahkan sesi acara pertama Anda.</p>
                        <div class="mt-6">
                            <button type="button" x-on:click.prevent="$dispatch('open-modal', 'add-schedule-modal')" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                <svg class="-ml-1 mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                                </svg>
                                Tambah Sesi Baru
                            </button>
                        </div>
                    </div>
                </div>
                @endif
            </div>

        </div>
    </div>

    <x-modal name="add-schedule-modal" focusable>
        <form method="POST" action="{{ route('admin.events.schedules.store', $event->id) }}" enctype="multipart/form-data" class="p-6">
            @csrf
            
            <div class="flex justify-between items-center mb-6 border-b border-gray-100 pb-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-800">Tambah Sesi Acara</h2>
                    <p class="text-sm text-gray-500 mt-1">Isi detail waktu dan materi sesi.</p>
                </div>
                <button type="button" x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600 transition">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="space-y-5">
                <div>
                    <x-input-label value="Nama Sesi / Materi" />
                    <x-text-input name="nama_sesi" type="text" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Pembukaan & Sambutan" required />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label value="Waktu Mulai" />
                        <x-text-input name="waktu_mulai" type="datetime-local" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" required />
                    </div>
                    <div>
                        <x-input-label value="Waktu Selesai" />
                        <x-text-input name="waktu_selesai" type="datetime-local" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" required />
                    </div>
                </div>

                <div>
                    <x-input-label value="Penanggung Jawab / Pemateri" />
                    <x-text-input name="penanggung_jawab" type="text" class="mt-1 block w-full focus:ring-emerald-500 focus:border-emerald-500" placeholder="Contoh: Rekan Ahmad (Ketua PC)" />
                </div>

                <div>
                    <x-input-label value="Upload File Materi (Opsional)" />
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-lg hover:border-emerald-400 transition bg-gray-50">
                        <div class="space-y-1 text-center">
                            <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="flex text-sm text-gray-600 justify-center">
                                <label for="file_materi" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500 px-2">
                                    <span>Pilih File</span>
                                    <input id="file_materi" name="file_materi" type="file" class="sr-only">
                                </label>
                            </div>
                            <p class="text-xs text-gray-500">PDF, PPT, DOC up to 10MB</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-4 border-t border-gray-100">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button class="bg-emerald-600 hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-800">Simpan Sesi</x-primary-button>
            </div>
        </form>
    </x-modal>

    <style>
        .animate-fade-in-down { animation: fadeInDown 0.4s ease-out; }
        .animate-fade-in-up { animation: fadeInUp 0.5s ease-out forwards; opacity: 0; }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>

</x-app-layout>