<x-app-layout>
    {{-- CSS KHUSUS: RESET TAMPILAN AGAR FULL SCREEN DI HP --}}
    <style>
        /* Sembunyikan Navigasi Bawaan Laravel */
        aside, header, nav, .fixed.inset-0.bg-black { display: none !important; }
        
        /* Reset Padding Main Layout agar mentok ke tepi layar HP */
        main { padding: 0 !important; }
        
        /* Pastikan background menyatu */
        body { background-color: #f3f4f6; }
    </style>

    <div class="min-h-screen w-full md:max-w-md mx-auto bg-gray-50 md:shadow-2xl overflow-hidden relative pb-20 md:border-x border-gray-200">
        
        <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 rounded-b-[2rem] md:rounded-b-[2.5rem] px-6 pt-12 pb-20 text-white shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10 blur-xl"></div>
            <div class="absolute bottom-0 left-0 -ml-8 -mb-8 w-24 h-24 rounded-full bg-white opacity-10 blur-xl"></div>

            <div class="flex items-center justify-between relative z-10">
                <div class="max-w-[70%]">
                    <p class="text-emerald-100 text-sm mb-1">Selamat Datang,</p>
                    <h1 class="text-2xl font-bold truncate leading-tight">{{ Auth::user()->name }}</h1>
                    <span class="inline-block mt-2 px-3 py-1 bg-emerald-700/50 backdrop-blur-sm rounded-full text-xs border border-emerald-500/30 truncate max-w-full">
                        {{ Auth::user()->profile->asal_delegasi ?? 'Anggota Baru' }}
                    </span>
                </div>
                <div class="h-16 w-16 rounded-full bg-white/10 backdrop-blur-md text-white flex items-center justify-center text-2xl font-bold border-2 border-white/20 shadow-inner flex-shrink-0">
                    {{ substr(Auth::user()->name, 0, 1) }}
                </div>
            </div>
        </div>

        <div class="px-5 -mt-12 relative z-20">
            <div class="bg-white rounded-2xl shadow-lg p-4 grid grid-cols-2 gap-4 border border-gray-100">
                
                <a href="{{ route('biodata.edit') }}" class="flex flex-col items-center justify-center p-4 rounded-xl hover:bg-emerald-50 active:scale-95 transition-all duration-200 group border border-transparent hover:border-emerald-100">
                    <div class="h-12 w-12 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mb-3 group-hover:bg-emerald-600 group-hover:text-white transition-colors shadow-sm">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    </div>
                    <span class="text-sm font-bold text-gray-700 group-hover:text-emerald-700">Biodata Saya</span>
                </a>

                <form method="POST" action="{{ route('logout') }}" class="w-full h-full">
                    @csrf
                    <button type="submit" class="w-full h-full flex flex-col items-center justify-center p-4 rounded-xl hover:bg-red-50 active:scale-95 transition-all duration-200 group border border-transparent hover:border-red-100">
                        <div class="h-12 w-12 bg-red-100 text-red-600 rounded-full flex items-center justify-center mb-3 group-hover:bg-red-600 group-hover:text-white transition-colors shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700 group-hover:text-red-700">Keluar</span>
                    </button>
                </form>

            </div>
        </div>

        <div class="px-5 mt-8">
            
            @if(session('success'))
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-r-lg shadow-sm flex items-start animate-fade-in-down">
                    <svg class="w-5 h-5 text-green-500 mr-3 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-sm text-green-700 font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center">
                    <span class="w-1 h-6 bg-emerald-600 rounded-full mr-3"></span>
                    Riwayat Acara
                </h3>
                <span class="text-xs text-gray-400 font-medium">Terbaru</span>
            </div>

            <div class="space-y-4 pb-10">
                @forelse($registrations as $reg)
                    <div class="bg-white rounded-2xl p-5 shadow-[0_2px_8px_rgba(0,0,0,0.04)] border border-gray-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                        <div class="absolute left-0 top-0 bottom-0 w-1.5 
                            @if($reg->status == 'pending') bg-yellow-400 
                            @elseif($reg->status == 'verified' || $reg->status == 'lulus') bg-emerald-500 
                            @elseif($reg->status == 'rejected') bg-red-500 
                            @endif">
                        </div>

                        <div class="pl-3">
                            <div class="flex justify-between items-start mb-2">
                                <div class="pr-2 w-full">
                                    <h4 class="font-bold text-gray-800 text-[15px] leading-snug line-clamp-2">{{ $reg->event->nama_acara }}</h4>
                                    <p class="text-xs text-gray-500 mt-1.5 flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        {{ $reg->event->tanggal_mulai->format('d M Y') }}
                                    </p>
                                </div>
                                <div class="shrink-0">
                                    @if($reg->status == 'pending')
                                        <span class="bg-yellow-50 text-yellow-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-yellow-200 uppercase tracking-wide">Proses</span>
                                    @elseif($reg->status == 'verified')
                                        <span class="bg-emerald-50 text-emerald-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-emerald-200 uppercase tracking-wide">Terdaftar</span>
                                    @elseif($reg->status == 'lulus')
                                        <span class="bg-blue-50 text-blue-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-blue-200 uppercase tracking-wide">Lulus</span>
                                    @elseif($reg->status == 'rejected')
                                        <span class="bg-red-50 text-red-700 text-[10px] font-bold px-2.5 py-1 rounded-full border border-red-200 uppercase tracking-wide">Ditolak</span>
                                    @endif
                                </div>
                            </div>

                            <div class="mt-4 pt-3 border-t border-gray-50">
                                @if($reg->status == 'rejected')
                                    <div class="bg-red-50/50 p-3 rounded-xl mb-3 border border-red-100">
                                        <p class="text-xs text-red-800 font-bold mb-1 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                            Alasan Penolakan:
                                        </p>
                                        <p class="text-xs text-red-600 leading-relaxed pl-4">"{{ $reg->keterangan_penolakan }}"</p>
                                    </div>
                                    
                                    <button onclick="document.getElementById('reupload-{{ $reg->id }}').classList.toggle('hidden')" class="w-full py-2.5 bg-red-600 text-white rounded-xl text-xs font-bold hover:bg-red-700 active:scale-95 transition-all flex items-center justify-center shadow-sm">
                                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Upload Ulang Bukti
                                    </button>

                                    <div id="reupload-{{ $reg->id }}" class="hidden mt-4 animate-fade-in-down bg-gray-50 p-3 rounded-xl border border-dashed border-gray-300">
                                        <form action="{{ route('registrations.reupload', $reg->id) }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <label class="block mb-2 text-xs font-medium text-gray-700">Pilih File Baru (JPG/PDF):</label>
                                            <input type="file" name="bukti_pembayaran" class="block w-full text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-white file:text-emerald-700 hover:file:bg-emerald-50 shadow-sm border border-gray-200 rounded-lg mb-3" required>
                                            <button type="submit" class="w-full py-2 bg-emerald-600 text-white rounded-lg text-xs font-bold hover:bg-emerald-700">Kirim File</button>
                                        </form>
                                    </div>

                                @elseif($reg->status == 'pending')
                                    <div class="flex items-center justify-center py-2 bg-gray-50 rounded-xl">
                                        <svg class="w-4 h-4 text-gray-400 mr-2 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                        <p class="text-xs text-gray-500 font-medium">Sedang diverifikasi admin...</p>
                                    </div>
                                @elseif($reg->status == 'verified' || $reg->status == 'lulus')
                                    <div class="grid grid-cols-2 gap-3">
                                        <a href="{{ route('registrations.show', $reg->id) }}" class="py-2.5 bg-gray-50 text-gray-600 rounded-xl text-xs font-bold flex items-center justify-center hover:bg-gray-100 transition-colors border border-gray-200">
    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
    Detail
</a>
<a href="{{ route('registrations.qr', $reg->id) }}" class="py-2.5 bg-emerald-600 text-white rounded-xl text-xs font-bold flex items-center justify-center hover:bg-emerald-700 transition-colors shadow-sm">
    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
    QR Code
</a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center py-16 opacity-50">
                        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <p class="text-sm text-gray-500 font-medium">Belum ada acara diikuti</p>
                        <a href="{{ url('/') }}" class="mt-5 px-6 py-2.5 bg-emerald-600 text-white text-xs rounded-full font-bold shadow-md hover:bg-emerald-700 active:scale-95 transition-all">
                            Cari Acara Sekarang
                        </a>
                    </div>
                @endforelse
            </div>
            
            <div class="h-10"></div> </div>

        <div class="absolute bottom-0 w-full bg-white border-t border-gray-100 py-4 flex justify-center shadow-[0_-5px_20px_rgba(0,0,0,0.03)] z-30">
            <p class="text-[10px] text-gray-400 font-medium tracking-wide">© {{ date('Y') }} SI-KADER IPNU IPPNU</p>
        </div>

    </div>
</x-app-layout>