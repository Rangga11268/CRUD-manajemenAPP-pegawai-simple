<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Gaji') }} - {{ \Carbon\Carbon::parse($salary->periode)->format('F Y') }}
            </h2>
            <a href="{{ route('salary.slip', $salary) }}" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Download PDF
            </a>
        </div>
    </x-slot>

    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700 rounded-lg mb-4">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <a href="{{ route('salary.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Payroll</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-sm font-medium text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Detail Payroll</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Slip Gaji: {{ $salary->pegawai->nama_pegawai }}</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('salary.slip', $salary) }}" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700">
                            <i class="fas fa-file-pdf mr-2"></i> Download PDF
                        </a>
                        <a href="{{ route('salary.index') }}" class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="p-4 mx-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
        <div class="flex flex-col md:flex-row justify-between mb-8 pb-4 border-b dark:border-gray-700">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white uppercase tracking-wider mb-2">Slip Gaji</h2>
                <p class="text-gray-500 dark:text-gray-400">Periode: <span class="font-semibold text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($salary->periode)->translatedFormat('F Y') }}</span></p>
            </div>
            <div class="mt-4 md:mt-0 md:text-right">
                <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Diberikan pada:</p>
                <p class="text-lg font-bold text-gray-900 dark:text-white">{{ $salary->tanggal_bayar ? $salary->tanggal_bayar->translatedFormat('d F Y') : '-' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Pegawai:</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $salary->pegawai->nama_pegawai }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">ID Pegawai (NIP):</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $salary->pegawai->employee_id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Jabatan:</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $salary->pegawai->jabatans->nama_jabatan ?? '-' }}</span>
                </div>
            </div>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Department:</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $salary->pegawai->department->name ?? '-' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-sm font-medium text-gray-500 dark:text-gray-400">Status Pajak:</span>
                    <span class="text-sm font-bold text-gray-900 dark:text-white">Sesuai Kebijakan</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto rounded-lg border dark:border-gray-700 mb-8 mt-4">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">Deskripsi Komponen Gaji</th>
                        <th scope="col" class="px-6 py-3 text-right">Jumlah (IDR)</th>
                    </tr>
                </thead>
                <tbody class="divide-y dark:divide-gray-700">
                    <tr class="bg-gray-50 dark:bg-gray-750">
                        <td class="px-6 py-2 font-bold text-blue-700 dark:text-blue-400">A. PENGHASILAN</td>
                        <td></td>
                    </tr>
                    <tr class="bg-white dark:bg-gray-800">
                        <td class="px-6 py-3">Gaji Pokok</td>
                        <td class="px-6 py-3 text-right font-semibold text-gray-900 dark:text-white">{{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
                    </tr>
                    @foreach($salary->components as $component)
                        @if($component->type == 'tunjangan')
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-6 py-3">{{ $component->nama }}</td>
                            <td class="px-6 py-3 text-right font-semibold text-gray-900 dark:text-white">{{ number_format($component->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    @endforeach
                    <tr class="bg-green-50 dark:bg-green-900/30 font-bold text-gray-900 dark:text-white">
                        <td class="px-6 py-3">Total Penghasilan Bruto (A)</td>
                        <td class="px-6 py-3 text-right">Rp {{ number_format($salary->gaji_pokok + $salary->total_tunjangan, 0, ',', '.') }}</td>
                    </tr>

                    <tr class="bg-gray-50 dark:bg-gray-750">
                        <td class="px-6 py-2 font-bold text-red-700 dark:text-red-400">B. POTONGAN</td>
                        <td></td>
                    </tr>
                    @forelse($salary->components as $component)
                        @if($component->type == 'potongan')
                        <tr class="bg-white dark:bg-gray-800">
                            <td class="px-6 py-3">{{ $component->nama }}</td>
                            <td class="px-6 py-3 text-right font-semibold text-gray-900 dark:text-white">- {{ number_format($component->jumlah, 0, ',', '.') }}</td>
                        </tr>
                        @endif
                    @empty
                        <tr class="bg-white dark:bg-gray-800">
                            <td colspan="2" class="px-6 py-3 text-center italic text-gray-400">Tidak ada potongan</td>
                        </tr>
                    @endforelse
                    <tr class="bg-red-50 dark:bg-red-900/30 font-bold text-gray-900 dark:text-white">
                        <td class="px-6 py-3">Total Potongan (B)</td>
                        <td class="px-6 py-3 text-right">- Rp {{ number_format($salary->total_potongan, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
                <tfoot class="bg-gray-100 dark:bg-gray-700 border-t-2 dark:border-gray-600">
                    <tr class="text-lg font-bold text-gray-900 dark:text-white">
                        <th class="px-6 py-4">GAJI BERSIH DITERIMA (A - B)</th>
                        <th class="px-6 py-4 text-right text-2xl text-blue-600 dark:text-blue-400">Rp {{ number_format($salary->gaji_bersih, 0, ',', '.') }}</th>
                    </tr>
                </tfoot>
            </table>
        </div>

        <div class="text-right text-xs text-gray-400 mt-4">
            Slip ini dihasilkan secara otomatis oleh sistem pada {{ now()->translatedFormat('d F Y, H:i') }}.
        </div>
    </div>
</x-app-layout>
