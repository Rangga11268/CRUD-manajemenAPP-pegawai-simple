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

<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <strong>Data Absensi</strong>
        
        @if(auth()->user()->hasRole('pegawai'))
            <div class="d-flex">
                <form action="{{ route('attendance.clock-in') }}" method="POST" class="mr-2">
                    @csrf
                    <button type="submit" class="btn btn-success text-white">
                        <i class="cil-account-logout c-icon mr-1"></i> Clock In
                    </button>
                </form>
                <form action="{{ route('attendance.clock-out') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger text-white">
                        <i class="cil-account-logout c-icon mr-1" style="transform: scaleX(-1);"></i> Clock Out
                    </button>
                </form>
            </div>
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pegawai</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        <th>Durasi Kerja</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                    <tr>
                        <td class="font-weight-bold">{{ $attendance->tanggal->format('d M Y') }}</td>
                        <td>
                            <div class="font-weight-bold">{{ $attendance->pegawai->nama_pegawai }}</div>
                            <div class="text-muted small">{{ $attendance->pegawai->user->department->name ?? '-' }}</div>
                        </td>
                        <td>{{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '-' }}</td>
                        <td>{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $attendance->status === 'hadir' ? 'success' : 'warning' }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td>{{ $attendance->work_hours ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">
                            Belum ada data absensi.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-3">
            {{ $attendances->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
