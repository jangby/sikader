<x-app-layout>
    {{-- CSS KHUSUS --}}
    <style>
        aside, header, nav, .fixed.inset-0.bg-black { display: none !important; }
        main { padding: 0 !important; }
        body { background-color: #f3f4f6; }
    </style>

    <div class="min-h-screen w-full md:max-w-md mx-auto bg-gray-50 md:shadow-2xl overflow-hidden relative pb-20 md:border-x border-gray-200">
        
        <div class="bg-gradient-to-br from-emerald-600 to-emerald-800 px-5 pt-8 pb-24 text-white shadow-lg relative z-10 rounded-b-[2.5rem]">
             <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-white opacity-10 blur-xl"></div>
             
             <div class="flex items-center relative z-20 mt-4">
                <a href="{{ route('dashboard') }}" class="mr-4 p-2 bg-white/20 backdrop-blur-md rounded-full hover:bg-white/30 transition-colors">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
                <h1 class="text-xl font-bold leading-tight">Detail Pendaftaran</h1>
            </div>
        </div>

        <div class="px-5 -mt-16 relative z-20">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 text-center">
                <p class="text-xs text-gray-400 uppercase tracking-widest font-bold mb-2">Status Pendaftaran</p>
                
                @if($registration->status == 'verified')
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                    <h2 class="text-xl font-bold text-emerald-700">Terdaftar</h2>
                    <p class="text-xs text-gray-500 mt-1">Data & Pembayaran Terverifikasi</p>
                @elseif($registration->status == 'pending')
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-yellow-100 text-yellow-600 rounded-full mb-3 animate-pulse">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h2 class="text-xl font-bold text-yellow-700">Menunggu Verifikasi</h2>
                    <p class="text-xs text-gray-500 mt-1">Admin sedang mengecek data Anda</p>
                @elseif($registration->status == 'rejected')
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-red-100 text-red-600 rounded-full mb-3">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </div>
                    <h2 class="text-xl font-bold text-red-700">Ditolak</h2>
                    <p class="text-xs text-red-500 mt-1">{{ $registration->keterangan_penolakan ?? 'Data tidak valid' }}</p>
                @endif
            </div>
        </div>

        <div class="px-5 mt-6">
            <h3 class="text-sm font-bold text-gray-800 mb-3 flex items-center">
                <span class="w-1 h-4 bg-emerald-600 rounded-full mr-2"></span>
                Informasi Acara
            </h3>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 space-y-3">
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-bold">Nama Acara</p>
                    <p class="text-sm font-bold text-gray-800">{{ $registration->event->nama_acara }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold">Tanggal</p>
                        <p class="text-xs font-semibold text-gray-700">{{ $registration->event->tanggal_mulai->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] text-gray-400 uppercase font-bold">Lokasi</p>
                        <p class="text-xs font-semibold text-gray-700">{{ $registration->event->lokasi }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-5 mt-6 pb-8">
            <h3 class="text-sm font-bold text-gray-800 mb-3 flex items-center">
                <span class="w-1 h-4 bg-emerald-600 rounded-full mr-2"></span>
                Data Peserta
            </h3>
            <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 space-y-4">
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-xs text-gray-500">Nama Lengkap</span>
                    <span class="text-xs font-bold text-gray-800 text-right">{{ $registration->user->profile->nama_lengkap }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-xs text-gray-500">Delegasi</span>
                    <span class="text-xs font-bold text-gray-800 text-right">{{ $registration->user->profile->asal_delegasi }}</span>
                </div>
                <div class="flex justify-between border-b border-gray-50 pb-2">
                    <span class="text-xs text-gray-500">Ukuran Baju</span>
                    <span class="text-xs font-bold text-gray-800">{{ $registration->ukuran_baju }}</span>
                </div>
                
                <div class="pt-2">
                    <p class="text-xs text-gray-500 mb-2">Bukti Pembayaran</p>
                    @if($registration->bukti_pembayaran)
                        <a href="{{ asset('storage/'.$registration->bukti_pembayaran) }}" target="_blank" class="flex items-center justify-center w-full py-2 bg-emerald-50 text-emerald-700 rounded-lg text-xs font-bold border border-emerald-100 hover:bg-emerald-100">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                            Lihat File
                        </a>
                    @else
                        <p class="text-xs text-gray-400 italic">Gratis / Belum upload</p>
                    @endif
                </div>

                @if(!empty($registration->data_dokumen))
                    <div class="pt-2">
                        <p class="text-xs text-gray-500 mb-2">Dokumen Persyaratan</p>
                        <div class="space-y-2">
                            @foreach($registration->data_dokumen as $namaDoc => $path)
                                <a href="{{ asset('storage/'.$path) }}" target="_blank" class="flex items-center justify-between p-2 bg-gray-50 rounded-lg border border-gray-100 hover:bg-gray-100">
                                    <span class="text-xs font-medium text-gray-600 truncate mr-2">{{ $namaDoc }}</span>
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        @if(in_array($registration->status, ['verified', 'lulus']))
            <div class="absolute bottom-0 w-full bg-white border-t border-gray-100 p-4 shadow-[0_-5px_15px_rgba(0,0,0,0.05)]">
                <a href="{{ route('registrations.qr', $registration->id) }}" class="flex items-center justify-center w-full py-3 bg-gray-900 text-white rounded-xl font-bold shadow-lg active:scale-95 transition-all">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Buka QR Code Saya
                </a>
            </div>
        @endif

    </div>
</x-app-layout>