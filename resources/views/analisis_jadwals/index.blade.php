@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Data Analisis</li>
    </ol>
</nav>

@if(session('status'))
<div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow p-3 mb-5 bg-white rounded">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('analisis_jadwals.create') }}" class="btn btn-outline-secondary"><i class="fas fa-plus"></i> Tambah Data</a>
    </div>

    <table class="table table-hover">
        <thead style="background: #fd6bc5; color: white;">
            <tr>
                <th>No</th>
                <th>Jadwal Konten</th>
                <th>User</th>
                <th>Isi Laporan</th>
                <th>Tanggal Laporan</th>
                <th>Status Laporan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($analisis as $key => $laporan)
            <tr>
                <td>{{ $key + $analisis->firstItem() }}</td>
                <td>{{ $laporan->jadwalKonten->judul_konten ?? '-' }}</td>
                <td>{{ $laporan->user->name ?? '-' }}</td>
                <td>{{ $laporan->isi_laporan }}</td>
                <td>{{ $laporan->tanggal_laporan ?? '-' }}</td>
                <td>
                    @php
                        $badgeClass = [
                            'pending' => 'warning',
                            'approved' => 'success',
                            'rejected' => 'danger'
                        ][$laporan->status_laporan] ?? 'secondary';
                    @endphp
                    <span class="badge bg-{{ $badgeClass }}">
                        {{ ucfirst($laporan->status_laporan) }}
                    </span>
                </td>
                <td>
                    <a href="{{ route('analisis_jadwals.edit', $laporan->id) }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('analisis_jadwals.destroy', $laporan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                    </form>

                    {{-- Form untuk ubah status --}}
                    <form action="{{ route('analisis_jadwals.updateStatus', $laporan->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <select name="status_laporan" onchange="this.form.submit()" class="form-select form-select-sm d-inline w-auto">
                            <option value="pending" {{ $laporan->status_laporan == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ $laporan->status_laporan == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ $laporan->status_laporan == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $analisis->links() }}
</div>
@endsection
