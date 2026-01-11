<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Admin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-blue-500">
                    <div class="text-gray-500 text-sm">Total Acara</div>
                    <div class="text-2xl font-bold">{{ $totalEvents }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-green-500">
                    <div class="text-gray-500 text-sm">Acara Aktif</div>
                    <div class="text-2xl font-bold">{{ $activeEvents }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-yellow-500">
                    <div class="text-gray-500 text-sm">Pendaftar Pending</div>
                    <div class="text-2xl font-bold">{{ $pendingRegistrations }}</div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 border-l-4 border-purple-500">
                    <div class="text-gray-500 text-sm">Total Kader</div>
                    <div class="text-2xl font-bold">{{ $totalKader }}</div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Menu Cepat</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <a href="{{ route('admin.events.create') }}" class="block p-4 border rounded-lg hover:bg-gray-50 transition text-center">
                            <span class="text-2xl">📅</span>
                            <div class="font-bold mt-2">Buat Acara Baru</div>
                        </a>
                        <a href="{{ route('admin.events.index') }}" class="block p-4 border rounded-lg hover:bg-gray-50 transition text-center">
                            <span class="text-2xl">📋</span>
                            <div class="font-bold mt-2">Kelola Data Acara</div>
                        </a>
                        <a href="#" class="block p-4 border rounded-lg hover:bg-gray-50 transition text-center">
                            <span class="text-2xl">👥</span>
                            <div class="font-bold mt-2">Data Kader</div>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>