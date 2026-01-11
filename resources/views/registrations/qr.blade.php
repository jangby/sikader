<x-app-layout>
    {{-- CSS KHUSUS --}}
    <style>
        /* Sembunyikan Navigasi Bawaan */
        aside, header, nav, .fixed.inset-0.bg-black { display: none !important; }
        main { padding: 0 !important; }
        body { background-color: #0f172a; } /* Slate-900 Background */

        /* Animasi Garis Laser Scanner */
        @keyframes scan {
            0%, 100% { top: 0%; opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { top: 100%; opacity: 0; }
        }
        .scanner-line {
            position: absolute;
            width: 100%;
            height: 4px;
            background: linear-gradient(to right, transparent, #10b981, transparent);
            box-shadow: 0 0 10px #10b981;
            animation: scan 2s linear infinite;
        }
    </style>

    <div class="min-h-screen w-full md:max-w-md mx-auto bg-slate-900 relative overflow-hidden flex flex-col items-center justify-center p-6 md:border-x border-slate-800">
        
        <div class="absolute top-0 left-1/2 -translate-x-1/2 w-64 h-64 bg-emerald-500 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>
        <div class="absolute bottom-0 right-0 w-64 h-64 bg-blue-500 rounded-full mix-blend-screen filter blur-[80px] opacity-10"></div>

        <div class="absolute top-6 left-0 w-full px-6 z-30 flex justify-between items-center">
            <a href="{{ route('dashboard') }}" class="p-2.5 bg-white/10 backdrop-blur-md rounded-full text-white hover:bg-white/20 transition-all border border-white/10 shadow-lg">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </a>
            <span class="text-white/80 text-xs font-bold tracking-widest uppercase bg-white/5 px-3 py-1 rounded-full border border-white/10">Digital Pass</span>
        </div>

        <div class="w-full relative z-20 mt-8">
            
            <div class="bg-white rounded-t-3xl overflow-hidden relative">
                <div class="bg-gradient-to-br from-emerald-600 to-teal-800 p-6 text-white relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-24 h-24 bg-white opacity-10 rounded-full -mr-8 -mt-8 blur-xl"></div>
                    
                    <p class="text-[10px] font-bold tracking-wider uppercase opacity-80 mb-1">Event Ticket</p>
                    <h2 class="text-xl font-bold leading-tight mb-2">{{ $registration->event->nama_acara }}</h2>
                    <div class="flex items-center text-xs font-medium text-emerald-100">
                        <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        {{ $registration->event->tanggal_mulai->format('d M Y') }}
                    </div>
                </div>

                <div class="p-6 pb-8 bg-white">
                    <div class="text-center">
                        <h3 class="text-lg font-bold text-gray-800">{{ $registration->user->profile->nama_lengkap }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $registration->user->profile->asal_delegasi }}</p>
                        
                        <div class="flex justify-center gap-2">
                            <span class="px-3 py-1 bg-emerald-50 text-emerald-700 text-[10px] font-bold uppercase tracking-wide rounded-full border border-emerald-100">
                                Peserta
                            </span>
                            <span class="px-3 py-1 bg-gray-50 text-gray-600 text-[10px] font-bold uppercase tracking-wide rounded-full border border-gray-100">
                                {{ $registration->ukuran_baju }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="absolute bottom-0 left-0 w-full translate-y-1/2 flex justify-between items-center px-0">
                    <div class="w-6 h-6 bg-slate-900 rounded-full -ml-3"></div> <div class="flex-1 border-t-2 border-dashed border-gray-300 mx-2"></div>
                    
                    <div class="w-6 h-6 bg-slate-900 rounded-full -mr-3"></div> </div>
            </div>

            <div class="bg-gray-50 rounded-b-3xl p-8 pt-10 text-center relative shadow-2xl">
                
                <p class="text-xs text-gray-400 font-medium mb-4 uppercase tracking-wider">Scan this QR Code</p>

                <div class="relative inline-block p-4 bg-white rounded-2xl shadow-sm border border-gray-200">
                    <div class="absolute inset-0 overflow-hidden rounded-xl pointer-events-none">
                        <div class="scanner-line"></div>
                    </div>

                    <div class="relative z-10">
                        {!! QrCode::size(200)->color(31, 41, 55)->backgroundColor(255, 255, 255)->generate($registration->id) !!}
                    </div>
                </div>

                <div class="mt-6 flex flex-col items-center">
                    <p class="text-[10px] text-gray-400">ID REGISTRASI</p>
                    <p class="font-mono text-lg font-bold text-gray-700 tracking-widest">#{{ str_pad($registration->id, 6, '0', STR_PAD_LEFT) }}</p>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-200">
                    <p class="text-[10px] text-gray-400">Tunjukkan tiket ini kepada panitia di lokasi acara.</p>
                </div>
            </div>

        </div>

        <div class="mt-10 opacity-40 text-center">
            <p class="text-[10px] text-white tracking-[0.2em] font-light">POWERED BY SI-KADER</p>
        </div>

    </div>
</x-app-layout>