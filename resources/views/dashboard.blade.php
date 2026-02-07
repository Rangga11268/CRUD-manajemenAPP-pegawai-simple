<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium">Selamat Datang Kembali, {{ Auth::user()->name }}!</h3>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                        Ini adalah halaman utama sistem manajemen pegawai Anda.
                    </p>
                </div>
            </div>

            <!-- Attendance Widget -->
            @if(auth()->user()->hasRole('pegawai'))
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Absensi Hari Ini - {{ date('d M Y') }}</h4>
                    <div class="flex items-center justify-between">
                        <div class="text-gray-600 dark:text-gray-400">
                            @if($todayAttendance)
                                <div>
                                    <span class="block text-sm">Masuk:</span>
                                    <span class="text-xl font-bold text-green-600">{{ $todayAttendance->clock_in ? $todayAttendance->clock_in->format('H:i') : '-' }}</span>
                                </div>
                                <div class="mt-2">
                                    <span class="block text-sm">Pulang:</span>
                                    <span class="text-xl font-bold text-red-600">{{ $todayAttendance->clock_out ? $todayAttendance->clock_out->format('H:i') : '-' }}</span>
                                </div>
                            @else
                                <span class="text-lg text-yellow-600">Anda belum melakukan absen hari ini.</span>
                            @endif
                        </div>
                        
                        <div class="flex space-x-4">
                            @if(!$todayAttendance)
                                <form action="{{ route('attendance.clock-in') }}" method="POST">
                                    @csrf
                                    <x-primary-button class="bg-green-600 hover:bg-green-700 py-3 px-6 text-lg">
                                        {{ __('Absen Masuk') }}
                                    </x-primary-button>
                                </form>
                            @elseif(!$todayAttendance->clock_out)
                                <form action="{{ route('attendance.clock-out') }}" method="POST">
                                    @csrf
                                    <x-primary-button class="bg-red-600 hover:bg-red-700 py-3 px-6 text-lg">
                                        {{ __('Absen Pulang') }}
                                    </x-primary-button>
                                </form>
                            @else
                                <div class="text-green-600 font-bold text-lg bg-green-100 px-4 py-2 rounded">
                                    ✓ Selesai
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Admin/HR Dashboard Charts -->
            @can('view reports')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Department Distribution -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Pegawai per Departemen</h3>
                    <div id="dashboardDeptChart"></div>
                </div>

                <!-- Attendance Trends -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Tren Kehadiran (7 Hari Terakhir)</h3>
                    <div id="dashboardAttendanceChart"></div>
                </div>
            </div>

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
                                chart: { type: 'pie', height: 300 },
                                labels: data.department.labels,
                                responsive: [{ breakpoint: 480, options: { chart: { width: 200 }, legend: { position: 'bottom' } } }]
                            };
                            new ApexCharts(document.querySelector("#dashboardDeptChart"), deptOptions).render();

                            // Attendance Chart
                            var attendanceOptions = {
                                series: [{ name: 'Hadir', data: data.attendance.onTime }, { name: 'Telat', data: data.attendance.late }],
                                chart: { type: 'bar', height: 300, stacked: true },
                                xaxis: { categories: data.attendance.labels },
                                colors: ['#0E9F6E', '#F05252']
                            };
                            new ApexCharts(document.querySelector("#dashboardAttendanceChart"), attendanceOptions).render();
                        });
                });
            </script>
            @endpush
            @endcan

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Pegawai</h4>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $totalPegawai ?? 'N/A' }}
                        </p>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Total Jabatan</h4>
                        <p class="mt-2 text-3xl font-bold text-gray-900 dark:text-gray-100">
                            {{ $totalJabatan ?? 'N/A' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <a href="{{ route('pegawai.create') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Tambah Pegawai Baru
                </a>
                <a href="{{ route('jabatan.create') }}"
                    class="ml-4 inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                    Tambah Jabatan Baru
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Pegawai yang Baru
                        Ditambahkan</h4>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Nama</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Jabatan</th>
                                    <th
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                        Tanggal Ditambahkan</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse ($recentPegawai ?? [] as $pegawai)
                                    <tr>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                            {{ $pegawai->nama_pegawai }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $pegawai->jabatans->nama_jabatan ?? 'N/A' }}</td>
                                        <td
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-300">
                                            {{ $pegawai->created_at->format('d M Y') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500 dark:text-gray-400">
                                            Belum ada data pegawai.
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
</x-app-layout>
