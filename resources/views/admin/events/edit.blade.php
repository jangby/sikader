<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Acara') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('admin.events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <x-input-label for="nama_acara" :value="__('Nama Acara')" />
                        <x-text-input id="nama_acara" class="block mt-1 w-full" type="text" name="nama_acara" :value="old('nama_acara', $event->nama_acara)" required autofocus />
                        <x-input-error :messages="$errors->get('nama_acara')" class="mt-2" />
                    </div>

                    <div class="mb-4">
        <x-input-label for="banner" :value="__('Banner Acara')" />
        
        @if($event->banner)
            <div class="mb-2">
                <img src="{{ asset('storage/' . $event->banner) }}" alt="Current Banner" class="h-32 w-auto rounded-lg shadow-sm object-cover">
            </div>
        @endif

        <input type="file" name="banner" id="banner" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 mt-1 shadow-sm border border-gray-300 rounded-md">
        <p class="text-xs text-gray-500 mt-1">Upload baru untuk mengganti banner lama.</p>
        <x-input-error :messages="$errors->get('banner')" class="mt-2" />
    </div>

                    <div class="mb-4">
                         <x-input-label for="is_active" :value="__('Status Pendaftaran')" />
                         <select id="is_active" name="is_active" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-bold {{ $event->is_active ? 'text-green-700 bg-green-50' : 'text-red-700 bg-red-50' }}">
                             <option value="1" {{ $event->is_active ? 'selected' : '' }}>🟢 Buka (Aktif)</option>
                             <option value="0" {{ !$event->is_active ? 'selected' : '' }}>🔴 Tutup (Selesai/Penuh)</option>
                         </select>
                         <p class="text-xs text-gray-500 mt-1">Jika ditutup, acara tidak akan muncul di halaman depan website.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="jenis_kaderisasi" :value="__('Jenis Kaderisasi')" />
                            <select id="jenis_kaderisasi" name="jenis_kaderisasi" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="MAKESTA" {{ $event->jenis_kaderisasi == 'MAKESTA' ? 'selected' : '' }}>MAKESTA</option>
                                <option value="LAKMUD" {{ $event->jenis_kaderisasi == 'LAKMUD' ? 'selected' : '' }}>LAKMUD</option>
                                <option value="LAKUT" {{ $event->jenis_kaderisasi == 'LAKUT' ? 'selected' : '' }}>LAKUT</option>
                                <option value="NON-FORMAL" {{ $event->jenis_kaderisasi == 'NON-FORMAL' ? 'selected' : '' }}>Non-Formal</option>
                            </select>
                        </div>
                        <div>
                            <x-input-label for="lokasi" :value="__('Lokasi Acara')" />
                            <x-text-input id="lokasi" class="block mt-1 w-full" type="text" name="lokasi" :value="old('lokasi', $event->lokasi)" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="tanggal_mulai" :value="__('Tanggal Mulai')" />
                            <x-text-input id="tanggal_mulai" class="block mt-1 w-full" type="datetime-local" name="tanggal_mulai" :value="old('tanggal_mulai', $event->tanggal_mulai->format('Y-m-d\TH:i'))" required />
                        </div>
                        <div>
                            <x-input-label for="tanggal_selesai" :value="__('Tanggal Selesai')" />
                            <x-text-input id="tanggal_selesai" class="block mt-1 w-full" type="datetime-local" name="tanggal_selesai" :value="old('tanggal_selesai', $event->tanggal_selesai->format('Y-m-d\TH:i'))" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <x-input-label for="biaya" :value="__('Biaya Pendaftaran (Rp)')" />
                            <x-text-input id="biaya" class="block mt-1 w-full" type="number" name="biaya" :value="old('biaya', $event->biaya)" required />
                        </div>
                        <div>
                            <x-input-label for="kuota" :value="__('Kuota Peserta')" />
                            <x-text-input id="kuota" class="block mt-1 w-full" type="number" name="kuota" :value="old('kuota', $event->kuota)" required />
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
                            @if(!empty($event->info_pembayaran))
                                @foreach($event->info_pembayaran as $bank)
                                <div class="grid grid-cols-7 gap-2 items-center mb-2 bank-row">
                                    <div class="col-span-2">
                                        <input type="text" name="rek_provider[]" value="{{ $bank['provider'] }}" class="w-full text-xs rounded-md border-gray-300 focus:border-yellow-500 focus:ring-yellow-500" placeholder="Bank (Misal: BRI)" required>
                                    </div>
                                    <div class="col-span-2">
                                        <input type="text" name="rek_number[]" value="{{ $bank['number'] }}" class="w-full text-xs rounded-md border-gray-300 focus:border-yellow-500 focus:ring-yellow-500" placeholder="No. Rekening" required>
                                    </div>
                                    <div class="col-span-2">
                                        <input type="text" name="rek_name[]" value="{{ $bank['owner'] }}" class="w-full text-xs rounded-md border-gray-300 focus:border-yellow-500 focus:ring-yellow-500" placeholder="Atas Nama" required>
                                    </div>
                                    <button type="button" onclick="this.parentElement.remove()" class="bg-red-100 text-red-600 p-1.5 rounded hover:bg-red-200 text-center" title="Hapus">
                                        &times;
                                    </button>
                                </div>
                                @endforeach
                            @else
                                <p id="empty-bank-msg" class="text-xs text-gray-400 italic">Belum ada rekening diatur.</p>
                            @endif
                        </div>
                    </div>
                    <div class="mt-8 border-t pt-6 mb-6">
                        <div class="flex justify-between items-center mb-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-800">Persyaratan Dokumen Upload</h3>
                                <p class="text-sm text-gray-500">Edit atau tambah dokumen yang wajib diupload peserta.</p>
                            </div>
                            <button type="button" onclick="addDocInput()" class="text-sm bg-indigo-50 text-indigo-700 px-3 py-2 rounded-md font-bold hover:bg-indigo-100 border border-indigo-200">
                                + Tambah Dokumen
                            </button>
                        </div>

                        <div id="doc-wrapper" class="space-y-3 bg-gray-50 p-4 rounded-lg border border-gray-200">
                            
                            @if(!empty($event->config_dokumen))
                                @foreach($event->config_dokumen as $doc)
                                <div class="flex gap-2 items-center doc-row">
                                    <div class="flex-grow grid grid-cols-3 gap-2">
                                        <input type="text" name="dokumen_nama[]" value="{{ $doc['nama'] }}" class="col-span-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Nama Dokumen" required>
                                        <select name="dokumen_wajib[]" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            <option value="1" {{ $doc['wajib'] ? 'selected' : '' }}>Wajib</option>
                                            <option value="0" {{ !$doc['wajib'] ? 'selected' : '' }}>Opsional</option>
                                        </select>
                                    </div>
                                    <button type="button" onclick="this.parentElement.remove()" class="bg-red-100 text-red-600 p-2 rounded hover:bg-red-200 transition">
                                        &times;
                                    </button>
                                </div>
                                @endforeach
                            @else
                                <p id="empty-msg" class="text-sm text-gray-400 text-center italic py-2">Belum ada persyaratan dokumen.</p>
                            @endif

                        </div>
                    </div>

                    <div class="flex items-center justify-end border-t pt-6">
                        <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-900 mr-4">Batal</a>
                        <x-primary-button>
                            {{ __('Update Acara') }}
                        </x-primary-button>
                    </div>

                </form>
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
            div.className = 'flex gap-2 items-center doc-row mt-2 animate-pulse';
            div.innerHTML = `
                <div class="flex-grow grid grid-cols-3 gap-2">
                    <input type="text" name="dokumen_nama[]" class="col-span-2 rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm" placeholder="Nama Dokumen Baru" required>
                    <select name="dokumen_wajib[]" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                        <option value="1">Wajib</option>
                        <option value="0">Opsional</option>
                    </select>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="bg-red-100 text-red-600 p-2 rounded hover:bg-red-200 transition">
                    &times;
                </button>
            `;
            wrapper.appendChild(div);
            setTimeout(() => div.classList.remove('animate-pulse'), 500);
        }

        // --- SCRIPT REKENING (BARU) ---
        function addBankInput() {
            const wrapper = document.getElementById('bank-wrapper');
            const emptyMsg = document.getElementById('empty-bank-msg');
            
            if(emptyMsg) emptyMsg.style.display = 'none';

            const div = document.createElement('div');
            div.className = 'grid grid-cols-7 gap-2 items-center mb-2 animate-pulse'; 
            
            div.innerHTML = `
                <div class="col-span-2">
                    <input type="text" name="rek_provider[]" class="w-full text-xs rounded-md border-gray-300 focus:border-yellow-500 focus:ring-yellow-500" placeholder="Bank (Misal: BRI)" required>
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