@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Analytics & Reports</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Reports</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <!-- Department Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <strong>Pegawai per Departemen</strong>
            </div>
            <div class="card-body">
                <div id="deptChart"></div>
            </div>
        </div>
    </div>
    
    <!-- Attendance Chart -->
    <div class="col-lg-6 mb-4">
        <div class="card h-100">
            <div class="card-header">
                <strong>Tren Kehadiran (7 Hari)</strong>
            </div>
            <div class="card-body">
                <div id="attendanceChart"></div>
            </div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-header">
        <strong>Export & Download Data</strong>
    </div>
    <div class="card-body">
         <div class="row">
            <!-- Export Pegawai -->
            <div class="col-md-6 mb-4 mb-md-0">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-3 bg-success text-white rounded mr-3">
                                <i class="fas fa-file-excel c-icon c-icon-xl"></i>
                            </div>
                            <h5 class="mb-0">Data Pegawai</h5>
                        </div>
                        <p class="text-muted">Download data seluruh pegawai aktif dalam format Excel untuk pelaporan eksternal.</p>
                        <a href="{{ route('reports.export.pegawai') }}" class="btn btn-success btn-block">
                            <i class="fas fa-cloud-download-alt c-icon mr-1"></i> Export Excel (.xlsx)
                        </a>
                    </div>
                </div>
            </div>

            <!-- Export Attendance -->
            <div class="col-md-6">
                <div class="card bg-light border-0 h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="p-3 bg-info text-white rounded mr-3">
                                <i class="fas fa-calendar-check c-icon c-icon-xl"></i>
                            </div>
                            <h5 class="mb-0">Laporan Absensi</h5>
                        </div>
                        <form action="{{ route('reports.export.attendance') }}" method="GET">
                            <div class="form-row mb-3">
                                <div class="col-6">
                                    <label class="small text-muted text-uppercase font-weight-bold">Dari Tanggal</label>
                                    <input type="date" name="start_date" class="form-control" required value="{{ date('Y-m-01') }}">
                                </div>
                                <div class="col-6">
                                    <label class="small text-muted text-uppercase font-weight-bold">Sampai Tanggal</label>
                                    <input type="date" name="end_date" class="form-control" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-info btn-block text-white">
                                <i class="fas fa-cloud-download-alt c-icon mr-1"></i> Download Report (.pdf)
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Fetch chart data
        fetch('{{ route('reports.chart-data') }}')
            .then(response => response.json())
            .then(data => {
                // Department Chart
                var deptOptions = {
                    series: data.department.data,
                    chart: {
                        type: 'pie',
                        height: 300
                    },
                    labels: data.department.labels,
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                width: 200
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };
                var deptChart = new ApexCharts(document.querySelector("#deptChart"), deptOptions);
                deptChart.render();

                // Attendance Chart
                var attendanceOptions = {
                    series: [{
                        name: 'Hadir (Tepat Waktu)',
                        data: data.attendance.onTime
                    }, {
                        name: 'Terlambat/Telat',
                        data: data.attendance.late
                    }],
                    chart: {
                        type: 'bar',
                        height: 300,
                        stacked: true,
                        toolbar: {
                            show: false
                        }
                    },
                    plotOptions: {
                        bar: {
                            horizontal: false,
                            columnWidth: '55%',
                            endingShape: 'rounded'
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        show: true,
                        width: 2,
                        colors: ['transparent']
                    },
                    xaxis: {
                        categories: data.attendance.labels,
                    },
                    legend: {
                        position: 'bottom'
                    },
                    fill: {
                        opacity: 1
                    },
                    colors: ['#2eb85c', '#e55353'] // CoreUI Success, Danger
                };
                var attendanceChart = new ApexCharts(document.querySelector("#attendanceChart"), attendanceOptions);
                attendanceChart.render();
            });
    });
</script>
@endpush
@endsection
