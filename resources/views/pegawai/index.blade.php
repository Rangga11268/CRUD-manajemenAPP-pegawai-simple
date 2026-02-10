@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Data Pegawai</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pegawai</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark font-weight-bold">
            <i class="fas fa-users mr-2 text-primary"></i>Data Pegawai
        </h5>
        <div class="d-flex">
            <form class="form-inline d-inline-block mr-2" action="{{ route('pegawai.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="nama_pegawai" class="form-control border-right-0" placeholder="Cari Pegawai..." value="{{ $nama_pegawai }}" style="border-top-left-radius: 20px; border-bottom-left-radius: 20px;">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary border-left-0" type="submit" style="border-top-right-radius: 20px; border-bottom-right-radius: 20px;">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </div>
            </form>
            <button type="button" class="btn btn-success text-white mr-2 shadow-sm rounded-pill px-3" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-file-excel mr-1"></i> Import
            </button>
            <a href="{{ route('pegawai.create') }}" class="btn btn-primary shadow-sm rounded-pill px-3">
                <i class="fas fa-plus mr-1"></i> Tambah
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="border-top-0 pl-4">Nama / NIK</th>
                        <th class="border-top-0">Jabatan & Dept</th>
                        <th class="border-top-0">Kontak</th>
                        <th class="border-top-0">Status</th>
                        <th class="border-top-0 text-center pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pegawais as $pegawai)
                    <tr>
                        <td class="pl-4 align-middle">
                            <div class="d-flex align-items-center">
                                <div class="c-avatar mr-3">
                                    <img class="c-avatar-img" src="{{ $pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png' ? asset('storage/' . $pegawai->image) : 'https://ui-avatars.com/api/?name='.urlencode($pegawai->nama_pegawai).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $pegawai->nama_pegawai }}">
                                </div>
                                <div>
                                    <div class="font-weight-bold text-dark">{{ $pegawai->nama_pegawai }}</div>
                                    <div class="small text-muted">{{ $pegawai->nik ?? '-' }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="align-middle">
                            <div class="font-weight-bold">{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</div>
                            <div class="small text-muted">{{ $pegawai->department->nama_department ?? '-' }}</div>
                        </td>
                        <td class="align-middle">
                            <div>{{ $pegawai->user->email ?? '-' }}</div>
                            <div class="small text-muted">{{ $pegawai->no_hp ?? '-' }}</div>
                        </td>
                        <td class="align-middle">
                            @php
                                $statusColors = [
                                    'aktif' => 'success',
                                    'cuti' => 'warning',
                                    'resign' => 'danger',
                                    'pensiun' => 'secondary',
                                ];
                                $colorClass = $statusColors[$pegawai->status] ?? 'secondary';
                            @endphp
                            <span class="badge badge-{{ $colorClass }} px-2 py-1">
                                {{ ucfirst($pegawai->status) }}
                            </span>
                        </td>
                        <td class="text-center align-middle pr-4">
                            <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-sm btn-info text-white shadow-sm rounded-circle" title="Detail" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-sm btn-warning text-white shadow-sm rounded-circle mx-1" title="Edit" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" class="d-inline-block">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger shadow-sm rounded-circle btn-delete" title="Hapus" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="fas fa-users-slash fa-2x mb-3 opacity-50"></i>
                            <p class="mb-0">Tidak ada data pegawai yang tersedia.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $pegawais->withQueryString()->links() }}
        </div>
    </div>
</div>

<!-- Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Import Data Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('pegawai.import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <p class="text-muted">Pastikan file Excel Anda sesuai dengan format template (Nama, Email, Password, dll).</p>
                    <div class="form-group">
                        <label>Pilih File Excel</label>
                        <input type="file" name="file" class="form-control-file" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Import Sekarang</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
