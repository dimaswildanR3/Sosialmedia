@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jadwal_kontens.index') }}" style="color: #fd6bc5">Data Jadwal Kontens</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Jadwal Kontens</li>
    </ol>
</nav>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow p-3 mb-5 bg-white rounded">
    <form action="{{ route('jadwal_kontens.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="judul_konten">Judul Konten</label>
            <input type="text" name="judul_konten" class="form-control @error('judul_konten') is-invalid @enderror" value="{{ old('judul_konten') }}">
            @error('judul_konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="user_id">User</label>
            <select name="user_id" class="form-control @error('user_id') is-invalid @enderror">
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
            <label for="kategori_id">Kategori</label>
            <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
            @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="tanggal_publikasi">Tanggal Publikasi</label>
            <input type="date" name="tanggal_publikasi" class="form-control @error('tanggal_publikasi') is-invalid @enderror" value="{{ old('tanggal_publikasi') }}">
            @error('tanggal_publikasi') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="platform">Platform</label>
            <textarea name="platform" rows="4" class="form-control @error('platform') is-invalid @enderror">{{ old('platform') }}</textarea>
            @error('platform') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Status hidden & default to 'scheduled' -->
        <input type="hidden" name="status" value="scheduled">

        <button type="submit" class="btn btn-outline-success"><i class="fas fa-save"></i> Simpan</button>
        <a href="{{ route('jadwal_kontens.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </form>
</div>

{{-- JavaScript untuk validasi tanggal --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tanggalInput = document.querySelector('input[name="tanggal_publikasi"]');
        const today = new Date().toISOString().split('T')[0];
        tanggalInput.setAttribute('min', today);
    });
</script>
@endsection
