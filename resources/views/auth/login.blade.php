<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Masuk - {{ config('app.name', 'SI-KADER') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { background-color: #f3f4f6; font-family: 'Figtree', sans-serif; }
    </style>
</head>
<body class="antialiased text-gray-900 bg-gray-50">

    <div class="min-h-screen flex items-center justify-center p-0 md:p-6">

        <div class="w-full md:max-w-4xl bg-white md:shadow-2xl md:rounded-3xl overflow-hidden relative md:flex">
            
            <div class="relative h-64 md:h-auto md:w-1/2 bg-gradient-to-br from-emerald-600 to-teal-900 flex flex-col items-center justify-center text-white p-10 overflow-hidden">
                <div class="absolute top-0 right-0 w-64 h-64 bg-white opacity-10 rounded-full blur-3xl -mr-16 -mt-16"></div>
                <div class="absolute bottom-0 left-0 w-48 h-48 bg-emerald-400 opacity-20 rounded-full blur-2xl -ml-10 -mb-10"></div>

                <div class="relative z-10 text-center">
                    <div class="w-20 h-20 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center mb-6 shadow-lg border border-white/20 mx-auto transform transition hover:scale-105 duration-300">
                        <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    
                    <h1 class="text-3xl font-bold tracking-tight mb-2">Selamat Datang</h1>
                    <p class="text-emerald-100 text-sm">Masuk untuk mengelola data kaderisasi IPNU IPPNU secara terpadu.</p>
                </div>
            </div>

            <div class="w-full md:w-1/2 bg-white px-8 py-10 md:py-16 relative">
                
                <div class="absolute top-0 left-0 w-full transform -translate-y-full md:hidden">
                     <svg viewBox="0 0 1440 320" class="w-full h-8 text-white fill-current block"><path d="M0,224L1440,32L1440,320L0,320Z"></path></svg>
                </div>

                <x-auth-session-status class="mb-6" :status="session('status')" />

                <div class="mb-8">
                    <h2 class="text-2xl font-bold text-gray-800">Login Akun</h2>
                    <p class="text-sm text-gray-500 mt-1">Silakan masukkan kredensial Anda.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-5">
                        <x-input-label for="email" :value="__('Email')" class="text-xs uppercase text-gray-500 font-bold tracking-wide" />
                        <div class="relative mt-2">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                            </div>
                            <x-text-input id="email" class="block w-full pl-11 pr-4 py-3 border-gray-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500 bg-gray-50 placeholder-gray-400 transition-all" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@email.com" />
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="mb-6">
                        <x-input-label for="password" :value="__('Kata Sandi')" class="text-xs uppercase text-gray-500 font-bold tracking-wide" />
                        <div class="relative mt-2">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <x-text-input id="password" class="block w-full pl-11 pr-4 py-3 border-gray-200 rounded-xl text-sm focus:border-emerald-500 focus:ring-emerald-500 bg-gray-50 placeholder-gray-400 transition-all" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div class="flex items-center justify-between mb-8">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-emerald-600 shadow-sm focus:ring-emerald-500" name="remember">
                            <span class="ml-2 text-xs text-gray-600 font-medium">{{ __('Ingat Saya') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-xs text-emerald-600 font-bold hover:text-emerald-800 transition" href="{{ route('password.request') }}">
                                {{ __('Lupa Sandi?') }}
                            </a>
                        @endif
                    </div>

                    <button type="submit" class="w-full py-4 bg-gray-900 text-white font-bold rounded-xl shadow-lg hover:bg-gray-800 active:scale-95 transition-all flex items-center justify-center tracking-wide text-sm">
                        MASUK
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </button>
                </form>
            </div>
        </div>

    </div>

</body>
</html>