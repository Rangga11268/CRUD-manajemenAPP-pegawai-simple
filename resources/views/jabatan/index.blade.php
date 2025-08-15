<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('jabatan') }}
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
            <h2 class="text-2xl font-semibold text-gray-200">Data Jabatan</h2>
            <a href="{{ route('jabatan.create') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Tambah Data
            </a>
        </div>

        <div class="overflow-x-auto bg-gray-200 shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">No</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Nama Jabatan</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Deskripsi</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y bg-gray-800 ">
                    @foreach ($jabatans as $index => $jabatan)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200 font-semibold">{{ $jabatan->nama_jabatan }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $jabatan->deskripsi_jabatan }}</td>
                            <td class="px-6 py-4 text-center space-x-2">
                                <a href="{{ route('jabatan.edit', $jabatan->id) }}"
                                    class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('jabatan.destroy', $jabatan->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline"
                                        onclick="return confirm('Yakin ingin menghapus?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>


</x-app-layout>
