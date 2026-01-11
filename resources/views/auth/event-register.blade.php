<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $event->nama_acara }} - Pendaftaran</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { background-color: #f3f4f6; font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="antialiased text-gray-900">

    <div class="min-h-screen md:min-h-0 w-full md:max-w-5xl mx-auto bg-white md:shadow-2xl md:rounded-3xl overflow-hidden relative border-gray-200">
        
        <div class="relative h-56 md:h-80 bg-gray-900">
            @if($event->banner)
                <img src="{{ asset('storage/' . $event->banner) }}" alt="{{ $event->nama_acara }}" class="w-full h-full object-cover opacity-80">
            @else
                <div class="w-full h-full bg-gradient-to-br from-emerald-600 to-teal-900 opacity-90"></div>
            @endif

            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>

            <div class="absolute top-0 left-0 w-full p-6 md:p-8 flex justify-between items-start z-10">
                <a href="{{ url('/') }}" class="p-2.5 bg-white/20 backdrop-blur-md rounded-full text-white hover:bg-white/30 transition shadow-lg border border-white/10 group">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </a>
            </div>

            <div class="absolute bottom-0 left-0 w-full p-6 md:p-10 pb-12 md:pb-16 z-10 text-white">
                <span class="inline-block px-3 py-1 bg-emerald-500 rounded-md text-[10px] md:text-xs font-bold uppercase tracking-wider mb-3 shadow-sm border border-emerald-400">
                    {{ $event->jenis_kaderisasi }}
                </span>
                <h1 class="text-2xl md:text-4xl font-bold leading-tight drop-shadow-md max-w-3xl">{{ $event->nama_acara }}</h1>
                <p class="text-xs md:text-sm text-gray-200 mt-3 flex items-center font-medium">
                    <svg class="w-4 h-4 mr-2 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    {{ $event->tanggal_mulai->format('d F Y, H:i') }} WIB
                </p>
            </div>
        </div>

        <div class="relative -mt-8 md:-mt-10 bg-white rounded-t-3xl md:rounded-none px-6 md:px-12 pt-10 pb-12 shadow-[0_-5px_20px_rgba(0,0,0,0.05)] md:shadow-none border-t border-gray-50 md:border-0">
            
            <div class="mb-8 md:flex md:items-end md:justify-between md:border-b md:border-gray-100 md:pb-6">
                <div>
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900">Buat Akun Peserta</h2>
                    <p class="text-sm text-gray-500 mt-1">Lengkapi formulir di bawah ini untuk mendaftar.</p>
                </div>
                <div class="hidden md:block text-sm text-gray-400">
                    Langkah 1 dari 3
                </div>
            </div>

            <form method="POST" action="{{ route('events.process_register', $event->id) }}">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-y-5 gap-x-8">
                    
                    <div class="md:col-span-2">
                        <x-input-label for="name" :value="__('Nama Lengkap')" class="text-xs uppercase text-gray-500 font-bold tracking-wide" />
                        <div class="relative mt-2">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <x-text-input id="name" class="block w-full pl-11 pr-4 py-3.5 border-gray-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500 bg-gray-50/50 placeholder-gray-400" type="text" name="name" :value="old('name')" required autofocus placeholder="Contoh: Ahmad Fauzi" />
                        </div>
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Alamat Email')" class="text-xs uppercase text-gray-500 font-bold tracking-wide" />
                        <div class="relative mt-2">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </div>
                            <x-text-input id="email" class="block w-full pl-11 pr-4 py-3.5 border-gray-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500 bg-gray-50/50 placeholder-gray-400" type="email" name="email" :value="old('email')" required placeholder="email@contoh.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="no_hp" :value="__('Nomor WhatsApp')" class="text-xs uppercase text-gray-500 font-bold tracking-wide" />
                        <div class="relative mt-2">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                            </div>
                            <x-text-input id="no_hp" class="block w-full pl-11 pr-4 py-3.5 border-gray-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500 bg-gray-50/50 placeholder-gray-400" type="text" name="no_hp" :value="old('no_hp')" required placeholder="08xxxxxxxxxx" />
                        </div>
                        <p class="text-[10px] text-gray-400 mt-1.5 ml-1">*Kode verifikasi akan dikirim ke nomor ini.</p>
                        <x-input-error :messages="$errors->get('no_hp')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Kata Sandi')" class="text-xs uppercase text-gray-500 font-bold tracking-wide" />
                        <div class="relative mt-2">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <x-text-input id="password" class="block w-full pl-11 pr-4 py-3.5 border-gray-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500 bg-gray-50/50 placeholder-gray-400" type="password" name="password" required autocomplete="new-password" placeholder="Minimal 8 karakter" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-xs uppercase text-gray-500 font-bold tracking-wide" />
                        <div class="relative mt-2">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <x-text-input id="password_confirmation" class="block w-full pl-11 pr-4 py-3.5 border-gray-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500 bg-gray-50/50 placeholder-gray-400" type="password" name="password_confirmation" required placeholder="Ulangi kata sandi" />
                        </div>
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                </div>

                <div class="mt-8 md:mt-10">
                    <button type="submit" class="w-full py-4 bg-emerald-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 hover:bg-emerald-700 active:scale-95 transition-all flex items-center justify-center text-sm tracking-wide md:text-base">
                        DAFTAR SEKARANG
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                    </button>
                </div>

                <div class="mt-8 text-center pb-4">
                    <p class="text-sm text-gray-500">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="text-emerald-600 font-bold hover:underline">Masuk disini</a>
                    </p>
                </div>
            </form>
        </div>

    </div>
</body>
</html>