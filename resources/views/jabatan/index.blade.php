<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Jabatan') }}
        </h2>
    </x-slot>

    <section class="max-w-6xl mx-auto px-4 py-8">
        @if (Session::has('success'))
            <div class="bg-green-100 mb-3 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert">
                <p class="font-bold"><i class="fa-solid fa-check"></i></p>
                <p class="text-sm">{{ Session::get('success') }}</p>
            </div>
        @elseif (Session::has('delete'))
            <div class="bg-red-300 mb-3 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
                <p class="font-bold"><i class="fa-solid fa-trash"></i></p>
                <p class="text-sm">{{ Session::get('delete') }}</p>
            </div>
        @elseif (Session::has('failed'))
            <div class="bg-blue-300 mb-3 border-t border-b border-blue-500 text-blue-700 px-4 py-3" role="alert">
                <p class="font-bold"><i class="fa-solid fa-info"></i></p>
                <p class="text-sm">{{ Session::get('failed') }}</p>
            </div>
        @endif
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-200">Data Jabatan</h2>
            <a href="{{ route('jabatan.create') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                Tambah Data
            </a>
        </div>


        <form class="flex max-w-sm mx-auto mb-3">
            <label for="simple-search" class="sr-only">Search</label>
            <div class="relative w-full">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5v10M3 5a2 2 0 1 0 0-4 2 2 0 0 0 0 4Zm0 10a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4Zm0 0V6a3 3 0 0 0-3-3H9m1.5-2-2 2 2 2" />
                    </svg>
                </div>
                <input type="text" id="simple-search" value="{{ $nama_jabatan }}" name="nama_jabatan"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Cari nama jabatan..." />
            </div>
            <button type="submit"
                class="p-2.5 ms-2 text-sm font-medium text-white bg-blue-700 rounded-lg border border-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                <svg class="w-4 h-4" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
                <span class="sr-only">Search</span>
            </button>
        </form>


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
                    @forelse ($jabatans as $index => $jabatan)
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
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-4 text-center text-sm text-gray-400">
                                Tidak ada data jabatan yang tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-center">
            {{ $jabatans->links('vendor.pagination.flowbite') }}
        </div>
    </section>


</x-app-layout>
