<x-app-layout>
    <div class="my-6 p-10 max-w-6xl mx-auto rounded-lg shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-center border-b pb-4">
            <h3 class="text-xl font-semibold text-gray-200">Tambah Data pegawai</h3>
            <a href="{{ route('pegawai.index') }}"
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

            <form action="{{ route('pegawai.store') }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama pegawai:</label>
                    <input type="text" name="nama_pegawai"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        placeholder="Masukan nama pegawai" value="{{ old('nama_pegawai') }}">
                    @error('nama_pegawai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Alamat:</label>
                    <input type="text" name="alamat"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        placeholder="Masukan deskripsi pegawai" value="{{ old('alamat') }}">
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Telepon:</label>
                    <input type="text" name="telepon"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 "
                        placeholder="Masukan deskripsi pegawai" value="{{ old('telepon') }}">
                    @error('telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="jabatan_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pilih
                        Jabatan:</label>
                    <select id="jabatan_id" name="jabatan_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($jabatans as $jabatan)
                            <option value="{{ $jabatan->id }}"
                                {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>
                                {{ $jabatan->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                    @error('jabatan_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-3">
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="image">Upload
                        file</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        aria-describedby="image_help" name="image" id="image" type="file">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="image">WEBP, PNG, JPG, JPEG or GIF
                        (MAX SIZE 2MB).</p>

                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4 pt-4">
                    <a href="{{ route('pegawai.index') }}"
                        class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
                    <button type="submit"
                        class="px-6 py-2 bg-slate-800 text-white rounded hover:bg-slate-600 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>



</x-app-layout>
