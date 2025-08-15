<x-app-layout>
    <div class="my-6 p-10 max-w-6xl mx-auto rounded-lg shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-center border-b pb-4">
            <h3 class="text-xl font-semibold text-gray-200">Edit Data pegawai</h3>
            <a href="{{ route('pegawai.index') }}"
                class="mt-4 sm:mt-0 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Kembali
            </a>
        </div>

        <div class="pt-6">
            <form action="{{ route('pegawai.edit', $pegawai->id) }}" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-200 mb-1">Nama pegawai:</label>
                    <input type="text" name="nama_pegawai"
                        class="w-full px-4 py-2 border @error('nama_pegawai') border-red-500  @enderror rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                        placeholder="Masukan nama pegawai" value="{{ $pegawai->nama_pegawai }}">
                    @error('nama_pegawai')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-200 mb-1">Alamat pegawai:</label>
                    <input type="text" name="alamat" class="w-full px-4 py-2 border "
                        placeholder="Masukan alamat pegawai" value="{{ $pegawai->alamat }}">
                    @error('alamat')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-200 mb-1">Telepon pegawai:</label>
                    <input type="text" name="telepon" class="w-full px-4 py-2 border "
                        placeholder="Masukan telepon pegawai" value="{{ $pegawai->telepon }}">
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
