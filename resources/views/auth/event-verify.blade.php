<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Verifikasi - {{ $event->nama_acara }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { background-color: #f3f4f6; font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="antialiased text-gray-900">

    <div class="min-h-screen w-full md:max-w-md mx-auto bg-white md:shadow-2xl overflow-hidden relative md:border-x border-gray-200">
        
        <div class="relative h-48 bg-gray-900">
            @if($event->banner)
                <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->nama_acara }}" class="w-full h-full object-cover opacity-60">
            @else
                <div class="w-full h-full bg-gradient-to-br from-emerald-600 to-teal-900 opacity-90"></div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-t from-black/80 to-transparent flex flex-col justify-end p-6 pb-12">
                <h1 class="text-white text-xl font-bold leading-tight">Verifikasi Keamanan</h1>
                <p class="text-gray-300 text-xs mt-1">Langkah 2 dari 3: Konfirmasi Identitas</p>
            </div>
        </div>

        <div class="relative -mt-6 bg-white rounded-t-3xl px-6 pt-8 pb-10 shadow-[0_-5px_20px_rgba(0,0,0,0.05)] min-h-[500px]">
            
            <div class="text-center mb-8">
                <div class="w-16 h-16 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-4 animate-bounce">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Kami telah mengirimkan kode rahasia ke: <br>
                    <span class="font-bold text-gray-800">{{ Auth::user()->email }}</span> dan <br>
                    <span class="font-bold text-gray-800">{{ Auth::user()->no_hp }}</span>
                </p>
            </div>

            @if(session('error'))
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg flex items-start animate-pulse">
                    <svg class="w-5 h-5 text-red-500 mr-2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <p class="text-xs text-red-700 font-bold">{{ session('error') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('events.process_verify', $event->id) }}">
                @csrf

                <div class="space-y-6">
                    <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100 relative group focus-within:ring-2 focus-within:ring-blue-500/20 transition-all">
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold text-blue-700 uppercase tracking-wider flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Kode Email
                            </label>
                            <span class="text-[10px] text-blue-400 bg-blue-100 px-2 py-0.5 rounded-full">Cek Inbox/Spam</span>
                        </div>
                        <input type="text" name="email_code" 
                               class="w-full bg-white text-center text-3xl font-bold tracking-[0.5em] border-gray-200 rounded-xl py-3 text-gray-700 focus:border-blue-500 focus:ring-blue-500 shadow-sm" 
                               maxlength="6" placeholder="******" required autofocus>
                    </div>

                    <div class="bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100 relative group focus-within:ring-2 focus-within:ring-emerald-500/20 transition-all">
                        <div class="flex items-center justify-between mb-2">
                            <label class="text-xs font-bold text-emerald-700 uppercase tracking-wider flex items-center">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                Kode WhatsApp
                            </label>
                            <span class="text-[10px] text-emerald-500 bg-emerald-100 px-2 py-0.5 rounded-full">Cek Chat WA</span>
                        </div>
                        <input type="text" name="wa_code" 
                               class="w-full bg-white text-center text-3xl font-bold tracking-[0.5em] border-gray-200 rounded-xl py-3 text-gray-700 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm" 
                               maxlength="6" placeholder="******" required>
                    </div>
                </div>

                <div class="mt-8">
                    <button type="submit" class="w-full py-3.5 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:bg-gray-800 active:scale-95 transition-all flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Verifikasi & Lanjut
                    </button>
                    
                    <p class="text-center text-xs text-gray-400 mt-4">
                        Pastikan kedua kode dimasukkan dengan benar.
                    </p>
                </div>

            </form>
        </div>

    </div>
</body>
</html>