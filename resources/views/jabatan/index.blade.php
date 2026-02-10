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

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>List Jabatan</strong>
        <form class="form-inline" action="{{ route('jabatan.index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="nama_jabatan" class="form-control" placeholder="Cari nama jabatan..." value="{{ $nama_jabatan }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search c-icon"></i>
                    </button>
                </div>
            </div>
            <a href="{{ route('jabatan.create') }}" class="btn btn-primary ml-3">
                <i class="fas fa-plus c-icon mr-1"></i> Tambah Jabatan
            </a>
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Nama Jabatan</th>
                        <th>Deskripsi</th>
                        <th class="text-center" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jabatans as $index => $jabatan)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td class="font-weight-bold">{{ $jabatan->nama_jabatan }}</td>
                        <td>{{ $jabatan->deskripsi_jabatan }}</td>
                        <td class="text-center">
                            <a href="{{ route('jabatan.edit', $jabatan->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fas fa-edit c-icon"></i>
                            </a>
                            <form action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash c-icon"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Tidak ada data jabatan yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        </div>
    </div>
    </div>
</div>
@endsection
