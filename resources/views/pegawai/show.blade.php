<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pegawai') }}
        </h2>
    </x-slot>

    <div class="p-4 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5 dark:bg-gray-800 dark:border-gray-700 rounded-lg mb-4">
        <div class="w-full mb-1">
            <div class="mb-4">
                <nav class="flex mb-5" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-gray-700 hover:text-blue-600 dark:text-gray-300 dark:hover:text-white">
                                <svg class="w-5 h-5 mr-2.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path></svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <a href="{{ route('pegawai.index') }}" class="ml-1 text-sm font-medium text-gray-700 hover:text-blue-600 md:ml-2 dark:text-gray-300 dark:hover:text-white">Pegawai</a>
                            </div>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
                                <span class="ml-1 text-sm font-medium text-gray-400 md:ml-2 dark:text-gray-500" aria-current="page">Detail Pegawai</span>
                            </div>
                        </li>
                    </ol>
                </nav>
                <div class="flex items-center justify-between">
                    <h1 class="text-xl font-semibold text-gray-900 sm:text-2xl dark:text-white">Detail Pegawai: {{ $pegawai->nama_pegawai }}</h1>
                    <div class="flex space-x-2">
                        <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                            <i class="fas fa-edit mr-2"></i> Edit
                        </a>
                        <a href="{{ route('pegawai.index') }}" class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-200 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                            Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 px-4 pt-4 xl:grid-cols-3 xl:gap-4 dark:bg-gray-900">
        <div class="col-span-full xl:col-auto">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
                <div class="items-center sm:flex xl:block 2xl:flex sm:space-x-4 xl:space-x-0 2xl:space-x-4">
                    @if ($pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png')
                        <img class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0 border-2 border-blue-500" src="{{ asset('storage/' . $pegawai->image) }}" alt="Jese picture">
                    @else
                        <img class="mb-4 rounded-lg w-28 h-28 sm:mb-0 xl:mb-4 2xl:mb-0 border-2 border-gray-300" src="https://ui-avatars.com/api/?name={{ urlencode($pegawai->nama_pegawai) }}&color=7F9CF5&background=EBF4FF" alt="Jese picture">
                    @endif
                    <div>
                        <h3 class="mb-1 text-xl font-bold text-gray-900 dark:text-white">{{ $pegawai->nama_pegawai }}</h3>
                        <div class="mb-4 text-sm text-gray-500 dark:text-gray-400">
                            {{ $pegawai->jabatans->nama_jabatan ?? '-' }}
                        </div>
                        <div class="flex items-center space-x-4">
                            <span class="bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">
                                {{ strtoupper($pegawai->status) }}
                            </span>
                            @if($pegawai->user)
                                <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">
                                    Linked to User
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-4 text-xl font-semibold dark:text-white">Informasi Pekerjaan</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Department</label>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $pegawai->department->name ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Jabatan</label>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Masuk</label>
                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $pegawai->tanggal_masuk?->translatedFormat('d F Y') }}</p>
                    </div>
                    <div>
                        <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Gaji Pokok</label>
                        <p class="text-sm font-bold text-blue-600 dark:text-blue-400">Rp {{ number_format($pegawai->gaji_pokok, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-2">
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-4 text-xl font-semibold dark:text-white">Identitas & Kontak</h3>
                <div class="grid grid-cols-6 gap-6">
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">ID Pegawai (NIP)</label>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $pegawai->employee_id }}</p>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">NIK (KTP)</label>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $pegawai->nik }}</p>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Email</label>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $pegawai->email }}</p>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">No. Telepon</label>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $pegawai->telepon }}</p>
                    </div>
                    <div class="col-span-6">
                        <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</label>
                        <p class="text-base text-gray-900 dark:text-white italic">{{ $pegawai->alamat }}</p>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</label>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $pegawai->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div class="col-span-6 sm:col-span-3">
                        <label class="block mb-1 text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Lahir</label>
                        <p class="text-base font-semibold text-gray-900 dark:text-white">{{ $pegawai->tanggal_lahir?->translatedFormat('d F Y') }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-4 mb-4 bg-white border border-gray-200 rounded-lg shadow-sm sm:p-6 dark:border-gray-700 dark:bg-gray-800">
                <h3 class="mb-4 text-xl font-semibold dark:text-white">Akun Keamanan</h3>
                @if($pegawai->user)
                    <div class="flex items-center space-x-4">
                        <div class="flex-shrink-0">
                            <i class="fas fa-user-shield text-3xl text-green-500"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Terhubung dengan: {{ $pegawai->user->name }}
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                Role: {{ ucfirst($pegawai->user->role) }} | Email: {{ $pegawai->user->email }}
                            </p>
                        </div>
                    </div>
                @else
                    <div class="flex items-center p-4 text-sm text-yellow-800 rounded-lg bg-yellow-50 dark:bg-gray-800 dark:text-yellow-300" role="alert">
                        <i class="fas fa-exclamation-triangle mr-3"></i>
                        <div>
                            Pegawai ini belum memiliki akun login sistem. Silahkan buat akun di menu <a href="{{ route('users.index') }}" class="font-bold underline">Management User</a>.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
