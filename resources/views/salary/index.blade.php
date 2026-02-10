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

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark font-weight-bold">
            <i class="fas fa-money-bill-wave mr-2 text-primary"></i>Daftar Penggajian
        </h5>
        <div>
            <a href="{{ route('salary.bulk') }}" class="btn btn-success text-white mr-2 shadow-sm rounded-pill px-3">
                <i class="fas fa-magic mr-1"></i> Generate Massal
            </a>
            <a href="{{ route('salary.create') }}" class="btn btn-primary shadow-sm rounded-pill px-3">
                <i class="fas fa-plus mr-1"></i> Buat Slip Gaji
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="border-top-0 pl-4">Pegawai</th>
                        <th class="border-top-0">Periode</th>
                        <th class="border-top-0">Gaji Dasar</th>
                        <th class="border-top-0">Tunjangan/Potongan</th>
                        <th class="border-top-0">Netto (Bersih)</th>
                        <th class="border-top-0 text-center pr-4" style="width: 150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salaries as $salary)
                    <tr>
                        <td class="pl-4 align-middle">
                            <div class="font-weight-bold">{{ $salary->pegawai->nama_pegawai }}</div>
                            <div class="text-muted small">{{ $salary->pegawai->jabatans->nama_jabatan ?? '-' }}</div>
                        </td>
                        <td class="align-middle">
                            <i class="far fa-calendar-alt mr-1 text-muted"></i> {{ \Carbon\Carbon::parse($salary->periode)->format('F Y') }}
                        </td>
                        <td class="align-middle">
                            <span class="badge badge-light border">Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}</span>
                        </td>
                        <td class="align-middle">
                            <div class="d-flex flex-column">
                                <span class="text-success small"><i class="fas fa-plus mr-1"></i> Rp {{ number_format($salary->total_tunjangan, 0, ',', '.') }}</span>
                                <span class="text-danger small"><i class="fas fa-minus mr-1"></i> Rp {{ number_format($salary->total_potongan, 0, ',', '.') }}</span>
                            </div>
                        </td>
                        <td class="align-middle font-weight-bold text-primary">Rp {{ number_format($salary->gaji_bersih, 0, ',', '.') }}</td>
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group" role="group">
                                <a href="{{ route('salary.slip', $salary) }}" class="btn btn-sm btn-info text-white shadow-sm rounded-circle mx-1" title="Download PDF" target="_blank" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                    <i class="fas fa-file-pdf"></i>
                                </a>
                                @can('create salary')
                                <a href="{{ route('salary.edit', $salary) }}" class="btn btn-sm btn-warning text-white shadow-sm rounded-circle mx-1" title="Edit" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('salary.destroy', $salary) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data gaji ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm rounded-circle mx-1" title="Hapus" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
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
                            <i class="fas fa-file-invoice-dollar fa-3x mb-3 opacity-50"></i>
                            <p class="mb-0">Belum ada data penggajian.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
