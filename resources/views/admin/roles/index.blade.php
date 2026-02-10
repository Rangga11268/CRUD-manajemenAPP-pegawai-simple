@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark font-weight-bold">
                            <i class="fas fa-user-shield mr-2 text-primary"></i>Manajemen Role & Hak Akses
                        </h5>
                        <a href="{{ route('roles.create') }}" class="btn btn-primary shadow-sm rounded-pill px-3">
                            <i class="fas fa-plus mr-1"></i> Tambah Role
                        </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-top-0 pl-4">Role</th>
                                        <th class="border-top-0">Hak Akses (Permissions)</th>
                                        <th class="border-top-0 text-center pr-4" style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($roles as $role)
                                    <tr>
                                        <td class="pl-4 align-middle">
                                            <span class="font-weight-bold">{{ $role->name }}</span>
                                        </td>
                                        <td class="align-middle">
                                            @foreach($role->permissions->take(5) as $permission)
                                                <span class="badge badge-info px-2 py-1 mr-1 mb-1">{{ $permission->name }}</span>
                                            @endforeach
                                            @if($role->permissions->count() > 5)
                                                <span class="badge badge-secondary px-2 py-1">+{{ $role->permissions->count() - 5 }} lainnya</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle pr-4">
                                            <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-sm btn-info text-white shadow-sm rounded-circle mx-1" title="Edit" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('roles.destroy', $role->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus role ini?');">
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
                                        <td colspan="3" class="text-center py-5 text-muted">
                                            <i class="fas fa-user-lock fa-2x mb-3 opacity-50"></i>
                                            <p class="mb-0">Belum ada data role.</p>
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
    </div>
</div>
@endsection
