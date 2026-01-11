<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Distribusi Sertifikat: {{ $event->nama_acara }}
            </h2>
            <a href="{{ route('admin.events.manage', $event->id) }}" class="text-sm text-gray-600 hover:text-gray-900 border border-gray-300 px-3 py-1 rounded-md bg-white">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4 shadow-sm">{{ session('success') }}</div>
            @endif

            <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded-r shadow-sm flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-blue-700 font-bold">Instruksi:</p>
                    <p class="text-sm text-blue-700">
                        1. Upload file sertifikat peserta ke Google Drive Anda.<br>
                        2. Pastikan akses file di Google Drive sudah diatur ke <b>"Anyone with the link" (Siapa saja yang memiliki link)</b>.<br>
                        3. Salin link file tersebut dan tempel (paste) di kolom input pada tabel di bawah ini.
                    </p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Peserta</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Link</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi (Google Drive)</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($graduates as $index => $reg)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-gray-500">{{ $index + 1 }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $reg->user->profile->nama_lengkap ?? $reg->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $reg->user->profile->asal_delegasi ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($reg->certificate_link)
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                            Tersedia
                                        </span>
                                    @else
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                            Belum Ada
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center gap-2">
                                        
                                        @if($reg->certificate_link)
                                            <a href="{{ $reg->certificate_link }}" target="_blank" class="text-blue-600 hover:text-blue-900 bg-blue-50 px-3 py-1 rounded-md border border-blue-200 flex items-center">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                                                Buka Drive
                                            </a>
                                        @endif

                                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'input-link-{{ $reg->id }}')" 
                                            class="{{ $reg->certificate_link ? 'text-gray-600 bg-gray-100' : 'text-white bg-indigo-600 hover:bg-indigo-700' }} px-3 py-1 rounded-md border border-transparent shadow-sm flex items-center transition">
                                            @if($reg->certificate_link)
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                Edit Link
                                            @else
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                                Input Link
                                            @endif
                                        </button>

                                    </div>
                                </td>
                            </tr>

                            <x-modal name="input-link-{{ $reg->id }}" focusable>
                                <form method="POST" action="{{ route('admin.events.certificate.save', $reg->id) }}" class="p-6">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <h2 class="text-lg font-medium text-gray-900 mb-1">
                                        {{ $reg->certificate_link ? 'Edit' : 'Input' }} Link Sertifikat
                                    </h2>
                                    <p class="text-sm text-gray-500 mb-4">
                                        Peserta: <b>{{ $reg->user->profile->nama_lengkap }}</b>
                                    </p>
                                    
                                    <div class="mb-4">
                                        <x-input-label for="link_{{ $reg->id }}" value="URL Google Drive / File Link" />
                                        <x-text-input id="link_{{ $reg->id }}" name="certificate_link" type="url" class="mt-1 block w-full" 
                                            placeholder="https://drive.google.com/..." 
                                            :value="$reg->certificate_link" required autofocus />
                                        <p class="text-xs text-gray-500 mt-1">Pastikan link bisa diakses publik (Anyone with the link).</p>
                                    </div>

                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                                        <x-primary-button class="ml-3">Simpan Link</x-primary-button>
                                    </div>
                                </form>
                            </x-modal>

                            @endforeach

                            @if($graduates->isEmpty())
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                        Belum ada peserta yang Lulus.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            
        </div>
    </div>
</x-app-layout>