<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ \App\Models\Setting::value('app_name', config('app.name')) }} - Manajemen SDM</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Navigation -->
        <nav class="bg-white/90 backdrop-blur-md fixed w-full z-50 shadow-sm border-b border-gray-100 transition-all duration-300">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                <!-- Logo & Brand -->
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div class="bg-blue-600 text-white p-2 rounded-lg">
                        @if(\App\Models\Setting::value('app_logo'))
                             <img src="{{ asset('storage/' . \App\Models\Setting::value('app_logo')) }}" alt="Logo" class="h-8 w-auto">
                        @else
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 0 11-6 0 3 3 0 016 0zm6 3a2 0 11-4 0 2 2 0 014 0zM7 10a2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <span class="text-2xl font-bold text-gray-900">{{ \App\Models\Setting::value('app_name', config('app.name')) }}</span>
                </a>
                    <div class="hidden md:block">
                        @if (Route::has('login'))
                            <div class="ml-4 flex items-center gap-4">
                                @auth
                                    <a href="{{ url('/dashboard') }}"
                                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-600/30 transform hover:-translate-y-0.5">
                                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                    </a>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="text-sm font-semibold text-gray-600 hover:text-blue-600 transition">
                                        Log in
                                    </a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}"
                                            class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-full hover:bg-blue-700 transition shadow-lg shadow-blue-600/30 transform hover:-translate-y-0.5">
                                            Register
                                        </a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button class="text-gray-600 focus:outline-none">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-grow pt-20">
            <!-- Hero Section -->
            <section class="relative bg-white overflow-hidden">
                <div class="absolute inset-y-0 right-0 w-1/2 bg-blue-50 rounded-l-[10rem] hidden lg:block opacity-60"></div>
                <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-24 sm:py-32">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                        <div class="text-left space-y-8 animate-fade-in-up">
                            <div class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100 text-blue-700 text-sm font-semibold">
                                <span class="w-2 h-2 rounded-full bg-blue-600 mr-2"></span>
                                Sistem Manajemen Terintegrasi v1.0
                            </div>
                            <h1 class="text-5xl font-extrabold tracking-tight text-gray-900 sm:text-6xl leading-tight">
                                Kelola SDM Perusahaan <br>
                                <span class="text-blue-600 relative">
                                    Lebih Cerdas
                                    <svg class="absolute w-full h-3 -bottom-1 left-0 text-blue-200 -z-10" viewBox="0 0 100 10" preserveAspectRatio="none">
                                        <path d="M0 5 Q 50 10 100 5 L 100 10 L 0 10 Z" fill="currentColor"></path>
                                    </svg>
                                </span>
                            </h1>
                            <p class="text-lg text-gray-600 leading-relaxed max-w-lg">
                                Platform lengkap untuk manajemen pegawai, absensi, penggajian, dan cuti. 
                                Tingkatkan produktivitas tim dengan otomatisasi proses HR yang modern.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-8 py-4 text-base font-semibold text-white bg-blue-600 rounded-full hover:bg-blue-700 transition shadow-xl shadow-blue-600/20 transform hover:-translate-y-1">
                                    Mulai Sekarang
                                    <i class="fas fa-arrow-right ml-2 text-sm"></i>
                                </a>
                                <a href="#features" class="inline-flex justify-center items-center px-8 py-4 text-base font-semibold text-gray-700 bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition hover:border-blue-300">
                                    Pelajari Fitur
                                </a>
                            </div>
                            <div class="pt-8 flex items-center gap-8 text-gray-500 text-sm">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-check-circle text-green-500"></i> Data Aman
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-check-circle text-green-500"></i> Real-time Dashboard
                                </div>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-check-circle text-green-500"></i> Export Report
                                </div>
                            </div>
                        </div>
                        <div class="relative lg:h-auto lg:w-full">
                            <!-- Illustrated Abstract Graphic -->
                            <div class="relative bg-white rounded-2xl shadow-2xl p-6 border border-gray-100 transform rotate-2 hover:rotate-0 transition duration-500">
                                <div class="flex items-center justify-between mb-6">
                                    <div class="flex items-center gap-3">
                                        <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                        <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                        <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                    </div>
                                    <div class="text-xs text-gray-400">Dashboard Preview</div>
                                </div>
                                <div class="grid grid-cols-2 gap-4 mb-4">
                                    <div class="bg-blue-50 p-4 rounded-xl">
                                        <div class="text-blue-600 text-2xl font-bold mb-1">{{ $totalPegawai }}</div>
                                        <div class="text-sm text-gray-600">Total Pegawai</div>
                                    </div>
                                    <div class="bg-green-50 p-4 rounded-xl">
                                        <div class="text-green-600 text-2xl font-bold mb-1">{{ $totalJabatan }}</div>
                                        <div class="text-sm text-gray-600">Posisi Jabatan</div>
                                    </div>
                                </div>
                                <div class="space-y-3">
                                    <div class="h-2 bg-gray-100 rounded-full w-3/4"></div>
                                    <div class="h-2 bg-gray-100 rounded-full w-1/2"></div>
                                    <div class="h-2 bg-gray-100 rounded-full w-5/6"></div>
                                </div>
                                <div class="mt-6 flex justify-between items-end">
                                    <div class="flex -space-x-2">
                                        @foreach($recentPegawai->take(3) as $pegawai)
                                            <img class="w-10 h-10 rounded-full border-2 border-white" 
                                                src="https://ui-avatars.com/api/?name={{ urlencode($pegawai->nama_pegawai) }}&background=random" 
                                                alt="{{ $pegawai->nama_pegawai }}">
                                        @endforeach
                                        <div class="w-10 h-10 rounded-full border-2 border-white bg-gray-100 flex items-center justify-center text-xs font-bold text-gray-500">
                                            +{{ $totalPegawai > 3 ? $totalPegawai - 3 : 0 }}
                                        </div>
                                    </div>
                                    <div class="text-blue-600 font-bold text-sm">Live Update <i class="fas fa-wifi ml-1 animate-pulse"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

             <!-- Agenda Section -->
            <section class="py-12 bg-white">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                     <div class="text-center mb-12">
                        <h2 class="text-blue-600 font-semibold tracking-wide uppercase text-sm">Kalender Perusahaan</h2>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Agenda & Hari Libur</h3>
                    </div>
                    <div class="row justify-content-center">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            @forelse($upcomingEvents ?? [] as $event)
                            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-lg transition duration-300">
                                <div class="flex items-center gap-4 mb-4">
                                     <div class="w-12 h-12 rounded-full flex items-center justify-center
                                        @if($event->category == 'holiday') bg-red-100 text-red-600
                                        @elseif($event->category == 'cuti_bersama') bg-orange-100 text-orange-600
                                        @else bg-blue-100 text-blue-600 @endif">
                                        @if($event->category == 'holiday')
                                            <i class="fas fa-umbrella-beach text-xl"></i>
                                        @elseif($event->category == 'cuti_bersama')
                                            <i class="fas fa-plane-departure text-xl"></i>
                                        @else
                                            <i class="fas fa-briefcase text-xl"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg">{{ $event->title }}</h4>
                                        <span class="text-xs font-medium px-2 py-1 rounded-full
                                            @if($event->category == 'holiday') bg-red-50 text-red-600
                                            @elseif($event->category == 'cuti_bersama') bg-orange-50 text-orange-600
                                            @else bg-blue-50 text-blue-600 @endif">
                                            {{ ucfirst(str_replace('_', ' ', $event->category)) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="space-y-2 text-gray-600">
                                    <div class="flex items-center gap-2 text-sm">
                                        <i class="far fa-calendar-alt text-gray-400"></i>
                                        <span>{{ $event->start_date->format('d M Y') }}
                                            @if($event->end_date && $event->end_date != $event->start_date)
                                                - {{ $event->end_date->format('d M Y') }}
                                            @endif
                                        </span>
                                    </div>
                                    @if($event->description)
                                    <p class="text-sm text-gray-500 line-clamp-2">{{ $event->description }}</p>
                                    @endif
                                </div>

                                @if($event->is_day_off)
                                    <div class="mt-4 pt-4 border-t border-gray-50 text-center">
                                        <span class="inline-flex items-center text-xs font-semibold text-red-500">
                                            <i class="fas fa-ban mr-1"></i> Libur (Office Closed)
                                        </span>
                                    </div>
                                @endif
                            </div>
                            @empty
                            <div class="col-span-full text-center py-12 bg-gray-50 rounded-2xl border border-dashed border-gray-300">
                                <i class="far fa-calendar-times text-4xl text-gray-300 mb-3 block"></i>
                                <p class="text-gray-500">Belum ada agenda perusahaan dalam waktu dekat.</p>
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </section>

            <!-- Features Section -->
            <section id="features" class="py-24 bg-gray-50">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-blue-600 font-semibold tracking-wide uppercase text-sm">Fitur Unggulan</h2>
                        <h3 class="mt-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Semua Kebutuhan HR dalam Satu Aplikasi</h3>
                        <p class="mt-4 max-w-2xl text-lg text-gray-500 mx-auto">Dirancang untuk memudahkan administrasi perusahaan Anda.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition duration-300 border border-gray-100 group">
                            <div class="w-14 h-14 bg-blue-100 rounded-xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-blue-600 group-hover:text-white transition">
                                <i class="fas fa-users text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Database Pegawai</h4>
                            <p class="text-gray-500 leading-relaxed">Penyimpanan data pegawai terpusat dengan profil detail, riwayat jabatan, dan dokumen penting.</p>
                        </div>
                        
                        <!-- Feature 2 -->
                        <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition duration-300 border border-gray-100 group">
                            <div class="w-14 h-14 bg-green-100 rounded-xl flex items-center justify-center text-green-600 mb-6 group-hover:bg-green-600 group-hover:text-white transition">
                                <i class="fas fa-clock text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Absensi Online</h4>
                            <p class="text-gray-500 leading-relaxed">Sistem pencatatan kehadiran real-time dengan clock-in/out yang mudah dan akurat.</p>
                        </div>
                        
                        <!-- Feature 3 -->
                        <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition duration-300 border border-gray-100 group">
                            <div class="w-14 h-14 bg-purple-100 rounded-xl flex items-center justify-center text-purple-600 mb-6 group-hover:bg-purple-600 group-hover:text-white transition">
                                <i class="fas fa-money-bill-wave text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Payroll System</h4>
                            <p class="text-gray-500 leading-relaxed">Otomatisasi perhitungan gaji, tunjangan, dan potongan dengan slip gaji digital.</p>
                        </div>

                        <!-- Feature 4 -->
                        <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition duration-300 border border-gray-100 group">
                            <div class="w-14 h-14 bg-orange-100 rounded-xl flex items-center justify-center text-orange-600 mb-6 group-hover:bg-orange-600 group-hover:text-white transition">
                                <i class="fas fa-plane-departure text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Manajemen Cuti</h4>
                            <p class="text-gray-500 leading-relaxed">Pengajuan dan persetujuan cuti yang efisien dengan tracking sisa kuota cuti.</p>
                        </div>
                        
                        <!-- Feature 5 -->
                        <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition duration-300 border border-gray-100 group">
                            <div class="w-14 h-14 bg-red-100 rounded-xl flex items-center justify-center text-red-600 mb-6 group-hover:bg-red-600 group-hover:text-white transition">
                                <i class="fas fa-chart-line text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Laporan & Analitik</h4>
                            <p class="text-gray-500 leading-relaxed">Visualisasi data kinerja perusahaan dan absensi dalam bentuk grafik interaktif.</p>
                        </div>

                         <!-- Feature 6 -->
                         <div class="bg-white rounded-2xl p-8 shadow-sm hover:shadow-lg transition duration-300 border border-gray-100 group">
                            <div class="w-14 h-14 bg-teal-100 rounded-xl flex items-center justify-center text-teal-600 mb-6 group-hover:bg-teal-600 group-hover:text-white transition">
                                <i class="fas fa-file-pdf text-2xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Export Data</h4>
                            <p class="text-gray-500 leading-relaxed">Kemudahan export data laporan ke format PDF dan Excel untuk keperluan administrasi.</p>
                        </div>
                    </div>
                </div>
            </section>

             <!-- New Team Members Section -->
             <section class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Tim Terbaru Bergabung</h2>
                        <p class="mt-4 text-lg text-gray-500">Menyambut talenta-talenta baru di perusahaan.</p>
                    </div>
                    
                    <div class="flex flex-wrap justify-center gap-8">
                        @forelse ($recentPegawai as $pegawai)
                            <div class="flex flex-col items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100 w-48 hover:-translate-y-2 transition-transform duration-300">
                                <div class="relative">
                                    <img class="w-24 h-24 rounded-full object-cover border-4 border-blue-50"
                                        src="{{ $pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png' ? asset('storage/' . $pegawai->image) : 'https://ui-avatars.com/api/?name='.urlencode($pegawai->nama_pegawai).'&color=7F9CF5&background=EBF4FF' }}"
                                        alt="{{ $pegawai->nama_pegawai }}">
                                    <span class="absolute bottom-1 right-1 w-5 h-5 bg-green-500 border-2 border-white rounded-full"></span>
                                </div>
                                <h3 class="mt-4 text-sm font-bold text-gray-900 text-center">{{ Str::limit($pegawai->nama_pegawai, 15) }}</h3>
                                <p class="text-xs text-blue-600 mt-1 text-center font-medium px-2 py-1 bg-blue-50 rounded-md">
                                    {{ $pegawai->jabatans->nama_jabatan ?? 'Pegawai' }}
                                </p>
                            </div>
                        @empty
                            <div class="p-8 text-center text-gray-500 bg-gray-50 rounded-xl w-full">
                                <i class="fas fa-user-slash text-4xl mb-3 text-gray-300"></i>
                                <p>Belum ada data pegawai baru.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

             <!-- CTA Section -->
             <section class="py-20 relative overflow-hidden">
                <div class="absolute inset-0 bg-blue-600">
                    <svg class="absolute inset-0 h-full w-full opacity-10" viewBox="0 0 100 100" preserveAspectRatio="none">
                        <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
                    </svg>
                </div>
                <div class="relative max-w-4xl mx-auto text-center px-6">
                    <h2 class="text-3xl font-bold text-white sm:text-4xl mb-6">Siap Mengoptimalkan Manajemen SDM?</h2>
                    <p class="text-blue-100 text-lg mb-10 max-w-2xl mx-auto">Bergabunglah sekarang dan rasakan kemudahan pengelolaan administrasi kepegawaian yang lebih efisien.</p>
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-blue-600 bg-white rounded-full hover:bg-gray-100 transition shadow-xl">
                        Akses Dashboard
                    </a>
                </div>
            </section>
        </main>

        <footer class="bg-gray-900 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-6 py-12 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <!-- Brand -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-2 text-white text-xl font-bold">
                            <i class="fas fa-users-cog text-blue-500"></i> Manajemen SDM
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Aplikasi manajemen sumber daya manusia berbasis web yang modern, aman, dan mudah digunakan.
                        </p>
                    </div>
                    
                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-white font-semibold mb-4">Akses Cepat</h3>
                        <ul class="space-y-2 text-sm text-gray-400">
                            <li><a href="#" class="hover:text-blue-400 transition">Beranda</a></li>
                            <li><a href="#features" class="hover:text-blue-400 transition">Fitur</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition">Login Pegawai</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="text-white font-semibold mb-4">Hubungi Kami</h3>
                         <ul class="space-y-2 text-sm text-gray-400">
                            <li class="flex items-center gap-2"><i class="fas fa-envelope text-gray-500"></i> admin@company.com</li>
                            <li class="flex items-center gap-2"><i class="fas fa-phone text-gray-500"></i> +62 21 1234 5678</li>
                        </ul>
                    </div>
                </div>
                <div class="mt-12 pt-8 border-t border-gray-800 text-center text-gray-500 text-sm">
                    &copy; {{ date('Y') }} {{ \App\Models\Setting::value('app_name', config('app.name')) }}. All rights reserved.
                </div>
            </div>
        </footer>
    </div>
</body>

</html>
