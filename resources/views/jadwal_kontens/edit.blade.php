@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('jadwal_kontens.index') }}" style="color: #fd6bc5">Data Jadwal Konten</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Jadwal Konten</li>
    </ol>
</nav>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card shadow p-3 mb-5 bg-white rounded">
    <form action="{{ route('jadwal_kontens.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PATCH')

        <!-- Judul Konten -->
        <div class="form-group mb-3">
            <label for="judul_konten">Judul Konten</label>
            <input type="text" name="judul_konten" class="form-control @error('judul_konten') is-invalid @enderror"
                   value="{{ old('judul_konten', $jadwal->judul_konten) }}">
            @error('judul_konten') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Kategori -->
        <div class="form-group mb-3">
            <label for="kategori_id">Kategori</label>
            <select name="kategori_id" class="form-control @error('kategori_id') is-invalid @enderror">
                <option value="">-- Pilih Kategori --</option>
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $jadwal->kategori_id) == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama_kategori }}
                    </option>
                @endforeach
            </select>
            @error('kategori_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Tanggal & Waktu Postingan -->
        <div class="form-group mb-3">
            <label for="tanggal_postingan">Tanggal & Waktu Postingan</label>
            <input type="datetime-local" name="tanggal_postingan" class="form-control @error('tanggal_postingan') is-invalid @enderror"
                   value="{{ old('tanggal_postingan', \Carbon\Carbon::parse($jadwal->tanggal_postingan)->format('Y-m-d\TH:i')) }}">
            @error('tanggal_postingan') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Caption (CKEditor) -->
        <div class="form-group mb-3">
            <label for="caption">Caption</label>
            <textarea id="caption" name="caption" rows="4" class="form-control @error('caption') is-invalid @enderror">{{ old('caption', $jadwal->caption) }}</textarea>
            @error('caption') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <!-- Akun Ditandai -->
        <div class="form-group mb-3">
            <label for="akun_ditandai">Akun Ditandai (Opsional)</label>
            <input type="text" name="akun_ditandai" class="form-control" value="{{ old('akun_ditandai', $jadwal->akun_ditandai) }}">
        </div>

        <!-- Hashtag -->
        <div class="form-group mb-3">
            <label for="hastag">Hashtag (Opsional)</label>
            <input type="text" name="hastag" class="form-control" value="{{ old('hastag', $jadwal->hastag) }}">
        </div>

        <!-- Tombol -->
        <button type="submit" class="btn btn-outline-success"><i class="fas fa-save"></i> Update</button>
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

    // Set minimal waktu sekarang
    document.addEventListener("DOMContentLoaded", function () {
        const tanggalInput = document.querySelector('input[name="tanggal_postingan"]');
        if (tanggalInput) {
            const now = new Date();
            const year = now.getFullYear();
            const month = String(now.getMonth() + 1).padStart(2, '0');
            const day = String(now.getDate()).padStart(2, '0');
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            tanggalInput.min = `${year}-${month}-${day}T${hours}:${minutes}`;
        }
    });
</script>
@endsection
