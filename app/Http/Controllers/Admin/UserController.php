<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        // Ambil semua user, urutkan terbaru
        $users = User::latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    // Menampilkan form tambah admin/user baru
    public function create()
    {
        return view('admin.users.create');
    }

    // Menyimpan user baru (Khusus Admin menambahkan akun)
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,user'], // Validasi role
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            // Kita bisa otomatis verifikasi email/wa jika dibuat oleh admin (opsional)
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    // Menampilkan form edit (untuk ganti password dll)
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    // Update data user & password
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'role' => ['required', 'in:admin,user'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()], // Password nullable (opsional)
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        // Hanya update password jika input password diisi
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Data pengguna berhasil diperbarui!');
    }

    // Hapus user
    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }
        
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'Pengguna berhasil dihapus.');
    }
}