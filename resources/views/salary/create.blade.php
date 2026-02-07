<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Generate Payroll') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form method="POST" action="{{ route('salary.store') }}">
                        @csrf

                        @if(session('error'))
                            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                                <strong class="font-bold">Error!</strong>
                                <span class="block sm:inline">{{ session('error') }}</span>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Pegawai -->
                            <div class="mb-4">
                                <x-input-label for="pegawai_id" :value="__('Select Pegawai')" />
                                <select id="pegawai_id" name="pegawai_id" class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                                    @foreach($pegawais as $pegawai)
                                        <option value="{{ $pegawai->id }}">{{ $pegawai->nama_pegawai }} - {{ $pegawai->jabatan->nama_jabatan ?? '-' }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Periode -->
                            <div class="mb-4">
                                <x-input-label for="periode" :value="__('Periode (YYYY-MM)')" />
                                <x-text-input id="periode" class="block mt-1 w-full" type="month" name="periode" :value="date('Y-m')" required />
                            </div>
                        </div>

                        <!-- Components -->
                        <div class="mt-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100 mb-4">Komponen Tambahan</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-semibold mb-2">Tunjangan (Allowance)</h4>
                                    <!-- Dynamic fields placeholder - simplified for now -->
                                    <div class="space-y-2">
                                        <div class="flex gap-2">
                                            <x-text-input name="tunjangan[0][nama]" placeholder="Nama Tunjangan" class="w-1/2" />
                                            <x-text-input name="tunjangan[0][jumlah]" type="number" placeholder="Jumlah" class="w-1/2" />
                                        </div>
                                        <div class="flex gap-2">
                                            <x-text-input name="tunjangan[1][nama]" placeholder="Nama Tunjangan" class="w-1/2" />
                                            <x-text-input name="tunjangan[1][jumlah]" type="number" placeholder="Jumlah" class="w-1/2" />
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-semibold mb-2">Potongan (Deduction)</h4>
                                    <div class="space-y-2">
                                        <div class="flex gap-2">
                                            <x-text-input name="potongan[0][nama]" placeholder="Nama Potongan" class="w-1/2" />
                                            <x-text-input name="potongan[0][jumlah]" type="number" placeholder="Jumlah" class="w-1/2" />
                                        </div>
                                        <div class="flex gap-2">
                                            <x-text-input name="potongan[1][nama]" placeholder="Nama Potongan" class="w-1/2" />
                                            <x-text-input name="potongan[1][jumlah]" type="number" placeholder="Jumlah" class="w-1/2" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-primary-button class="ml-4">
                                {{ __('Generate Payroll') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
