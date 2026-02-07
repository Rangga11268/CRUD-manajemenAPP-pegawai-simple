<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Department') }}
        </h2>
    </x-slot>

    <section class="max-w-6xl mx-auto px-4 py-8">
        @if (Session::has('success'))
            <div class="bg-green-100 mb-3 border-t border-b border-green-500 text-green-700 px-4 py-3" role="alert">
                <p class="text-sm">{{ Session::get('success') }}</p>
            </div>
        @elseif (Session::has('delete'))
            <div class="bg-red-100 mb-3 border-t border-b border-red-500 text-red-700 px-4 py-3" role="alert">
                <p class="text-sm">{{ Session::get('delete') }}</p>
            </div>
        @elseif (Session::has('failed'))
            <div class="bg-yellow-100 mb-3 border-t border-b border-yellow-500 text-yellow-700 px-4 py-3" role="alert">
                <p class="text-sm">{{ Session::get('failed') }}</p>
            </div>
        @endif

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-semibold text-gray-200">Data Department</h2>
            @can('create department')
            <a href="{{ route('department.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Tambah Department
            </a>
            @endcan
        </div>

        <form class="flex max-w-md mb-4">
            <input type="text" name="search" value="{{ $search }}" placeholder="Cari department..."
                class="flex-1 bg-gray-700 border border-gray-600 text-white rounded-l-lg px-4 py-2 focus:ring-blue-500 focus:border-blue-500">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r-lg hover:bg-blue-700">
                Cari
            </button>
        </form>

        <div class="overflow-x-auto bg-gray-200 shadow-md rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">No</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Kode</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Nama</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Deskripsi</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Jumlah Pegawai</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Status</th>
                        <th class="px-6 py-3 text-center text-sm font-medium text-gray-900">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y bg-gray-800">
                    @forelse ($departments as $index => $department)
                        <tr>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200 font-mono">{{ $department->code }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200 font-semibold">{{ $department->name }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ Str::limit($department->description, 50) }}</td>
                            <td class="px-6 py-4 text-sm text-gray-200">{{ $department->pegawais_count ?? $department->pegawais()->count() }}</td>
                            <td class="px-6 py-4 text-sm">
                                @if($department->is_active)
                                    <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded">Aktif</span>
                                @else
                                    <span class="bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded">Non-aktif</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex justify-center items-center space-x-2">
                                    <a href="{{ route('department.show', $department) }}" class="text-green-400 hover:underline">Detail</a>
                                    @can('edit department')
                                    <a href="{{ route('department.edit', $department) }}" class="text-blue-400 hover:underline">Edit</a>
                                    @endcan
                                    @can('delete department')
                                    <form action="{{ route('department.destroy', $department) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:underline">Hapus</button>
                                    </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-400">
                                Tidak ada data department.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $departments->links() }}
        </div>
    </section>
</x-app-layout>
