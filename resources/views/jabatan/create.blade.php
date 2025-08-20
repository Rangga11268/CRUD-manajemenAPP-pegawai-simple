<x-app-layout>
    <div class="my-6 p-10 max-w-6xl mx-auto rounded-lg shadow-lg">
        <div class="flex flex-col sm:flex-row justify-between items-center border-b pb-4">
            <h3 class="text-xl font-semibold text-gray-200">Tambah Data Jabatan</h3>
            <a href="{{ route('jabatan.index') }}"
                class="mt-4 sm:mt-0 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600 transition">
                Kembali
            </a>
        </div>

        <div class="pt-6">
            <form action="{{ route('jabatan.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="mt-4">
                    <x-input-label for="nama_jabatan" :value="__('Nama Jabatan:')" />

                    <x-text-input id="nama_jabatan" class="block mt-1 w-full" type="text" name="nama_jabatan"
                        autocomplete="new-name" value="{{ old('nama_jabatan') }}" />

                    <x-input-error :messages="$errors->get('nama_jabatan')" class="mt-2" />
                </div>

                <div class="mt-4">
                    <x-input-label for="deskripsi_jabatan" :value="__('Deskripsi Jabatan:')" />

                    <x-text-input id="deskripsi_jabatan" class="block mt-1 w-full" type="text"
                        name="deskripsi_jabatan" autocomplete="new-name" value="{{ old('deskripsi_jabatan') }}" />

                    <x-input-error :messages="$errors->get('deskripsi_jabatan')" class="mt-2" />
                </div>

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
