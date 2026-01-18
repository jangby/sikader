<x-app-layout>
    {{-- 
        SETUP ALPINE JS DATA 
        Kita inisialisasi state di sini agar bisa diakses oleh seluruh halaman 
    --}}
    <div x-data="{
        showModal: {{ $errors->any() ? 'true' : 'false' }}, 
        isEditMode: false,
        formAction: '{{ route('admin.users.store') }}',
        formData: {
            name: '{{ old('name') }}',
            email: '{{ old('email') }}',
            role: '{{ old('role', 'user') }}',
        },
        openForCreate() {
            this.showModal = true;
            this.isEditMode = false;
            this.formAction = '{{ route('admin.users.store') }}';
            this.formData = { name: '', email: '', role: 'user' }; // Reset form
        },
        openForEdit(user, url) {
            this.showModal = true;
            this.isEditMode = true;
            this.formAction = url;
            this.formData = {
                name: user.name,
                email: user.email,
                role: user.role
            };
        },
        closeModal() {
            this.showModal = false;
        }
    }" class="min-h-screen bg-gray-50 py-8">
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header & Tombol Tambah --}}
            <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 leading-tight">Manajemen Pengguna</h2>
                    <p class="text-sm text-gray-500 mt-1">Kelola akun admin dan anggota dalam satu tampilan.</p>
                </div>
                <div class="mt-4 md:mt-0">
                    {{-- Tombol Trigger Modal Tambah --}}
                    <button @click="openForCreate()" 
                       class="inline-flex items-center px-5 py-2.5 bg-emerald-600 border border-transparent rounded-xl font-semibold text-xs text-white uppercase tracking-widest hover:bg-emerald-700 active:bg-emerald-800 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Tambah Pengguna
                    </button>
                </div>
            </div>

            {{-- Alert Sukses --}}
            @if(session('success'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 bg-white border-l-4 border-emerald-500 p-4 rounded-r shadow-sm flex items-start justify-between animate-fade-in-down">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-emerald-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <p class="text-sm text-gray-600">{{ session('success') }}</p>
                    </div>
                    <button @click="show = false" class="text-gray-400 hover:text-gray-600"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                </div>
            @endif

            {{-- Tabel Pengguna --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-gray-50/50">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Pengguna</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Terdaftar Sejak</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50/80 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-10 w-10 rounded-full flex items-center justify-center text-white font-bold text-sm shadow-sm {{ $user->role === 'admin' ? 'bg-gradient-to-br from-purple-500 to-indigo-600' : 'bg-gradient-to-br from-emerald-400 to-emerald-600' }}">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-bold text-gray-900">{{ $user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800 border-purple-200' : 'bg-emerald-100 text-emerald-800 border-emerald-200' }} border">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $user->created_at->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                                    <div class="flex justify-center items-center space-x-2">
                                        {{-- Tombol Edit (Trigger Modal) --}}
                                        <button @click="openForEdit({{ $user }}, '{{ route('admin.users.update', $user->id) }}')" 
                                                class="group p-2 rounded-lg bg-yellow-50 text-yellow-600 hover:bg-yellow-100 transition border border-transparent hover:border-yellow-200">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                        </button>

                                        {{-- Tombol Hapus --}}
                                        @if(auth()->id() !== $user->id)
                                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="group p-2 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition border border-transparent hover:border-red-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            </div>
        </div>

        {{-- 
            =========================================
            MODAL FORM (CREATE & EDIT)
            =========================================
        --}}
        <div x-show="showModal" style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div x-show="showModal" 
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" 
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
                 class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                 @click="closeModal()"></div>

            <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="relative bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-lg w-full">
                    
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4 border-b border-gray-100">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-emerald-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg class="h-6 w-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    <span x-text="isEditMode ? 'Edit Pengguna' : 'Tambah Pengguna Baru'"></span>
                                </h3>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        Silakan lengkapi form di bawah ini.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <form :action="formAction" method="POST" class="p-6">
                        @csrf
                        <input type="hidden" name="_method" :value="isEditMode ? 'PUT' : 'POST'">

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" x-model="formData.name" required
                                   class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm text-sm">
                            <x-input-error :messages="$errors->get('name')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Email</label>
                            <input type="email" name="email" x-model="formData.email" required
                                   class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm text-sm">
                            <x-input-error :messages="$errors->get('email')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Role / Peran</label>
                            <select name="role" x-model="formData.role" required
                                    class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm text-sm">
                                <option value="user">User / Anggota</option>
                                <option value="admin">Administrator</option>
                            </select>
                            <x-input-error :messages="$errors->get('role')" class="mt-1" />
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Password <span x-show="isEditMode" class="text-xs text-gray-400 font-normal">(Kosongkan jika tidak ingin mengubah)</span>
                            </label>
                            <input type="password" name="password" 
                                   :required="!isEditMode"
                                   class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm text-sm"
                                   placeholder="Min. 8 karakter">
                            <x-input-error :messages="$errors->get('password')" class="mt-1" />
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation" 
                                   :required="!isEditMode"
                                   class="w-full rounded-lg border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 shadow-sm text-sm">
                        </div>

                        <div class="flex flex-row-reverse gap-2">
                            <button type="submit" 
                                    class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-emerald-600 text-base font-medium text-white hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:ml-3 sm:w-auto sm:text-sm">
                                <span x-text="isEditMode ? 'Simpan Perubahan' : 'Buat Pengguna'"></span>
                            </button>
                            <button type="button" @click="closeModal()" 
                                    class="mt-3 w-full inline-flex justify-center rounded-lg border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>