<x-app-layout>
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

    <x-slot name="header">
        <div class="hidden md:flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Scanner: {{ $schedule->nama_sesi }}
            </h2>
            <a href="{{ route('admin.events.attendance', $event->id) }}" class="text-sm text-gray-600 hover:text-gray-900 border border-gray-300 px-3 py-1 rounded bg-white">
                &larr; Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-2 md:py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="md:hidden flex justify-between items-center px-4 mb-4">
                <div>
                    <h2 class="font-bold text-lg text-gray-800 leading-tight">Scanner Absensi</h2>
                    <p class="text-xs text-gray-500">{{ Str::limit($schedule->nama_sesi, 30) }}</p>
                </div>
                <a href="{{ route('admin.events.attendance', $event->id) }}" class="bg-gray-200 text-gray-700 px-3 py-1 rounded text-xs">
                    Keluar
                </a>
            </div>

            <div id="https-alert" class="hidden mx-4 mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-3 text-sm rounded shadow-sm" role="alert">
                <b>Peringatan:</b> Kamera butuh koneksi HTTPS atau Localhost.
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 lg:gap-6">
                
                <div class="lg:col-span-2 space-y-4">
                    <div class="bg-white p-4 rounded-xl shadow-sm border border-gray-100 min-h-[500px] flex flex-col justify-center">
                        
                        <div id="scan-result" class="hidden mb-4 p-3 rounded-lg text-center font-bold text-lg shadow-sm transition-all duration-300 max-w-md mx-auto w-full"></div>

                        <div class="relative overflow-hidden rounded-lg bg-black w-full md:w-[450px] aspect-square mx-auto border-4 border-gray-100 shadow-inner">
                            <div id="reader" class="w-full h-full"></div>
                            
                            <div id="camera-loading" class="absolute inset-0 flex items-center justify-center text-white text-sm">
                                <div class="text-center">
                                    <svg class="animate-spin h-8 w-8 text-white mx-auto mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Memuat Kamera...
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 text-center">
                            <p class="text-xs text-gray-400">Pastikan QR Code terlihat jelas di kotak kamera</p>
                        </div>

                        <div x-data="{ open: false }" class="mt-6 border-t pt-4 max-w-md mx-auto w-full">
                            <button @click="open = !open" class="text-xs font-bold text-indigo-600 w-full text-center py-2 hover:bg-gray-50 rounded">
                                <span x-show="!open">Input Manual (ID Peserta) &darr;</span>
                                <span x-show="open">Tutup Input Manual &uarr;</span>
                            </button>
                            
                            <div x-show="open" class="mt-2" style="display: none;">
                                <form id="manual-form" class="flex gap-2">
                                    <input type="number" id="manual-id" class="rounded-md border-gray-300 w-full text-sm" placeholder="ID (Angka)">
                                    <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">Kirim</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-1">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 flex flex-col h-[400px] lg:h-[500px] overflow-hidden">
                        <div class="p-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
                            <h3 class="font-bold text-gray-800 text-sm">Riwayat Live</h3>
                            <span id="counter-badge" class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded-full font-bold">
                                {{ $schedule->attendances->count() }} Masuk
                            </span>
                        </div>
                        
                        <div class="flex-1 overflow-y-auto p-3 bg-gray-50/50">
                            <ul id="history-list" class="space-y-2">
                                @foreach($recentAttendances as $attendance)
                                <li class="flex items-center p-3 bg-white rounded-lg border border-gray-100 shadow-sm">
                                    <div class="flex-shrink-0 w-8 h-8 bg-green-100 text-green-600 rounded-full flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="font-bold text-sm text-gray-900 truncate">
                                            {{ $attendance->registration->user->profile->nama_lengkap ?? 'Peserta' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $attendance->scanned_at->format('H:i:s') }}
                                        </div>
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
        // Cek HTTPS
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

            // FUNGSI: Kirim Data
            function sendAttendance(registrationId) {
                // UI Loading
                resultBox.className = "mb-4 p-3 rounded-lg text-center font-bold text-sm bg-gray-100 text-gray-600 block animate-pulse max-w-md mx-auto w-full";
                resultBox.innerText = "Memproses ID: " + registrationId + "...";

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
                        resultBox.className = "mb-4 p-3 rounded-lg text-center font-bold text-sm bg-green-100 text-green-700 block shadow-md border border-green-200 max-w-md mx-auto w-full";
                        resultBox.innerHTML = `✅ ${data.user}<br><span class="text-xs font-normal">Berhasil Absen</span>`;
                        addToHistory(data.user, data.time);
                        updateCounter();
                    } else if (data.status === 'warning') {
                        resultBox.className = "mb-4 p-3 rounded-lg text-center font-bold text-sm bg-yellow-100 text-yellow-700 block border border-yellow-200 max-w-md mx-auto w-full";
                        resultBox.innerHTML = `⚠️ ${data.user}<br><span class="text-xs font-normal">Sudah Absen Sebelumnya</span>`;
                    } else {
                        resultBox.className = "mb-4 p-3 rounded-lg text-center font-bold text-sm bg-red-100 text-red-700 block border border-red-200 max-w-md mx-auto w-full";
                        resultBox.innerText = "❌ " + data.message;
                    }
                })
                .catch(error => {
                    console.error(error);
                    resultBox.className = "mb-4 p-3 rounded-lg text-center font-bold text-sm bg-red-100 text-red-700 block max-w-md mx-auto w-full";
                    resultBox.innerText = "❌ Gangguan Koneksi";
                });
            }

            function addToHistory(name, time) {
                const item = `
                    <li class="flex items-center p-3 bg-green-50 rounded-lg border border-green-200 shadow-sm animate-in slide-in-from-top duration-300">
                        <div class="flex-shrink-0 w-8 h-8 bg-green-500 text-white rounded-full flex items-center justify-center mr-3">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div class="font-bold text-sm text-gray-900 truncate">${name}</div>
                            <div class="text-xs text-gray-500">${time}</div>
                        </div>
                    </li>
                `;
                historyList.insertAdjacentHTML('afterbegin', item);
            }

            function updateCounter() {
                currentCount++;
                counterBadge.innerText = currentCount + " Masuk";
            }

            try {
                // CONFIG LIBRARY
                const config = { 
                    fps: 10, 
                    qrbox: { width: 250, height: 250 }, // Ukuran kotak fokus
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
                    }, 2500);
                }

                html5QrcodeScanner.render(onScanSuccess, (error) => {
                    document.getElementById('camera-loading').style.display = 'none';
                });
                
            } catch (err) {
                console.error(err);
                document.getElementById('reader').innerHTML = '<div class="p-4 text-center text-red-500">Gagal akses kamera.</div>';
            }

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
</x-app-layout>