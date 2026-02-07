<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pegawai') }}
        </h2>
    </x-slot>

    <section class="max-w-7xl mx-auto px-4 py-8">
        @if (Session::has('success'))
            <div class="bg-green-100 mb-3 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert">
                <p class="font-bold"><i class="fa-solid fa-check"></i></p>
                <p class="text-sm">{{ Session::get('success') }}</p>
            </div>
        @elseif (Session::has('delete'))
            <div class="bg-red-100 mb-3 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
                <p class="font-bold"><i class="fa-solid fa-trash"></i></p>
                <p class="text-sm">{{ Session::get('delete') }}</p>
            </div>
        @endif
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-200">Data Pegawai</h2>
            <a href="{{ route('pegawai.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Tambah Data
            </a>
        </div>

        <form class="flex max-w-md mb-4">
            <div class="relative w-full">
                <input type="text" name="nama_pegawai" value="{{ $nama_pegawai }}"
                    class="block w-full p-2.5 z-20 text-sm text-gray-900 bg-gray-50 rounded-lg border-s-gray-50 border-s-2 border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-s-gray-700  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:border-blue-500"
                    placeholder="Cari nama atau NIK..." />
                <button type="submit"
                    class="absolute top-0 end-0 p-2.5 text-sm font-medium h-full text-white bg-blue-700 rounded-e-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                    <span class="sr-only">Search</span>
                </button>
            </div>
        </form>

        <div class="overflow-x-auto bg-gray-200 shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">No</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Nama / NIK</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Jabatan & Dept</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Kontak</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y bg-gray-800">
                    @forelse ($pegawais as $index => $pegawai)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $loop->iteration + $pegawais->firstItem() - 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200">
                                <div class="font-semibold">{{ $pegawai->nama_pegawai }}</div>
                                <div class="text-xs text-gray-400">{{ $pegawai->nik }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-200">
                                <div>{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</div>
                                <div class="text-xs text-gray-400">{{ $pegawai->department->name ?? '-' }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-200">
                                <div class="text-xs">{{ $pegawai->email }}</div>
                                <div class="text-xs">{{ $pegawai->telepon }}</div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                @php
                                    $statusColors = [
                                        'aktif' => 'bg-green-100 text-green-800',
                                        'cuti' => 'bg-yellow-100 text-yellow-800',
                                        'resign' => 'bg-red-100 text-red-800',
                                        'pensiun' => 'bg-gray-100 text-gray-800',
                                    ];
                                    $colorClass = $statusColors[$pegawai->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp
                                <span class="{{ $colorClass }} text-xs font-medium px-2.5 py-0.5 rounded">
                                    {{ ucfirst($pegawai->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('pegawai.show', $pegawai->id) }}" class="text-green-400 hover:underline">Detail</a>
                                    <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="text-blue-400 hover:underline">Edit</a>
                                    <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-400">
                                Tidak ada data pegawai yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $pegawais->links() }}
        </div>
    </section>
</x-app-layout>
