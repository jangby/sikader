<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">Manajemen Dana</h2>
                <p class="text-sm text-gray-500">{{ $event->nama_acara }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('admin.events.manage', $event->id) }}" class="text-sm text-gray-600 hover:text-gray-900 border border-gray-300 px-3 py-1 rounded-md bg-white">&larr; Kembali</a>
                <a href="{{ route('admin.events.finances.lpj', $event->id) }}" target="_blank" class="text-sm text-white bg-gray-800 hover:bg-gray-700 px-3 py-1 rounded-md flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    Cetak LPJ
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6">{{ session('success') }}</div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-green-500">
                    <div class="text-gray-500 text-xs uppercase font-bold">Total Pemasukan</div>
                    <div class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPemasukan, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-400 mt-1">Dari Peserta & Sponsor</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 border-red-500">
                    <div class="text-gray-500 text-xs uppercase font-bold">Total Pengeluaran</div>
                    <div class="text-2xl font-bold text-red-600">Rp {{ number_format($totalPengeluaran, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-400 mt-1">Operasional Acara</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border-l-4 {{ $saldoAkhir >= 0 ? 'border-blue-500' : 'border-red-600' }}">
                    <div class="text-gray-500 text-xs uppercase font-bold">Sisa Saldo Kas</div>
                    <div class="text-2xl font-bold {{ $saldoAkhir >= 0 ? 'text-blue-600' : 'text-red-600' }}">Rp {{ number_format($saldoAkhir, 0, ',', '.') }}</div>
                    <div class="text-xs text-gray-400 mt-1">Status: {{ $saldoAkhir >= 0 ? 'Aman' : 'Defisit' }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">1. Pemasukan Tiket Peserta (Otomatis)</h3>
                        <span class="bg-indigo-100 text-indigo-800 text-xs px-2 py-1 rounded-full">System Auto-Calculate</span>
                    </div>
                    <div class="flex justify-between items-center bg-gray-50 p-4 rounded-md border border-gray-200">
                        <div>
                            <span class="block text-sm text-gray-600">Jumlah Peserta Terverifikasi</span>
                            <span class="text-xl font-bold">{{ $jumlahPesertaBayar }} Orang</span>
                        </div>
                        <div class="text-center">
                            <span class="block text-sm text-gray-600">Harga Tiket</span>
                            <span class="text-xl font-bold">x Rp {{ number_format($event->biaya, 0, ',', '.') }}</span>
                        </div>
                        <div class="text-right">
                            <span class="block text-sm text-gray-600">Subtotal</span>
                            <span class="text-2xl font-bold text-green-600">Rp {{ number_format($totalPemasukanPeserta, 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-bold text-gray-800">2. Jurnal Keuangan (Sponsor & Pengeluaran)</h3>
                        <button x-data="" x-on:click.prevent="$dispatch('open-modal', 'add-finance-modal')" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 text-sm flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                            Catat Transaksi
                        </button>
                    </div>

                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Nominal</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 text-sm">
                            @foreach($transaksiLain as $data)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">{{ $data->tanggal->format('d/m/Y') }}</td>
                                <td class="px-6 py-4">{{ $data->keterangan }}</td>
                                <td class="px-6 py-4">
                                    @if($data->jenis == 'pemasukan')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-bold">Pemasukan</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-bold">Pengeluaran</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right font-mono font-bold {{ $data->jenis == 'pemasukan' ? 'text-green-600' : 'text-red-600' }}">
                                    Rp {{ number_format($data->nominal, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('admin.events.finances.destroy', $data->id) }}" method="POST" onsubmit="return confirm('Hapus data ini?');">
                                        @csrf @method('DELETE')
                                        <button class="text-red-500 hover:text-red-700">&times;</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($transaksiLain->isEmpty())
                                <tr><td colspan="5" class="text-center py-4 text-gray-500">Belum ada transaksi manual dicatat.</td></tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-modal name="add-finance-modal" focusable>
        <form method="POST" action="{{ route('admin.events.finances.store', $event->id) }}" class="p-6">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 mb-4">Catat Transaksi Baru</h2>
            
            <div class="mb-4">
                <x-input-label value="Jenis Transaksi" />
                <select name="jenis" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500">
                    <option value="pengeluaran">🔴 Pengeluaran (Belanja/Sewa)</option>
                    <option value="pemasukan">🟢 Pemasukan (Sponsor/Donasi)</option>
                </select>
            </div>

            <div class="mb-4">
                <x-input-label value="Keterangan / Sumber" />
                <x-text-input name="keterangan" type="text" class="mt-1 block w-full" placeholder="Contoh: Sewa Sound System" required />
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <x-input-label value="Nominal (Rp)" />
                    <x-text-input name="nominal" type="number" class="mt-1 block w-full" placeholder="0" required />
                </div>
                <div>
                    <x-input-label value="Tanggal" />
                    <x-text-input name="tanggal" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">Batal</x-secondary-button>
                <x-primary-button class="ml-3">Simpan</x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>