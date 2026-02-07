<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Department') }}
        </h2>
    </x-slot>

    <section class="max-w-2xl mx-auto px-4 py-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <form action="{{ route('department.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="code" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Kode Department</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}" 
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Contoh: HRD, IT, FIN" required>
                    @error('code')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Department</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" 
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Nama department" required>
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Deskripsi</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Deskripsi department">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="parent_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Parent Department (Opsional)</label>
                    <select name="parent_id" id="parent_id" 
                        class="w-full bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg px-4 py-2 text-gray-900 dark:text-white focus:ring-blue-500 focus:border-blue-500">
                        <option value="">-- Tidak ada parent --</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}" {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-6">
                    <label class="flex items-center">
                        <input type="checkbox" name="is_active" value="1" checked
                            class="rounded border-gray-300 dark:border-gray-600 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Aktif</span>
                    </label>
                </div>

                <div class="flex justify-end space-x-2">
                    <a href="{{ route('department.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Batal
                    </a>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </section>
</x-app-layout>
