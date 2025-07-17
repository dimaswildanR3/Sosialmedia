@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb" class="mb-4">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Profil Saya</li>
    </ol>
</nav>

@if(session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: '{{ session('success') }}',
        confirmButtonColor: '#fd6bc5'
    });
</script>
@endif

<div class="d-flex justify-content-center align-items-center" style="min-height: 70vh;">
    <div class="card shadow p-4 bg-white rounded" style="max-width: 500px; width: 100%;">
        <h4 class="mb-4 text-center" style="color:#fd6bc5;">Informasi Profil</h4>
        <p><strong>Nama:</strong> {{ $user->name }}</p>
        <p><strong>Email:</strong> {{ $user->email }}</p>
        <p><strong>Bergabung Sejak:</strong> {{ $user->created_at->format('d M Y') }}</p>
        <div class="text-center">
            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary mt-3">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
    </div>
</div>
@endsection
