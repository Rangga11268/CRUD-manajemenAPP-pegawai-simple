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

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark font-weight-bold">
            <i class="fas fa-calendar-minus mr-2 text-primary"></i>Pengajuan Cuti
        </h5>
        @if(auth()->user()->hasRole('pegawai'))
        <a href="{{ route('leave.create') }}" class="btn btn-primary shadow-sm rounded-pill px-3">
            <i class="fas fa-plus mr-1"></i> Ajukan Cuti
        </a>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="border-top-0 pl-4">Pegawai</th>
                        <th class="border-top-0">Jenis Cuti</th>
                        <th class="border-top-0">Tanggal</th>
                        <th class="border-top-0">Durasi</th>
                        <th class="border-top-0">Status</th>
                        <th class="border-top-0 text-center pr-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($leaves as $leave)
                    <tr>
                        <td class="pl-4 align-middle font-weight-bold">{{ $leave->pegawai->nama_pegawai }}</td>
                        <td class="align-middle">{{ $leave->leaveType->nama }}</td>
                        <td class="align-middle text-muted">
                            <i class="far fa-calendar-alt mr-1"></i> {{ $leave->start_date->format('d M') }} - {{ $leave->end_date->format('d M Y') }}
                        </td>
                        <td class="align-middle"><span class="badge badge-light border">{{ $leave->days_count }} hari</span></td>
                        <td class="align-middle">
                            @php
                                $statusColors = [
                                    'approved' => 'success',
                                    'rejected' => 'danger',
                                    'pending' => 'warning',
                                ];
                                $color = $statusColors[$leave->status] ?? 'secondary';
                            @endphp
                            <span class="badge badge-{{ $color }} px-2 py-1">
                                {{ ucfirst($leave->status) }}
                            </span>
                        </td>
                        <td class="text-center align-middle pr-4">
                            @if($leave->status === 'pending' && auth()->user()->can('approve leave'))
                                <div class="d-flex justify-content-center">
                                    <form action="{{ route('leave.approve', $leave) }}" method="POST" class="mr-2">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success text-white shadow-sm rounded-circle" title="Approve" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('leave.reject', $leave) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="rejection_reason" value="Rejected by admin">
                                        <button type="submit" class="btn btn-sm btn-danger text-white shadow-sm rounded-circle" title="Reject" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </form>
                                </div>
                            @else
                                <div class="d-flex justify-content-center">
                                    <a href="{{ route('leave.show', $leave->id) }}" class="btn btn-sm btn-info text-white shadow-sm rounded-circle mr-2" title="Detail" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    
                                    @if($leave->status === 'pending' && $leave->pegawai_id === auth()->user()->pegawai->id)
                                        <a href="{{ route('leave.edit', $leave->id) }}" class="btn btn-sm btn-warning text-white shadow-sm rounded-circle mr-2" title="Edit" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('leave.destroy', $leave->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger text-white shadow-sm rounded-circle" title="Hapus" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="fas fa-plane-departure fa-2x mb-3 opacity-50"></i>
                            <p class="mb-0">Belum ada data cuti.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $leaves->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection
