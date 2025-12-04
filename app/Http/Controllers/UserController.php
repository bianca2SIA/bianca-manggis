<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    // 🔹 Tampilkan semua data user (PAKAI PAGINATION)
    public function index()
    {
        $dataUser = User::latest()->paginate(10); // <— penting buat syarat pagination
        return view('admin.user.index', compact('dataUser'));
    }

    // 🔹 Form tambah user baru
    public function create()
    {
        return view('admin.user.create');
    }

    // 🔹 Simpan user baru ke database
    public function store(Request $request)
    {
        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email',
            'password'        => 'required|min:6',
            'role'            => 'required',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ambil hanya field yang diperlukan
        $data             = $request->only(['name', 'email', 'role']);
        $data['password'] = Hash::make($request->password);

        // upload foto jika ada
        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] =
            $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        User::create($data);

        return redirect()->route('user.index')->with('success', 'User berhasil ditambahkan!');
    }

    // 🔹 Form edit data user
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.user.edit', compact('user'));
    }

    // 🔹 Update data user
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'            => 'required|string|max:255',
            'email'           => 'required|email|unique:users,email,' . $id,
            'password'        => 'nullable|min:6',
            'role'            => 'required',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // ambil field dasar (tanpa password & foto dulu)
        $data = $request->only(['name', 'email', 'role']);

        // hanya update password jika diisi
        if (! empty($request->password)) {
            $data['password'] = Hash::make($request->password);
        }

        // kalau upload foto baru
        if ($request->hasFile('profile_picture')) {

            // hapus foto lama (kalau ada)
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }

            // simpan foto baru
            $data['profile_picture'] =
            $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $user->update($data);

        return redirect()->route('user.index')->with('success', 'User berhasil diperbarui!');
    }

    // 🔹 Hapus user
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->profile_picture) {
            Storage::disk('public')->delete($user->profile_picture);
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User berhasil dihapus!');
    }
}
