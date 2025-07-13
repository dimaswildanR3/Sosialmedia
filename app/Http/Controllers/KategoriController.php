<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::paginate(10); 
        return view('kategoris.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategoris.create');
    }

    public function store(Request $request)
    { $request->validate([
       
            'nama_kategori' => 'required|unique:kategoris,nama_kategori'
        ]);

        Kategori::create($request->all());

        return redirect()->route('kategoris.index')->with('status', 'Kategori berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('kategoris.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|unique:kategoris,nama_kategori,' . $kategori->id
        ]);

        $kategori->update($request->all());

        return redirect()->route('kategoris.index')->with('status', 'Kategori berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategoris.index')->with('status', 'Kategori berhasil dihapus');
    }
}
