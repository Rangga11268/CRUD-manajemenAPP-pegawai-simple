@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Detail Pengajuan Cuti</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('leave.index') }}">Cuti</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card border-0 shadow-sm rounded-lg mb-4">
            <div class="card-header bg-white border-bottom-0 py-3">
                <h5 class="mb-0 text-dark font-weight-bold">
                    <i class="fas fa-info-circle mr-2 text-primary"></i>Informasi Cuti
                </h5>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4 text-muted font-weight-bold">Pegawai</div>
                    <div class="col-md-8 font-weight-bold">{{ $leave->pegawai->nama_pegawai }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted font-weight-bold">Jenis Cuti</div>
                    <div class="col-md-8">{{ $leave->leaveType->nama }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted font-weight-bold">Tanggal</div>
                    <div class="col-md-8">
                        {{ $leave->start_date->format('d M Y') }} s/d {{ $leave->end_date->format('d M Y') }}
                        <span class="badge badge-info ml-2">{{ $leave->days_count }} Hari</span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted font-weight-bold">Alasan</div>
                    <div class="col-md-8 text-break">{{ $leave->alasan }}</div>
                </div>
                <hr>
                <div class="row mb-3">
                    <div class="col-md-4 text-muted font-weight-bold">Status</div>
                    <div class="col-md-8">
                        @php
                            $statusColors = [
                                'approved' => 'success',
                                'rejected' => 'danger',
                                'pending' => 'warning',
                            ];
                            $color = $statusColors[$leave->status] ?? 'secondary';
                        @endphp
                        <span class="badge badge-{{ $color }} px-3 py-2 rounded-pill">
                            {{ ucfirst($leave->status) }}
                        </span>
                    </div>
                </div>

                @if($leave->status !== 'pending')
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted font-weight-bold">Diproses Oleh</div>
                        <div class="col-md-8">{{ $leave->approver->name ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 text-muted font-weight-bold">Diproses Pada</div>
                        <div class="col-md-8">{{ $leave->approved_at ? $leave->approved_at->format('d M Y H:i') : '-' }}</div>
                    </div>
                    @if($leave->status === 'rejected')
                        <div class="row mb-3">
                            <div class="col-md-4 text-muted font-weight-bold">Alasan Penolakan</div>
                            <div class="col-md-8 text-danger">{{ $leave->rejection_reason ?? '-' }}</div>
                        </div>
                    @endif
                @endif
            </div>
            <div class="card-footer bg-white border-top-0 py-3 text-right">
                <a href="{{ route('leave.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm">Kembali</a>
                
                @if($leave->status === 'pending' && $leave->pegawai_id === auth()->user()->pegawai->id)
                    <a href="{{ route('leave.edit', $leave->id) }}" class="btn btn-warning rounded-pill px-4 shadow-sm ml-2 text-white">
                        <i class="fas fa-edit mr-1"></i> Edit
                    </a>
                    <form action="{{ route('leave.destroy', $leave->id) }}" method="POST" class="d-inline-block ml-2" onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengajuan ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill px-4 shadow-sm">
                            <i class="fas fa-trash mr-1"></i> Hapus
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
