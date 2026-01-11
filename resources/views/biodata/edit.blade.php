<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Lengkapi Biodata Kader') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Berhasil!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('biodata.update') }}">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="nama_lengkap" :value="__('Nama Lengkap')" />
                        <x-text-input id="nama_lengkap" class="block mt-1 w-full" type="text" name="nama_lengkap" :value="old('nama_lengkap', $profile->nama_lengkap ?? Auth::user()->name)" required autofocus />
                        <x-input-error :messages="$errors->get('nama_lengkap')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="tempat_lahir" :value="__('Tempat Lahir')" />
                            <x-text-input id="tempat_lahir" class="block mt-1 w-full" type="text" name="tempat_lahir" :value="old('tempat_lahir', $profile->tempat_lahir ?? '')" required />
                        </div>
                        <div>
                            <x-input-label for="tanggal_lahir" :value="__('Tanggal Lahir')" />
                            <x-text-input id="tanggal_lahir" class="block mt-1 w-full" type="date" name="tanggal_lahir" :value="old('tanggal_lahir', $profile->tanggal_lahir ?? '')" required />
                        </div>
                    </div>

                    <div class="mb-4">
                        <x-input-label for="alamat" :value="__('Alamat (Jalan / Dusun)')" />
                        <textarea id="alamat" name="alamat" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm block mt-1 w-full" rows="2" required>{{ old('alamat', $profile->alamat ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                        <div>
                            <x-input-label for="rt" :value="__('RT')" />
                            <x-text-input id="rt" class="block mt-1 w-full" type="text" name="rt" :value="old('rt', $profile->rt ?? '')" required />
                        </div>
                        <div>
                            <x-input-label for="rw" :value="__('RW')" />
                            <x-text-input id="rw" class="block mt-1 w-full" type="text" name="rw" :value="old('rw', $profile->rw ?? '')" required />
                        </div>
                        <div class="col-span-2">
                            <x-input-label for="desa" :value="__('Desa / Kelurahan')" />
                            <x-text-input id="desa" class="block mt-1 w-full" type="text" name="desa" :value="old('desa', $profile->desa ?? '')" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <x-input-label for="kecamatan" :value="__('Kecamatan')" />
                            <x-text-input id="kecamatan" class="block mt-1 w-full" type="text" name="kecamatan" :value="old('kecamatan', $profile->kecamatan ?? '')" required />
                        </div>
                        <div>
                            <x-input-label for="kabupaten" :value="__('Kabupaten')" />
                            <x-text-input id="kabupaten" class="block mt-1 w-full" type="text" name="kabupaten" :value="old('kabupaten', $profile->kabupaten ?? '')" required />
                        </div>
                    </div>

                    <div class="mb-6">
                        <x-input-label for="asal_delegasi" :value="__('Asal Delegasi (PR/PK/PAC)')" />
                        <x-text-input id="asal_delegasi" class="block mt-1 w-full" type="text" name="asal_delegasi" :value="old('asal_delegasi', $profile->asal_delegasi ?? '')" placeholder="Contoh: PR IPNU Desa Sukamaju" required />
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-4">
                            {{ __('Simpan Biodata') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>