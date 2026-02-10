@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Data Jabatan</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Jabatan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark font-weight-bold">
            <i class="fas fa-briefcase mr-2 text-primary"></i>Data Jabatan
        </h5>
        <div class="d-flex">
            <form class="form-inline d-inline-block mr-2" action="{{ route('jabatan.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="nama_jabatan" class="form-control border-right-0" placeholder="Cari Jabatan..." value="{{ $nama_jabatan }}" style="border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary border-left-0" type="submit" style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <a href="{{ route('jabatan.create') }}" class="btn btn-primary shadow-sm rounded-pill px-3">
                <i class="fas fa-plus mr-1"></i> Tambah
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="border-top-0 pl-4" style="width: 5%">No</th>
                        <th class="border-top-0">Nama Jabatan</th>
                        <th class="border-top-0">Deskripsi</th>
                        <th class="border-top-0 text-center pr-4" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jabatans as $index => $jabatan)
                    <tr>
                        <td class="pl-4 align-middle">{{ $index + 1 }}</td>
                        <td class="font-weight-bold align-middle">{{ $jabatan->nama_jabatan }}</td>
                        <td class="align-middle text-muted">{{ $jabatan->deskripsi_jabatan ?? '-' }}</td>
                        <td class="text-center align-middle pr-4">
                            <a href="{{ route('jabatan.edit', $jabatan->id) }}" class="btn btn-sm btn-warning text-white shadow-sm rounded-circle mx-1" title="Edit" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm rounded-circle" title="Hapus" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="fas fa-briefcase fa-2x mb-3 opacity-50"></i>
                            <p class="mb-0">Tidak ada data jabatan yang tersedia.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
