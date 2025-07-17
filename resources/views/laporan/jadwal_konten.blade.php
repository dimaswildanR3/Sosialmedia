@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
        <li class="breadcrumb-item active" aria-current="page">Laporan Jadwal Konten</li>
    </ol>
</nav>

@if(session('status'))
<div class="alert alert-success">{{ session('status') }}</div>
@endif

<div class="card shadow p-4 mb-5 bg-white rounded">
    <h5 class="mb-4"><i class="fas fa-chart-line me-2"></i>Laporan Jadwal Konten</h5>

    <form method="GET" action="{{ route('laporan.jadwal.export') }}" class="row g-3 align-items-end">
        <div class="col-md-4">
            <label for="start_date" class="form-label">Dari Tanggal</label>
            <input type="date" name="start_date" id="start_date" class="form-control"
                   value="{{ request('start_date') }}">
        </div>
        <div class="col-md-4">
            <label for="end_date" class="form-label">Sampai Tanggal</label>
            <input type="date" name="end_date" id="end_date" class="form-control"
                   value="{{ request('end_date') }}">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-success w-100">
                <i class="fas fa-file-excel me-1"></i> Export Excel
            </button>
        </div>
    </form>
</div>
@endsection
