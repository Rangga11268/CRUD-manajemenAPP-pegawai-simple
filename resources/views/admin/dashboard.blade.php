@extends('layouts.admin')

@section('content')
<div class="fade-in">
    <!-- Row 1: User Info & Stats/Attendance -->
    <div class="row mb-4">
        <!-- User Info Card -->
        <div class="col-md-4 mb-4 mb-md-0">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column align-items-center justify-content-center text-center">
                    <div class="c-avatar mb-3" style="width: 80px; height: 80px;">
                        @php
                            $pegawai = auth()->user()->pegawai;
                            $imagePath = $pegawai && $pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png' 
                                ? asset('storage/' . $pegawai->image) 
                                : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=7F9CF5&background=EBF4FF';
                        @endphp
                        <img class="c-avatar-img rounded-circle" src="{{ $imagePath }}" alt="{{ auth()->user()->email }}">
                    </div>
                    <h5 class="mb-1 text-primary">{{ auth()->user()->name }}</h5>
                    <div class="text-muted small mb-3">{{ auth()->user()->getRoleNames()->first() ?? 'Pegawai' }}</div>
                    
                    <div class="d-flex justify-content-center gap-2">
                         <span class="badge badge-success px-3 py-2"><i class="fas fa-circle text-white small mr-1"></i> Active Now</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side: Widget or Attendance -->
        <div class="col-md-8">
            @if(auth()->user()->hasRole('pegawai'))
                <!-- Attendance Widget for Pegawai -->
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-header bg-white font-weight-bold d-flex justify-content-between align-items-center border-bottom-0 pt-4 px-4">
                        <span><i class="fas fa-clock text-info mr-2"></i> Absensi Hari Ini</span>
                        <span class="text-muted small">{{ date('l, d F Y') }}</span>
                    </div>
                    <div class="card-body px-4 pb-4">
                        <div class="row text-center mb-4">
                            <div class="col-6 border-right">
                                <div class="text-muted small mb-1">Jam Masuk</div>
                                <h3 class="font-weight-bold text-success display-5">{{ $todayAttendance && $todayAttendance->clock_in ? $todayAttendance->clock_in->format('H:i') : '--:--' }}</h3>
                            </div>
                            <div class="col-6">
                                <div class="text-muted small mb-1">Jam Pulang</div>
                                <h3 class="font-weight-bold text-danger display-5">{{ $todayAttendance && $todayAttendance->clock_out ? $todayAttendance->clock_out->format('H:i') : '--:--' }}</h3>
                            </div>
                        </div>
                        
                        <div>
                             @if(!$todayAttendance)
                                <form action="{{ route('attendance.clock-in') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-block btn-lg shadow-sm">
                                        <i class="fas fa-sign-in-alt mr-2"></i> Absen Masuk
                                    </button>
                                </form>
                            @elseif(!$todayAttendance->clock_out)
                                <form action="{{ route('attendance.clock-out') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-block btn-lg shadow-sm" onclick="return confirm('Apakah anda yakin ingin pulang?')">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Absen Pulang
                                    </button>
                                </form>
                            @else
                                <div class="alert alert-light border-success text-success text-center font-weight-bold mb-0">
                                    <i class="fas fa-check-circle mr-2"></i> Absensi Hari Ini Selesai
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <!-- Admin Stats Widgets -->
                <div class="row">
                    <div class="col-sm-6 col-lg-3">
                         <div class="card text-white bg-gradient-info h-100 border-0 shadow-sm">
                            <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-value-lg">{{ $totalDepartment ?? 0 }}</div>
                                    <div>Departemen</div>
                                </div>
                                <div class="btn-group float-right">
                                    <i class="fas fa-building fa-2x" style="opacity: 0.4"></i>
                                </div>
                            </div>
                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-lg-3">
                         <div class="card text-white bg-gradient-primary h-100 border-0 shadow-sm">
                            <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-value-lg">{{ $totalPegawai ?? 0 }}</div>
                                    <div>Total Pegawai</div>
                                </div>
                                <div class="btn-group float-right">
                                    <i class="fas fa-users fa-2x" style="opacity: 0.4"></i>
                                </div>
                            </div>
                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                            </div>
                        </div>
                    </div>

                     <div class="col-sm-6 col-lg-3">
                         <div class="card text-white bg-gradient-success h-100 border-0 shadow-sm">
                            <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-value-lg">{{ $todayAttendanceCount ?? 0 }}</div>
                                    <div>Hadir Hari Ini</div>
                                </div>
                                <div class="btn-group float-right">
                                    <i class="fas fa-check-circle fa-2x" style="opacity: 0.4"></i>
                                </div>
                            </div>
                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                            </div>
                        </div>
                    </div>

                     <div class="col-sm-6 col-lg-3">
                         <div class="card text-white bg-gradient-warning h-100 border-0 shadow-sm">
                            <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-value-lg">{{ $todayLateCount ?? 0 }}</div>
                                    <div>Terlambat</div>
                                </div>
                                <div class="btn-group float-right">
                                    <i class="fas fa-clock fa-2x" style="opacity: 0.4"></i>
                                </div>
                            </div>
                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                            </div>
                        </div>
                    </div>

                     <div class="col-sm-6 col-lg-3">
                         <div class="card text-white bg-gradient-danger h-100 border-0 shadow-sm">
                            <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                                <div>
                                    <div class="text-value-lg">{{ $todayLeavesCount ?? 0 }}</div>
                                    <div>Sedang Cuti</div>
                                </div>
                                <div class="btn-group float-right">
                                    <i class="fas fa-calendar-minus fa-2x" style="opacity: 0.4"></i>
                                </div>
                            </div>
                            <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Row 2: Charts (Admin Only) -->
    @can('view reports')
    <div class="row mb-4">
        <div class="col-lg-8 mb-4 mb-lg-0">
             <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white font-weight-bold border-bottom-0 py-3">
                    <i class="fas fa-chart-area mr-2 text-primary"></i> Statistik Pegawai per Departemen
                </div>
                <div class="card-body">
                    <div class="c-chart-wrapper">
                        <div id="dashboardDeptChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
             <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white font-weight-bold border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-calendar-alt mr-2 text-primary"></i> Agenda Perusahaan</span>
                    <a href="{{ route('calendar.index') }}" class="btn btn-sm btn-light text-primary">Lihat Semua</a>
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        @forelse($upcomingEvents ?? [] as $event)
                            <li class="list-group-item d-flex justify-content-between align-items-center px-4">
                                <div>
                                    <div class="font-weight-bold text-dark">{{ $event->title }}</div>
                                    <small class="text-muted">
                                        <i class="far fa-clock mr-1"></i> {{ $event->start_date->format('d M Y') }}
                                        @if($event->is_day_off)
                                            <span class="badge badge-danger ml-2">Libur</span>
                                        @endif
                                    </small>
                                </div>
                                <div class="text-right">
                                    @if($event->category == 'holiday')
                                        <i class="fas fa-umbrella-beach text-danger" title="Hari Libur"></i>
                                    @elseif($event->category == 'cuti_bersama')
                                        <i class="fas fa-plane-departure text-warning" title="Cuti Bersama"></i>
                                    @else
                                        <i class="fas fa-briefcase text-info" title="Event Kantor"></i>
                                    @endif
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item text-center py-4 text-muted">
                                Belum ada agenda dalam waktu dekat.
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>
    @endcan

    <!-- Row 3: Recent Employees Table -->
    <div class="row">
        <div class="col-md-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white font-weight-bold border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                    <span><i class="fas fa-user-clock mr-2 text-warning"></i> Pegawai Baru Bergabung</span>
                    <a href="{{ route('pegawai.index') }}" class="btn btn-sm btn-light text-primary">Lihat Semua <i class="fas fa-arrow-right ml-1"></i></a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead class="thead-light">
                                <tr>
                                    <th class="border-top-0 pl-4 w-50">Nama Pegawai</th>
                                    <th class="border-top-0">Jabatan</th>
                                    <th class="border-top-0">Status</th>
                                    <th class="border-top-0 text-right pr-4">Tanggal Gabung</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentPegawai ?? [] as $pegawai)
                                <tr>
                                    <td class="pl-4">
                                        <div class="d-flex align-items-center">
                                            <div class="c-avatar mr-3">
                                                 <img class="c-avatar-img" src="https://ui-avatars.com/api/?name={{ urlencode($pegawai->nama_pegawai) }}&color=7F9CF5&background=EBF4FF" alt="{{ $pegawai->nama_pegawai }}">
                                            </div>
                                            <div>
                                                <div class="font-weight-bold">{{ $pegawai->nama_pegawai }}</div>
                                                <div class="small text-muted">{{ $pegawai->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge badge-light border">{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</span>
                                    </td>
                                    <td>
                                         <span class="badge badge-success">Active</span>
                                    </td>
                                    <td class="text-right pr-4 text-muted">
                                        {{ $pegawai->created_at->format('d M Y') }}
                                        <br>
                                        <small>{{ $pegawai->created_at->diffForHumans() }}</small>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted">
                                        <i class="fas fa-box-open fa-2x mb-3 d-block opacity-50"></i>
                                        Belum ada data pegawai baru.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
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
                    // Department Chart (Bar Chart now for better readability in wide column)
                    var deptOptions = {
                        series: [{
                            name: 'Jumlah Pegawai',
                            data: data.department.data
                        }],
                        chart: { type: 'bar', height: 350, fontFamily: 'Inter, sans-serif', toolbar: {show: false} },
                        plotOptions: { bar: { borderRadius: 4, horizontal: true, } },
                        dataLabels: { enabled: true },
                        xaxis: { categories: data.department.labels },
                        colors: ['#321fdb']
                    };
                    new ApexCharts(document.querySelector("#dashboardDeptChart"), deptOptions).render();

                    // Attendance Chart (Donut for 7 days summary might be better or stick to bar)
                    // Let's keep it Bar but Vertical for simple daily comparison
                    var attendanceOptions = {
                        series: [{ name: 'Hadir', data: data.attendance.onTime }, { name: 'Telat', data: data.attendance.late }],
                        chart: { type: 'bar', height: 350, stacked: true, toolbar: { show: false }, fontFamily: 'Inter, sans-serif' },
                        xaxis: { categories: data.attendance.labels, axisBorder: { show: false }, axisTicks: { show: false } }, // labels are days
                        legend: { position: 'top' },
                         colors: ['#2eb85c', '#e55353'],
                        dataLabels: { enabled: false }
                    };
                    new ApexCharts(document.querySelector("#dashboardAttendanceChart"), attendanceOptions).render();
                })
                .catch(error => console.error('Error fetching chart data:', error));
        });
    </script>
    @endcan
@endsection
