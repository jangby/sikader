<x-app-layout>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

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
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <a href="{{ route('admin.events.attendance', $event->id) }}" class="ml-1 text-sm font-medium text-gray-500 hover:text-emerald-600 md:ml-2">Absensi</a>
                            </div>
                        </li>
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-sm font-medium text-emerald-600 md:ml-2">Scanner</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="mt-1">
                    <h2 class="font-bold text-2xl text-gray-800 leading-tight">
                        {{ $schedule->nama_sesi }}
                    </h2>
                    <p class="text-sm text-gray-500 flex items-center gap-1 mt-1">
                        <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span>
                        Mode Scanner Aktif
                    </p>
                </div>
            </div>
            
            <a href="{{ route('admin.events.attendance', $event->id) }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition ease-in-out duration-150">
                &larr; Keluar
            </a>
        </div>
    </x-slot>

    <div class="py-8 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div id="https-alert" class="hidden mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg shadow-sm">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <b>Peringatan Keamanan:</b> Akses kamera memerlukan koneksi aman (HTTPS) atau Localhost.
                        </p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-lg border border-gray-100 flex flex-col justify-center relative overflow-hidden">
                        
                        <div id="scan-result" class="hidden absolute top-4 left-4 right-4 z-20 p-4 rounded-xl text-center font-bold text-lg shadow-lg transform transition-all duration-300 scale-95 opacity-0"></div>

                        <div class="relative overflow-hidden rounded-xl bg-black w-full max-w-lg aspect-square mx-auto border-4 border-gray-200 shadow-inner group">
                            <div id="reader" class="w-full h-full object-cover"></div>
                            
                            <div id="camera-loading" class="absolute inset-0 flex flex-col items-center justify-center text-white bg-black/80 z-10">
                                <svg class="animate-spin h-10 w-10 text-emerald-500 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span class="text-sm font-medium">Mengaktifkan Kamera...</span>
                            </div>

                            <div class="absolute inset-0 border-2 border-white/20 pointer-events-none"></div>
                            <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-48 h-48 border-2 border-emerald-500 rounded-lg shadow-[0_0_0_9999px_rgba(0,0,0,0.5)] pointer-events-none">
                                <div class="absolute top-0 left-0 w-4 h-4 border-t-4 border-l-4 border-emerald-400 -mt-1 -ml-1"></div>
                                <div class="absolute top-0 right-0 w-4 h-4 border-t-4 border-r-4 border-emerald-400 -mt-1 -mr-1"></div>
                                <div class="absolute bottom-0 left-0 w-4 h-4 border-b-4 border-l-4 border-emerald-400 -mb-1 -ml-1"></div>
                                <div class="absolute bottom-0 right-0 w-4 h-4 border-b-4 border-r-4 border-emerald-400 -mb-1 -mr-1"></div>
                            </div>
                        </div>

                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-500">Arahkan kamera ke QR Code pada Kartu Peserta.</p>
                        </div>

                        <div x-data="{ open: false }" class="mt-6 border-t border-gray-100 pt-4 max-w-md mx-auto w-full">
                            <button @click="open = !open" class="text-sm font-semibold text-emerald-600 hover:text-emerald-800 w-full text-center py-2 hover:bg-emerald-50 rounded-lg transition flex justify-center items-center gap-2">
                                <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                <svg x-show="open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                                <span x-show="!open">Input Manual (Jika QR Gagal)</span>
                                <span x-show="open">Tutup Input Manual</span>
                            </button>
                            
                            <div x-show="open" class="mt-3 animate-fade-in-down" style="display: none;">
                                <form id="manual-form" class="flex gap-3">
                                    <input type="number" id="manual-id" class="rounded-lg border-gray-300 w-full text-sm focus:ring-emerald-500 focus:border-emerald-500" placeholder="Masukkan ID Peserta (Angka)" required>
                                    <button type="submit" class="bg-emerald-600 text-white px-6 py-2 rounded-lg text-sm font-bold hover:bg-emerald-700 transition shadow-sm">Kirim</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 flex flex-col h-[500px] lg:h-[600px] overflow-hidden sticky top-6">
                        <div class="p-5 bg-gradient-to-r from-emerald-50 to-white border-b border-gray-100 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800 text-base flex items-center gap-2">
                                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Riwayat Live
                            </h3>
                            <span id="counter-badge" class="text-xs bg-emerald-100 text-emerald-800 px-3 py-1 rounded-full font-bold shadow-sm">
                                {{ $schedule->attendances->count() }} Hadir
                            </span>
                        </div>
                        
                        <div class="flex-1 overflow-y-auto p-4 bg-gray-50/30 scroll-smooth" id="history-container">
                            <ul id="history-list" class="space-y-3">
                                @foreach($recentAttendances as $attendance)
                                <li class="flex items-center p-3.5 bg-white rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition duration-300">
                                    <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center mr-3 font-bold text-sm shadow-inner">
                                        {{ substr($attendance->registration->user->profile->nama_lengkap ?? 'P', 0, 1) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-bold text-sm text-gray-900 truncate">
                                            {{ $attendance->registration->user->profile->nama_lengkap ?? 'Peserta' }}
                                        </div>
                                        <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $attendance->scanned_at->format('H:i:s') }}
                                        </div>
                                    </div>
                                    <div class="text-emerald-500">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <audio id="beep-sound" src="https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3"></audio>

    <script>
        // Cek HTTPS untuk akses kamera
        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            document.getElementById('https-alert').classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const beep = document.getElementById('beep-sound');
            const resultBox = document.getElementById('scan-result');
            const historyList = document.getElementById('history-list');
            const counterBadge = document.getElementById('counter-badge');
            
            let isProcessing = false;
            let currentCount = {{ $schedule->attendances->count() }};

            // FUNGSI: Kirim Data ke Server
            function sendAttendance(registrationId) {
                // Tampilkan notifikasi loading
                showNotification('info', `Memproses ID: ${registrationId}...`);

                fetch("{{ route('admin.events.scan.store', [$event->id, $schedule->id]) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": csrfToken
                    },
                    body: JSON.stringify({ registration_id: registrationId })
                })
                .then(response => response.json())
                .then(data => {
                    if(data.status === 'success') {
                        beep.currentTime = 0; 
                        beep.play();
                        showNotification('success', `✅ ${data.user}<br><span class="text-xs font-normal opacity-90">Berhasil Absen</span>`);
                        addToHistory(data.user, data.time);
                        updateCounter();
                    } else if (data.status === 'warning') {
                        showNotification('warning', `⚠️ ${data.user}<br><span class="text-xs font-normal opacity-90">Sudah Absen Sebelumnya</span>`);
                    } else {
                        showNotification('error', `❌ ${data.message}`);
                    }
                })
                .catch(error => {
                    console.error(error);
                    showNotification('error', "❌ Gangguan Koneksi");
                });
            }

            // Fungsi Menampilkan Notifikasi Pop-up
            function showNotification(type, message) {
                resultBox.classList.remove('hidden', 'bg-emerald-500', 'bg-amber-500', 'bg-red-500', 'bg-gray-500');
                resultBox.classList.add('scale-100', 'opacity-100');
                
                if(type === 'success') resultBox.classList.add('bg-emerald-500', 'text-white');
                else if(type === 'warning') resultBox.classList.add('bg-amber-500', 'text-white');
                else if(type === 'error') resultBox.classList.add('bg-red-500', 'text-white');
                else resultBox.classList.add('bg-gray-600', 'text-white');

                resultBox.innerHTML = message;

                // Hilangkan notifikasi setelah 3 detik
                setTimeout(() => {
                    resultBox.classList.remove('scale-100', 'opacity-100');
                    resultBox.classList.add('scale-95', 'opacity-0');
                    setTimeout(() => resultBox.classList.add('hidden'), 300);
                }, 3000);
            }

            function addToHistory(name, time) {
                const initial = name.charAt(0).toUpperCase();
                const item = `
                    <li class="flex items-center p-3.5 bg-emerald-50 rounded-xl border border-emerald-100 shadow-sm animate-fade-in-down transition duration-500">
                        <div class="flex-shrink-0 w-10 h-10 bg-emerald-500 text-white rounded-full flex items-center justify-center mr-3 font-bold text-sm shadow-md">
                            ${initial}
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-bold text-sm text-gray-900 truncate">${name}</div>
                            <div class="text-xs text-gray-500 flex items-center gap-1 mt-0.5">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                ${time}
                            </div>
                        </div>
                        <div class="text-emerald-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </li>
                `;
                historyList.insertAdjacentHTML('afterbegin', item);
            }

            function updateCounter() {
                currentCount++;
                counterBadge.innerText = currentCount + " Hadir";
            }

            // Inisialisasi Scanner
            try {
                const config = { 
                    fps: 10, 
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 1.0 
                };

                let html5QrcodeScanner = new Html5QrcodeScanner("reader", config, false);

                function onScanSuccess(decodedText) {
                    if(isProcessing) return;
                    isProcessing = true;
                    html5QrcodeScanner.pause();
                    sendAttendance(decodedText);
                    setTimeout(() => { 
                        isProcessing = false;
                        html5QrcodeScanner.resume();
                    }, 2500); // Delay sebelum scan berikutnya
                }

                html5QrcodeScanner.render(onScanSuccess, (error) => {
                    // Sembunyikan loading jika kamera siap
                    const loading = document.getElementById('camera-loading');
                    if(loading) loading.style.display = 'none';
                });
                
            } catch (err) {
                console.error(err);
                document.getElementById('reader').innerHTML = '<div class="p-10 text-center text-red-500">Gagal akses kamera. Pastikan izin diberikan.</div>';
            }

            // Handle Input Manual
            document.getElementById('manual-form').addEventListener('submit', function(e){
                e.preventDefault();
                let id = document.getElementById('manual-id').value;
                if(id) {
                    sendAttendance(id);
                    document.getElementById('manual-id').value = '';
                }
            });
        });
    </script>

    <style>
        .animate-fade-in-down { animation: fadeInDown 0.5s ease-out; }
        @keyframes fadeInDown { from { opacity: 0; transform: translateY(-20px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</x-app-layout>