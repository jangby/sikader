<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.events.index') }}" class="text-gray-400 hover:text-emerald-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-emerald-900 leading-tight">
                {{ __('Edit Acara') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                
                <div class="p-8">
                    <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-8">
                            <div class="flex justify-between items-center border-b border-gray-200 pb-2 mb-4">
                                <h3 class="text-lg font-semibold text-emerald-800">
                                    Informasi Utama
                                </h3>
                                {{-- Status Badge di Header Section --}}
                                <div class="flex items-center gap-2">
                                    <span class="text-xs font-medium text-gray-500">Status Saat Ini:</span>
                                    <span class="px-2 py-1 text-xs rounded-full font-bold {{ $event->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $event->is_active ? 'BUKA' : 'TUTUP' }}
                                    </span>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 gap-6">
                                {{-- Nama Acara --}}
                                <div>
                                    <x-input-label for="nama_acara" :value="__('Nama Acara')" class="text-gray-700" />
                                    <x-text-input id="nama_acara" class="block mt-1 w-full focus:ring-emerald-500 focus:border-emerald-500" type="text" name="nama_acara" :value="old('nama_acara', $event->nama_acara)" required autofocus />
                                    <x-input-error :messages="$errors->get('nama_acara')" class="mt-2" />
                                </div>

                                {{-- Banner dengan Preview --}}
                                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                    <x-input-label for="banner" :value="__('Banner Acara')" class="mb-2 text-gray-700" />
                                    
                                    <div class="flex flex-col md:flex-row gap-6 items-start">
                                        {{-- Preview Gambar Lama/Baru --}}
                                        <div class="flex-shrink-0 w-full md:w-1/3">
                                            @if($event->banner)
                                                <div class="relative group">
                                                    <img src="{{ asset('storage/' . $event->banner) }}" alt="Current Banner" class="w-full h-32 object-cover rounded-lg shadow-sm border border-gray-300">
                                                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 transition rounded-lg flex items-center justify-center">
                                                        <span class="text-white opacity-0 group-hover:opacity-100 font-bold text-xs bg-black bg-opacity-50 px-2 py-1 rounded">Banner Saat Ini</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="w-full h-32 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400 border border-gray-300 border-dashed">
                                                    No Banner
                                                </div>
                                            @endif
                                        </div>

                                        {{-- Input Upload --}}
                                        <div class="flex-grow w-full">
                                            <label class="block w-full">
                                                <span class="sr-only">Choose profile photo</span>
                                                <input type="file" name="banner" class="block w-full text-sm text-gray-500
                                                  file:mr-4 file:py-2 file:px-4
                                                  file:rounded-full file:border-0
                                                  file:text-sm file:font-semibold
                                                  file:bg-emerald-50 file:text-emerald-700
                                                  hover:file:bg-emerald-100
                                                  transition
                                                "/>
                                            </label>
                                            <p class="text-xs text-gray-500 mt-2">Upload file baru jika ingin mengganti banner lama. (JPG/PNG, Max 2MB).</p>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('banner')" class="mt-2" />
                                </div>

                                {{-- Status & Jenis (Grid) --}}
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div>
                                         <x-input-label for="is_active" :value="__('Status Pendaftaran')" class="text-gray-700" />
                                         <div class="relative mt-1">
                                             <select id="is_active" name="is_active" class="block w-full border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500 font-semibold appearance-none pl-3 pr-10">
                                                 <option value="1" {{ $event->is_active ? 'selected' : '' }} class="text-green-700">🟢 Buka (Pendaftaran Aktif)</option>
                                                 <option value="0" {{ !$event->is_active ? 'selected' : '' }} class="text-red-700">🔴 Tutup (Selesai/Penuh)</option>
                                             </select>
                                             {{-- Custom Chevron --}}
                                             <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                                              </div>
                                         </div>
                                         <p class="text-xs text-gray-500 mt-1">Jika ditutup, tombol daftar akan hilang dari halaman depan.</p>
                                    </div>

                                    <div>
                                        <x-input-label for="jenis_kaderisasi" :value="__('Jenis Kaderisasi')" class="text-gray-700" />
                                        <select id="jenis_kaderisasi" name="jenis_kaderisasi" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                                            <option value="MAKESTA" {{ $event->jenis_kaderisasi == 'MAKESTA' ? 'selected' : '' }}>MAKESTA</option>
                                            <option value="LAKMUD" {{ $event->jenis_kaderisasi == 'LAKMUD' ? 'selected' : '' }}>LAKMUD</option>
                                            <option value="LAKUT" {{ $event->jenis_kaderisasi == 'LATIN' ? 'selected' : '' }}>LATIN</option>
                                            <option value="LAKUT" {{ $event->jenis_kaderisasi == 'LATPEL' ? 'selected' : '' }}>LATPEL</option>
                                            <option value="NON-FORMAL" {{ $event->jenis_kaderisasi == 'NON-FORMAL' ? 'selected' : '' }}>Non-Formal</option>
                                        </select>
                                    </div>
                                </div>
                                
                                {{-- Lokasi --}}
                                <div>
                                    <x-input-label for="lokasi" :value="__('Lokasi Acara')" class="text-gray-700" />
                                    <x-text-input id="lokasi" class="block mt-1 w-full focus:ring-emerald-500 focus:border-emerald-500" type="text" name="lokasi" :value="old('lokasi', $event->lokasi)" required />
                                </div>
                            </div>
                        </div>

                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-emerald-800 border-b border-gray-200 pb-2 mb-4">
                                Waktu & Biaya
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                                    <x-text-input id="tanggal_mulai" class="block mt-1 w-full focus:ring-emerald-500 focus:border-emerald-500" type="datetime-local" name="tanggal_mulai" :value="old('tanggal_mulai', $event->tanggal_mulai->format('Y-m-d\TH:i'))" required />
                                </div>
                                <div>
                                    <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                                    <x-text-input id="tanggal_selesai" class="block mt-1 w-full focus:ring-emerald-500 focus:border-emerald-500" type="datetime-local" name="tanggal_selesai" :value="old('tanggal_selesai', $event->tanggal_selesai->format('Y-m-d\TH:i'))" required />
                                </div>
                                
                                <div>
                                    <x-input-label for="biaya" :value="__('Biaya Pendaftaran (Rp)')" />
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <x-text-input id="biaya" class="block w-full pl-10 focus:ring-emerald-500 focus:border-emerald-500" type="number" name="biaya" :value="old('biaya', $event->biaya)" required />
                                    </div>
                                </div>
                                <div>
                                    <x-input-label for="kuota" :value="__('Kuota Peserta')" />
                                    <x-text-input id="kuota" class="block mt-1 w-full focus:ring-emerald-500 focus:border-emerald-500" type="number" name="kuota" :value="old('kuota', $event->kuota)" required />
                                    <p class="text-xs text-gray-500 mt-1">0 = Tidak Terbatas.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            
                            <div class="bg-emerald-50/50 p-6 rounded-xl border border-emerald-100 h-fit">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <h3 class="text-sm font-bold text-emerald-800 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                                            Rekening Pembayaran
                                        </h3>
                                        <p class="text-xs text-emerald-600/80">Info transfer untuk peserta.</p>
                                    </div>
                                    <button type="button" onclick="addBankInput()" class="text-xs bg-white text-emerald-700 px-3 py-2 rounded-lg border border-emerald-200 shadow-sm hover:bg-emerald-100 font-bold transition">
                                        + Tambah
                                    </button>
                                </div>
                                
                                <div id="bank-wrapper" class="space-y-3">
                                    @if(!empty($event->info_pembayaran))
                                        @foreach($event->info_pembayaran as $bank)
                                        <div class="flex flex-col gap-2 bg-white p-3 rounded-md border border-emerald-100 shadow-sm relative group">
                                            <div class="grid grid-cols-2 gap-2">
                                                <input type="text" name="rek_provider[]" value="{{ $bank['provider'] }}" class="w-full text-xs rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Bank" required>
                                                <input type="text" name="rek_number[]" value="{{ $bank['number'] }}" class="w-full text-xs rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="No. Rekening" required>
                                            </div>
                                            <input type="text" name="rek_name[]" value="{{ $bank['owner'] }}" class="w-full text-xs rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Atas Nama" required>
                                            
                                            <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 bg-red-100 text-red-600 rounded-full p-1 shadow hover:bg-red-200 transition" title="Hapus">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                        @endforeach
                                    @else
                                        <p id="empty-bank-msg" class="text-xs text-gray-400 italic text-center py-4 border-2 border-dashed border-emerald-100 rounded-lg">Belum ada rekening diatur.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 h-fit">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                                            Syarat Dokumen
                                        </h3>
                                        <p class="text-xs text-gray-500">Berkas upload peserta.</p>
                                    </div>
                                    <button type="button" onclick="addDocInput()" class="text-xs bg-white text-emerald-700 px-3 py-2 rounded-lg border border-emerald-200 shadow-sm hover:bg-emerald-50 font-bold transition">
                                        + Tambah
                                    </button>
                                </div>

                                <div id="doc-wrapper" class="space-y-3">
                                    @if(!empty($event->config_dokumen))
                                        @foreach($event->config_dokumen as $doc)
                                        <div class="flex gap-2 items-start doc-row">
                                            <div class="flex-grow grid grid-cols-3 gap-2">
                                                <input type="text" name="dokumen_nama[]" value="{{ $doc['nama'] }}" class="col-span-2 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="Nama Dokumen" required>
                                                <select name="dokumen_wajib[]" class="rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                                                    <option value="1" {{ $doc['wajib'] ? 'selected' : '' }}>Wajib</option>
                                                    <option value="0" {{ !$doc['wajib'] ? 'selected' : '' }}>Opsional</option>
                                                </select>
                                            </div>
                                            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 p-2 hover:bg-red-50 rounded transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                            </button>
                                        </div>
                                        @endforeach
                                    @else
                                        <p id="empty-msg" class="text-xs text-gray-400 italic text-center py-4 border-2 border-dashed border-gray-200 rounded-lg">Belum ada persyaratan dokumen.</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end border-t border-gray-100 pt-6 mt-8 gap-4">
                            <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition">Batal</a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg">
                                {{ __('Update Acara') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- SCRIPT DOKUMEN ---
        function addDocInput() {
            const wrapper = document.getElementById('doc-wrapper');
            const emptyMsg = document.getElementById('empty-msg');
            if(emptyMsg) emptyMsg.style.display = 'none';

            const div = document.createElement('div');
            div.className = 'flex gap-2 items-start doc-row animate-fade-in-down';
            div.innerHTML = `
                <div class="flex-grow grid grid-cols-3 gap-2">
                    <input type="text" name="dokumen_nama[]" class="col-span-2 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="Nama Dokumen Baru" required>
                    <select name="dokumen_wajib[]" class="rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="1">Wajib</option>
                        <option value="0">Opsional</option>
                    </select>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 p-2 hover:bg-red-50 rounded transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            `;
            wrapper.appendChild(div);
        }

        // --- SCRIPT REKENING ---
        function addBankInput() {
            const wrapper = document.getElementById('bank-wrapper');
            const emptyMsg = document.getElementById('empty-bank-msg');
            if(emptyMsg) emptyMsg.style.display = 'none';

            const div = document.createElement('div');
            div.className = 'flex flex-col gap-2 bg-white p-3 rounded-md border border-emerald-100 shadow-sm animate-fade-in-down relative group';
            div.innerHTML = `
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="rek_provider[]" class="w-full text-xs rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Bank" required>
                    <input type="text" name="rek_number[]" class="w-full text-xs rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="No. Rekening" required>
                </div>
                <input type="text" name="rek_name[]" class="w-full text-xs rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Atas Nama" required>
                
                <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 bg-red-100 text-red-600 rounded-full p-1 shadow hover:bg-red-200 transition" title="Hapus">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            `;
            wrapper.appendChild(div);
        }
    </script>
    
    <style>
        .animate-fade-in-down {
            animation: fadeInDown 0.3s ease-out;
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</x-app-layout>