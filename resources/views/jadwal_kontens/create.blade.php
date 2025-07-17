@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jadwal_kontens.index') }}" style="color: #fd6bc5">Data Jadwal Konten</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Jadwal Konten</li>
    </ol>
</nav>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow p-3 mb-5 bg-white rounded">
    <form action="{{ route('jadwal_kontens.store') }}" method="POST">
        @csrf

        <!-- Judul Konten -->
        <div class="form-group mb-3">
            <label for="judul_konten">Judul Konten</label>
            <input type="text" name="judul_konten" class="form-control @error('judul_konten') is-invalid @enderror" value="{{ old('judul_konten') }}">
            @error('judul_konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Kategori -->
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

        <!-- Tanggal & Waktu Postingan -->
        <div class="form-group mb-3">
            <label for="tanggal_postingan">Tanggal & Waktu Postingan</label>
            <input type="datetime-local" name="tanggal_postingan" class="form-control @error('tanggal_postingan') is-invalid @enderror" value="{{ old('tanggal_postingan') }}">
            @error('tanggal_postingan') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Caption (CKEditor) -->
        <div class="form-group mb-3">
            <label for="caption">Caption</label>
            <textarea id="caption" name="caption" rows="4" class="form-control @error('caption') is-invalid @enderror">{{ old('caption') }}</textarea>
            @error('caption') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Akun Ditandai -->
        <div class="form-group mb-3">
            <label for="akun_ditandai">Akun Ditandai (Opsional)</label>
            <input type="text" name="akun_ditandai" class="form-control" value="{{ old('akun_ditandai') }}">
        </div>

        <!-- Hashtag -->
        <div class="form-group mb-3">
            <label for="hastag">Hashtag (Opsional)</label>
            <input type="text" name="hastag" class="form-control" value="{{ old('hastag') }}">
        </div>

        <!-- Status hidden -->
        <input type="hidden" name="status" value="scheduled">

        <!-- Tombol -->
        <button type="submit" class="btn btn-outline-success"><i class="fas fa-save"></i> Simpan</button>
        <a href="{{ route('jadwal_kontens.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </form>
</div>

<!-- CKEditor -->
<script src="https://cdn.ckeditor.com/ckeditor5/39.0.0/classic/ckeditor.js"></script>
<script>
    ClassicEditor
        .create(document.querySelector('#caption'), {
            toolbar: ['bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote']
        })
        .catch(error => {
            console.error(error);
        });

    // Validasi minimal tanggal & waktu
    document.addEventListener("DOMContentLoaded", function () {
        const tanggalInput = document.querySelector('input[name="tanggal_postingan"]');
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        tanggalInput.min = `${year}-${month}-${day}T${hours}:${minutes}`;
    });
</script>
@endsection
