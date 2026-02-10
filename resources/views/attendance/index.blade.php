@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Laporan Absensi</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Attendance</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark font-weight-bold">
            <i class="fas fa-clock mr-2 text-primary"></i>Data Absensi
        </h5>
        
        @if(auth()->user()->hasRole('pegawai'))
            <div class="d-flex">
                <form action="{{ route('attendance.clock-in') }}" method="POST" class="mr-2">
                    @csrf
                    <button type="submit" class="btn btn-success text-white shadow-sm rounded-pill px-4">
                        <i class="fas fa-sign-in-alt mr-2"></i> Clock In
                    </button> // 
                </form>
                <form action="{{ route('attendance.clock-out') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger text-white shadow-sm rounded-pill px-4">
                        <i class="fas fa-sign-out-alt mr-2"></i> Clock Out
                    </button>
                </form>
            </div>
        @else
            <a href="{{ route('attendance.create') }}" class="btn btn-primary shadow-sm rounded-pill px-3">
                <i class="fas fa-plus-circle mr-1"></i> Input Absensi
            </a>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="border-top-0 pl-4">Tanggal</th>
                        <th class="border-top-0">Pegawai</th>
                        <th class="border-top-0">Jam Masuk</th>
                        <th class="border-top-0">Jam Pulang</th>
                        <th class="border-top-0">Status</th>
                        <th class="border-top-0">Durasi Kerja</th>
                        @if(!auth()->user()->hasRole('pegawai'))
                        <th class="border-top-0 text-center pr-4" style="width: 120px;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                    <tr>
                        <td class="pl-4 align-middle font-weight-bold">{{ $attendance->tanggal->format('d M Y') }}</td>
                        <td class="align-middle">
                            <div class="font-weight-bold">{{ $attendance->pegawai->nama_pegawai }}</div>
                            <div class="text-muted small">{{ $attendance->pegawai->user->department->name ?? '-' }}</div>
                        </td>
                        <td class="align-middle text-success">{{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '-' }}</td>
                        <td class="align-middle text-danger">{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '-' }}</td>
                        <td class="align-middle">
                             <span class="badge badge-{{ $attendance->status === 'hadir' ? 'success' : ($attendance->status === 'telat' ? 'warning' : 'danger') }} px-2 py-1">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td class="align-middle">
                            @if($attendance->clock_in && $attendance->clock_out)
                                @php
                                    $start = \Carbon\Carbon::parse($attendance->clock_in);
                                    $end = \Carbon\Carbon::parse($attendance->clock_out);
                                    $diff = $start->diff($end);
                                @endphp
                                <span class="badge badge-light border">{{ $diff->format('%H Jam %I Menit') }}</span>
                            @else
                                -
                            @endif
                        </td>
                        @if(!auth()->user()->hasRole('pegawai'))
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group" role="group">
                                <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-sm btn-warning text-white shadow-sm rounded-circle mx-1" title="Edit" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data absensi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm rounded-circle" title="Hapus" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-clock fa-2x mb-3 opacity-50"></i>
                            <p class="mb-0">Belum ada data absensi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
