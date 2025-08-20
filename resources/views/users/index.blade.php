<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Users') }}
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
            <h2 class="text-2xl font-semibold text-gray-200">Data Users</h2>
            <a href="{{ route('users.create') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
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
                <input type="text" id="simple-search" value="{{ $namaUsers }}" name="name"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Cari nama users..." />
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
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Role</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y bg-gray-800">
                    @foreach ($users as $index => $user)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $user->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $user->role }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('users.edit', $user->id) }}"
                                        class="text-blue-500 hover:underline">Edit</a>
                                    <a href="{{ route('users.show', $user->id) }}"
                                        class="text-blue-500 hover:underline">Detail</a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST"
                                        class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4 text-center">
            {{ $users->links('vendor.pagination.flowbite') }}
        </div>
    </section>


</x-app-layout>
