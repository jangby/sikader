<x-app-layout>
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
                        <li aria-current="page">
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-sm font-medium text-emerald-600 md:ml-2">Pengaturan Akun</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <h2 class="mt-2 font-bold text-2xl text-emerald-900 leading-tight">
                    Profil Saya
                </h2>
                <p class="text-sm text-gray-500 mt-1">Kelola informasi akun dan keamanan Anda.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <div class="lg:col-span-1 space-y-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-emerald-100 text-center relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-r from-emerald-500 to-emerald-700"></div>
                        
                        <div class="relative z-10 -mt-10 mb-4">
                            <div class="w-24 h-24 mx-auto rounded-full bg-white p-1 shadow-lg">
                                <div class="w-full h-full rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600 text-3xl font-bold uppercase">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            </div>
                        </div>
                        
                        <h3 class="text-xl font-bold text-gray-800">{{ $user->name }}</h3>
                        <p class="text-sm text-gray-500 mb-4">{{ $user->email }}</p>
                        
                        <div class="inline-flex items-center px-3 py-1 bg-emerald-50 text-emerald-700 rounded-full text-xs font-bold border border-emerald-200">
                            Administrator
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-100 grid grid-cols-2 gap-4 text-left">
                            <div>
                                <p class="text-xs text-gray-400 uppercase">Bergabung</p>
                                <p class="text-sm font-medium text-gray-700">{{ $user->created_at->format('d M Y') }}</p>
                            </div>
                            <div>
                                <p class="text-xs text-gray-400 uppercase">Status</p>
                                <p class="text-sm font-medium text-green-600">● Aktif</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-blue-50 p-5 rounded-xl border border-blue-100">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-blue-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Tips Keamanan</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc pl-5 space-y-1">
                                        <li>Gunakan password yang kuat (minimal 8 karakter).</li>
                                        <li>Jangan bagikan akun Anda kepada siapapun.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-8">
                    
                    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                            <div class="p-2 bg-emerald-50 rounded-lg text-emerald-600 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Informasi Profil</h3>
                                <p class="text-sm text-gray-500">Perbarui nama dan alamat email akun Anda.</p>
                            </div>
                        </div>
                        
                        <div class="max-w-xl">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-gray-100">
                        <div class="flex items-center mb-6 pb-4 border-b border-gray-100">
                            <div class="p-2 bg-amber-50 rounded-lg text-amber-600 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Ganti Password</h3>
                                <p class="text-sm text-gray-500">Pastikan akun Anda tetap aman dengan password yang kuat.</p>
                            </div>
                        </div>

                        <div class="max-w-xl">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>

                    <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-sm border border-red-100 relative overflow-hidden">
                        <div class="absolute right-0 top-0 p-4 opacity-5">
                            <svg class="w-32 h-32 text-red-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        </div>

                        <div class="flex items-center mb-6 pb-4 border-b border-red-50 relative z-10">
                            <div class="p-2 bg-red-50 rounded-lg text-red-600 mr-4">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-red-700">Zona Bahaya</h3>
                                <p class="text-sm text-red-500">Hapus akun secara permanen.</p>
                            </div>
                        </div>

                        <div class="max-w-xl relative z-10">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>