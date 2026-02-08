@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Daftar Cuti</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Cuti</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Pengajuan Cuti</strong>
        @if(auth()->user()->hasRole('pegawai'))
        <a href="{{ route('leave.create') }}" class="btn btn-primary">
            <i class="cil-plus c-icon mr-1"></i> Ajukan Cuti
        </a>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Pegawai</th>
                        <th>Jenis Cuti</th>
                        <th>Tanggal</th>
                        <th>Durasi</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leaves as $leave)
                    <tr>
                        <td class="font-weight-bold">{{ $leave->pegawai->nama_pegawai }}</td>
                        <td>{{ $leave->leaveType->nama }}</td>
                        <td>{{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M Y') }}</td>
                        <td>{{ $leave->days_count }} hari</td>
                        <td>
                            @php
                                $statusColors = [
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                    'pending' => 'warning',
                                ];
                                $color = $statusColors[$leave->status] ?? 'secondary';
                            @endphp
                            <span class="badge badge-{{ $color }}">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            @if($leave->status === 'pending' && auth()->user()->can('approve leave'))
                                <div class="d-flex justify-content-center">
                                    <form action="{{ route('leave.approve', $leave) }}" method="POST" class="mr-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success text-white" title="Approve">
                                            <i class="cil-check c-icon"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('leave.reject', $leave) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="rejection_reason" value="Rejected by admin">
                                        <button type="submit" class="btn btn-sm btn-danger text-white" title="Reject">
                                            <i class="cil-x c-icon"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada data cuti.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $leaves->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
