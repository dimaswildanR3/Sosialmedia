@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">File Konten</li>
    </ol>
</nav>

@if(session('status'))
<div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow p-3 mb-5 bg-white rounded">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('file_kontens.create') }}" class="btn btn-outline-secondary"><i class="fas fa-plus"></i> Tambah Data</a>
    </div>

    <table class="table table-hover">
        <thead style="background: #fd6bc5; color: white;">
            <tr>
                <th>No</th>
                <th>Nama File</th>
                <th>URL File</th>
                <th>Tipe File</th>
                <th>Jadwal Konten</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($files as $key => $file)
            <tr>
                <td>{{ $key + $files->firstItem() }}</td>
                <td>{{ $file->nama_file }}</td>
                <td>
                    @if($file->tipe_file == 'image' && $file->url_file)
                        <img src="{{ asset('storage/' . $file->url_file) }}" alt="Thumbnail" style="max-width: 100px; max-height: 60px; object-fit: contain; border: 1px solid #ddd; padding: 2px;">
                    @elseif($file->url_file)
                        <a href="{{ asset('storage/' . $file->url_file) }}" target="_blank" rel="noopener noreferrer">
                            Lihat File
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td>{{ ucfirst($file->tipe_file) }}</td>
                <td>{{ $file->jadwalKonten->judul_konten ?? '-' }}</td>
                <td>
                    <a href="{{ route('file_kontens.edit', $file->id) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit"></i></a>
                    <form action="{{ route('file_kontens.destroy', $file->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $files->links() }}
</div>
@endsection
