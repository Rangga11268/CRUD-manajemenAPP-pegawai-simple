<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - PT. Rangga Sejahtera</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 bg-gray-100 dark:bg-gray-900 antialiased">
    <div class="min-h-screen flex flex-col">
        <nav class="bg-white dark:bg-gray-800 shadow-md">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600 dark:text-blue-400">
                            Manajemen Pegawai
                        </a>
                    </div>
                    <div class="hidden md:block">
                        @if (Route::has('login'))
                            <div class="ml-4 flex items-center md:ml-6">
                                @auth
                                    <a href="{{ url('/dashboard') }}"
                                        class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Login</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                            class="ml-4 px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-gray-200 dark:bg-gray-700 rounded-md hover:bg-gray-300 dark:hover:bg-gray-600">Register</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-grow">
            <section class="text-center py-20 bg-white dark:bg-gray-800">
                <div class="max-w-4xl mx-auto px-6">
                    <h1
                        class="text-4xl font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                        Manajemen Pegawai Modern & Efisien
                    </h1>
                    <p class="mt-6 max-w-2xl mx-auto text-lg leading-8 text-gray-600 dark:text-gray-300">
                        Selamat datang di sistem manajemen pegawai PT. Rangga Sejahtera. Kelola data, pantau kinerja,
                        dan tingkatkan produktivitas dengan mudah.
                    </p>
                    <div class="mt-10">
                        <a href="{{ route('login') }}"
                            class="px-8 py-3 text-base font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700">Mulai
                            Sekarang</a>
                    </div>
                </div>
            </section>

            <!-- Stats Section -->
            <section class="py-16 bg-gray-50 dark:bg-gray-800/50">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-center">
                        <div class="p-8 bg-white dark:bg-gray-800 rounded-lg shadow">
                            <h3 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $totalPegawai }}</h3>
                            <p class="mt-2 text-base font-medium text-gray-500 dark:text-gray-400">Total Pegawai
                                Terdaftar</p>
                        </div>
                        <div class="p-8 bg-white dark:bg-gray-800 rounded-lg shadow">
                            <h3 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $totalJabatan }}</h3>
                            <p class="mt-2 text-base font-medium text-gray-500 dark:text-gray-400">Total Jabatan
                                Tersedia</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="py-16 bg-white dark:bg-gray-800">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Anggota
                            Tim Terbaru Kami</h2>
                        <p class="mt-4 text-lg leading-8 text-gray-600 dark:text-gray-300">
                            Berikut adalah beberapa pegawai yang baru bergabung dengan kami.
                        </p>
                    </div>
                    <div class="mt-10 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-5">
                        @forelse ($recentPegawai as $pegawai)
                            <div class="text-center">
                                <img class="mx-auto h-24 w-24 rounded-full"
                                    src="https://ui-avatars.com/api/?name={{ urlencode($pegawai->nama_pegawai) }}&color=7F9CF5&background=EBF4FF"
                                    alt="Avatar {{ $pegawai->nama_pegawai }}">
                                <h3
                                    class="mt-6 text-base font-semibold leading-7 tracking-tight text-gray-900 dark:text-white">
                                    {{ $pegawai->nama_pegawai }}</h3>
                                <p class="text-sm leading-6 text-gray-600 dark:text-gray-400">
                                    {{ $pegawai->jabatan->nama_jabatan ?? 'Belum ada jabatan' }}</p>
                            </div>
                        @empty
                            <p class="col-span-full text-center text-gray-500 dark:text-gray-400">Belum ada pegawai baru
                                yang ditambahkan.</p>
                        @endforelse
                    </div>
                </div>
            </section>
        </main>


        @include('layouts.footer')
    </div>
</body>

</html>
