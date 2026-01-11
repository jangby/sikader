<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Data Peserta
                </h2>
                <p class="text-sm text-gray-500">{{ $event->nama_acara }}</p>
            </div>
            <a href="{{ route('admin.events.manage', $event->id) }}" class="text-sm text-gray-600 hover:text-gray-900 border border-gray-300 px-3 py-1 rounded-md bg-white shadow-sm">
                &larr; Kembali ke Menu
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-sm border-b-4 border-indigo-500">
                    <div class="text-gray-400 text-xs font-bold uppercase">Total Peserta</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-b-4 border-blue-500">
                    <div class="text-blue-600 text-xs font-bold uppercase">Laki-laki</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['laki'] }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-b-4 border-pink-500">
                    <div class="text-pink-600 text-xs font-bold uppercase">Perempuan</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['perempuan'] }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-b-4 border-green-500">
                    <div class="text-green-600 text-xs font-bold uppercase">Lulus / Alumni</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['lulus'] }}</div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-lg shadow-sm mb-6 flex flex-col md:flex-row justify-between gap-4 items-center">
                
                <form method="GET" class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                    <select name="gender" class="rounded-md border-gray-300 text-sm focus:ring-indigo-500" onchange="this.form.submit()">
                        <option value="">- Semua Gender -</option>
                        <option value="Laki-laki" {{ request('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ request('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                    <div class="relative w-full md:w-64">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama..." class="rounded-md border-gray-300 text-sm w-full pl-8 focus:ring-indigo-500">
                        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                </form>

                <div class="flex gap-2 w-full md:w-auto justify-end">
                    
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 text-sm flex items-center shadow-sm transition">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Export Excel
                            <svg class="w-3 h-3 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>

                        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 py-1 border border-gray-200" style="display: none;">
                            <a href="{{ route('admin.events.participants.export', ['event' => $event->id, 'filter' => 'all']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Semua Data</a>
                            <a href="{{ route('admin.events.participants.export', ['event' => $event->id, 'filter' => 'Laki-laki']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Khusus Laki-laki</a>
                            <a href="{{ route('admin.events.participants.export', ['event' => $event->id, 'filter' => 'Perempuan']) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Khusus Perempuan</a>
                        </div>
                    </div>

                    <a href="{{ route('admin.events.qr_codes', $event->id) }}" class="bg-white border border-gray-300 text-gray-700 px-3 py-2 rounded-md hover:bg-gray-50 text-sm flex items-center shadow-sm" title="Lihat QR Code">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 16H4v4h2v-4zM6 10H4v2h2v-2zm0-4H4v2h2V6zM10 6H8v2h2V6zm0 4H8v2h2v-2zm0 4H8v4h2v-4zm6-8h-2v2h2V6zm-6 0h-2v2h2V6zm4 8h-2v4h2v-4zm0-4h-2v2h2v-2z"></path></svg>
                    </a>

                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-participant-modal')" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm flex items-center shadow-sm transition">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Peserta
                    </button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nama Lengkap</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">L/P</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">No HP (WA)</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Delegasi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($registrations as $index => $reg)
                            @php $profile = $reg->user->profile; @endphp
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $registrations->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $profile->nama_lengkap ?? $reg->user->name }}</div>
                                    <div class="text-xs text-gray-500">Reg ID: #{{ $reg->id }}</div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    @if(($profile->jenis_kelamin ?? '') == 'Laki-laki')
                                        <span class="text-blue-600 bg-blue-100 px-2 py-1 rounded-full text-xs">L</span>
                                    @elseif(($profile->jenis_kelamin ?? '') == 'Perempuan')
                                        <span class="text-pink-600 bg-pink-100 px-2 py-1 rounded-full text-xs">P</span>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-900">
                                    {{ $profile->no_hp ?? '-' }}
                                    @if($profile->no_hp)
                                        <a href="https://wa.me/{{ $profile->no_hp }}" target="_blank" class="text-green-500 hover:text-green-700 ml-1">
                                            &rarr;
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $profile->asal_delegasi ?? '-' }}</td>
                                <td class="px-6 py-4">
                                    @if($reg->status == 'lulus')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Lulus</span>
                                    @elseif($reg->status == 'verified')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Verified</span>
                                    @elseif($reg->status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ ucfirst($reg->status) }}</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-user-{{ $reg->id }}')" class="text-indigo-600 hover:text-indigo-900 font-bold">
                                        Edit
                                    </button>
                                </td>
                            </tr>

                            <x-modal name="edit-user-{{ $reg->id }}" focusable>
    <form method="POST" action="{{ route('admin.events.participants.update', $reg->id) }}" class="p-6 text-left">
        @csrf
        @method('PUT')
        
        <div class="flex justify-between items-center mb-4 border-b pb-2">
            <h2 class="text-lg font-bold text-gray-900">Edit Data & Status Peserta</h2>
            <button type="button" x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600">
                <span class="text-2xl">&times;</span>
            </button>
        </div>
        
        <div class="space-y-4 h-96 overflow-y-auto pr-2"> 
            
            <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200 mb-4">
                <h3 class="text-sm font-bold text-yellow-800 mb-2 uppercase">Status Keikutsertaan</h3>
                <div>
                    <x-input-label value="Ubah Status Peserta" />
                    <select name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500 font-bold text-gray-700">
                        <option value="pending" {{ $reg->status == 'pending' ? 'selected' : '' }}>Pending (Menunggu Verifikasi)</option>
                        <option value="verified" {{ $reg->status == 'verified' ? 'selected' : '' }}>Verified (Peserta Sah)</option>
                        <option value="lulus" {{ $reg->status == 'lulus' ? 'selected' : '' }} class="bg-green-100 text-green-800">✅ LULUS (Berhak Sertifikat)</option>
                        <option value="tidak_lulus" {{ $reg->status == 'tidak_lulus' ? 'selected' : '' }} class="bg-red-100 text-red-800">❌ TIDAK LULUS / GUGUR</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1">
                        Pilih <b>"LULUS"</b> agar peserta ini muncul di menu Sertifikat.
                    </p>
                </div>
            </div>

            <div>
                <h3 class="text-sm font-bold text-gray-700 mb-2 uppercase border-b pb-1">Identitas Diri</h3>
                <div class="mb-3">
                    <x-input-label value="Nama Lengkap" />
                    <x-text-input name="nama_lengkap" type="text" class="mt-1 block w-full" :value="$profile->nama_lengkap ?? ''" required />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label value="No HP (WhatsApp)" />
                        <x-text-input name="no_hp" type="number" class="mt-1 block w-full" :value="$profile->no_hp ?? ''" required />
                    </div>
                    <div>
                        <x-input-label value="Jenis Kelamin" />
                        <select name="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="Laki-laki" {{ ($profile->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ ($profile->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <x-input-label value="Tempat Lahir" />
                    <x-text-input name="tempat_lahir" type="text" class="mt-1 block w-full" :value="$profile->tempat_lahir ?? ''" required />
                </div>
                <div>
                    <x-input-label value="Tanggal Lahir" />
                    <x-text-input name="tanggal_lahir" type="date" class="mt-1 block w-full" :value="$profile->tanggal_lahir ?? ''" required />
                </div>
            </div>
            
            <div class="mb-3">
                <x-input-label value="Asal Delegasi" />
                <x-text-input name="asal_delegasi" type="text" class="mt-1 block w-full" :value="$profile->asal_delegasi ?? ''" required />
            </div>

            <div>
                <h3 class="text-sm font-bold text-gray-700 mb-2 uppercase border-b pb-1 mt-4">Alamat Domisili</h3>
                
                <div class="mb-3">
                    <x-input-label value="Jalan / Dusun / Blok" />
                    <textarea name="alamat" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ $profile->alamat ?? '' }}</textarea>
                </div>

                <div class="grid grid-cols-2 gap-4 mb-3">
                    <div>
                        <x-input-label value="RT" />
                        <x-text-input name="rt" type="text" class="mt-1 block w-full" :value="$profile->rt ?? ''" required />
                    </div>
                    <div>
                        <x-input-label value="RW" />
                        <x-text-input name="rw" type="text" class="mt-1 block w-full" :value="$profile->rw ?? ''" required />
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <x-input-label value="Desa/Kel" />
                        <x-text-input name="desa" type="text" class="mt-1 block w-full" :value="$profile->desa ?? ''" required />
                    </div>
                    <div>
                        <x-input-label value="Kecamatan" />
                        <x-text-input name="kecamatan" type="text" class="mt-1 block w-full" :value="$profile->kecamatan ?? ''" required />
                    </div>
                    <div>
                        <x-input-label value="Kabupaten" />
                        <x-text-input name="kabupaten" type="text" class="mt-1 block w-full" :value="$profile->kabupaten ?? ''" required />
                    </div>
                </div>
            </div>

        </div>

        <div class="mt-6 flex justify-end pt-4 border-t">
            <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
            <x-primary-button class="ml-3">Simpan Perubahan</x-primary-button>
        </div>
    </form>
</x-modal>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="p-4 border-t border-gray-200">
                    {{ $registrations->links() }}
                </div>
            </div>
        </div>
    </div>

    <x-modal name="add-participant-modal" focusable>
        <form method="POST" action="{{ route('admin.events.participants.store', $event->id) }}" class="p-6">
            @csrf
            
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h2 class="text-lg font-bold text-gray-900">Tambah Peserta Offline</h2>
                <button type="button" x-on:click="$dispatch('close')" class="text-gray-400 hover:text-gray-600">
                    <span class="text-2xl">&times;</span>
                </button>
            </div>
            
            <div class="space-y-4 h-96 overflow-y-auto pr-2"> <div>
                    <h3 class="text-sm font-bold text-gray-700 mb-2 uppercase border-b pb-1">Identitas Diri</h3>
                    <div class="mb-3">
                        <x-input-label for="nama_lengkap" value="Nama Lengkap" />
                        <x-text-input id="nama_lengkap" name="nama_lengkap" type="text" class="mt-1 block w-full" placeholder="Sesuai KTP/Identitas" required />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="no_hp" value="No HP (WhatsApp)" />
                            <x-text-input id="no_hp" name="no_hp" type="number" class="mt-1 block w-full" placeholder="0812..." required />
                        </div>
                        <div>
                            <x-input-label for="jenis_kelamin" value="Jenis Kelamin" />
                            <select name="jenis_kelamin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                <option value="">- Pilih -</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="tempat_lahir" value="Tempat Lahir" />
                        <x-text-input id="tempat_lahir" name="tempat_lahir" type="text" class="mt-1 block w-full" required />
                    </div>
                    <div>
                        <x-input-label for="tanggal_lahir" value="Tanggal Lahir" />
                        <x-text-input id="tanggal_lahir" name="tanggal_lahir" type="date" class="mt-1 block w-full" required />
                    </div>
                </div>
                
                <div class="mb-3">
                    <x-input-label for="asal_delegasi" value="Asal Delegasi" />
                    <x-text-input id="asal_delegasi" name="asal_delegasi" type="text" class="mt-1 block w-full" placeholder="Contoh: PR IPNU Desa Sukamaju" required />
                </div>

                <div>
                    <h3 class="text-sm font-bold text-gray-700 mb-2 uppercase border-b pb-1 mt-4">Alamat Domisili</h3>
                    
                    <div class="mb-3">
                        <x-input-label for="alamat" value="Jalan / Dusun / Blok" />
                        <textarea id="alamat" name="alamat" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-3">
                        <div>
                            <x-input-label for="rt" value="RT" />
                            <x-text-input id="rt" name="rt" type="text" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="rw" value="RW" />
                            <x-text-input id="rw" name="rw" type="text" class="mt-1 block w-full" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="desa" value="Desa/Kel" />
                            <x-text-input id="desa" name="desa" type="text" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="kecamatan" value="Kecamatan" />
                            <x-text-input id="kecamatan" name="kecamatan" type="text" class="mt-1 block w-full" required />
                        </div>
                        <div>
                            <x-input-label for="kabupaten" value="Kabupaten" />
                            <x-text-input id="kabupaten" name="kabupaten" type="text" class="mt-1 block w-full" required />
                        </div>
                    </div>
                </div>

            </div>

            <div class="mt-6 flex justify-end pt-4 border-t">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button class="ml-3">Simpan Peserta</x-primary-button>
            </div>
        </form>
    </x-modal>

</x-app-layout>