<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AkunController extends Controller
{
    public function index()
    {
        $akun = User::paginate(5);
        return view('akun.index', compact('akun'));
    }

    public function create()
    {
        return view('akun.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // tambahkan 'role' jika ada di request
            'role' => $request->role ?? 'user',
        ]);
        
        return redirect('/akun')->with('status', 'Akun berhasil dibuat!');
    }

    public function edit($id)
    {
        $akun = User::findOrFail($id);
        return view('akun.edit', compact('akun'));
    }

    public function update(Request $request, $id)
    {
        $akun = User::findOrFail($id);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            // validasi email unik kecuali untuk user ini sendiri
            'email' => ['required', 'string', 'email', 'max:255', "unique:users,email,$id"],
            // password opsional, hanya validasi jika diisi
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        $akun->name = $request->name;
        $akun->email = $request->email;

        if ($request->filled('password')) {
            $akun->password = Hash::make($request->password);
        }

        // update role jika ada di form (optional)
        if ($request->has('role')) {
            $akun->role = $request->role;
        }

        $akun->save();

        return redirect('/akun')->with('status', 'Akun berhasil diubah!');
    }

    public function destroy($id)
    {
        $akun = User::findOrFail($id);
        $akun->delete();

        return redirect('/akun')->with('status', 'Akun berhasil dihapus!');
    }
}
