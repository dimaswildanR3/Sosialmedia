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
    <div class="card shadow-sm p-4 rounded text-center" style="max-width: 400px; width: 100%;">

        {{-- Foto Profil --}}
        <div class="mb-3">
            @if ($user->photo)
               <img src="{{ asset('storage/' . $user->photo) }}" alt="Foto Profil"
     class="rounded-circle border" 
     style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #fd6bc5;">

            @else
                @php
                    $initial = strtoupper(substr($user->name ?? $user->email, 0, 1));
                @endphp
                <div style="
                    width: 120px; 
                    height: 120px; 
                    line-height: 120px; 
                    border-radius: 50%; 
                    background-color: #fd6bc5; 
                    color: white; 
                    font-size: 56px; 
                    font-weight: 700; 
                    user-select: none;
                    margin: 0 auto;
                    box-shadow: 0 0 10px rgba(253, 107, 197, 0.5);
                ">
                    {{ $initial }}
                </div>
            @endif
        </div>

        {{-- Nama dan Email --}}
        <h4 style="color: #333; font-weight: 700; margin-bottom: 4px;">{{ $user->name }}</h4>
        <p style="color: #666; font-size: 1rem; margin-top: 0; margin-bottom: 8px;">{{ $user->email }}</p>

        {{-- Info Bergabung --}}
        <p style="color: #999; font-style: italic; margin-bottom: 16px;">
            Bergabung sejak {{ $user->created_at->format('d M Y') }}
        </p>

        {{-- Tombol Edit --}}
        <a href="{{ route('profile.edit') }}" class="btn btn-outline-pink px-4 py-2" 
           style="color: #fd6bc5; border-color: #fd6bc5; font-weight: 600; transition: all 0.3s ease;">
            <i class="fas fa-edit mr-2"></i> Edit Profil
        </a>

    </div>
</div>

<style>
.btn-outline-pink {
    border: 2px solid #fd6bc5;
    color: #fd6bc5;
    background-color: transparent;
}
.btn-outline-pink:hover {
    background-color: #fd6bc5;
    color: white;
    text-decoration: none;
}
</style>
@endsection
