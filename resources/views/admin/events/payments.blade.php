<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Dashboard Keuangan
                </h2>
                <p class="text-sm text-gray-500">Verifikasi Pembayaran: {{ $event->nama_acara }}</p>
            </div>
            <a href="{{ route('admin.events.manage', $event->id) }}" class="text-sm text-gray-600 hover:text-gray-900 border border-gray-300 px-3 py-1 rounded-md bg-white shadow-sm">
                &larr; Kembali ke Menu
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 shadow-sm flex items-center justify-between">
                    <span>{{ session('success') }}</span>
                    <button @click="show = false" class="text-green-700 font-bold hover:text-green-900">&times;</button>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-indigo-500">
                    <div class="text-gray-500 text-xs uppercase font-bold tracking-wider">Total Transaksi</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $stats['total'] }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-yellow-500">
                    <div class="text-yellow-600 text-xs uppercase font-bold tracking-wider">Menunggu Verifikasi</div>
                    <div class="text-2xl font-bold text-yellow-700">{{ $stats['pending'] }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-green-500">
                    <div class="text-green-600 text-xs uppercase font-bold tracking-wider">Sudah Lunas (Verified)</div>
                    <div class="text-2xl font-bold text-green-700">{{ $stats['verified'] }}</div>
                </div>
                <div class="bg-white p-4 rounded-lg shadow-sm border-l-4 border-red-500">
                    <div class="text-red-600 text-xs uppercase font-bold tracking-wider">Ditolak / Bermasalah</div>
                    <div class="text-2xl font-bold text-red-700">{{ $stats['rejected'] }}</div>
                </div>
            </div>

            <div class="bg-white p-4 rounded-t-lg border-b border-gray-200 flex flex-col md:flex-row justify-between gap-4 items-center shadow-sm">
                <form method="GET" class="flex flex-col md:flex-row gap-2 w-full md:w-auto">
                    <select name="gender" class="rounded-md border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500" onchange="this.form.submit()">
                        <option value="">Semua Gender</option>
                        <option value="Laki-laki" {{ request('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="Perempuan" {{ request('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>

                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama peserta..." class="rounded-md border-gray-300 text-sm focus:ring-indigo-500 focus:border-indigo-500 pl-8 w-full md:w-64">
                        <div class="absolute inset-y-0 left-0 pl-2 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                    </div>
                    
                    <button type="submit" class="bg-gray-800 text-white px-4 py-2 rounded-md text-sm hover:bg-gray-700">Filter</button>
                    @if(request()->has('gender') || request()->has('search'))
                        <a href="{{ route('admin.events.payments', $event->id) }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded-md text-sm hover:bg-gray-300">Reset</a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-b-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Data Peserta</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Waktu Upload</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Bukti Bayar</th>
                                <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($registrations as $index => $reg)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $registrations->firstItem() + $index }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-gray-900">{{ $reg->user->profile->nama_lengkap ?? $reg->user->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $reg->user->profile->asal_delegasi ?? 'Delegasi Umum' }}</div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    @if(optional($reg->user->profile)->jenis_kelamin == 'Laki-laki')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">Laki-laki</span>
                                    @elseif(optional($reg->user->profile)->jenis_kelamin == 'Perempuan')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-pink-100 text-pink-800">Perempuan</span>
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    <div class="flex flex-col">
                                        <span>{{ $reg->updated_at->format('d M Y') }}</span>
                                        <span class="text-xs text-gray-400">{{ $reg->updated_at->format('H:i') }} WIB</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($reg->bukti_pembayaran == 'manual_offline')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            <svg class="mr-1.5 h-2 w-2 text-gray-400" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="3" /></svg>
                                            Tunai (Offline)
                                        </span>
                                    @elseif($reg->bukti_pembayaran)
                                        <button onclick="openModal('{{ asset('storage/'.$reg->bukti_pembayaran) }}', '{{ $reg->user->profile->nama_lengkap }}')" class="text-indigo-600 hover:text-indigo-900 text-sm font-bold underline flex items-center justify-center mx-auto">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Lihat Bukti
                                        </button>
                                    @else
                                        <span class="text-red-400 text-xs italic">File Hilang</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-center">
                                    @if($reg->status == 'pending')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800 animate-pulse">Pending</span>
                                    @elseif($reg->status == 'verified')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Verified</span>
                                    @elseif($reg->status == 'rejected')
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Ditolak</span>
                                    @endif
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
    <div class="flex justify-end gap-2">
        @if($reg->bukti_pembayaran == 'manual_offline')
            <span class="text-gray-400 text-xs italic">Auto-Verified</span>
        @else
            @if($reg->status != 'verified')
                <form action="{{ route('admin.events.payments.verify', $reg->id) }}" method="POST">
                    @csrf @method('PATCH')
                    <input type="hidden" name="action" value="accept">
                    <button type="submit" onclick="return confirm('Verifikasi pembayaran peserta ini?')" class="bg-green-600 text-white p-1.5 rounded hover:bg-green-700" title="Terima">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </form>
            @endif

            @if($reg->status != 'rejected')
                <button type="button" 
                        onclick="openRejectModal('{{ route('admin.events.payments.verify', $reg->id) }}', '{{ $reg->user->profile->nama_lengkap ?? $reg->user->name }}')" 
                        class="bg-red-100 text-red-600 p-1.5 rounded hover:bg-red-200 border border-red-200" 
                        title="Tolak / Minta Upload Ulang">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            @endif
        @endif
    </div>
</td>
                            </tr>
                            @endforeach

                            @if($registrations->isEmpty())
                                <tr>
                                    <td colspan="7" class="px-6 py-10 text-center text-gray-500 bg-white">
                                        Tidak ada data pembayaran yang ditemukan.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="bg-gray-50 px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $registrations->links() }}
                </div>
            </div>
            
        </div>
    </div>

    <div id="proofModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modalTitle">
                                Bukti Pembayaran
                            </h3>
                            
                            <div class="mt-4 bg-gray-100 rounded-lg p-2 border border-gray-200 min-h-[300px] flex items-center justify-center">
                                
                                <img id="modalImage" src="" alt="Bukti Transfer" class="w-full h-auto object-contain max-h-[70vh] hidden">
                                
                                <iframe id="modalPdf" src="" class="w-full h-[70vh] hidden" frameborder="0"></iframe>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="closeModal()" class="w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Tutup
                    </button>
                    <a id="downloadBtn" href="#" target="_blank" class="mt-3 w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Buka Full / Download
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div id="rejectModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closeRejectModal()"></div>

        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
            
            <form id="rejectForm" method="POST" action="">
                @csrf 
                @method('PATCH')
                <input type="hidden" name="action" value="reject">

                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">Tolak Pembayaran</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 mb-2">Peserta: <span id="rejectUserName" class="font-bold"></span></p>
                                <label class="block text-sm font-medium text-gray-700">Alasan Penolakan (Wajib)</label>
                                <textarea name="alasan" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-red-500 focus:ring-red-500 sm:text-sm" placeholder="Contoh: Bukti buram, Nominal tidak sesuai..." required></textarea>
                                <p class="text-xs text-red-500 mt-1">*Pesan ini akan dikirim otomatis ke WhatsApp peserta.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                        Kirim Penolakan
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Batal
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

    <script>
        function openModal(fileSrc, userName) {
            const modalTitle = document.getElementById('modalTitle');
            const img = document.getElementById('modalImage');
            const pdf = document.getElementById('modalPdf');
            const downloadBtn = document.getElementById('downloadBtn');
            const modal = document.getElementById('proofModal');

            // 1. Set Info Umum
            modalTitle.innerText = 'Bukti Pembayaran: ' + userName;
            downloadBtn.href = fileSrc;

            // 2. Deteksi Ekstensi File (PDF atau Gambar?)
            // Mengambil ekstensi dari URL file (misal: .../file.pdf)
            // Hati-hati jika ada query string (?id=...), kita hapus dulu
            const cleanUrl = fileSrc.split('?')[0]; 
            const extension = cleanUrl.split('.').pop().toLowerCase();

            if (extension === 'pdf') {
                // Tampilkan Mode PDF
                img.classList.add('hidden');
                pdf.classList.remove('hidden');
                pdf.src = fileSrc;
            } else {
                // Tampilkan Mode Gambar
                pdf.classList.add('hidden');
                pdf.src = 'about:blank'; // Reset iframe agar tidak load background
                img.classList.remove('hidden');
                img.src = fileSrc;
            }

            // 3. Tampilkan Modal
            modal.classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('proofModal').classList.add('hidden');
            // Reset src agar video/pdf berhenti loading
            document.getElementById('modalImage').src = '';
            document.getElementById('modalPdf').src = '';
        }

        // Close on Esc key
        document.onkeydown = function(evt) {
            evt = evt || window.event;
            if (evt.keyCode == 27) {
                closeModal();
            }
        };

        // SCRIPT MODAL REJECT (BARU)
    function openRejectModal(actionUrl, userName) {
        document.getElementById('rejectForm').action = actionUrl;
        document.getElementById('rejectUserName').innerText = userName;
        document.getElementById('rejectModal').classList.remove('hidden');
    }

    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
    </script>
</x-app-layout>