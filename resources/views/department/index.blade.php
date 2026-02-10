@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Data Department</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Department</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>List Department</strong>
        <form class="form-inline" action="{{ route('department.index') }}" method="GET">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Cari department..." value="{{ $search }}">
                <div class="input-group-append">
                    <button class="btn btn-outline-secondary" type="submit">
                        <i class="fas fa-search c-icon"></i>
                    </button>
                </div>
            </div>
            @can('create department')
            <a href="{{ route('department.create') }}" class="btn btn-primary ml-3">
                <i class="fas fa-plus c-icon mr-1"></i> Tambah Department
            </a>
            @endcan
        </form>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th style="width: 10%">Kode</th>
                        <th>Nama</th>
                        <th>Jumlah Pegawai</th>
                        <th>Status</th>
                        <th class="text-center" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $department)
                    <tr>
                        <td class="font-weight-bold font-mono">{{ $department->code }}</td>
                        <td>
                            <div class="font-weight-bold">{{ $department->name }}</div>
                            <div class="text-muted small">{{ Str::limit($department->description, 50) }}</div>
                        </td>
                        <td>
                            <span class="badge badge-info">{{ $department->pegawais_count ?? $department->pegawais()->count() }} Pegawai</span>
                        </td>
                        <td>
                            @if($department->is_active)
                                <span class="badge badge-success">Aktif</span>
                            @else
                                <span class="badge badge-danger">Non-aktif</span>
                            @endif
                        </td>
                        <td class="text-center">
                            @can('edit department')
                            <a href="{{ route('department.edit', $department) }}" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fas fa-edit c-icon"></i>
                            </a>
                            @endcan
                            @can('delete department')
                            <form action="{{ route('department.destroy', $department) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash c-icon"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Tidak ada data department.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
