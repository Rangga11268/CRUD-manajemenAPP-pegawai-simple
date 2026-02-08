@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Detail Gaji: {{ $salary->pegawai->nama_pegawai }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('salary.index') }}">Payroll</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Slip Gaji - {{ \Carbon\Carbon::parse($salary->periode)->translatedFormat('F Y') }}</strong>
        <div class="d-flex">
             <a href="{{ route('salary.slip', $salary) }}" class="btn btn-dark text-white mr-2">
                <i class="cil-file c-icon mr-1"></i> Download PDF
             </a>
             <a href="{{ route('salary.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
    <div class="card-body p-5">
        <div class="row mb-4">
            <div class="col-sm-6">
                <h4 class="mb-3 text-uppercase">Slip Gaji</h4>
                <div>Periode: <strong>{{ \Carbon\Carbon::parse($salary->periode)->translatedFormat('F Y') }}</strong></div>
            </div>
            <div class="col-sm-6 text-sm-right">
                <div>Diberikan pada:</div>
                <h5 class="text-primary">{{ $salary->tanggal_bayar ? $salary->tanggal_bayar->translatedFormat('d F Y') : '-' }}</h5>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-sm-6">
                <div><strong>Nama Pegawai:</strong> {{ $salary->pegawai->nama_pegawai }}</div>
                <div><strong>ID Pegawai (NIP):</strong> {{ $salary->pegawai->employee_id }}</div>
                <div><strong>Jabatan:</strong> {{ $salary->pegawai->jabatans->nama_jabatan ?? '-' }}</div>
            </div>
            <div class="col-sm-6">
                <div><strong>Department:</strong> {{ $salary->pegawai->department->name ?? '-' }}</div>
                <div><strong>Status Pajak:</strong> Sesuai Kebijakan</div>
            </div>
        </div>

        <div class="table-responsive-sm">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Deskripsi Komponen Gaji</th>
                        <th class="text-right">Jumlah (IDR)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="font-weight-bold text-primary">A. PENGHASILAN</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Gaji Pokok</td>
                        <td class="text-right">{{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
                    </tr>
                    @foreach($salary->components as $component)
                        @if($component->type == 'tunjangan')
                        <tr>
                            <td>{{ $component->nama }}</td>
                            <td class="text-right">{{ number_format($component->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    @endforeach
                    <tr class="font-weight-bold">
                        <td>Total Penghasilan Bruto (A)</td>
                        <td class="text-right">Rp {{ number_format($salary->gaji_pokok + $salary->total_tunjangan, 0, ',', '.') }}</td>
                    </tr>

                    <tr>
                        <td class="font-weight-bold text-danger">B. POTONGAN</td>
                        <td></td>
                    </tr>
                    @forelse($salary->components as $component)
                        @if($component->type == 'potongan')
                        <tr>
                            <td>{{ $component->nama }}</td>
                            <td class="text-right text-danger">- {{ number_format($component->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    @empty
                        <tr>
                            <td colspan="2" class="text-center font-italic text-muted">Tidak ada potongan</td>
                        </tr>
                    @endforelse
                    <tr class="font-weight-bold">
                        <td>Total Potongan (B)</td>
                        <td class="text-right text-danger">- Rp {{ number_format($salary->total_potongan, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-lg-4 col-sm-5 ml-auto">
                <table class="table table-clear">
                    <tbody>
                        <tr>
                            <td class="left"><strong>GAJI BERSIH (A - B)</strong></td>
                            <td class="text-right">
                                <h4 class="text-primary">Rp {{ number_format($salary->gaji_bersih, 0, ',', '.') }}</h4>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-right text-muted small mt-4">
             Slip ini dihasilkan secara otomatis oleh sistem pada {{ now()->translatedFormat('d F Y, H:i') }}.
        </div>
    </div>
</div>
@endsection
