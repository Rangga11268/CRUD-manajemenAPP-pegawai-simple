<style>
    body {
        overflow: hidden;
    }
</style>
<x-app-layout>
    <div class="my-0 p-5 max-w-4xl mx-auto rounded-lg shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-center border-b pb-4">
            <h3 class="text-xl font-semibold text-gray-200">Edit Data pegawai</h3>
            <a href="{{ route('pegawai.index') }}"
                class="mt-4 sm:mt-0 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Kembali
            </a>
        </div>

        <div>
            <form action="{{ route('pegawai.update', $pegawai->id) }}" method="POST" class="space-y-6"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Nama pegawai:</label>
                    <input type="text" name="nama_pegawai"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        placeholder="Masukan nama pegawai" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}">
                    @error('nama_pegawai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Alamat:</label>
                    <input type="text" name="alamat"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                        placeholder="Masukan deskripsi pegawai" value="{{ old('alamat', $pegawai->alamat) }}">
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Telepon:</label>
                    <input type="text" name="telepon"
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 "
                        placeholder="Masukan deskripsi pegawai" value="{{ old('telepon', $pegawai->telepon) }}">
                    @error('telepon')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-2">
                    <label for="jabatan_id" class="block mb-1 text-sm font-medium text-gray-900 dark:text-white">Pilih
                        Jabatan:</label>
                    <select id="jabatan_id" name="jabatan_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($jabatan as $j)
                            <option value="{{ $j->id }}"
                                {{ old('jabatan_id', $pegawai->jabatan_id) == $j->id ? 'selected' : '' }}>
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                    @error('jabatan_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mt-2">
                    <label class="block mb-1 text-sm font-medium text-gray-900 dark:text-white" for="image">Upload
                        file</label>
                    <div class="sm:flex items-center gap-x-4">
                        <div class="flex-shrink-0">
                            @if ($pegawai->image)
                                <img src="{{ asset('storage/' . $pegawai->image) }}"
                                    alt="Foto {{ $pegawai->nama_pegawai }}"
                                    class="h-24 w-24 rounded-full object-cover">
                            @else
                                <span class="inline-block h-24 w-24 overflow-hidden rounded-full bg-gray-100">
                                    <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                        <path
                                            d="M24 20.993V24H0v-2.997A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </span>
                            @endif
                        </div>
                        <div class="flex-grow mt-2 sm:mt-0">
                            <input
                                class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
                                aria-describedby="image_help" name="image" id="image" type="file">
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="image">WEBP, PNG, JPG, JPEG
                                or GIF
                                (MAX SIZE 2MB).</p>
                        </div>
                    </div>
                    @error('image')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end gap-4">
                    <a href="{{ route('pegawai.index') }}"
                        class="px-4 py-2 mb-10 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
                    <button type="submit"
                        class="px-6 py-2 mb-10 bg-slate-800 text-white rounded hover:bg-slate-600 transition">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
