@extends('layouts.admin')

@section('content')
<style>
    body {
        background-color: #fef4fb;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        margin: 0;
        padding: 0;
    }

    .dashboard-wrapper {
        position: relative;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-start;
        padding: 120px 20px 20px 20px; /* Top padding disesuaikan tinggi navbar */
        box-sizing: border-box;
    }

    .background-decor {
        position: absolute;
        width: 80vw;
        height: 80vh;
        background: linear-gradient(135deg, #fd6bc5 0%, #f9a8d4 100%);
        border-radius: 30px;
        opacity: 0.2;
        z-index: 0;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        filter: blur(50px);
    }

    .card {
        position: relative;
        background-color: white;
        border-radius: 12px;
        padding: 30px;
        box-shadow: 0 8px 24px rgba(253, 107, 197, 0.2);
        text-align: center;
        max-width: 400px;
        width: 100%;
        z-index: 1;
        margin-bottom: 30px;
    }

    .card-header {
        font-size: 20px;
        font-weight: 600;
        color: #fd6bc5;
        margin-bottom: 20px;
    }

    .card-body p {
        font-size: 16px;
        color: #555;
    }

    .success-icon {
        font-size: 48px;
        color: #fd6bc5;
        margin-top: 10px;
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0%, 100% {
            transform: scale(1);
            opacity: 1;
        }
        50% {
            transform: scale(1.1);
            opacity: 0.7;
        }
    }

    .stats-container {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
        max-width: 800px;
        width: 100%;
        z-index: 1;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 6px 20px rgba(253, 107, 197, 0.15);
        flex: 1 1 150px;
        padding: 20px;
        text-align: center;
        color: #fd6bc5;
        font-weight: 600;
        font-size: 18px;
        min-width: 120px;
    }

    .stat-value {
        font-size: 36px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .welcome-quote {
        font-style: italic;
        color: #fd6bc5;
        margin-top: 10px;
        font-size: 14px;
    }

    @media (max-width: 600px) {
        .dashboard-wrapper {
            padding: 120px 10px 20px 10px;
        }

        .card {
            max-width: 100%;
            padding: 20px;
        }

        .stats-container {
            flex-direction: column;
            gap: 15px;
            max-width: 100%;
            align-items: center;
        }

        .stat-card {
            width: 90%;
            font-size: 16px;
            padding: 15px;
        }

        .stat-value {
            font-size: 28px;
        }

        .welcome-quote {
            font-size: 12px;
        }
    }
</style>

@php
    use Illuminate\Support\Facades\DB;
@endphp

<div class="dashboard-wrapper">
    <div class="background-decor"></div>

    <div class="card">
        <div class="card-header">
            {{ __('Dashboard') }}
        </div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            <p>{{ __('Selamat, Anda berhasil masuk ke sistem!') }}</p>
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>

            <div class="welcome-quote">
                "{{ __('Setiap hari adalah kesempatan baru untuk berkreasi!') }}"
            </div>
        </div>
    </div>
    
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-value">{{ DB::table('users')->count() ?? 0 }}</div>
            <div>{{ __('Pengguna Terdaftar') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ DB::table('jadwal_kontens')->count() ?? 0 }}</div>
            <div>{{ __('Postingan') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-value">{{ DB::table('kategoris')->count() ?? 0 }}</div>
            <div>{{ __('Kategori') }}</div>
        </div>
    </div>
</div>
@endsection
