<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'SI-KADER') }} - Portal Kaderisasi Digital</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    colors: {
                        emerald: {
                            50: '#ecfdf5',
                            100: '#d1fae5',
                            500: '#10b981',
                            600: '#059669', // Warna Utama NU
                            700: '#047857',
                            900: '#064e3b',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'blob': 'blob 7s infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0)' },
                            '50%': { transform: 'translateY(-20px)' },
                        },
                        blob: {
                            '0%': { transform: 'translate(0px, 0px) scale(1)' },
                            '33%': { transform: 'translate(30px, -50px) scale(1.1)' },
                            '66%': { transform: 'translate(-20px, 20px) scale(0.9)' },
                            '100%': { transform: 'translate(0px, 0px) scale(1)' },
                        }
                    }
                }
            }
        }
    </script>
    <style>
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .pattern-grid {
            background-image: radial-gradient(#10b981 1px, transparent 1px);
            background-size: 30px 30px;
        }
    </style>
</head>
<body class="antialiased font-sans text-gray-600 bg-white selection:bg-emerald-500 selection:text-white">

    <nav class="fixed w-full z-50 top-0 transition-all duration-300 glass-nav">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="/" class="flex items-center gap-3 group">
                    <div class="relative">
                        <div class="absolute -inset-1 bg-emerald-500 rounded-full blur opacity-25 group-hover:opacity-50 transition duration-200"></div>
                        <img src="https://upload.wikimedia.org/wikipedia/commons/e/ec/Logo_IPNU.svg" class="relative h-10 w-auto" alt="Logo">
                    </div>
                    <div class="flex flex-col">
                        <span class="font-extrabold text-xl text-gray-900 leading-none tracking-tight">SI-KADER</span>
                        <span class="text-[10px] font-bold text-emerald-600 uppercase tracking-widest">Digital System</span>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-8">
                    <a href="#home" class="text-sm font-medium text-gray-600 hover:text-emerald-600 transition">Beranda</a>
                    <a href="#features" class="text-sm font-medium text-gray-600 hover:text-emerald-600 transition">Fitur</a>
                    <a href="#events" class="text-sm font-medium text-gray-600 hover:text-emerald-600 transition">Event Terbaru</a>
                </div>

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white transition-all duration-200 bg-gray-900 rounded-full hover:bg-gray-700 hover:shadow-lg">
                            Dashboard Saya
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="hidden md:block text-sm font-bold text-gray-900 hover:text-emerald-600 transition">
                            Masuk
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-emerald-700 transition-all duration-200 bg-emerald-50 border border-emerald-200 rounded-full hover:bg-emerald-100">
                                Daftar Akun
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <section id="home" class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
        <div class="absolute inset-0 opacity-[0.03] pattern-grid pointer-events-none"></div>
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-[600px] h-[600px] bg-emerald-100 rounded-full blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-[400px] h-[400px] bg-teal-100 rounded-full blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-emerald-50 border border-emerald-100 text-emerald-600 text-xs font-bold uppercase tracking-wider mb-6">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                </span>
                Sistem Informasi Terintegrasi
            </div>

            <h1 class="text-5xl md:text-7xl font-extrabold text-gray-900 tracking-tight mb-6 leading-tight">
                Kelola Kaderisasi <br>
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-600 to-teal-500">
                    Lebih Profesional
                </span>
            </h1>

            <p class="mt-4 text-xl text-gray-500 max-w-2xl mx-auto mb-10 leading-relaxed">
                Platform satu pintu untuk pendaftaran kegiatan, absensi digital QR Code, sertifikat otomatis, dan pelaporan yang transparan.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="#events" class="inline-flex items-center justify-center px-8 py-4 text-base font-bold text-white transition-all duration-200 bg-emerald-600 rounded-full hover:bg-emerald-700 hover:shadow-lg hover:shadow-emerald-200 hover:-translate-y-1">
                    Cari Kegiatan
                    <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                </a>
            </div>

            <div id="features" class="mt-16 grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
                <div class="bg-white p-6 rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 hover:-translate-y-1 transition duration-300">
                    <div class="w-10 h-10 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-4 mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4h2v-4zM6 16H4v4h2v-4zM6 10H4v2h2v-2zm0-4H4v2h2V6zM10 6H8v2h2V6zm0 4H8v2h2v-2zm0 4H8v4h2v-4zm6-8h-2v2h2V6zm-6 0h-2v2h2V6zm4 8h-2v4h2v-4zm0-4h-2v2h2v-2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900">QR Absensi</h3>
                    <p class="text-sm text-gray-500">Scan & Masuk</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 hover:-translate-y-1 transition duration-300">
                    <div class="w-10 h-10 bg-purple-50 rounded-xl flex items-center justify-center text-purple-600 mb-4 mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900">E-Sertifikat</h3>
                    <p class="text-sm text-gray-500">Otomatis Terbit</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 hover:-translate-y-1 transition duration-300">
                    <div class="w-10 h-10 bg-green-50 rounded-xl flex items-center justify-center text-green-600 mb-4 mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900">Validasi Data</h3>
                    <p class="text-sm text-gray-500">Email & WA</p>
                </div>
                <div class="bg-white p-6 rounded-2xl shadow-xl shadow-gray-200/50 border border-gray-100 hover:-translate-y-1 transition duration-300">
                    <div class="w-10 h-10 bg-orange-50 rounded-xl flex items-center justify-center text-orange-600 mb-4 mx-auto">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="font-bold text-gray-900">Manajemen</h3>
                    <p class="text-sm text-gray-500">Keuangan & LPJ</p>
                </div>
            </div>
        </div>
    </section>

    <section id="events" class="py-20 bg-gray-50 relative">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">Agenda Kegiatan</h2>
                    <p class="mt-4 text-lg text-gray-500">Daftar sekarang pada kegiatan yang sedang dibuka.</p>
                </div>
            </div>

            @if(isset($events) && $events->isEmpty())
                <div class="bg-white rounded-3xl p-12 text-center shadow-sm border border-gray-100 max-w-2xl mx-auto">
                    <div class="bg-gray-50 w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900">Belum ada kegiatan aktif</h3>
                    <p class="text-gray-500 mt-2">Saat ini belum ada pendaftaran acara yang dibuka. <br> Silakan cek kembali nanti atau hubungi admin.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach($events as $event)
                    <div class="group bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-2xl hover:shadow-emerald-100 border border-gray-100 transition-all duration-300 flex flex-col h-full relative">
                        
                        <div class="relative h-52 overflow-hidden bg-gradient-to-br from-emerald-500 to-teal-600">
                            <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 20px 20px;"></div>
                            
                            <div class="absolute top-4 left-4 z-20">
                                <span class="px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-white text-xs font-bold border border-white/30 uppercase tracking-wide">
                                    {{ $event->jenis_kaderisasi ?? 'Event' }}
                                </span>
                            </div>

                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md rounded-xl p-2 text-center min-w-[60px] shadow-lg">
                                <span class="block text-xs font-bold text-gray-400 uppercase">{{ $event->tanggal_mulai->format('M') }}</span>
                                <span class="block text-xl font-black text-emerald-600">{{ $event->tanggal_mulai->format('d') }}</span>
                            </div>
                            
                            <div class="absolute bottom-0 left-0 w-full p-4 bg-gradient-to-t from-black/60 to-transparent">
                                <div class="flex items-center text-white text-sm font-medium">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    {{ $event->tanggal_mulai->format('H:i') }} WIB
                                </div>
                            </div>
                        </div>

                        <div class="p-6 flex-1 flex flex-col">
                            <h3 class="text-xl font-bold text-gray-900 mb-3 group-hover:text-emerald-600 transition line-clamp-2 leading-tight">
                                {{ $event->nama_acara }}
                            </h3>
                            
                            <div class="flex items-start text-sm text-gray-500 mb-6">
                                <svg class="w-5 h-5 mr-2 text-emerald-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span class="line-clamp-2">{{ $event->lokasi }}</span>
                            </div>

                            <div class="mt-auto border-t border-gray-100 pt-4 flex items-center justify-between">
                                <div>
                                    <p class="text-xs text-gray-400 font-medium uppercase">Biaya Pendaftaran</p>
                                    <p class="text-lg font-bold {{ $event->biaya == 0 ? 'text-green-600' : 'text-gray-900' }}">
                                        {{ $event->biaya == 0 ? 'GRATIS' : 'Rp ' . number_format($event->biaya, 0, ',', '.') }}
                                    </p>
                                </div>
                                
                                @guest
                                    <a href="{{ route('events.register', $event->id) }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white transition-all duration-200 bg-emerald-600 rounded-lg hover:bg-emerald-700 hover:shadow-lg hover:-translate-y-0.5">
                                        Daftar
                                    </a>
                                @else
                                    <a href="{{ url('/dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-emerald-700 transition-all duration-200 bg-emerald-50 rounded-lg hover:bg-emerald-100 border border-emerald-200">
                                        Dashboard
                                    </a>
                                @endguest
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <footer class="bg-white border-t border-gray-100 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center text-center md:text-left gap-6">
                <div>
                    <a href="/" class="flex items-center justify-center md:justify-start gap-2 mb-2">
                        <span class="font-extrabold text-xl text-gray-900">SI-KADER</span>
                    </a>
                    <p class="text-gray-400 text-sm">Sistem Informasi Kaderisasi & Event Management.</p>
                </div>
                <div>
                    <p class="text-sm text-gray-400">&copy; {{ date('Y') }} SI-KADER. Developed with ❤️.</p>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>