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
            @if(!auth()->user()->hasRole('pegawai'))
                <a href="{{ route('attendance.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle c-icon mr-1"></i> Input Absensi
                </a>
            @else
            <div class="d-flex">
                <form action="{{ route('attendance.clock-in') }}" method="POST" class="mr-2">
                    @csrf
                    <button type="submit" class="btn btn-success text-white">
                        <i class="fas fa-sign-in-alt c-icon mr-1"></i> Clock In
                    </button>
                </form>
                <form action="{{ route('attendance.clock-out') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger text-white">
                        <i class="fas fa-sign-out-alt c-icon mr-1"></i> Clock Out
                    </button>
                </form>
            </div>
            @endif
        @endif
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover datatable">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Pegawai</th>
                        <th>Jam Masuk</th>
                        <th>Jam Pulang</th>
                        <th>Status</th>
                        <th>Durasi Kerja</th>
                        @if(!auth()->user()->hasRole('pegawai'))
                        <th class="text-center" style="width: 120px;">Aksi</th>
                        @endif
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
                             <span class="badge badge-{{ $attendance->status === 'hadir' ? 'success' : ($attendance->status === 'telat' ? 'warning' : 'danger') }}">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td>
                            @if($attendance->clock_in && $attendance->clock_out)
                                @php
                                    $start = \Carbon\Carbon::parse($attendance->clock_in);
                                    $end = \Carbon\Carbon::parse($attendance->clock_out);
                                    $diff = $start->diff($end);
                                @endphp
                                {{ $diff->format('%H Jam %I Menit') }}
                            @else
                                -
                            @endif
                        </td>
                        @if(!auth()->user()->hasRole('pegawai'))
                        <td class="text-center">
                            <div class="btn-group" role="group">
                                <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-sm btn-warning text-white" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data absensi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
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
    </div>
</div>
@endsection
