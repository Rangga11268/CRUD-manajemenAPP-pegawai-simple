<x-app-layout>
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div
                        class="flex flex-col sm:flex-row justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                        <h3 class="text-xl font-semibold text-gray-800 dark:text-gray-200">Detail Pegawai</h3>
                        <a href="{{ route('pegawai.index') }}"
                            class="mt-4 sm:mt-0 px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors duration-200">
                            Kembali
                        </a>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1 flex justify-center items-start">
                            @if ($pegawai->image)
                                <img src="{{ asset('storage/' . $pegawai->image) }}"
                                    alt="Foto {{ $pegawai->nama_pegawai }}"
                                    class="rounded-lg w-full h-auto object-cover shadow-md">
                            @else
                                <div
                                    class="w-full h-64 flex justify-center items-center bg-gray-100 dark:bg-gray-700 rounded-lg">
                                    <span class="text-gray-500">No Image</span>
                                </div>
                            @endif
                        </div>
                        <div class="md:col-span-2">
                            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                <tbody>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap bg-gray-50 dark:bg-gray-800">
                                            Nama Pegawai
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $pegawai->nama_pegawai }}
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap bg-gray-50 dark:bg-gray-800">
                                            Jabatan
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $pegawai->jabatans->nama_jabatan ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap bg-gray-50 dark:bg-gray-800">
                                            Alamat
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $pegawai->alamat }}
                                        </td>
                                    </tr>
                                    <tr class="border-b border-gray-200 dark:border-gray-700">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap bg-gray-50 dark:bg-gray-800">
                                            Nomor Telepon
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ $pegawai->telepon }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
