@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Jadwal Konten</li>
    </ol>
</nav>

@if(session('status'))
<div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow p-3 mb-5 bg-white rounded">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('jadwal_kontens.create') }}" class="btn btn-outline-secondary"><i class="fas fa-plus"></i> Tambah Data</a>
    </div>

    <table class="table table-hover">
        <thead style="background: #fd6bc5; color: white;">
        <tr>
            <th>ID</th>
            <th>Judul</th>
            <th>User</th>
            <th>Kategori</th>
            <th>Tanggal Publikasi</th>
            <th>Waktu Dibuat</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($jadwals as $key => $jadwal)
            <tr>
            <td>{{ $key + $jadwals->firstItem() }}</td>
            <td>{{ $jadwal->judul_konten }}</td>
            <td>{{ $jadwal->user->name ?? '-' }}</td>
            <td>{{ $jadwal->kategori->nama_kategori ?? '-' }}</td>
            <td>{{ $jadwal->tanggal_publikasi }}</td>
            <td>{{ $jadwal->waktu_di_buat }}</td>
            <td>
    @php
        $badgeClass = [
            'scheduled' => 'warning',
            'published' => 'success',
            'failed' => 'danger'
        ][$jadwal->status] ?? 'secondary';
    @endphp

    <span class="badge bg-{{ $badgeClass }}">
        {{ ucfirst($jadwal->status) }}
    </span>
</td>


            <td>
    <a href="{{ route('jadwal_kontens.edit', $jadwal->id) }}" class="btn btn-primary btn-sm">
        <i class="fas fa-edit"></i>
    </a>

    <form action="{{ route('jadwal_kontens.destroy', $jadwal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
    </form>

    {{-- Tambah: Form untuk ubah status --}}
    <form action="{{ route('jadwal_kontens.updateStatus', $jadwal->id) }}" method="POST" class="d-inline">
        @csrf
        @method('PATCH')
        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm d-inline w-auto">
            <option value="scheduled" {{ $jadwal->status == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
            <option value="published" {{ $jadwal->status == 'published' ? 'selected' : '' }}>Published</option>
            <option value="failed" {{ $jadwal->status == 'failed' ? 'selected' : '' }}>Failed</option>
        </select>
    </form>
</td>

            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $jadwals->links() }}
</div>
@endsection
