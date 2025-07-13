@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('file_kontens.index') }}" style="color: #fd6bc5">Data File Konten</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tambah File Konten</li>
    </ol>
</nav>

@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Oops!</strong> Ada kesalahan pada input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card shadow p-3 mb-5 bg-white rounded">
    <form action="{{ route('file_kontens.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="form-group mb-3">
            <label for="jadwal_konten_id">Jadwal Konten</label>
            <select name="jadwal_konten_id" id="jadwal_konten_id" class="form-control @error('jadwal_konten_id') is-invalid @enderror">
                <option value="">-- Pilih Jadwal --</option>
                @foreach($jadwals as $jadwal)
                    <option value="{{ $jadwal->id }}" {{ old('jadwal_konten_id') == $jadwal->id ? 'selected' : '' }}>
                        {{ $jadwal->judul_konten }}
                    </option>
                @endforeach
            </select>
            @error('jadwal_konten_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="nama_file">Nama File</label>
            <input type="text" name="nama_file" id="nama_file" class="form-control @error('nama_file') is-invalid @enderror" value="{{ old('nama_file') }}">
            @error('nama_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="tipe_file">Tipe File</label>
            <select name="tipe_file" id="tipe_file" class="form-control @error('tipe_file') is-invalid @enderror">
                <option value="">-- Pilih Tipe --</option>
                <option value="image" {{ old('tipe_file') == 'image' ? 'selected' : '' }}>Gambar (JPG, PNG)</option>
                <option value="pdf" {{ old('tipe_file') == 'pdf' ? 'selected' : '' }}>PDF</option>
                <!-- <option value="video" {{ old('tipe_file') == 'video' ? 'selected' : '' }}>Video (MP4)</option> -->
            </select>
            @error('tipe_file') <div class="invalid-feedback">{{ $message }}</div> @enderror
        </div>

        <div class="form-group mb-3">
            <label for="url_file">Upload File</label>
            <input type="file" name="url_file" id="url_file" class="form-control @error('url_file') is-invalid @enderror">
            @error('url_file') <div class="invalid-feedback">{{ $message }}</div> @enderror

            <div id="preview-container" class="mt-2">
                <p id="preview-file-name"></p>
            </div>
        </div>

        <button type="submit" class="btn btn-outline-success">Simpan</button>
        <a href="{{ route('file_kontens.index') }}" class="btn btn-outline-secondary">Kembali</a>
    </form>
</div>

<script>
    // Otomatis set accept file sesuai tipe_file yang dipilih
    document.getElementById('tipe_file').addEventListener('change', function () {
        const fileInput = document.getElementById('url_file');
        const type = this.value;

        if (type === 'image') {
            fileInput.accept = '.jpg,.jpeg,.png';
        } else if (type === 'pdf') {
            fileInput.accept = '.pdf';
        } else if (type === 'video') {
            fileInput.accept = '.mp4';
        } else {
            fileInput.accept = '';
        }
    });

    // Preview file ketika input file diubah
    document.getElementById('url_file').addEventListener('change', function(event) {
        const previewContainer = document.getElementById('preview-container');
        let previewImage = document.getElementById('preview-image');
        let previewFileName = document.getElementById('preview-file-name');

        const file = event.target.files[0];

        if (!file) {
            if(previewImage) previewImage.style.display = 'none';
            if(previewFileName) previewFileName.textContent = '';
            return;
        }

        if(previewImage) previewImage.style.display = 'none';
        if(previewFileName) previewFileName.textContent = '';

        const fileType = file.type;

        if(fileType.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                if(previewImage) {
                    previewImage.src = e.target.result;
                    previewImage.style.display = 'block';
                } else {
                    previewImage = document.createElement('img');
                    previewImage.id = 'preview-image';
                    previewImage.src = e.target.result;
                    previewImage.style.maxWidth = '250px';
                    previewImage.style.maxHeight = '150px';
                    previewImage.style.objectFit = 'contain';
                    previewImage.style.border = '1px solid #ddd';
                    previewImage.style.padding = '4px';
                    previewContainer.appendChild(previewImage);
                }
            };
            reader.readAsDataURL(file);
        } else {
            if(previewFileName) {
                previewFileName.textContent = 'File yang dipilih: ' + file.name;
            } else {
                previewFileName = document.createElement('p');
                previewFileName.id = 'preview-file-name';
                previewFileName.textContent = 'File yang dipilih: ' + file.name;
                previewContainer.appendChild(previewFileName);
            }
        }
    });
</script>
@endsection
