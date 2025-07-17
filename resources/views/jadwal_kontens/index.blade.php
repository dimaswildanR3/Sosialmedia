@extends('layouts.admin')

@section('content')
<style>
  /* Bikin tabel bisa di-scroll horizontal di layar kecil */
  @media (max-width: 767px) {
    .table-responsive {
      overflow-x: auto;
      -webkit-overflow-scrolling: touch;
    }

    /* Font tabel lebih kecil supaya muat */
    table.table {
      font-size: 0.85rem;
      min-width: 600px; /* pastikan ada scroll */
    }

    /* Tombol dan dropdown kecil */
    .btn-sm, .form-select-sm {
      font-size: 0.75rem;
      padding: 0.25rem 0.4rem;
    }

    /* Padding cell lebih compact */
    table.table td, table.table th {
      padding: 0.3rem 0.5rem;
      white-space: nowrap; /* supaya teks tidak wrap */
    }
  }
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Jadwal Konten</li>
    </ol>
</nav>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow p-3 mb-5 bg-white rounded">
    <div class="d-flex justify-content-end mb-3">
        <a href="{{ route('jadwal_kontens.create') }}" class="btn btn-outline-secondary">
            <i class="fas fa-plus"></i> Tambah Jadwal
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-hover">
            <thead style="background: #fd6bc5; color: white;">
            <tr>
                <th>No</th>
                <th>User</th>
                <th>Kategori</th>
                <th>Judul</th>
                <th>Tanggal Postingan</th>
                <th>Caption</th>
                <th>Waktu Dibuat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($jadwals as $key => $jadwal)
                <tr>
                    <td>{{ $key + $jadwals->firstItem() }}</td>
                    <td>{{ $jadwal->user->name ?? '-' }}</td>
                    <td>{{ $jadwal->kategori->nama_kategori ?? '-' }}</td>
                    <td>{{ $jadwal->judul_konten }}</td>

                    <!-- Format tanggal & waktu postingan -->
                    <td>{{ \Carbon\Carbon::parse($jadwal->tanggal_postingan)->format('d-m-Y H:i') }}</td>

                    <td>{{ Str::limit(strip_tags($jadwal->caption), 30) }}</td>


                    <!-- Jika 'waktu_dibuat' adalah created_at -->
                    <td>{{ \Carbon\Carbon::parse($jadwal->created_at)->format('d-m-Y H:i') }}</td>

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
                        <!-- Tombol Edit -->
                        <a href="{{ route('jadwal_kontens.edit', $jadwal->id) }}" class="btn btn-primary btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <!-- Tombol Hapus -->
                        <form action="{{ route('jadwal_kontens.destroy', $jadwal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm"><i class="fas fa-trash-alt"></i></button>
                        </form>

                        <!-- Dropdown Status -->
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
            @empty
                <tr>
                    <td colspan="9" class="text-center">Tidak ada data jadwal konten</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center">
        {{ $jadwals->links() }}
    </div>
</div>
@endsection
