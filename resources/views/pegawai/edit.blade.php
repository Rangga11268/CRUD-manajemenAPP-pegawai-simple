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

                <div class="mt-4">
                    <x-input-label for="nama_pegawai" :value="__('Nama pegawai:')" />

                    <x-text-input id="nama_pegawai" class="block mt-1 w-full" type="text" name="nama_pegawai"
                        autocomplete="new-name" value="{{ old('nama_pegawai', $pegawai->nama_pegawai) }}" />

                    <x-input-error :messages="$errors->get('nama_pegawai')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="alamat" :value="__('Alamat:')" />

                    <x-text-input id="alamat" class="block mt-1 w-full" type="text" name="alamat"
                        autocomplete="new-name" value="{{ old('alamat', $pegawai->alamat) }}" />

                    <x-input-error :messages="$errors->get('alamat')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="telepon" :value="__('Telepon:')" />

                    <x-text-input id="telepon" class="block mt-1 w-full" type="text" name="telepon"
                        autocomplete="new-name" value="{{ old('telepon', $pegawai->telepon) }}" />

                    <x-input-error :messages="$errors->get('telepon')" class="mt-2" />
                </div>

                <div class="mb-2">
                    <x-input-label for="jabatan_id" :value="__('Pilih Jabatan:')" />
                    <select id="jabatan_id" name="jabatan_id"
                        class="mt-2 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm">
                        @foreach ($jabatan as $j)
                            <option value="{{ $j->id }}"
                                {{ old('jabatan_id', $pegawai->jabatan_id) == $j->id ? 'selected' : '' }}>
                                {{ $j->nama_jabatan }}
                            </option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('jabatan_id')" class="mt-2" />
                </div>

                <div class="mt-2">
                    <x-input-label for="image" class="mb-2" :value="__('Upload gambar:')" />

                    <div class="sm:flex items-center gap-x-4">
                        <div class="flex-shrink-0">
                            @if ($pegawai->image)
                                <img src="{{ asset('storage/' . $pegawai->image) }}"
                                    alt="Foto {{ $pegawai->nama_pegawai }}" class="h-24 w-24 rounded-full object-cover">
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
                            <x-text-input id="image" class="block mt-1 w-full" type="file" name="image"
                                autocomplete="new-name" value="{{ old('image') }}" />
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
