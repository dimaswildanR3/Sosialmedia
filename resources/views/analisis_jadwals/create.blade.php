@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
      <li class="breadcrumb-item"><a href="{{ route('analisis_jadwals.index') }}" style="color: #fd6bc5">Data Analisis</a></li>
      <li class="breadcrumb-item active" aria-current="page">Tambah Data Analisis</li>
    </ol>
</nav>

<div class="card shadow p-3 mb-5 bg-white rounded">
    <form action="{{ route('analisis_jadwals.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="jadwal_konten_id">Jadwal Konten</label>
            <select name="jadwal_konten_id" id="jadwal_konten_id" class="form-control @error('jadwal_konten_id') is-invalid @enderror">
                <option value="">-- Pilih Jadwal Konten --</option>
                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id }}" {{ old('jadwal_konten_id') == $jadwal->id ? 'selected' : '' }}>
                        {{ $jadwal->judul_konten }}
                    </option>
                @endforeach
            </select>
            @error('jadwal_konten_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="user_id">User</label>
            <select name="user_id" id="user_id" class="form-control @error('user_id') is-invalid @enderror">
                <option value="">-- Pilih User --</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
            @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="isi_laporan">Isi Laporan</label>
            <textarea name="isi_laporan" id="isi_laporan" rows="4" class="form-control @error('isi_laporan') is-invalid @enderror" autocomplete="off">{{ old('isi_laporan') }}</textarea>
            @error('isi_laporan') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="tanggal_laporan">Tanggal Laporan</label>
            <input type="date" name="tanggal_laporan" id="tanggal_laporan" class="form-control @error('tanggal_laporan') is-invalid @enderror" value="{{ old('tanggal_laporan') }}">
            @error('tanggal_laporan') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="status_laporan">Status Laporan</label>
            <select name="status_laporan" id="status_laporan" class="form-control @error('status_laporan') is-invalid @enderror">
                <option value="">-- Pilih Status --</option>
                <option value="pending" {{ old('status_laporan') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ old('status_laporan') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ old('status_laporan') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            @error('status_laporan') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <button type="submit" class="btn btn-outline-success">Simpan</button>
        <a href="{{ route('analisis_jadwals.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </form>
</div>
@endsection
