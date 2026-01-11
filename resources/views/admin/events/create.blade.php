<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Acara Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="nama_acara" :value="__('Nama Acara')" />
                        <x-text-input id="nama_acara" class="block mt-1 w-full" type="text" name="nama_acara" :value="old('nama_acara')" required autofocus placeholder="Contoh: MAKESTA RAYA PAC SUKARAJA" />
                        <x-input-error :messages="$errors->get('nama_acara')" class="mt-2" />
                    </div>

                    <div class="mb-4">
        <x-input-label for="banner" :value="__('Banner Acara (Opsional)')" />
        <input type="file" name="banner" id="banner" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-1 shadow-sm border border-gray-300 rounded-md">
        <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG. Rasio disarankan 16:9.</p>
        <x-input-error :messages="$errors->get('banner')" class="mt-2" />
    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="jenis_kaderisasi" :value="__('Jenis Kaderisasi')" />
                            <select id="jenis_kaderisasi" name="jenis_kaderisasi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="MAKESTA">MAKESTA (Masa Kesetiaan Anggota)</option>
                                <option value="LAKMUD">LAKMUD (Latihan Kader Muda)</option>
                                <option value="LAKUT">LAKUT (Latihan Kader Utama)</option>
                                <option value="NON-FORMAL">Non-Formal (Upgrading/Seminar)</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="lokasi" :value="__('Lokasi Acara')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi')" required placeholder="Contoh: SMK Maarif NU 1" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                            <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="datetime-local" name="tanggal_mulai" :value="old('tanggal_mulai')" required />
                        </div>
                        <div>
                            <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                            <x-text-input id="tanggal_selesai" class="block mt-1 w-full" type="datetime-local" name="tanggal_selesai" :value="old('tanggal_selesai')" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <x-input-label for="biaya" :value="__('Biaya Pendaftaran (Rp)')" />
                            <x-text-input id="biaya" class="block mt-1 w-full" type="number" name="biaya" :value="old('biaya', 0)" required />
                            <p class="text-xs text-gray-500 mt-1">Isi 0 jika Gratis.</p>
                        </div>
                        <div>
                            <x-input-label for="kuota" :value="__('Kuota Peserta')" />
                            <x-text-input id="kuota" class="block mt-1 w-full" type="number" name="kuota" :value="old('kuota', 0)" required />
                            <p class="text-xs text-gray-500 mt-1">Isi 0 jika tidak terbatas.</p>
                        </div>
                    </div>

                    <div class="mb-6 bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-sm font-bold text-yellow-800">Rekening Pembayaran</h3>
                                <p class="text-xs text-yellow-600">Info ini akan muncul di biodata peserta jika biaya > 0.</p>
                            </div>
                            <button type="button" onclick="addBankInput()" class="text-xs bg-white text-yellow-700 px-3 py-2 rounded border border-yellow-300 shadow-sm hover:bg-yellow-100 font-bold">
                                + Tambah Rekening
                            </button>
                        </div>
                        
                        <div id="bank-wrapper" class="space-y-2">
                            <p id="empty-bank-msg" class="text-xs text-gray-400 italic">Belum ada rekening diatur.</p>
                        </div>
                    </div>
                    <div class="mt-8 border-t pt-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Persyaratan Dokumen Upload</h3>
                                <p class="text-sm text-gray-500">Apa saja berkas yang wajib diupload peserta?</p>
                            </div>
                            <button type="button" onclick="addDocInput()" class="text-sm bg-indigo-50 text-indigo-700 px-3 py-2 rounded-md font-bold hover:bg-indigo-100 border border-indigo-200">
                                + Tambah Dokumen
                            </button>
                        </div>

                        <div id="doc-wrapper" class="space-y-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            <p id="empty-msg" class="text-sm text-gray-400 text-center italic py-2">Belum ada persyaratan dokumen.</p>
                        </div>
                    </div>

                    <div class="flex items-center justify-end border-t pt-6">
                        <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                        <x-primary-button>
                            {{ __('Simpan Acara') }}
                        </x-primary-button>
                    </div>

                </form>
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
            div.className = 'flex gap-2 items-center doc-row animate-pulse'; 
            
            div.innerHTML = `
                <div class="flex-grow grid grid-cols-3 gap-2">
                    <input type="text" name="dokumen_nama[]" class="col-span-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Nama Dokumen (Misal: Sertifikat Makesta)" required>
                    <select name="dokumen_wajib[]" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="1">Wajib</option>
                        <option value="0">Opsional</option>
                    </select>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="bg-red-100 text-red-600 p-2 rounded hover:bg-red-200 transition" title="Hapus Baris">
                    &times;
                </button>
            `;
            
            wrapper.appendChild(div);
            setTimeout(() => div.classList.remove('animate-pulse'), 500);
        }

        // --- SCRIPT INPUT REKENING (BARU) ---
        function addBankInput() {
            const wrapper = document.getElementById('bank-wrapper');
            const emptyMsg = document.getElementById('empty-bank-msg');
            
            if(emptyMsg) emptyMsg.style.display = 'none';

            const div = document.createElement('div');
            div.className = 'grid grid-cols-7 gap-2 items-center mb-2 animate-pulse'; 
            
            div.innerHTML = `
                <div class="col-span-2">
                    <input type="text" name="rek_provider[]" class="w-full text-xs rounded-md border-gray-300 focus:border-yellow-500 focus:ring-yellow-500" placeholder="Bank/E-Wallet (Misal: BRI)" required>
                </div>
                <div class="col-span-2">
                    <input type="text" name="rek_number[]" class="w-full text-xs rounded-md border-gray-300 focus:border-yellow-500 focus:ring-yellow-500" placeholder="No. Rekening" required>
                </div>
                <div class="col-span-2">
                    <input type="text" name="rek_name[]" class="w-full text-xs rounded-md border-gray-300 focus:border-yellow-500 focus:ring-yellow-500" placeholder="Atas Nama" required>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="bg-red-100 text-red-600 p-1.5 rounded hover:bg-red-200 text-center" title="Hapus">
                    &times;
                </button>
            `;
            wrapper.appendChild(div);
            setTimeout(() => div.classList.remove('animate-pulse'), 500);
        }
    </script>
</x-app-layout>