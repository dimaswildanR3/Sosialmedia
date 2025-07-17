@extends('layouts.admin')

@section('content')
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="/dashboard" style="color: #fd6bc5">Dashboard</a></li>
      <li class="breadcrumb-item active" aria-current="page">Data Akun User</li>
    </ol>
</nav>

@if (session('status'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('status') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<div class="card border-left-primary shadow p-3 mb-5 bg-white rounded">
    <div class="d-flex justify-content-lg-end mb-3">
        <a class="btn btn-outline-secondary" href="/akun/create">
            <i class="fas fa-plus"></i> Tambah Data Pengguna
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
            <thead style="background: #fd6bc5; color: white;">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Nama Akun</th>
                    <th scope="col">Email</th>
                    @if (isset($akun[0]->role))
                    <th scope="col">Role</th>
                    @endif
                    <th scope="col">Akun Dibuat</th>
                    <th scope="col">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($akun as $key => $item)
                <tr>
                    <th scope="row">{{ $key + $akun->firstItem() }}</th>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    @if (isset($item->role))
                    <td>{{ $item->role }}</td>
                    @endif
                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <form action="/akun/{{ $item->id }}" method="post" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data ini?')">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger" title="Hapus Akun">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                        <a href="/akun/{{ $item->id }}/edit" class="btn btn-primary" title="Edit Akun">
                            <i class="fas fa-edit"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $akun->links() }}
    </div>
</div>
@endsection
