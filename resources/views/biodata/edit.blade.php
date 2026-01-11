<x-app-layout>
    {{-- CSS KHUSUS: RESET TAMPILAN FULL SCREEN HP --}}
    <style>
        aside, header, nav, .fixed.inset-0.bg-black { display: none !important; }
        main { padding: 0 !important; }
        body { background-color: #f3f4f6; }
    </style>

    <div class="min-h-screen w-full md:max-w-md mx-auto bg-gray-50 md:shadow-2xl overflow-hidden relative pb-20 md:border-x border-gray-200">
        
        <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 px-5 pt-8 pb-16 text-white shadow-lg relative z-10 rounded-b-[2.5rem]">
             <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10 blur-xl"></div>
             
             <div class="flex items-center relative z-20 mt-4">
                <a href="{{ route('dashboard') }}" class="mr-4 p-2 bg-white/20 backdrop-blur-md rounded-full hover:bg-white/30 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                
                <div>
                    <h1 class="text-xl font-bold leading-tight">Edit Biodata</h1>
                    <p class="text-xs text-emerald-100">Lengkapi data diri Anda dengan benar.</p>
                </div>
            </div>
        </div>

        <div class="px-5 -mt-10 relative z-20">
            
            @if(session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-xl shadow-sm flex items-start animate-fade-in-down">
                    <svg class="w-5 h-5 text-green-500 mr-2 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span class="text-sm text-green-700 font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('biodata.update') }}" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 space-y-5">
                @csrf

                <div>
                    <h3 class="text-emerald-700 font-bold text-sm uppercase tracking-wide border-b border-gray-100 pb-2 mb-4">Data Diri</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" class="text-xs text-gray-500 uppercase font-bold" />
                            <x-text-input id="nama_lengkap" class="block mt-1 w-full rounded-xl border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50" type="text" name="nama_lengkap" :value="old('nama_lengkap', $profile->nama_lengkap ?? Auth::user()->name)" required />
                            <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-1" />
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" class="text-xs text-gray-500 uppercase font-bold" />
                                <x-text-input id="tempat_lahir" class="block mt-1 w-full rounded-xl border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50" type="text" name="tempat_lahir" :value="old('tempat_lahir', $profile->tempat_lahir ?? '')" required />
                            </div>
                            <div>
                                <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" class="text-xs text-gray-500 uppercase font-bold" />
                                <x-text-input id="tanggal_lahir" class="block mt-1 w-full rounded-xl border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $profile->tanggal_lahir ?? '')" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <h3 class="text-emerald-700 font-bold text-sm uppercase tracking-wide border-b border-gray-100 pb-2 mb-4">Domisili</h3>
                    
                    <div class="space-y-4">
                        <div>
                            <x-input-label for="alamat" :value="__('Jalan / Dusun')" class="text-xs text-gray-500 uppercase font-bold" />
                            <textarea id="alamat" name="alamat" class="block mt-1 w-full rounded-xl border-gray-300 focus:ring-emerald-500 focus:border-emerald-500 bg-gray-50 shadow-sm text-sm" rows="2" required>{{ old('alamat', $profile->alamat ?? '') }}</textarea>
                        </div>

                        <div class="grid grid-cols-4 gap-3">
                            <div class="col-span-1">
                                <x-input-label for="rt" :value="__('RT')" class="text-xs text-gray-500 uppercase font-bold" />
                                <x-text-input id="rt" class="block mt-1 w-full rounded-xl border-gray-300 focus:ring-emerald-500 bg-gray-50 text-center" type="text" name="rt" :value="old('rt', $profile->rt ?? '')" required />
                            </div>
                            <div class="col-span-1">
                                <x-input-label for="rw" :value="__('RW')" class="text-xs text-gray-500 uppercase font-bold" />
                                <x-text-input id="rw" class="block mt-1 w-full rounded-xl border-gray-300 focus:ring-emerald-500 bg-gray-50 text-center" type="text" name="rw" :value="old('rw', $profile->rw ?? '')" required />
                            </div>
                            <div class="col-span-2">
                                <x-input-label for="desa" :value="__('Desa/Kel')" class="text-xs text-gray-500 uppercase font-bold" />
                                <x-text-input id="desa" class="block mt-1 w-full rounded-xl border-gray-300 focus:ring-emerald-500 bg-gray-50" type="text" name="desa" :value="old('desa', $profile->desa ?? '')" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <x-input-label for="kecamatan" :value="__('Kecamatan')" class="text-xs text-gray-500 uppercase font-bold" />
                                <x-text-input id="kecamatan" class="block mt-1 w-full rounded-xl border-gray-300 focus:ring-emerald-500 bg-gray-50" type="text" name="kecamatan" :value="old('kecamatan', $profile->kecamatan ?? '')" required />
                            </div>
                            <div>
                                <x-input-label for="kabupaten" :value="__('Kabupaten')" class="text-xs text-gray-500 uppercase font-bold" />
                                <x-text-input id="kabupaten" class="block mt-1 w-full rounded-xl border-gray-300 focus:ring-emerald-500 bg-gray-50" type="text" name="kabupaten" :value="old('kabupaten', $profile->kabupaten ?? '')" required />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="pt-2">
                    <h3 class="text-emerald-700 font-bold text-sm uppercase tracking-wide border-b border-gray-100 pb-2 mb-4">Keanggotaan</h3>
                    
                    <div>
                        <x-input-label for="asal_delegasi" :value="__('Asal Delegasi (PR/PK/PAC)')" class="text-xs text-gray-500 uppercase font-bold" />
                        <x-text-input id="asal_delegasi" class="block mt-1 w-full rounded-xl border-gray-300 focus:ring-emerald-500 bg-gray-50" type="text" name="asal_delegasi" :value="old('asal_delegasi', $profile->asal_delegasi ?? '')" placeholder="Contoh: PR IPNU Desa Sukamaju" required />
                        <p class="text-[10px] text-gray-400 mt-1">*Pastikan nama delegasi sesuai surat mandat.</p>
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" class="w-full py-3.5 bg-emerald-600 text-white rounded-xl font-bold shadow-lg shadow-emerald-200 hover:bg-emerald-700 active:scale-95 transition-all flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Perubahan
                    </button>
                    <a href="{{ route('dashboard') }}" class="block text-center mt-4 text-sm text-gray-500 font-medium hover:text-emerald-600">Batal</a>
                </div>

            </form>
            
            <div class="h-10"></div>
        </div>

    </div>
</x-app-layout>