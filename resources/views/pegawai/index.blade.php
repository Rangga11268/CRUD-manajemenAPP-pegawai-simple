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

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Data Pegawai</strong>
        <div>
            <form class="form-inline d-inline-block mr-3" action="{{ route('pegawai.index') }}" method="GET">
                <div class="input-group">
                    <input type="text" name="nama_pegawai" class="form-control" placeholder="Cari nama atau NIK..." value="{{ $nama_pegawai }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search c-icon"></i>
                        </button>
                    </div>
                </div>
            </form>
            <button type="button" class="btn btn-success text-white mr-1" data-toggle="modal" data-target="#importModal">
                <i class="fas fa-file-excel mr-1"></i> Import Excel
            </button>
            <a href="{{ route('pegawai.create') }}" class="btn btn-primary">
                <i class="fas fa-plus mr-1"></i> Tambah Pegawai
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Nama / NIK</th>
                        <th>Jabatan & Dept</th>
                        <th>Kontak</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pegawais as $pegawai)
                    <tr>
                        <td>
                            <div class="font-weight-bold">{{ $pegawai->nama_pegawai }}</div>
                            <div class="small text-muted">{{ $pegawai->nik }}</div>
                        </td>
                        <td>
                            <div>{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</div>
                            <div class="small text-muted">{{ $pegawai->department->name ?? '-' }}</div>
                        </td>
                        <td>
                            <div>{{ $pegawai->email }}</div>
                            <div class="small text-muted">{{ $pegawai->telepon }}</div>
                        </td>
                        <td>
                            @php
                                $statusColors = [
                                    'aktif' => 'success',
                                    'cuti' => 'warning',
                                    'resign' => 'danger',
                                    'pensiun' => 'secondary',
                                ];
                                $colorClass = $statusColors[$pegawai->status] ?? 'secondary';
                            @endphp
                            <span class="badge badge-{{ $colorClass }}">
                                {{ ucfirst($pegawai->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pegawai.show', $pegawai->id) }}" class="btn btn-sm btn-info text-white" title="Detail">
                                <i class="fas fa-info-circle c-icon"></i>
                            </a>
                            <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fas fa-edit c-icon"></i>
                            </a>
                            <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
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
                        <td colspan="5" class="text-center">
                            Tidak ada data pegawai yang tersedia.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        {{ $pegawais->withQueryString()->links() }}
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
