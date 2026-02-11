@extends('layouts.admin')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0">Dashboard</h2>
        </div>
    </div>

    <div class="row">
        <!-- Left Column (User Info & Attendance) -->
        <div class="col-xl-4 col-lg-5 mb-4">
            <!-- User Info Card -->
            <div class="card shadow-sm border-0 mb-4 rounded-lg">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <img class="rounded-lg mr-3 shadow-sm" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" alt="Avatar" width="80" height="80">
                        <div>
                            <h4 class="mb-1 font-weight-bold text-dark">{{ auth()->user()->name }}</h4>
                            <div class="text-muted mb-2">
                                {{ auth()->user()->getRoleNames()->first() ?? 'Pegawai' }}
                            </div>
                            <span class="badge badge-pill badge-success px-3 py-1">Active Now</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Widget -->
            @if(auth()->user()->hasRole('pegawai'))
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-body">
                    <h5 class="mb-4 font-weight-bold text-dark border-bottom pb-2">Absensi Hari Ini</h5>
                    <div class="d-flex justify-content-between mb-4">
                        <div class="font-weight-bold text-muted">{{ date('d M Y') }}</div>
                    </div>
                    
                    <div class="mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="text-muted">Jam Masuk</span>
                            <span class="h5 font-weight-bold text-success mb-0">{{ $todayAttendance->clock_in ? $todayAttendance->clock_in->format('H:i') : '--:--' }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center border-top pt-2">
                            <span class="text-muted">Jam Pulang</span>
                            <span class="h5 font-weight-bold text-danger mb-0">{{ $todayAttendance->clock_out ? $todayAttendance->clock_out->format('H:i') : '--:--' }}</span>
                        </div>
                    </div>

                    <div>
                        @if(!$todayAttendance)
                            <form action="{{ route('attendance.clock-in') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success btn-block rounded-pill font-weight-bold py-2 shadow-sm">
                                    <i class="fas fa-sign-in-alt mr-2"></i>Absen Masuk
                                </button>
                            </form>
                        @elseif(!$todayAttendance->clock_out)
                            <form action="{{ route('attendance.clock-out') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-block rounded-pill font-weight-bold py-2 shadow-sm">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Absen Pulang
                                </button>
                            </form>
                        @else
                            <div class="alert alert-success text-center font-weight-bold rounded-pill mb-0">
                                <i class="fas fa-check-circle mr-1"></i> Absensi Selesai
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column (Stats & Charts) -->
        <div class="col-xl-8 col-lg-7">
            <!-- Stats Row -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4 mb-md-0">
                    <div class="card shadow-sm border-0 rounded-lg h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-primary text-white rounded p-3 mr-3 shadow-sm">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <div>
                                <div class="text-muted text-uppercase font-weight-bold small">Total Pegawai</div>
                                <div class="h3 font-weight-bold text-dark mb-0">{{ $totalPegawai ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm border-0 rounded-lg h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="bg-purple text-white rounded p-3 mr-3 shadow-sm" style="background-color: #6f42c1;">
                                <i class="fas fa-sitemap fa-2x"></i>
                            </div>
                            <div>
                                <div class="text-muted text-uppercase font-weight-bold small">Total Jabatan</div>
                                <div class="h3 font-weight-bold text-dark mb-0">{{ $totalJabatan ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            @can('view reports')
            <div class="row mb-4">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="card shadow-sm border-0 rounded-lg h-100">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-dark mb-4">Pegawai per Departemen</h5>
                            <div id="dashboardDeptChart"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="card shadow-sm border-0 rounded-lg h-100">
                        <div class="card-body">
                            <h5 class="card-title font-weight-bold text-dark mb-4">Tren Kehadiran (7 Hari)</h5>
                            <div id="dashboardAttendanceChart"></div>
                        </div>
                    </div>
                </div>
            </div>
            @endcan

            <!-- Recent Employees -->
            <div class="card shadow-sm border-0 rounded-lg">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                     <h5 class="mb-0 font-weight-bold text-dark">Pegawai Baru</h5>
                     <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-outline-primary rounded-pill">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="border-top-0">Nama</th>
                                    <th class="border-top-0">Jabatan</th>
                                    <th class="border-top-0">Tanggal Bergabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentPegawai ?? [] as $pegawai)
                                <tr>
                                    <td class="font-weight-bold text-dark">{{ $pegawai->nama_pegawai }}</td>
                                    <td class="text-muted">{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</td>
                                    <td class="text-muted">{{ $pegawai->created_at->format('d M Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">Belum ada data.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @can('view reports')
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const isDark = document.body.classList.contains('c-dark-theme');
            const textColor = isDark ? '#a0aec0' : '#64748b';
            const fontFamily = 'Nunito, sans-serif';

            fetch('{{ route('reports.chart-data') }}')
                .then(response => response.json())
                .then(data => {
                    // Department Chart
                    var deptOptions = {
                        series: data.department.data,
                        chart: { type: 'donut', height: 280, fontFamily: fontFamily, foreColor: textColor },
                        labels: data.department.labels,
                        colors: ['#321fdb', '#9da5b1', '#e55353', '#2eb85c', '#f9b115'],
                        legend: { position: 'bottom', labels: { colors: textColor } },
                        plotOptions: { pie: { donut: { size: '65%' } } },
                        dataLabels: { style: { colors: [textColor] } }
                    };
                    var deptChart = new ApexCharts(document.querySelector("#dashboardDeptChart"), deptOptions);
                    deptChart.render();

                    // Attendance Chart
                    var attendanceOptions = {
                        series: [{ name: 'Hadir', data: data.attendance.onTime }, { name: 'Telat', data: data.attendance.late }],
                        chart: { type: 'bar', height: 280, stacked: true, toolbar: { show: false }, fontFamily: fontFamily, foreColor: textColor },
                        xaxis: { 
                            categories: data.attendance.labels, 
                            axisBorder: { show: false }, 
                            axisTicks: { show: false },
                            labels: { style: { colors: textColor } }
                        },
                        yaxis: { labels: { show: false } },
                        grid: { show: false },
                        colors: ['#2eb85c', '#e55353'],
                        dataLabels: { enabled: false },
                        legend: { labels: { colors: textColor } }
                    };
                    var attendanceChart = new ApexCharts(document.querySelector("#dashboardAttendanceChart"), attendanceOptions);
                    attendanceChart.render();
                    
                    // Listen for Dark Mode Toggle
                    document.getElementById('darkModeToggle').addEventListener('click', function() {
                        setTimeout(() => {
                            const newIsDark = document.body.classList.contains('c-dark-theme');
                            const newColor = newIsDark ? '#a0aec0' : '#64748b';
                            
                            deptChart.updateOptions({
                                chart: { foreColor: newColor },
                                legend: { labels: { colors: newColor } }
                            });
                            
                            attendanceChart.updateOptions({
                                chart: { foreColor: newColor },
                                xaxis: { labels: { style: { colors: newColor } } },
                                legend: { labels: { colors: newColor } }
                            });
                        }, 100);
                    });
                });
        });
    </script>
    @endpush
    @endcan
@endsection

