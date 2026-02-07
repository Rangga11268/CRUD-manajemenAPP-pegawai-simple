<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Analytics & Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Charts Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Department Distribution -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Pegawai per Departemen</h3>
                    <div id="deptChart"></div>
                </div>

                <!-- Attendance Trends -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tren Kehadiran (7 Hari Terakhir)</h3>
                    <div id="attendanceChart"></div>
                </div>
            </div>

            <!-- Export Section -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Export Data</h3>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Export Pegawai -->
                    <div class="border p-4 rounded-lg dark:border-gray-700">
                        <h4 class="font-medium mb-2 text-gray-800 dark:text-gray-200">Data Pegawai</h4>
                        <p class="text-sm text-gray-500 mb-4">Download data seluruh pegawai aktif dalam format Excel.</p>
                        <a href="{{ route('reports.export.pegawai') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            Export Excel
                        </a>
                    </div>

                    <!-- Export Attendance -->
                    <div class="border p-4 rounded-lg dark:border-gray-700">
                        <h4 class="font-medium mb-2 text-gray-800 dark:text-gray-200">Laporan Absensi</h4>
                        <p class="text-sm text-gray-500 mb-4">Download laporan absensi berdasarkan rentang tanggal.</p>
                        <form action="{{ route('reports.export.attendance') }}" method="GET" class="space-y-4">
                            <div class="flex space-x-4">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Dari</label>
                                    <input type="date" name="start_date" id="start_date" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required value="{{ date('Y-m-01') }}">
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Sampai</label>
                                    <input type="date" name="end_date" id="end_date" class="mt-1 block w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm" required value="{{ date('Y-m-d') }}">
                                </div>
                            </div>
                            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded inline-flex items-center">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                Download Report
                            </button>
                        </form>
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
