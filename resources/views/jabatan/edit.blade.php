<x-app-layout>
    <div class="my-6 p-6 rounded-lg shadow-md">
        <div class="flex flex-col sm:flex-row justify-between items-center border-b pb-4">
            <h3 class="text-xl font-semibold text-gray-200">Edit Data Jabatan</h3>
            <a href="{{ route('jabatan.index') }}"
                class="mt-4 sm:mt-0 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Kembali
            </a>
        </div>

        <div class="pt-6">
            @if ($errors->any())
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('jabatan.update', $jabatan->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUt')

                <!-- Nama Jabatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-200 mb-1">Nama Jabatan:</label>
                    <input type="text" name="nama_jabatan"
                        class="w-full px-4 py-2 border @error('nama_jabatan') border-red-500  @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukan nama jabatan" value="{{ $jabatan->nama_jabatan }}">
                    @error('nama_jabatan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Deskripsi Jabatan -->
                <div>
                    <label class="block text-sm font-medium text-gray-200 mb-1">Deskripsi Jabatan:</label>
                    <input type="text" name="deskripsi_jabatan" class="w-full px-4 py-2 border "
                        placeholder="Masukan deskripsi jabatan" value="{{ $jabatan->deskripsi_jabatan }}">
                    @error('deskripsi_jabatan')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('jabatan.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
                    <button type="submit"
                        class="px-6 py-2 bg-slate-800 text-white rounded hover:bg-slate-600 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>



</x-app-layout>
