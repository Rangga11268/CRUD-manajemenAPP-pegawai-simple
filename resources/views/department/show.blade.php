<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Department') }}: {{ $department->name }}
        </h2>
    </x-slot>

    <section class="max-w-4xl mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Informasi Department</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500 dark:text-gray-400">Kode</dt>
                            <dd class="text-lg font-mono text-gray-900 dark:text-white">{{ $department->code }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500 dark:text-gray-400">Nama</dt>
                            <dd class="text-lg text-gray-900 dark:text-white">{{ $department->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500 dark:text-gray-400">Deskripsi</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $department->description ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500 dark:text-gray-400">Parent Department</dt>
                            <dd class="text-gray-900 dark:text-white">{{ $department->parent->name ?? '-' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm text-gray-500 dark:text-gray-400">Status</dt>
                            <dd>
                                @if($department->is_active)
                                    <span class="bg-green-100 text-green-800 text-sm font-medium px-3 py-1 rounded">Aktif</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-sm font-medium px-3 py-1 rounded">Non-aktif</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistik</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
                            <p class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $department->pegawais->count() }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Total Pegawai</p>
                        </div>
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4">
                            <p class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $department->children->count() }}</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400">Sub-Department</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($department->pegawais->count() > 0)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Daftar Pegawai</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Nama</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Jabatan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($department->pegawais as $pegawai)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $pegawai->nama_pegawai }}</td>
                                <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-400">{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">{{ ucfirst($pegawai->status ?? 'aktif') }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        <div class="mt-6">
            <a href="{{ route('department.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                &larr; Kembali
            </a>
        </div>
    </section>
</x-app-layout>
