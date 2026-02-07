<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detail Pegawai') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex flex-col sm:flex-row justify-between items-center border-b border-gray-200 dark:border-gray-700 pb-4 mb-6">
                        <div class="flex items-center space-x-4">
                            @if ($pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png')
                                <img src="{{ asset('storage/' . $pegawai->image) }}" alt="Foto {{ $pegawai->nama_pegawai }}"
                                    class="h-16 w-16 rounded-full object-cover border-2 border-gray-300">
                            @else
                                <div class="h-16 w-16 rounded-full bg-blue-500 flex items-center justify-center text-white text-2xl font-bold">
                                    {{ substr($pegawai->nama_pegawai, 0, 1) }}
                                </div>
                            @endif
                            <div>
                                <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-200">{{ $pegawai->nama_pegawai }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ $pegawai->employee_id }} | {{ $pegawai->jabatans->nama_jabatan ?? '-' }}</p>
                            </div>
                        </div>
                        <div class="flex gap-2 mt-4 sm:mt-0">
                            <a href="{{ route('pegawai.edit', $pegawai->id) }}"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors duration-200">
                                Edit Data
                            </a>
                            <a href="{{ route('pegawai.index') }}"
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors duration-200">
                                Kembali
                            </a>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-semibold text-blue-500 mb-4 border-b border-gray-700 pb-2">Informasi Pribadi</h4>
                            <dl class="space-y-4 text-gray-900 dark:text-white">
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">NIK (KTP)</dt>
                                    <dd class="font-mono">{{ $pegawai->nik }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Jenis Kelamin</dt>
                                    <dd>{{ $pegawai->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Tanggal Lahir</dt>
                                    <dd>{{ $pegawai->tanggal_lahir?->translatedFormat('d F Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Alamat</dt>
                                    <dd class="whitespace-pre-wrap">{{ $pegawai->alamat }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Kontak</dt>
                                    <dd>
                                        <div><i class="fa-regular fa-envelope mr-1"></i> {{ $pegawai->email }}</div>
                                        <div><i class="fa-solid fa-phone mr-1"></i> {{ $pegawai->telepon }}</div>
                                    </dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h4 class="text-lg font-semibold text-green-500 mb-4 border-b border-gray-700 pb-2">Informasi Pekerjaan</h4>
                            <dl class="space-y-4 text-gray-900 dark:text-white">
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Department</dt>
                                    <dd class="font-semibold">{{ $pegawai->department->name ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Jabatan</dt>
                                    <dd>{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Status Kepegawaian</dt>
                                    <dd>
                                        <span class="px-2 py-1 text-xs rounded 
                                            {{ $pegawai->status == 'aktif' ? 'bg-green-100 text-green-800' : 
                                               ($pegawai->status == 'cuti' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                            {{ ucfirst($pegawai->status) }}
                                        </span>
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Tanggal Masuk</dt>
                                    <dd>{{ $pegawai->tanggal_masuk?->translatedFormat('d F Y') }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Masa Kerja</dt>
                                    <dd>{{ $pegawai->tanggal_masuk?->diffForHumans(null, true) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm text-gray-500 dark:text-gray-400">Akun User</dt>
                                    <dd>
                                        @if($pegawai->user)
                                            <span class="text-blue-400">{{ $pegawai->user->name }}</span> ({{ $pegawai->user->email }})
                                        @else
                                            <span class="text-gray-500 italic">Tidak terhubung ke akun user</span>
                                        @endif
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
