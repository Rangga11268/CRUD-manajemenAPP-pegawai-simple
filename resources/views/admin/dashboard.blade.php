@extends('layouts.admin')

@section('content')
<div class="fade-in">
    <!-- Welcome Banner -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-0 text-dark font-weight-bold">Dashboard</h2>
            <p class="text-muted mb-0">Selamat datang kembali, {{ auth()->user()->name }}! 👋</p>
        </div>
        <div class="text-right">
            <span class="text-muted small d-block">{{ date('l, d F Y') }}</span>
            <span class="h5 font-weight-bold text-primary">{{ date('H:i') }} WIB</span>
        </div>
    </div>

    <!-- Stats User (Pegawai Only) -->
    @if(auth()->user()->hasRole('pegawai'))
    <div class="row">
        <div class="col-md-6 col-lg-4 mb-4">
             <div class="card border-0 shadow-sm h-100 overflow-hidden">
                <div class="card-body p-4 d-flex align-items-center">
                    <div class="bg-primary-light p-3 rounded-circle mr-3 text-primary">
                        <i class="fas fa-user mb-0 fa-2x"></i>
                    </div>
                    <div>
                        <div class="text-value-lg text-primary">{{ auth()->user()->name }}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">Pegawai</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="card-title mb-0">Absensi Hari Ini</h5>
                        <span class="badge badge-info">{{ date('d M Y') }}</span>
                    </div>
                    
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center border-right">
                            <div class="text-muted small mb-1">Jam Masuk</div>
                            <h3 class="font-weight-bold text-success">{{ $todayAttendance && $todayAttendance->clock_in ? $todayAttendance->clock_in->format('H:i') : '--:--' }}</h3>
                        </div>
                        <div class="col-md-4 text-center border-right">
                            <div class="text-muted small mb-1">Jam Pulang</div>
                            <h3 class="font-weight-bold text-danger">{{ $todayAttendance && $todayAttendance->clock_out ? $todayAttendance->clock_out->format('H:i') : '--:--' }}</h3>
                        </div>
                        <div class="col-md-4 mt-3 mt-md-0">
                            @if(!$todayAttendance)
                                <form action="{{ route('attendance.clock-in') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-block shadow-sm py-2">
                                        <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                                    </button>
                                </form>
                            @elseif(!$todayAttendance->clock_out)
                                <form action="{{ route('attendance.clock-out') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-block shadow-sm py-2" onclick="return confirm('Apakah anda yakin ingin pulang?')">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Pulang
                                    </button>
                                </form>
                            @else
                                <div class="btn btn-outline-success btn-block disabled">
                                    <i class="fas fa-check-circle mr-2"></i> Selesai
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Admin Stats Widgets -->
    @can('view reports')
    <div class="row">
        <!-- Card 1: Total Pegawai -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-primary p-3 mfe-3 rounded">
                        <i class="fas fa-users fa-xl text-white"></i>
                    </div>
                    <div>
                        <div class="text-value text-primary">{{ $totalPegawai ?? 0 }}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">Total Pegawai</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 2: Hadir Hari Ini -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-success p-3 mfe-3 rounded">
                        <i class="fas fa-user-check fa-xl text-white"></i>
                    </div>
                    <div>
                        <div class="text-value text-success">{{ $todayAttendanceCount ?? 0 }}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">Hadir Hari Ini</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 3: Terlambat -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-warning p-3 mfe-3 rounded">
                        <i class="fas fa-user-clock fa-xl text-white"></i>
                    </div>
                    <div>
                        <div class="text-value text-warning">{{ $todayLateCount ?? 0 }}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">Terlambat</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card 4: Sedang Cuti -->
        <div class="col-sm-6 col-lg-3">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-3 d-flex align-items-center">
                    <div class="bg-danger p-3 mfe-3 rounded">
                        <i class="fas fa-calendar-minus fa-xl text-white"></i>
                    </div>
                    <div>
                        <div class="text-value text-danger">{{ $todayLeavesCount ?? 0 }}</div>
                        <div class="text-muted text-uppercase font-weight-bold small">Sedang Cuti</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts & Calendar Section -->
    <div class="row">
        <!-- Left: Charts -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 text-dark">Statistik Kepegawaian</h5>
                </div>
                <div class="card-body">
                    <div class="c-chart-wrapper" style="height:300px;">
                        <div id="dashboardDeptChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right: Calendar & Actions -->
        <div class="col-lg-4">
            <!-- Upcoming Events -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0 text-dark">Agenda Terdekat</h5>
                    <a href="{{ route('calendar.index') }}" class="small text-primary font-weight-bold">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($upcomingEvents ?? [] as $event)
                            <li class="list-group-item border-0 px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3 text-center">
                                        <div class="text-uppercase small font-weight-bold text-muted">{{ $event->start_date->format('M') }}</div>
                                        <div class="h4 mb-0 font-weight-bold {{ $event->is_day_off ? 'text-danger' : 'text-dark' }}">{{ $event->start_date->format('d') }}</div>
                                    </div>
                                    <div class="flex-grow-1 border-left pl-3">
                                        <div class="font-weight-bold text-dark">{{ Str::limit($event->title, 25) }}</div>
                                        <small class="text-muted">
                                            @if($event->category == 'holiday')
                                                <i class="fas fa-umbrella-beach text-danger mr-1"></i> Libur Nasional
                                            @elseif($event->category == 'cuti_bersama')
                                                <i class="fas fa-plane-departure text-warning mr-1"></i> Cuti Bersama
                                            @else
                                                <i class="fas fa-briefcase text-info mr-1"></i> Event
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item border-0 text-center py-4">
                                <img src="https://img.icons8.com/ios/50/dddddd/calendar--v1.png" alt="No Events" class="mb-2" style="opacity: 0.5; width: 40px;">
                                <p class="text-muted small mb-0">Tidak ada agenda dalam waktu dekat.</p>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="card-title mb-0 text-dark">Akses Cepat</h5>
                </div>
                <div class="card-body">
                    <div class="row no-gutters">
                        <div class="col-6 p-2">
                            <a href="{{ route('pegawai.create') }}" class="btn btn-outline-primary btn-block p-3">
                                <i class="fas fa-user-plus d-block fa-2x mb-2"></i>
                                <small>Tambah Pegawai</small>
                            </a>
                        </div>
                        <div class="col-6 p-2">
                            <a href="{{ route('salary.create') }}" class="btn btn-outline-success btn-block p-3">
                                <i class="fas fa-money-bill-wave d-block fa-2x mb-2"></i>
                                <small>Buat Slip Gaji</small>
                            </a>
                        </div>
                        <div class="col-6 p-2">
                            <a href="{{ route('attendance.index') }}" class="btn btn-outline-info btn-block p-3">
                                <i class="fas fa-clock d-block fa-2x mb-2"></i>
                                <small>Cek Absensi</small>
                            </a>
                        </div>
                        <div class="col-6 p-2">
                            <a href="{{ route('reports.index') }}" class="btn btn-outline-dark btn-block p-3">
                                <i class="fas fa-chart-pie d-block fa-2x mb-2"></i>
                                <small>Laporan</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <!-- Recent Employees Table -->
    @can('view pegawai')
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
            <h5 class="card-title mb-0 text-dark"><i class="fas fa-user-clock mr-2 text-warning"></i>Pegawai Terbaru</h5>
             <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-light text-primary">Lihat Semua Data</a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-striped mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th class="border-top-0 pl-4">Nama Pegawai</th>
                            <th class="border-top-0">Jabatan</th>
                            <th class="border-top-0">Department</th>
                            <th class="border-top-0">Status</th>
                            <th class="border-top-0 text-right pr-4">Bergabung</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($recentPegawai ?? [] as $pegawai)
                        <tr>
                            <td class="pl-4">
                                <div class="d-flex align-items-center">
                                    <div class="c-avatar mr-3">
                                          <img class="c-avatar-img" src="{{ $pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png' ? asset('storage/' . $pegawai->image) : 'https://ui-avatars.com/api/?name='.urlencode($pegawai->nama_pegawai).'&color=7F9CF5&background=EBF4FF' }}" alt="{{ $pegawai->nama_pegawai }}">
                                    </div>
                                    <div>
                                        <div class="font-weight-bold text-dark">{{ $pegawai->nama_pegawai }}</div>
                                        <div class="small text-muted">{{ $pegawai->user->email ?? '-' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</td>
                            <td>{{ $pegawai->department->nama_department ?? '-' }}</td>
                            <td>
                                <span class="badge badge-success px-2 py-1">Aktif</span>
                            </td>
                            <td class="text-right pr-4">
                                <div class="font-weight-bold text-dark">{{ $pegawai->created_at->format('d M Y') }}</div>
                                <div class="small text-muted">{{ $pegawai->created_at->diffForHumans() }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                Tidak ada data pegawai baru.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endcan
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
                        series: [{
                            name: 'Jumlah Pegawai',
                            data: data.department.data
                        }],
                        chart: { type: 'bar', height: 300, fontFamily: 'Nunito, sans-serif', toolbar: {show: false} },
                        plotOptions: { bar: { borderRadius: 4, horizontal: true, distributed: true } },
                        dataLabels: { enabled: true, style: { colors: ['#fff'] } },
                        xaxis: { categories: data.department.labels },
                        colors: ['#321fdb', '#3399ff', '#f9b115', '#e55353', '#2eb85c'],
                        legend: { show: false },
                        grid: { borderColor: '#f1f1f1' }
                    };
                    new ApexCharts(document.querySelector("#dashboardDeptChart"), deptOptions).render();
                })
                .catch(error => console.error('Error fetching chart data:', error));
        });
    </script>
    @endcan
@endsection
