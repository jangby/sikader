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
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-sm font-medium text-emerald-600 md:ml-2">Database Kader</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="mt-2 font-bold text-2xl text-emerald-900 leading-tight">
                    Database Kader
                </h2>
                <p class="text-sm text-gray-500 mt-1">Data seluruh anggota dan kader berdasarkan jenjang pengkaderan terakhir.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white p-5 rounded-xl shadow-sm border border-gray-100 flex flex-col items-center text-center hover:shadow-md transition">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total SDM</div>
                    <div class="text-3xl font-extrabold text-gray-800 mt-1">{{ $stats['total'] }}</div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-emerald-100 flex flex-col items-center text-center hover:shadow-md transition">
                    <div class="text-xs font-bold text-emerald-600 uppercase tracking-wider">Anggota (Makesta)</div>
                    <div class="text-3xl font-extrabold text-emerald-600 mt-1">{{ $stats['anggota'] }}</div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-blue-100 flex flex-col items-center text-center hover:shadow-md transition">
                    <div class="text-xs font-bold text-blue-600 uppercase tracking-wider">Kader Muda (Lakmud)</div>
                    <div class="text-3xl font-extrabold text-blue-600 mt-1">{{ $stats['kader_muda'] }}</div>
                </div>
                <div class="bg-white p-5 rounded-xl shadow-sm border border-purple-100 flex flex-col items-center text-center hover:shadow-md transition">
                    <div class="text-xs font-bold text-purple-600 uppercase tracking-wider">Instruktur/Utama</div>
                    <div class="text-3xl font-extrabold text-purple-600 mt-1">{{ $stats['instruktur'] }}</div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 flex flex-col md:flex-row justify-between items-center gap-4">
                <form method="GET" class="w-full md:w-1/2 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" 
                           class="block w-full pl-10 rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 sm:text-sm text-gray-700" 
                           placeholder="Cari Nama, Delegasi, atau Email...">
                </form>
                
                <div class="flex gap-2">
                    <button type="button" class="px-4 py-2 bg-emerald-50 text-emerald-700 rounded-lg text-sm font-bold hover:bg-emerald-100 transition border border-emerald-200 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Export Excel
                    </button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl border border-gray-100">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-emerald-50">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider w-10">No</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Identitas Kader</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Delegasi</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Status Kaderisasi</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-emerald-800 uppercase tracking-wider">Acara Terakhir</th>
                                <th scope="col" class="px-6 py-4 text-center text-xs font-bold text-emerald-800 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($users as $index => $user)
                            <tr class="hover:bg-emerald-50/20 transition duration-150">
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $users->firstItem() + $index }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 flex-shrink-0 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-700 font-bold text-sm uppercase">
                                            {{ substr($user->profile->nama_lengkap ?? $user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $user->profile->nama_lengkap ?? $user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                            @if($user->profile && $user->profile->no_hp)
                                                <div class="text-xs text-emerald-600 font-mono mt-0.5">{{ $user->profile->no_hp }}</div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-700">
                                    {{ $user->profile->asal_delegasi ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-col items-start gap-1">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold {{ $user->kader_badge }} border border-opacity-10 shadow-sm">
                                            {{ $user->kader_status }}
                                        </span>
                                        
                                        @if($user->reg_status)
                                            <div class="text-[10px] font-bold uppercase tracking-wide ml-1">
                                                @if($user->reg_status == 'lulus')
                                                    <span class="text-green-600 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                                        Lulus
                                                    </span>
                                                @elseif($user->reg_status == 'pending')
                                                    <span class="text-amber-600 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        Pending
                                                    </span>
                                                @elseif($user->reg_status == 'verified')
                                                    <span class="text-blue-600 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                                        Peserta
                                                    </span>
                                                @elseif($user->reg_status == 'tidak_lulus')
                                                    <span class="text-red-600 flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                                        Tidak Lulus
                                                    </span>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ Str::limit($user->last_event, 30) }}</div>
                                    @if($user->last_event != '-')
                                        <div class="text-xs text-gray-400">Terakhir diikuti</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="#" class="inline-flex items-center px-3 py-1.5 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                            @if($users->isEmpty())
                            <tr>
                                <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                    <div class="flex flex-col items-center">
                                        <div class="p-3 bg-gray-100 rounded-full mb-3">
                                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <p class="font-medium text-gray-900">Data kader tidak ditemukan.</p>
                                        <p class="text-sm text-gray-500 mt-1">Coba sesuaikan kata kunci pencarian Anda.</p>
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                    {{ $users->links() }}
                </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>