<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PT. Rangga Sejahtera</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50 text-gray-800">
    <nav class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex justify-between items-center">
            <h1 class="text-xl font-bold text-blue-600">Manajemen Pegawai</h1>
            <div class="space-x-4">
                <a href="{{ route('login') }}"
                    class="px-4 py-2 bg-slate-900 text-white rounded hover:bg-slate-600">Login</a>
                <a href="{{ route('register') }}"
                    class="px-4 py-2 bg-red-950 text-white rounded hover:bg-red-400">Register</a>
            </div>
        </div>
    </nav>


    <section class="text-center py-16 bg-gradient-to-r from-blue-100 to-green-100">
        <h2 class="text-3xl font-bold mb-4">Selamat Datang di Aplikasi Manajemen Pegawai</h2>
        <p class="text-xl text-gray-700">PT. Rangga Sejahtera</p>
    </section>

    <section class="max-w-4xl mx-auto px-6 py-12">
        <h3 class="text-2xl font-semibold mb-4 text-blue-700">Tentang PT. Rangga Sejahtera</h3>
        <p class="text-gray-700 leading-relaxed">
            PT. Rangga Sejahtera adalah perusahaan yang bergerak di bidang pengelolaan sumber daya manusia, berkomitmen
            untuk memberikan solusi manajemen pegawai yang efisien dan terintegrasi. Dengan aplikasi ini, kami
            mempermudah proses rekrutmen, penilaian kinerja, dan pengelolaan data pegawai secara digital dan aman.
        </p>
    </section>

    @include('layouts.footer');

</html>
