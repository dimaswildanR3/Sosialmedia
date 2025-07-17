@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Jenis Postingan</li>
    </ol>
</nav>

@if(session('status'))
<div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow p-3 mb-5 bg-white rounded">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('kategoris.create') }}" class="btn btn-outline-secondary"><i class="fas fa-plus"></i> Tambah Data</a>
    </div>

    <table class="table table-hover">
        <thead style="background: #fd6bc5; color: white;">
            <tr>
                <th>No</th>
                <th>Jenis Postingan</th>
                <th>Warna</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @foreach($kategoris as $key => $kategori)
            <tr>
            <td>{{ $key + $kategoris->firstItem() }}</td>
                <td>{{ $kategori->nama_kategori }}</td>
                <td>
                @if($kategori->warna)
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <div style="width: 20px; height: 20px; background-color: {{ $kategori->warna }}; border: 1px solid #ccc;"></div>
                        <span>{{ $kategori->warna }}</span>
                    </div>
                @else
                    <em>Tidak ada</em>
                @endif
            </td>
                <td>
                    <a href="{{ route('kategoris.edit', $kategori->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('kategoris.destroy', $kategori->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $kategoris->links() }}
</div>
@endsection
