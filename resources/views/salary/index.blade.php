@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Penggajian / Payroll</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Payroll</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Data Penggajian</strong>
        @can('create salary')
        <a href="{{ route('salary.create') }}" class="btn btn-primary">
            <i class="fas fa-plus c-icon mr-1"></i> Generate Payroll
        </a>
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Pegawai</th>
                        <th>Periode</th>
                        <th>Gaji Dasar</th>
                        <th>Tunjangan/Potongan</th>
                        <th>Netto (Bersih)</th>
                        <th class="text-center" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    @forelse ($salaries as $salary)
                    <tr>
                        <td>
                            <div class="font-weight-bold">{{ $salary->pegawai->nama_pegawai }}</div>
                            <div class="text-muted small">{{ $salary->pegawai->jabatans->nama_jabatan ?? '-' }}</div>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($salary->periode)->format('F Y') }}</td>
                        <td>
                            <span class="badge badge-light border">Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            <div class="d-flex flex-column">
                                <span class="text-success small"><i class="fas fa-plus mr-1"></i> Rp {{ number_format($salary->total_tunjangan, 0, ',', '.') }}</span>
                                <span class="text-danger small"><i class="fas fa-minus mr-1"></i> Rp {{ number_format($salary->total_potongan, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="font-weight-bold text-primary">Rp {{ number_format($salary->gaji_bersih, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('salary.slip', $salary) }}" class="btn btn-sm btn-info text-white" title="Download PDF" target="_blank">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                @can('create salary') {{-- Assuming edit permission is same as create or add specific permission later --}}
                                <a href="{{ route('salary.edit', $salary) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('salary.destroy', $salary) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data gaji ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                                @endcan
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-file-invoice-dollar fa-3x mb-3 d-block opacity-25"></i>
                            Belum ada data penggajian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
