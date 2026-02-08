<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Analytics & Reports') }}
        </h2>
    </x-slot>

    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700 rounded-t-lg">
        <div class="w-full mb-1">
            <div class="mb-4">
                <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Analytics & Reports</h1>
            </div>
        </div>
    </div>

    <!-- Charts Section -->
    <div class="grid grid-cols-1 gap-4 px-4 pt-4 lg:grid-cols-2">
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <h3 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">Pegawai per Departemen</h3>
            <div id="deptChart"></div>
        </div>
        <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
            <h3 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">Tren Kehadiran (7 Hari)</h3>
            <div id="attendanceChart"></div>
        </div>
    </div>

    <!-- Export Section -->
    <div class="p-4 bg-white border-b border-gray-200 mt-4 mx-4 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
        <h3 class="mb-4 text-xl font-semibold text-gray-900 dark:text-white">Export & Download Data</h3>
        
        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
            <!-- Export Pegawai -->
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                <div class="flex items-center mb-4">
                    <div class="flex items-center justify-center w-10 h-10 bg-green-100 rounded-lg dark:bg-green-900/30">
                        <i class="fas fa-file-excel text-green-600 dark:text-green-400"></i>
                    </div>
                    <h4 class="ml-3 text-lg font-bold text-gray-900 dark:text-white">Data Pegawai</h4>
                </div>
                <p class="mb-6 text-gray-500 dark:text-gray-400">Download data seluruh pegawai aktif dalam format Excel untuk pelaporan eksternal.</p>
                <a href="{{ route('reports.export.pegawai') }}" class="inline-flex items-center justify-center w-full px-5 py-3 text-sm font-medium text-center text-white bg-green-600 rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 dark:bg-green-500 dark:hover:bg-green-600">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    Export Excel (.xlsx)
                </a>
            </div>

            <!-- Export Attendance -->
            <div class="p-6 bg-gray-50 border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600">
                <div class="flex items-center mb-4">
                    <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-lg dark:bg-blue-900/30">
                        <i class="fas fa-calendar-check text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <h4 class="ml-3 text-lg font-bold text-gray-900 dark:text-white">Laporan Absensi</h4>
                </div>
                <form action="{{ route('reports.export.attendance') }}" method="GET" class="space-y-4">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block mb-2 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Dari Tanggal</label>
                            <input type="date" name="start_date" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:text-white" required value="{{ date('Y-m-01') }}">
                        </div>
                        <div>
                            <label class="block mb-2 text-xs font-semibold uppercase text-gray-500 dark:text-gray-400">Sampai Tanggal</label>
                            <input type="date" name="end_date" class="bg-white border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-800 dark:border-gray-600 dark:text-white" required value="{{ date('Y-m-d') }}">
                        </div>
                    </div>
                    <button type="submit" class="inline-flex items-center justify-center w-full px-5 py-3 text-sm font-medium text-center text-white bg-blue-600 rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 dark:bg-blue-500 dark:hover:bg-blue-600">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Download Report (.pdf)
                    </button>
                </form>
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
                            height: 350
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
                            height: 350,
                            stacked: true,
                        },
                        plotOptions: {
                            bar: {
                                horizontal: false,
                            },
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
                        colors: ['#0E9F6E', '#F05252'] // Green, Red
                    };
                    var attendanceChart = new ApexCharts(document.querySelector("#attendanceChart"), attendanceOptions);
                    attendanceChart.render();
                });
        });
    </script>
    @endpush
</x-app-layout>
