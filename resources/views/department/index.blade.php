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

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark font-weight-bold">
            <i class="fas fa-building mr-2 text-primary"></i>Data Department
        </h5>
        <div class="d-flex">
            <form class="form-inline d-inline-block mr-2" action="{{ route('department.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="search" class="form-control border-right-0" placeholder="Cari Department..." value="{{ $search }}" style="border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary border-left-0" type="submit" style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            @can('create department')
            <a href="{{ route('department.create') }}" class="btn btn-primary shadow-sm rounded-pill px-3">
                <i class="fas fa-plus mr-1"></i> Tambah
            </a>
            @endcan
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="border-top-0 pl-4" style="width: 10%">Kode</th>
                        <th class="border-top-0">Nama Department</th>
                        <th class="border-top-0">Jumlah Pegawai</th>
                        <th class="border-top-0">Status</th>
                        <th class="border-top-0 text-center pr-4" style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($departments as $department)
                    <tr>
                        <td class="pl-4 align-middle font-weight-bold font-mono">{{ $department->code }}</td>
                        <td class="align-middle">
                            <div class="font-weight-bold">{{ $department->name }}</div>
                            <div class="text-muted small">{{ Str::limit($department->description, 50) }}</div>
                        </td>
                        <td class="align-middle">
                            <span class="badge badge-info px-2 py-1">{{ $department->pegawais_count ?? $department->pegawais()->count() }} Pegawai</span>
                        </td>
                        <td class="align-middle">
                            @if($department->is_active)
                                <span class="badge badge-success px-2 py-1">Aktif</span>
                            @else
                                <span class="badge badge-danger px-2 py-1">Non-aktif</span>
                            @endif
                        </td>
                        <td class="text-center align-middle pr-4">
                            @can('edit department')
                            <a href="{{ route('department.edit', $department->id) }}" class="btn btn-sm btn-warning text-white shadow-sm rounded-circle mx-1" title="Edit" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            @endcan
                            @can('delete department')
                            <form action="{{ route('department.destroy', $department->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm rounded-circle btn-delete" title="Hapus" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            @endcan
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-building fa-2x mb-3 opacity-50"></i>
                            <p class="mb-0">Tidak ada data department.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
