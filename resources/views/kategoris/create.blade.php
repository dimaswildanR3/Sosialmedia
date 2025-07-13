@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('kategoris.index') }}" style="color: #fd6bc5">Data Kategori</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah Kategori</li>
    </ol>
</nav>

@if(session('status'))
    <div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow p-3 mb-5 bg-white rounded">
    <form action="{{ route('kategoris.store') }}" method="POST">
        @csrf
        <div class="form-group mb-3">
            <label for="nama_kategori">Nama Kategori</label>
            <input type="text" name="nama_kategori" id="nama_kategori"
                class="form-control @error('nama_kategori') is-invalid @enderror"
                value="{{ old('nama_kategori') }}" autocomplete="off">
            @error('nama_kategori')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-outline-success"><i class="fas fa-save"></i> Simpan</button>
        <a href="{{ route('kategoris.index') }}" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Kembali</a>
    </form>
</div>
@endsection
