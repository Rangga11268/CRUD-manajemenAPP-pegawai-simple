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
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Pegawai</th>
                        <th>Periode</th>
                        <th>Gaji Dasar</th>
                        <th>Netto</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($salaries as $salary)
                    <tr>
                        <td>
                            <div class="font-weight-bold">{{ $salary->pegawai->nama_pegawai }}</div>
                            <div class="text-muted small">{{ $salary->pegawai->user->department->name ?? '-' }}</div>
                        </td>
                        <td>{{ $salary->periode }}</td>
                        <td>Rp {{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
                        <td class="font-weight-bold">Rp {{ number_format($salary->gaji_bersih, 0, ',', '.') }}</td>
                        <td class="text-center">
                            <a href="{{ route('salary.slip', $salary) }}" class="btn btn-sm btn-info text-white" title="Slip PDF">
                                <i class="fas fa-file-pdf c-icon"></i> Slip PDF
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">
                            Belum ada data penggajian.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $salaries->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
