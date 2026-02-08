@extends('layouts.admin')

@section('content')
<div class="row">
    <!-- User Info Card -->
    <div class="col-sm-6 col-lg-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <strong>Information</strong>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="c-avatar mr-3">
                        <img class="c-avatar-img" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ auth()->user()->email }}">
                    </div>
                    <div>
                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                        <div class="text-muted small">{{ auth()->user()->getRoleNames()->first() ?? 'Pegawai' }}</div>
                        <span class="badge badge-success mt-1">Active Now</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Attendance Widget (Only for Pegawai) -->
    @if(auth()->user()->hasRole('pegawai'))
    <div class="col-sm-6 col-lg-8">
        <div class="card">
            <div class="card-header">
                <strong>Absensi Hari Ini</strong> <small>{{ date('d M Y') }}</small>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="callout callout-info">
                            <small class="text-muted">Jam Masuk</small>
                            <br>
                            <strong class="h4 text-success">{{ $todayAttendance && $todayAttendance->clock_in ? $todayAttendance->clock_in->format('H:i') : '--:--' }}</strong>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="callout callout-danger">
                            <small class="text-muted">Jam Pulang</small>
                            <br>
                            <strong class="h4 text-danger">{{ $todayAttendance && $todayAttendance->clock_out ? $todayAttendance->clock_out->format('H:i') : '--:--' }}</strong>
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    @if(!$todayAttendance)
                        <form action="{{ route('attendance.clock-in') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg btn-block">Absen Masuk</button>
                        </form>
                    @elseif(!$todayAttendance->clock_out)
                        <form action="{{ route('attendance.clock-out') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-lg btn-block">Absen Pulang</button>
                        </form>
                    @else
                        <div class="alert alert-success text-center">✓ Absensi Selesai</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

<div class="row">
    <!-- Stats Widgets -->
    <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-primary">
            <div class="card-body pb-0">
                <div class="text-value-lg">{{ $totalPegawai ?? 0 }}</div>
                <div>Total Pegawai</div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                <i class="cil-user c-icon c-icon-5xl" style="opacity: 0.5; position: absolute; right: 10px; bottom: 10px;"></i>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-info">
            <div class="card-body pb-0">
                <div class="text-value-lg">{{ $totalJabatan ?? 0 }}</div>
                <div>Total Jabatan</div>
            </div>
            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                <i class="cil-briefcase c-icon c-icon-5xl" style="opacity: 0.5; position: absolute; right: 10px; bottom: 10px;"></i>
            </div>
        </div>
    </div>
</div>

<!-- Charts -->
@can('view reports')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Pegawai per Departemen</div>
            <div class="card-body">
                <div class="c-chart-wrapper">
                    <div id="dashboardDeptChart"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">Tren Kehadiran (7 Hari)</div>
            <div class="card-body">
                <div class="c-chart-wrapper">
                    <div id="dashboardAttendanceChart"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan

<!-- Recent Employees -->
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <strong>Pegawai Baru</strong>
                <div class="card-header-actions">
                    <a href="{{ route('pegawai.index') }}" class="card-header-action">View All</a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm table-striped">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jabatan</th>
                            <th>Tanggal Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentPegawai ?? [] as $pegawai)
                        <tr>
                            <td>{{ $pegawai->nama_pegawai }}</td>
                            <td>{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</td>
                            <td>{{ $pegawai->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection

@section('javascript')
    @can('view reports')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            fetch('{{ route('reports.chart-data') }}')
                .then(response => response.json())
                .then(data => {
                    // Department Chart
                    var deptOptions = {
                        series: data.department.data,
                        chart: { type: 'donut', height: 280, fontFamily: 'Inter, sans-serif' },
                        labels: data.department.labels,
                        colors: ['#321fdb', '#9da5b1', '#e55353', '#2eb85c', '#f9b115'],
                        legend: { position: 'bottom' },
                        plotOptions: { pie: { donut: { size: '65%' } } }
                    };
                    new ApexCharts(document.querySelector("#dashboardDeptChart"), deptOptions).render();

                    // Attendance Chart
                    var attendanceOptions = {
                        series: [{ name: 'Hadir', data: data.attendance.onTime }, { name: 'Telat', data: data.attendance.late }],
                        chart: { type: 'bar', height: 280, stacked: true, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
                        xaxis: { categories: data.attendance.labels, axisBorder: { show: false }, axisTicks: { show: false } },
                        yaxis: { labels: { show: false } },
                        grid: { show: false },
                        colors: ['#2eb85c', '#e55353'],
                        dataLabels: { enabled: false }
                    };
                    new ApexCharts(document.querySelector("#dashboardAttendanceChart"), attendanceOptions).render();
                });
        });
    </script>
    @endcan
@endsection
