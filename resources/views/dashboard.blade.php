<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="grid grid-cols-1 px-4 pt-6 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
        <div class="col-span-full xl:col-auto">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
                <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                    <img class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" alt="Avatar">
                    <div>
                        <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">{{ auth()->user()->name }}</h3>
                        <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ auth()->user()->getRoleNames()->first() ?? 'Pegawai' }}
                        </div>
                        <div class="flex items-center space-x-2">
                            <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800">Active Now</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Attendance Widget -->
            @if(auth()->user()->hasRole('pegawai'))
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-4 text-xl font-semibold dark:text-white">Absensi Hari Ini</h3>
                <div class="flex items-center justify-between mb-4">
                    <div class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ date('d M Y') }}</div>
                </div>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Jam Masuk</span>
                        <span class="text-lg font-bold text-green-600">{{ $todayAttendance->clock_in ? $todayAttendance->clock_in->format('H:i') : '--:--' }}</span>
                    </div>
                    <div class="flex items-center justify-between border-t pt-4 dark:border-gray-700">
                        <span class="text-sm text-gray-500 dark:text-gray-400">Jam Pulang</span>
                        <span class="text-lg font-bold text-red-600">{{ $todayAttendance->clock_out ? $todayAttendance->clock_out->format('H:i') : '--:--' }}</span>
                    </div>
                    <div class="mt-6">
                        @if(!$todayAttendance)
                            <form action="{{ route('attendance.clock-in') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-white bg-green-700 hover:bg-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-600 dark:hover:bg-green-700">Absen Masuk</button>
                            </form>
                        @elseif(!$todayAttendance->clock_out)
                            <form action="{{ route('attendance.clock-out') }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full text-white bg-red-700 hover:bg-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600 dark:hover:bg-red-700">Absen Pulang</button>
                            </form>
                        @else
                            <div class="w-full text-green-700 bg-green-100 font-semibold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-green-900 dark:text-green-300">✓ Absensi Selesai</div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-span-2">
            <!-- Stats -->
            <div class="grid grid-cols-1 gap-4 mb-4 sm:grid-cols-2">
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-white bg-blue-600 rounded-lg shadow-md">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"></path></svg>
                        </div>
                        <div class="flex-shrink-0 ml-3">
                            <span class="text-2xl font-bold leading-none text-gray-900 dark:text-white">{{ $totalPegawai ?? 0 }}</span>
                            <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Total Pegawai</h3>
                        </div>
                    </div>
                </div>
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center">
                        <div class="inline-flex flex-shrink-0 justify-center items-center w-12 h-12 text-white bg-purple-600 rounded-lg shadow-md">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57a22.952 22.952 0 01-10 2.43 22.947 22.947 0 01-10-2.43V8a2 2 0 012-2h2zm10 5.47a21.97 21.97 0 00-5 1.51V10h5v1.47zM5 10v2.98a21.97 21.97 0 00-5-1.51V10h5zm3-3V5a1 1 0 011-1h2a1 1 0 011 1v2H8z" clip-rule="evenodd"></path><path d="M10.13 14.25c4.11 0 7.47.78 10 2V22H0v-5.75c2.53-1.22 5.89-2 10-2h.13z"></path></svg>
                        </div>
                        <div class="flex-shrink-0 ml-3">
                            <span class="text-2xl font-bold leading-none text-gray-900 dark:text-white">{{ $totalJabatan ?? 0 }}</span>
                            <h3 class="text-base font-normal text-gray-500 dark:text-gray-400">Total Jabatan</h3>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            @can('view reports')
            <div class="grid grid-cols-1 gap-4 mb-4 lg:grid-cols-2">
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                    <h3 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">Pegawai per Departemen</h3>
                    <div id="dashboardDeptChart"></div>
                </div>
                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                    <h3 class="mb-4 text-base font-semibold text-gray-900 dark:text-white">Tren Kehadiran (7 Hari)</h3>
                    <div id="dashboardAttendanceChart"></div>
                </div>
            </div>
            @endcan

            <!-- Recent Employees -->
            <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm dark:border-gray-700 dark:bg-gray-800 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-base font-semibold text-gray-900 dark:text-white">Pegawai Baru</h3>
                    <a href="{{ route('pegawai.index') }}" class="text-sm font-medium text-blue-600 hover:underline dark:text-blue-500">View all</a>
                </div>
                <div class="flex flex-col mt-6">
                    <div class="overflow-x-auto rounded-lg">
                        <div class="inline-block min-w-full align-middle">
                            <div class="overflow-hidden shadow sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                    <thead class="bg-gray-50 dark:bg-gray-700">
                                        <tr>
                                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Nama</th>
                                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Jabatan</th>
                                            <th scope="col" class="p-4 text-xs font-medium text-left text-gray-500 uppercase dark:text-gray-400">Tanggal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                        @forelse ($recentPegawai ?? [] as $pegawai)
                                        <tr class="hover:bg-gray-100 dark:hover:bg-gray-700">
                                            <td class="p-4 text-sm font-normal text-gray-900 whitespace-nowrap dark:text-white">
                                                <div class="text-base font-semibold text-gray-900 dark:text-white">{{ $pegawai->nama_pegawai }}</div>
                                            </td>
                                            <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</td>
                                            <td class="p-4 text-sm font-normal text-gray-500 whitespace-nowrap dark:text-gray-400">{{ $pegawai->created_at->format('d M Y') }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="3" class="p-4 text-center text-sm font-normal text-gray-500 dark:text-gray-400">Belum ada data.</td>
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
    </div>

    @can('view reports')
    @push('scripts')
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
                        colors: ['#1A56DB', '#7E3AF2', '#D61F69', '#10B981', '#F59E0B'],
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
                        colors: ['#10B981', '#F05252'],
                        dataLabels: { enabled: false }
                    };
                    new ApexCharts(document.querySelector("#dashboardAttendanceChart"), attendanceOptions).render();
                });
        });
    </script>
    @endpush
    @endcan
</x-app-layout>
