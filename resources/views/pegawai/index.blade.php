<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pegawai') }}
        </h2>
    </x-slot>

    <section class="max-w-6xl mx-auto px-4 py-8">
        @if (Session::has('success'))
            <div class="bg-blue-100 mb-3 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                <p class="font-bold"><i class="fa-solid fa-check"></i></p>
                <p class="text-sm">{{ Session::get('success') }}</p>
            </div>
        @elseif (Session::has('delete'))
            <div class="bg-red-300 mb-3 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
                <p class="font-bold"><i class="fa-solid fa-trash"></i></p>
                <p class="text-sm">{{ Session::get('delete') }}</p>
            </div>
        @endif
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-200">Data pegawai</h2>
            <a href="{{ route('pegawai.create') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Tambah Data
            </a>
        </div>

        <div class="overflow-x-auto bg-gray-200 shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">No</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Nama pegawai</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Alamat</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Telepon</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">jabatan</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y bg-gray-800">
                    @forelse ($pegawais as $index => $pegawai)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200 font-semibold">{{ $pegawai->nama_pegawai }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $pegawai->alamat }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $pegawai->telepon }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200">
                                {{ $pegawai->jabatans->nama_jabatan ?? 'Belum ada jabatan' }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('pegawai.edit', $pegawai->id) }}"
                                        class="text-blue-500 hover:underline">Edit</a>
                                    <a href="{{ route('pegawai.show', $pegawai->id) }}"
                                        class="text-blue-500 hover:underline">Detail</a>
                                    <form action="{{ route('pegawai.destroy', $pegawai->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
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
    </section>


</x-app-layout>
