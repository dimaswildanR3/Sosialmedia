@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('profile.show') }}" style="color:#fd6bc5">Profil Saya</a></li>
        <li class="breadcrumb-item active" aria-current="page">Edit Profil</li>
    </ol>
</nav>

<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow p-3 bg-white rounded" style="max-width: 380px; width: 100%;">

        <h4 class="mb-3 text-center" style="color:#fd6bc5;">Edit Profil</h4>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

           <div class="text-center mb-3" id="photo-container">
    @if ($user->photo)
        <img id="previewImage" 
            src="{{ asset('storage/' . $user->photo) }}" 
            alt="Foto Profil" 
            class="rounded-circle border" 
            style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #fd6bc5; cursor: pointer;"
            onclick="document.getElementById('photo').click();" />
    @else
        <div id="initialImage" onclick="document.getElementById('photo').click();" style="
            width: 120px; height: 120px; line-height: 120px; border-radius: 50%;
            background-color: #fd6bc5; color: white; font-size: 56px; font-weight: bold;
            user-select: none; cursor: pointer; margin: 0 auto; border: 3px solid #fd6bc5; text-align: center;">
            {{ strtoupper(substr($user->name ?? $user->email, 0, 1)) }}
        </div>
    @endif
    <input type="file" name="photo" id="photo" accept="image/*" style="display:none;" onchange="previewFile(this)">
    <small class="form-text text-muted">Klik foto untuk ganti</small>
</div>


            <div class="mb-2">
                <label for="name" class="form-label">Nama</label>
                <input type="text" id="name" name="name" class="form-control form-control-sm" value="{{ old('name', $user->name) }}" required>
                @error('name')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="mb-2">
                <label for="email" class="form-label">Email</label>
                <input type="email" id="email" name="email" class="form-control form-control-sm" value="{{ old('email', $user->email) }}" required>
                @error('email')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="mb-2">
                <label for="password" class="form-label">Password Baru (Opsional)</label>
                <input type="password" id="password" name="password" class="form-control form-control-sm" autocomplete="new-password">
                @error('password')<small class="text-danger">{{ $message }}</small>@enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control form-control-sm" autocomplete="new-password">
            </div>

          <div class="d-flex justify-content-center mt-4" style="gap: 1rem;">
    <button type="submit" class="btn btn-pink px-4 py-2" style="min-width: 100px;">
        Simpan
    </button>

    <a href="{{ route('profile.show') }}" class="btn btn-secondary px-4 py-2" style="min-width: 100px;">
        Batal
    </a>
</div>


        </form>
    </div>
</div>

<style>
.btn-pink {
    background-color: #fd6bc5;
    color: white;
    border: none;
    transition: background-color 0.3s ease;
    font-size: 0.9rem;
}
.btn-pink:hover {
    background-color: #e55da6;
    color: white;
    text-decoration: none;
}
.form-control-sm {
    font-size: 0.9rem;
    padding: 0.25rem 0.5rem;
}
</style>

<script>
function previewFile(input) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = document.getElementById('photo-container');

            // Ganti isi container dengan img baru
            container.querySelectorAll('img, div#initialImage').forEach(el => el.remove());

            const img = document.createElement('img');
            img.id = 'previewImage';
            img.src = e.target.result;
            img.className = 'rounded-circle border';
            img.style = "width: 120px; height: 120px; object-fit: cover; border: 3px solid #fd6bc5; cursor: pointer;";
            img.onclick = () => document.getElementById('photo').click();

            container.insertBefore(img, container.firstChild);
        };
        reader.readAsDataURL(file);
    }
}
</script>



@endsection
