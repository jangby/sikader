<x-guest-layout>
    <div class="mb-8 text-center border-b pb-4">
        <h2 class="text-2xl font-bold text-gray-900">Lengkapi Biodata</h2>
        <p class="text-sm text-gray-500 mt-1">Langkah Terakhir: {{ $event->nama_acara }}</p>
    </div>

    <form method="POST" action="{{ route('events.process_biodata', $event->id) }}" enctype="multipart/form-data">
        @csrf

        <h3 class="text-md font-bold text-emerald-700 uppercase mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Data Pribadi
        </h3>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                <select name="jenis_kelamin" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required>
                    <option value="">- Pilih -</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>
            <div>
                <x-input-label for="asal_delegasi" value="Asal Delegasi" />
                <x-text-input id="asal_delegasi" class="block mt-1 w-full" type="text" name="asal_delegasi" placeholder="Contoh: PR IPNU Desa..." required />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" required />
            </div>
            <div>
                <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" required />
            </div>
        </div>

        <h3 class="text-md font-bold text-emerald-700 uppercase mb-4 mt-8 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            Alamat Domisili
        </h3>

        <div class="mb-4">
            <x-input-label for="alamat" value="Jalan / Dusun / Blok" />
            <textarea name="alamat" rows="2" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500" required></textarea>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <x-input-label for="rt" value="RT" />
                <x-text-input id="rt" class="block mt-1 w-full" type="text" name="rt" required />
            </div>
            <div>
                <x-input-label for="rw" value="RW" />
                <x-text-input id="rw" class="block mt-1 w-full" type="text" name="rw" required />
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
            <div>
                <x-input-label for="desa" value="Desa/Kelurahan" />
                <x-text-input id="desa" class="block mt-1 w-full" type="text" name="desa" required />
            </div>
            <div>
                <x-input-label for="kecamatan" value="Kecamatan" />
                <x-text-input id="kecamatan" class="block mt-1 w-full" type="text" name="kecamatan" required />
            </div>
            <div>
                <x-input-label for="kabupaten" value="Kabupaten/Kota" />
                <x-text-input id="kabupaten" class="block mt-1 w-full" type="text" name="kabupaten" required />
            </div>
        </div>

        <h3 class="text-md font-bold text-emerald-700 uppercase mb-4 mt-8 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
            Kelengkapan Acara
        </h3>

        <div class="mb-6">
            <x-input-label for="ukuran_baju" value="Ukuran Kaos/PDH" />
            <select name="ukuran_baju" class="block mt-1 w-full border-gray-300 rounded-md shadow-sm focus:border-emerald-500 focus:ring-emerald-500 font-bold" required>
                <option value="">- Pilih Ukuran -</option>
                <option value="S">S (Small)</option>
                <option value="M">M (Medium)</option>
                <option value="L">L (Large)</option>
                <option value="XL">XL (Extra Large)</option>
                <option value="XXL">XXL (Double Extra Large)</option>
                <option value="XXXL">XXXL (Jumbo)</option>
            </select>
            <p class="text-xs text-gray-500 mt-1">Pastikan ukuran sesuai, tidak bisa ditukar.</p>
        </div>

        @if(!empty($event->config_dokumen))
            <h3 class="text-md font-bold text-emerald-700 uppercase mb-4 mt-8 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                Upload Berkas
            </h3>
            
            <div class="space-y-4 bg-gray-50 p-4 rounded-lg border border-gray-200">
                @foreach($event->config_dokumen as $index => $doc)
                    <div>
                        <label class="block font-medium text-sm text-gray-700 mb-1">
                            {{ $doc['nama'] }} 
                            @if($doc['wajib']) <span class="text-red-500">*</span> @else <span class="text-gray-400 text-xs">(Opsional)</span> @endif
                        </label>
                        
                        <input type="file" 
                               name="dokumen[{{ $index }}]" 
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                               accept=".jpg,.jpeg,.png,.pdf"
                               {{ $doc['wajib'] ? 'required' : '' }}
                        >
                        <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG/PDF. Max: 5MB.</p>
                        <x-input-error :messages="$errors->get('dokumen.'.$index)" class="mt-2" />
                    </div>
                @endforeach
            </div>
        @endif

        @if($event->biaya > 0)
            <h3 class="text-md font-bold text-emerald-700 uppercase mb-4 mt-8 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Pembayaran Pendaftaran
            </h3>

            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
                <p class="text-sm text-yellow-800 font-bold mb-2">Biaya Pendaftaran: Rp {{ number_format($event->biaya, 0, ',', '.') }}</p>
                <p class="text-sm text-gray-600 mb-3">Silakan transfer ke salah satu rekening berikut:</p>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                    @if(!empty($event->info_pembayaran))
                        @foreach($event->info_pembayaran as $bank)
                            <div class="bg-white p-3 rounded border shadow-sm">
                                <p class="font-bold text-gray-800">{{ $bank['provider'] }}</p>
                                <p class="text-lg text-emerald-600 font-mono font-bold">{{ $bank['number'] }}</p>
                                <p class="text-xs text-gray-500 uppercase">A.N {{ $bank['owner'] }}</p>
                            </div>
                        @endforeach
                    @else
                        <div class="col-span-2 bg-red-50 p-3 rounded text-red-500 text-sm italic">
                            Informasi rekening belum diatur oleh panitia. Silakan hubungi panitia.
                        </div>
                    @endif
                </div>

                <div class="mt-4 border-t border-yellow-200 pt-4">
                    <x-input-label for="bukti_pembayaran" value="Upload Bukti Transfer" />
                    <input type="file" 
                           name="bukti_pembayaran" 
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100"
                           accept=".jpg,.jpeg,.png,.pdf"
                           required
                    >
                    <p class="text-xs text-gray-500 mt-1">Format: JPG/PNG/PDF. Pastikan nominal & tanggal terlihat jelas.</p>
                    <x-input-error :messages="$errors->get('bukti_pembayaran')" class="mt-2" />
                </div>
            </div>
        @endif
        <div class="flex items-center justify-end mt-8">
            <x-primary-button class="w-full justify-center py-3 text-lg bg-emerald-600 hover:bg-emerald-700">
                {{ __('Kirim Pendaftaran') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>