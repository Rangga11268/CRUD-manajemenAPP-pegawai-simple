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

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-8 text-gray-900 dark:text-gray-100">
                    
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-8 mb-8">
                        <h1 class="text-3xl font-bold text-center mb-2">SLIP GAJI</h1>
                        <p class="text-center text-gray-500">Periode: {{ $salary->periode }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-8 mb-8">
                        <div>
                            <div class="grid grid-cols-3 gap-4 mb-2">
                                <span class="text-gray-500">Nama</span>
                                <span class="col-span-2 font-medium">: {{ $salary->pegawai->nama_pegawai }}</span>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mb-2">
                                <span class="text-gray-500">ID Pegawai</span>
                                <span class="col-span-2 font-medium">: {{ $salary->pegawai->employee_id }}</span>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mb-2">
                                <span class="text-gray-500">Jabatan</span>
                                <span class="col-span-2 font-medium">: {{ $salary->pegawai->jabatans->nama_jabatan ?? '-' }}</span>
                            </div>
                        </div>
                        <div>
                            <div class="grid grid-cols-3 gap-4 mb-2">
                                <span class="text-gray-500">Departemen</span>
                                <span class="col-span-2 font-medium">: {{ $salary->pegawai->user->department->name ?? '-' }}</span>
                            </div>
                            <div class="grid grid-cols-3 gap-4 mb-2">
                                <span class="text-gray-500">Tanggal Bayar</span>
                                <span class="col-span-2 font-medium">: {{ $salary->tanggal_bayar ? $salary->tanggal_bayar->format('d M Y') : '-' }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="border rounded-lg overflow-hidden mb-8">
                        <table class="w-full">
                            <thead class="bg-gray-50 dark:bg-gray-700">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Deskripsi</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Jumlah (Rp)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                <!-- Penghasilan -->
                                <tr class="bg-gray-50 dark:bg-gray-750">
                                    <td colspan="2" class="px-6 py-2 text-sm font-bold text-gray-700 dark:text-gray-300">A. PENGHASILAN</td>
                                </tr>
                                <tr>
                                    <td class="px-6 py-3 text-sm">Gaji Pokok</td>
                                    <td class="px-6 py-3 text-sm text-right">{{ number_format($salary->gaji_pokok, 0, ',', '.') }}</td>
                                </tr>
                                @foreach($salary->components as $component)
                                    @if($component->type == 'tunjangan')
                                    <tr>
                                        <td class="px-6 py-3 text-sm">{{ $component->nama }}</td>
                                        <td class="px-6 py-3 text-sm text-right">{{ number_format($component->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                    @endif
                                @endforeach
                                <tr class="bg-green-50 dark:bg-green-900/20 font-bold">
                                    <td class="px-6 py-3 text-sm">Total Penghasilan Bruto</td>
                                    <td class="px-6 py-3 text-sm text-right">{{ number_format($salary->gaji_pokok + $salary->total_tunjangan, 0, ',', '.') }}</td>
                                </tr>

                                <!-- Potongan -->
                                <tr class="bg-gray-50 dark:bg-gray-750">
                                    <td colspan="2" class="px-6 py-2 text-sm font-bold text-gray-700 dark:text-gray-300 mt-4">B. POTONGAN</td>
                                </tr>
                                @foreach($salary->components as $component)
                                    @if($component->type == 'potongan')
                                    <tr>
                                        <td class="px-6 py-3 text-sm">{{ $component->nama }}</td>
                                        <td class="px-6 py-3 text-sm text-right">{{ number_format($component->jumlah, 0, ',', '.') }}</td>
                                    </tr>
                                    @endif
                                @endforeach
                                @if($salary->total_potongan == 0)
                                <tr>
                                    <td class="px-6 py-3 text-sm text-gray-500 italic">- Tidak ada potongan -</td>
                                    <td class="px-6 py-3 text-sm text-right">0</td>
                                </tr>
                                @endif
                                <tr class="bg-red-50 dark:bg-red-900/20 font-bold">
                                    <td class="px-6 py-3 text-sm">Total Potongan</td>
                                    <td class="px-6 py-3 text-sm text-right">{{ number_format($salary->total_potongan, 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-gray-100 dark:bg-gray-700 border-t-2 border-gray-300 dark:border-gray-600">
                                <tr>
                                    <td class="px-6 py-4 text-base font-bold text-gray-900 dark:text-gray-100">GAJI BERSIH (A - B)</td>
                                    <td class="px-6 py-4 text-xl font-bold text-right text-gray-900 dark:text-gray-100">{{ number_format($salary->gaji_bersih, 0, ',', '.') }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <div class="text-right">
                        <p class="text-sm text-gray-500">Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
