<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SI-KADER') }} - IPNU IPPNU GARUT</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased bg-gray-50 text-gray-800 font-sans">

    <nav class="fixed w-full z-50 transition-all duration-300 bg-white/80 backdrop-blur-md border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-20 items-center">
                <div class="flex-shrink-0 flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center text-white font-bold text-xl shadow-lg shadow-emerald-200">
                        S
                    </div>
                    <div>
                        <h1 class="font-bold text-xl tracking-tight text-gray-900">SIKUT</h1>
                        <p class="text-[10px] font-bold text-emerald-600 tracking-widest uppercase">IPNU IPPNU Garut</p>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#acara" class="text-sm font-semibold text-gray-600 hover:text-emerald-600 transition">Cari Acara</a>
                    <a href="#fitur" class="text-sm font-semibold text-gray-600 hover:text-emerald-600 transition">Fitur</a>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-emerald-600 text-white text-sm font-bold rounded-full hover:bg-emerald-700 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                Dashboard Saya
                            </a>
                        @else
                            <div class="flex items-center gap-3">
                                <a href="{{ route('login') }}" class="px-5 py-2.5 bg-gray-900 text-white text-sm font-bold rounded-full hover:bg-gray-800 transition shadow-md">Masuk</a>
                            </div>
                        @endauth
                    @endif
                </div>

                <div class="flex items-center md:hidden">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="text-sm font-bold text-emerald-600 mr-4">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-bold text-gray-700 mr-4">Masuk</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <header class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 bg-emerald-100 rounded-full blur-3xl opacity-50"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-teal-100 rounded-full blur-3xl opacity-50"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            <span class="inline-block py-1 px-3 rounded-full bg-emerald-50 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-6 border border-emerald-100">
                Sistem Informasi Kaderisasi Terpadu
            </span>
            <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 tracking-tight mb-6 leading-tight">
                Bangun Kader Berkualitas <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">Era Digital</span>
            </h1>
            <p class="mt-4 max-w-2xl mx-auto text-lg md:text-xl text-gray-500 mb-10">
                Platform pendaftaran, pengelolaan data, dan sertifikasi kader IPNU IPPNU secara terintegrasi, mudah, dan transparan.
            </p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#acara" class="px-8 py-4 bg-emerald-600 text-white font-bold rounded-xl shadow-lg hover:bg-emerald-700 transition transform hover:-translate-y-1">
                    Jelajahi Acara
                </a>
                <a href="#fitur" class="px-8 py-4 bg-white text-gray-700 font-bold rounded-xl shadow-sm border border-gray-200 hover:bg-gray-50 transition">
                    Pelajari Fitur
                </a>
            </div>
        </div>
    </header>

    <section id="acara" class="py-20 bg-white relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900">Acara Kaderisasi Terdekat</h2>
                <p class="mt-4 text-gray-500">Segera daftarkan diri Anda sebelum kuota penuh.</p>
            </div>

            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                    <article class="flex flex-col bg-white rounded-3xl shadow-xl shadow-gray-200/50 overflow-hidden border border-gray-100 hover:shadow-2xl transition-all duration-300 group transform hover:-translate-y-2 h-full">
                        
                        <div class="relative h-56 overflow-hidden bg-gray-100">
                            @if($event->banner)
                                <img src="{{ asset('storage/' . $event->banner) }}" 
                                     alt="{{ $event->nama_acara }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-emerald-600 to-teal-800 flex flex-col items-center justify-center p-6 text-center">
                                    <svg class="w-12 h-12 text-white/30 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    <span class="text-white/40 font-bold text-sm tracking-widest uppercase">{{ $event->jenis_kaderisasi }}</span>
                                </div>
                            @endif

                            <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent opacity-60"></div>

                            <div class="absolute top-4 left-4">
                                <span class="px-3 py-1 bg-white/90 backdrop-blur text-emerald-700 text-xs font-bold rounded-lg shadow-sm uppercase tracking-wide">
                                    {{ $event->jenis_kaderisasi }}
                                </span>
                            </div>

                            <div class="absolute bottom-4 right-4">
                                @if($event->biaya > 0)
                                    <span class="px-3 py-1 bg-emerald-500 text-white text-xs font-bold rounded-lg shadow-sm">
                                        Rp {{ number_format($event->biaya, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-yellow-400 text-yellow-900 text-xs font-bold rounded-lg shadow-sm">
                                        GRATIS
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="flex-1 p-6 flex flex-col">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 line-clamp-2 leading-tight group-hover:text-emerald-600 transition-colors">
                                {{ $event->nama_acara }}
                            </h3>

                            <div class="space-y-3 mt-2 mb-6">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-xs text-gray-500 font-bold uppercase">Pelaksanaan</p>
                                        <p class="text-sm font-semibold text-gray-800">{{ $event->tanggal_mulai->format('d M Y') }}</p>
                                    </div>
                                </div>

                                <div class="flex items-start">
                                    <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 mt-0.5">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                    </div>
                                    <div class="ml-3">
                                        <p class="text-xs text-gray-500 font-bold uppercase">Lokasi</p>
                                        <p class="text-sm font-semibold text-gray-800 line-clamp-1">{{ $event->lokasi }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-auto pt-6 border-t border-gray-100">
                                @if($event->kuota > 0)
                                    <a href="{{ route('events.register', $event->id) }}" class="block w-full py-3 bg-gray-900 text-white text-center font-bold rounded-xl hover:bg-emerald-600 transition-colors shadow-lg shadow-gray-200">
                                        Daftar Sekarang
                                    </a>
                                @else
                                    <button disabled class="block w-full py-3 bg-gray-100 text-gray-400 text-center font-bold rounded-xl cursor-not-allowed">
                                        Kuota Penuh
                                    </button>
                                @endif
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                <div class="mt-16 text-center">
                    <p class="text-gray-500 mb-4">Masih belum menemukan acara yang pas?</p>
                    <a href="#" class="inline-flex items-center font-bold text-emerald-600 hover:text-emerald-700">
                        Lihat Arsip Kegiatan
                        <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                    </a>
                </div>
            @else
                <div class="max-w-md mx-auto text-center py-10">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Belum Ada Acara Aktif</h3>
                    <p class="text-gray-500 mt-2">Saat ini belum ada kegiatan kaderisasi yang dibuka. Silakan cek kembali nanti.</p>
                </div>
            @endif
        </div>
    </section>

    <section id="fitur" class="py-24 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-emerald-600 font-bold uppercase tracking-wider text-xs">Kenapa SI-KADER?</span>
                <h2 class="text-3xl font-bold text-gray-900 mt-2">Digitalisasi Organisasi Masa Depan</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 text-center hover:shadow-lg transition duration-300">
                    <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pendaftaran Mudah</h3>
                    <p class="text-gray-500 leading-relaxed">Proses registrasi peserta dilakukan secara online, tanpa ribet berkas fisik, dan terverifikasi otomatis.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 text-center hover:shadow-lg transition duration-300">
                    <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">E-Tiket & Absensi</h3>
                    <p class="text-gray-500 leading-relaxed">Peserta mendapatkan QR Code eksklusif sebagai tiket masuk dan absensi digital real-time.</p>
                </div>

                <div class="bg-white p-8 rounded-3xl shadow-sm border border-gray-100 text-center hover:shadow-lg transition duration-300">
                    <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mx-auto mb-6">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Database Terpusat</h3>
                    <p class="text-gray-500 leading-relaxed">Data kader tersimpan aman dan terpusat, memudahkan pelacakan alumni dan distribusi sertifikat.</p>
                </div>
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-white py-12 border-t border-gray-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center">
            <div class="mb-6 md:mb-0 text-center md:text-left">
                <h2 class="text-2xl font-bold tracking-tight">SI-KADER</h2>
                <p class="text-gray-400 text-sm mt-1">Sistem Informasi Kaderisasi IPNU IPPNU</p>
            </div>
            <div class="flex flex-col md:flex-row items-center gap-6 text-sm text-gray-400">
                <a href="#" class="hover:text-emerald-400 transition">Tentang Kami</a>
                <a href="#" class="hover:text-emerald-400 transition">Bantuan</a>
                <a href="#" class="hover:text-emerald-400 transition">Kontak</a>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-10 pt-8 border-t border-gray-800 text-center text-xs text-gray-500">
            &copy; {{ date('Y') }} SI-KADER. All rights reserved. Built with Laravel & Tailwind.
        </div>
    </footer>

</body>
</html>