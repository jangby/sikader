<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-2">
            <a href="{{ route('admin.events.index') }}" class="text-gray-400 hover:text-emerald-600 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h2 class="font-bold text-2xl text-emerald-900 leading-tight">
                {{ __('Buat Acara Baru') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-xl border border-gray-100">
                
                <div class="p-8">
                    <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-emerald-800 border-b border-gray-200 pb-2 mb-4">
                                Informasi Utama
                            </h3>

                            <div class="grid grid-cols-1 gap-6">
                                {{-- Nama Acara --}}
                                <div>
                                    <x-input-label for="nama_acara" :value="__('Nama Acara')" class="text-gray-700" />
                                    <x-text-input id="nama_acara" 
                                                  class="block mt-1 w-full focus:ring-emerald-500 focus:border-emerald-500" 
                                                  type="text" 
                                                  name="nama_acara" 
                                                  :value="old('nama_acara')" 
                                                  required autofocus 
                                                  placeholder="Contoh: MAKESTA RAYA PAC SUKARAJA" />
                                    <x-input-error :messages="$errors->get('nama_acara')" class="mt-2" />
                                </div>

                                {{-- Banner --}}
                                <div>
                                    <x-input-label for="banner" :value="__('Banner Acara (Opsional)')" class="text-gray-700" />
                                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md hover:border-emerald-400 transition bg-gray-50">
                                        <div class="space-y-1 text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <div class="flex text-sm text-gray-600 justify-center">
                                                <label for="banner" class="relative cursor-pointer bg-white rounded-md font-medium text-emerald-600 hover:text-emerald-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-emerald-500">
                                                    <span>Upload Banner</span>
                                                    <input id="banner" name="banner" type="file" class="sr-only">
                                                </label>
                                                <p class="pl-1">atau drag and drop</p>
                                            </div>
                                            <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB (Rasio 16:9)</p>
                                        </div>
                                    </div>
                                    <x-input-error :messages="$errors->get('banner')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                {{-- Jenis Kaderisasi --}}
                                <div>
                                    <x-input-label for="jenis_kaderisasi" :value="__('Jenis Kaderisasi')" class="text-gray-700" />
                                    <select id="jenis_kaderisasi" name="jenis_kaderisasi" class="block mt-1 w-full border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 rounded-md shadow-sm">
                                        <option value="MAKESTA">MAKESTA (Masa Kesetiaan Anggota)</option>
                                        <option value="LAKMUD">LAKMUD (Latihan Kader Muda)</option>
                                        <option value="LAKUT">LATIN (Latihan Instruktur)</option>
                                        <option value="LAKUT">LATPEL (Latihan Pelatih)</option>
                                        <option value="NON-FORMAL">Non-Formal (Upgrading/Seminar)</option>
                                    </select>
                                </div>
                                {{-- Lokasi --}}
                                <div>
                                    <x-input-label for="lokasi" :value="__('Lokasi Acara')" class="text-gray-700" />
                                    <x-text-input id="lokasi" class="block mt-1 w-full focus:ring-emerald-500 focus:border-emerald-500" type="text" name="lokasi" :value="old('lokasi')" required placeholder="Contoh: SMK Maarif NU 1" />
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
                                    <x-text-input id="tanggal_mulai" class="block mt-1 w-full focus:ring-emerald-500 focus:border-emerald-500" type="datetime-local" name="tanggal_mulai" :value="old('tanggal_mulai')" required />
                                </div>
                                <div>
                                    <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                                    <x-text-input id="tanggal_selesai" class="block mt-1 w-full focus:ring-emerald-500 focus:border-emerald-500" type="datetime-local" name="tanggal_selesai" :value="old('tanggal_selesai')" required />
                                </div>
                                
                                <div>
                                    <x-input-label for="biaya" :value="__('Biaya Pendaftaran (Rp)')" />
                                    <div class="relative mt-1">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">Rp</span>
                                        </div>
                                        <x-text-input id="biaya" class="block w-full pl-10 focus:ring-emerald-500 focus:border-emerald-500" type="number" name="biaya" :value="old('biaya', 0)" required />
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Isi 0 jika Gratis.</p>
                                </div>
                                <div>
                                    <x-input-label for="kuota" :value="__('Kuota Peserta')" />
                                    <x-text-input id="kuota" class="block mt-1 w-full focus:ring-emerald-500 focus:border-emerald-500" type="number" name="kuota" :value="old('kuota', 0)" required />
                                    <p class="text-xs text-gray-500 mt-1">Isi 0 jika tidak terbatas.</p>
                                </div>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                            
                            <div class="bg-emerald-50/50 p-6 rounded-xl border border-emerald-100 h-fit">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <h3 class="text-sm font-bold text-emerald-800 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                            </svg>
                                            Rekening Pembayaran
                                        </h3>
                                        <p class="text-xs text-emerald-600/80">Info ini muncul jika biaya > 0.</p>
                                    </div>
                                    <button type="button" onclick="addBankInput()" class="text-xs bg-white text-emerald-700 px-3 py-2 rounded-lg border border-emerald-200 shadow-sm hover:bg-emerald-100 hover:border-emerald-300 font-bold transition">
                                        + Tambah
                                    </button>
                                </div>
                                
                                <div id="bank-wrapper" class="space-y-3">
                                    <p id="empty-bank-msg" class="text-xs text-gray-400 italic text-center py-4 border-2 border-dashed border-emerald-100 rounded-lg">Belum ada rekening diatur.</p>
                                </div>
                            </div>

                            <div class="bg-gray-50 p-6 rounded-xl border border-gray-200 h-fit">
                                <div class="flex justify-between items-center mb-4">
                                    <div>
                                        <h3 class="text-sm font-bold text-gray-800 flex items-center gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            Syarat Dokumen
                                        </h3>
                                        <p class="text-xs text-gray-500">Berkas yang wajib diupload peserta.</p>
                                    </div>
                                    <button type="button" onclick="addDocInput()" class="text-xs bg-white text-emerald-700 px-3 py-2 rounded-lg border border-emerald-200 shadow-sm hover:bg-emerald-50 font-bold transition">
                                        + Tambah
                                    </button>
                                </div>

                                <div id="doc-wrapper" class="space-y-3">
                                    <p id="empty-msg" class="text-xs text-gray-400 italic text-center py-4 border-2 border-dashed border-gray-200 rounded-lg">Belum ada persyaratan dokumen.</p>
                                </div>
                            </div>

                        </div>

                        <div class="flex items-center justify-end border-t border-gray-100 pt-6 mt-8 gap-4">
                            <a href="{{ route('admin.events.index') }}" class="text-sm text-gray-500 hover:text-gray-700 font-medium transition">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-6 py-3 bg-emerald-600 border border-transparent rounded-lg font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 focus:bg-emerald-700 active:bg-emerald-900 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg">
                                {{ __('Simpan Acara') }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- SCRIPT INPUT DOKUMEN ---
        function addDocInput() {
            const wrapper = document.getElementById('doc-wrapper');
            const emptyMsg = document.getElementById('empty-msg');
            
            if(emptyMsg) emptyMsg.style.display = 'none';

            const div = document.createElement('div');
            div.className = 'flex gap-2 items-start doc-row animate-fade-in-down'; 
            
            // Perbaikan: Styling input menggunakan border emerald saat focus
            div.innerHTML = `
                <div class="flex-grow grid grid-cols-3 gap-2">
                    <input type="text" name="dokumen_nama[]" class="col-span-2 rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm" placeholder="Nama Dokumen (Misal: KTP)" required>
                    <select name="dokumen_wajib[]" class="rounded-md border-gray-300 shadow-sm focus:border-emerald-500 focus:ring-emerald-500 text-sm">
                        <option value="1">Wajib</option>
                        <option value="0">Opsional</option>
                    </select>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700 p-2 hover:bg-red-50 rounded transition" title="Hapus Baris">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            `;
            
            wrapper.appendChild(div);
        }

        // --- SCRIPT INPUT REKENING ---
        function addBankInput() {
            const wrapper = document.getElementById('bank-wrapper');
            const emptyMsg = document.getElementById('empty-bank-msg');
            
            if(emptyMsg) emptyMsg.style.display = 'none';

            const div = document.createElement('div');
            div.className = 'flex flex-col gap-2 bg-white p-3 rounded-md border border-emerald-100 shadow-sm animate-fade-in-down relative group'; 
            
            // Perbaikan: Styling input agar senada dengan emerald
            div.innerHTML = `
                <div class="grid grid-cols-2 gap-2">
                    <input type="text" name="rek_provider[]" class="w-full text-xs rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Bank/E-Wallet (Misal: DANA)" required>
                    <input type="text" name="rek_number[]" class="w-full text-xs rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="No. Rekening" required>
                </div>
                <input type="text" name="rek_name[]" class="w-full text-xs rounded-md border-gray-300 focus:border-emerald-500 focus:ring-emerald-500" placeholder="Atas Nama" required>
                
                <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 bg-red-100 text-red-600 rounded-full p-1 shadow hover:bg-red-200 transition opacity-0 group-hover:opacity-100" title="Hapus">
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
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</x-app-layout>