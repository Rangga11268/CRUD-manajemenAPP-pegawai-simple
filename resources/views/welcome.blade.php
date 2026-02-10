<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Platform manajemen sumber daya manusia modern untuk pengelolaan pegawai, absensi, penggajian, dan cuti secara terintegrasi.">

    <title>{{ \App\Models\Setting::value('app_name', config('app.name')) }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', sans-serif; }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInLeft {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(30px); }
            to { opacity: 1; transform: translateX(0); }
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(2deg); }
            50% { transform: translateY(-10px) rotate(0deg); }
        }
        @keyframes pulse-soft {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }
        @keyframes countUp {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes gradient-shift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }
        .animate-fade-in-left { animation: fadeInLeft 0.8s ease-out forwards; }
        .animate-fade-in-right { animation: fadeInRight 0.8s ease-out forwards; }
        .animate-float { animation: float 6s ease-in-out infinite; }
        .animate-pulse-soft { animation: pulse-soft 3s ease-in-out infinite; }
        .animate-count-up { animation: countUp 0.6s ease-out forwards; }

        .delay-100 { animation-delay: 0.1s; }
        .delay-200 { animation-delay: 0.2s; }
        .delay-300 { animation-delay: 0.3s; }
        .delay-400 { animation-delay: 0.4s; }
        .delay-500 { animation-delay: 0.5s; }

        .gradient-text {
            background: linear-gradient(135deg, #2563eb, #7c3aed, #2563eb);
            background-size: 200% 200%;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradient-shift 4s ease infinite;
        }

        /* Glassmorphism */
        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        /* Feature card hover effect */
        .feature-card {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px -12px rgba(0, 0, 0, 0.1);
        }
        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(-5deg);
        }
        .feature-icon {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Scroll to top */
        .scroll-top-btn {
            transition: all 0.3s ease;
        }
        .scroll-top-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
        }
    </style>
</head>

<body class="text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col" x-data="{ scrollTop: false }" @scroll.window="scrollTop = (window.scrollY > 400)">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-xl fixed w-full z-50 shadow-sm border-b border-gray-100/50 transition-all duration-300">
            <div x-data="{ mobileMenuOpen: false }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <!-- Logo & Brand -->
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="bg-gradient-to-br from-blue-600 to-indigo-600 text-white p-2.5 rounded-xl shadow-lg shadow-blue-600/20 group-hover:shadow-blue-600/40 transition-all duration-300">
                            @if(\App\Models\Setting::value('app_logo'))
                                <img src="{{ asset('storage/' . \App\Models\Setting::value('app_logo')) }}" alt="Logo" class="h-7 w-auto">
                            @else
                                <i class="fas fa-users-cog text-lg"></i>
                            @endif
                        </div>
                        <span class="text-xl font-extrabold text-gray-900 tracking-tight">{{ \App\Models\Setting::value('app_name', config('app.name')) }}</span>
                    </a>

                    <!-- Desktop Nav -->
                    <div class="hidden md:flex items-center gap-6">
                        <a href="#features" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">Fitur</a>
                        <a href="#agenda" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">Agenda</a>
                        <a href="#team" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">Tim</a>
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                    class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40 transform hover:-translate-y-0.5">
                                    <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="text-sm font-semibold text-gray-600 hover:text-blue-600 transition">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}"
                                        class="px-5 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-lg shadow-blue-600/25 hover:shadow-blue-600/40 transform hover:-translate-y-0.5">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>

                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-blue-600 focus:outline-none transition">
                            <i x-show="!mobileMenuOpen" class="fas fa-bars text-xl"></i>
                            <i x-show="mobileMenuOpen" class="fas fa-times text-xl" style="display:none;"></i>
                        </button>
                    </div>
                </div>

                <!-- Mobile Menu Dropdown -->
                <div x-show="mobileMenuOpen" x-cloak
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="md:hidden pb-4 border-t border-gray-100" style="display: none;">
                    <div class="flex flex-col gap-2 pt-4">
                        <a href="#features" @click="mobileMenuOpen = false" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">Fitur</a>
                        <a href="#agenda" @click="mobileMenuOpen = false" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">Agenda</a>
                        <a href="#team" @click="mobileMenuOpen = false" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">Tim</a>
                        <hr class="border-gray-100 my-1">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg text-center">
                                    <i class="fas fa-tachometer-alt mr-1"></i> Dashboard
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="px-4 py-2.5 text-sm font-semibold text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">
                                    Log in
                                </a>
                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="px-4 py-2.5 text-sm font-semibold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg text-center">
                                        Register
                                    </a>
                                @endif
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <main class="flex-grow pt-20">
            <!-- ====== HERO SECTION ====== -->
            <section class="relative bg-gradient-to-br from-white via-blue-50/30 to-indigo-50/40 overflow-hidden">

                <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-20 sm:py-28 lg:py-36">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                        <!-- Left: Content -->
                        <div class="text-left space-y-8">
                            <div class="animate-fade-in-up" style="opacity:0;">
                                <span class="inline-flex items-center px-4 py-2 rounded-full bg-blue-100/80 text-blue-700 text-sm font-semibold border border-blue-200/50">
                                    <span class="relative flex h-2 w-2 mr-2">
                                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-500 opacity-75"></span>
                                        <span class="relative inline-flex rounded-full h-2 w-2 bg-blue-600"></span>
                                    </span>
                                    Sistem Terintegrasi v1.0
                                </span>
                            </div>

                            <h1 class="animate-fade-in-up delay-100" style="opacity:0;">
                                <span class="block text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-gray-900 leading-[1.1]">
                                    Kelola SDM
                                </span>
                                <span class="block text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-[1.1] mt-2">
                                    Perusahaan <span class="gradient-text">Lebih Cerdas</span>
                                </span>
                            </h1>

                            <p class="text-lg text-gray-600 leading-relaxed max-w-lg animate-fade-in-up delay-200" style="opacity:0;">
                                Platform lengkap untuk manajemen pegawai, absensi, penggajian, dan cuti.
                                Tingkatkan produktivitas tim dengan otomatisasi proses HR yang modern.
                            </p>

                            <div class="flex flex-col sm:flex-row gap-4 animate-fade-in-up delay-300" style="opacity:0;">
                                <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 shadow-xl shadow-blue-600/25 hover:shadow-blue-600/40 transform hover:-translate-y-1">
                                    Mulai Sekarang
                                    <i class="fas fa-arrow-right ml-3 text-sm"></i>
                                </a>
                                <a href="#features" class="inline-flex justify-center items-center px-8 py-4 text-base font-bold text-gray-700 bg-white border-2 border-gray-200 rounded-2xl hover:bg-gray-50 transition-all duration-300 hover:border-blue-300 hover:text-blue-600">
                                    <i class="fas fa-play-circle mr-2 text-blue-500"></i>
                                    Pelajari Fitur
                                </a>
                            </div>

                            <div class="pt-4 flex flex-wrap items-center gap-6 text-gray-500 text-sm animate-fade-in-up delay-400" style="opacity:0;">
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-check text-green-600 text-xs"></i>
                                    </div>
                                    <span class="font-medium">Data Aman</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-check text-green-600 text-xs"></i>
                                    </div>
                                    <span class="font-medium">Real-time</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-5 h-5 rounded-full bg-green-100 flex items-center justify-center">
                                        <i class="fas fa-check text-green-600 text-xs"></i>
                                    </div>
                                    <span class="font-medium">Export Report</span>
                                </div>
                            </div>
                        </div>

                        <!-- Right: Dashboard Preview Card -->
                        <div class="relative animate-fade-in-right delay-200 hidden lg:block" style="opacity:0;">
                            <div class="animate-float">
                                <div class="relative glass rounded-3xl shadow-2xl p-8 border border-white/40">
                                    <!-- Window chrome -->
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="flex items-center gap-2">
                                            <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                            <div class="w-3 h-3 rounded-full bg-yellow-400"></div>
                                            <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                        </div>
                                        <div class="text-xs text-gray-400 font-medium px-3 py-1 bg-gray-50 rounded-full">Dashboard Preview</div>
                                    </div>

                                    <!-- Stats grid -->
                                    <div class="grid grid-cols-2 gap-4 mb-6">
                                        <div class="bg-gradient-to-br from-blue-50 to-blue-100/50 p-5 rounded-2xl border border-blue-100/50">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="w-10 h-10 bg-blue-500 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-users text-white text-sm"></i>
                                                </div>
                                                <span class="text-xs text-green-600 font-bold bg-green-50 px-2 py-0.5 rounded-full">
                                                    <i class="fas fa-arrow-up mr-0.5"></i> Live
                                                </span>
                                            </div>
                                            <div class="text-blue-700 text-3xl font-extrabold">{{ $totalPegawai }}</div>
                                            <div class="text-sm text-gray-500 font-medium mt-1">Total Pegawai</div>
                                        </div>
                                        <div class="bg-gradient-to-br from-emerald-50 to-emerald-100/50 p-5 rounded-2xl border border-emerald-100/50">
                                            <div class="flex items-center justify-between mb-2">
                                                <div class="w-10 h-10 bg-emerald-500 rounded-xl flex items-center justify-center">
                                                    <i class="fas fa-briefcase text-white text-sm"></i>
                                                </div>
                                                <span class="text-xs text-emerald-600 font-bold bg-emerald-50 px-2 py-0.5 rounded-full">Active</span>
                                            </div>
                                            <div class="text-emerald-700 text-3xl font-extrabold">{{ $totalJabatan }}</div>
                                            <div class="text-sm text-gray-500 font-medium mt-1">Posisi Jabatan</div>
                                        </div>
                                    </div>

                                    <!-- Mini chart bars -->
                                    <div class="space-y-3 mb-6">
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-gray-400 w-12">Hadir</span>
                                            <div class="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-blue-500 to-blue-400 rounded-full" style="width: 85%"></div>
                                            </div>
                                            <span class="text-xs font-bold text-gray-600">85%</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-gray-400 w-12">Izin</span>
                                            <div class="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-amber-500 to-amber-400 rounded-full" style="width: 10%"></div>
                                            </div>
                                            <span class="text-xs font-bold text-gray-600">10%</span>
                                        </div>
                                        <div class="flex items-center gap-3">
                                            <span class="text-xs text-gray-400 w-12">Sakit</span>
                                            <div class="flex-1 h-2.5 bg-gray-100 rounded-full overflow-hidden">
                                                <div class="h-full bg-gradient-to-r from-rose-500 to-rose-400 rounded-full" style="width: 5%"></div>
                                            </div>
                                            <span class="text-xs font-bold text-gray-600">5%</span>
                                        </div>
                                    </div>

                                    <!-- Avatars footer -->
                                    <div class="flex justify-between items-center pt-4 border-t border-gray-100">
                                        <div class="flex -space-x-3">
                                            @foreach($recentPegawai->take(4) as $pegawai)
                                                <img class="w-10 h-10 rounded-full border-2 border-white ring-2 ring-blue-50" 
                                                    src="https://ui-avatars.com/api/?name={{ urlencode($pegawai->nama_pegawai) }}&background=random&bold=true" 
                                                    alt="{{ $pegawai->nama_pegawai }}">
                                            @endforeach
                                            <div class="w-10 h-10 rounded-full border-2 border-white ring-2 ring-blue-50 bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-xs font-bold text-white">
                                                +{{ $totalPegawai > 4 ? $totalPegawai - 4 : 0 }}
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-blue-600 font-bold text-sm">
                                            <span class="relative flex h-2.5 w-2.5">
                                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-blue-400 opacity-75"></span>
                                                <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-blue-500"></span>
                                            </span>
                                            Live Update
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ====== STATS COUNTER ====== -->
            <section class="relative py-16 bg-white border-y border-gray-100">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="grid grid-cols-2 lg:grid-cols-4 gap-8">
                        <div class="text-center animate-count-up" style="opacity:0;">
                            <div class="text-4xl lg:text-5xl font-extrabold text-blue-600 mb-2">{{ $totalPegawai }}+</div>
                            <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Pegawai</div>
                        </div>
                        <div class="text-center animate-count-up delay-100" style="opacity:0;">
                            <div class="text-4xl lg:text-5xl font-extrabold text-indigo-600 mb-2">{{ $totalJabatan }}</div>
                            <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Posisi Jabatan</div>
                        </div>
                        <div class="text-center animate-count-up delay-200" style="opacity:0;">
                            <div class="text-4xl lg:text-5xl font-extrabold text-emerald-600 mb-2">6</div>
                            <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Modul Aktif</div>
                        </div>
                        <div class="text-center animate-count-up delay-300" style="opacity:0;">
                            <div class="text-4xl lg:text-5xl font-extrabold text-amber-600 mb-2">24/7</div>
                            <div class="text-sm font-medium text-gray-500 uppercase tracking-wider">Akses Online</div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ====== FEATURES SECTION ====== -->
            <section id="features" class="py-24 bg-gradient-to-b from-gray-50 to-white">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider mb-4">Fitur Unggulan</span>
                        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl lg:text-5xl">
                            Semua Kebutuhan HR <br class="hidden sm:block">dalam <span class="gradient-text">Satu Aplikasi</span>
                        </h2>
                        <p class="mt-4 max-w-2xl text-lg text-gray-500 mx-auto">Dirancang untuk memudahkan administrasi perusahaan Anda dengan teknologi modern.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100 group">
                            <div class="feature-icon w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-blue-500/20">
                                <i class="fas fa-users text-xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Database Pegawai</h4>
                            <p class="text-gray-500 leading-relaxed">Penyimpanan data pegawai terpusat dengan profil detail, riwayat jabatan, dan dokumen penting.</p>
                        </div>
                        
                        <!-- Feature 2 -->
                        <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100 group">
                            <div class="feature-icon w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-emerald-500/20">
                                <i class="fas fa-clock text-xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Absensi Online</h4>
                            <p class="text-gray-500 leading-relaxed">Sistem pencatatan kehadiran real-time dengan clock-in/out yang mudah dan akurat.</p>
                        </div>
                        
                        <!-- Feature 3 -->
                        <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100 group">
                            <div class="feature-icon w-14 h-14 bg-gradient-to-br from-violet-500 to-violet-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-violet-500/20">
                                <i class="fas fa-money-bill-wave text-xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Payroll System</h4>
                            <p class="text-gray-500 leading-relaxed">Otomatisasi perhitungan gaji, tunjangan, dan potongan dengan slip gaji digital.</p>
                        </div>

                        <!-- Feature 4 -->
                        <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100 group">
                            <div class="feature-icon w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-amber-500/20">
                                <i class="fas fa-plane-departure text-xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Manajemen Cuti</h4>
                            <p class="text-gray-500 leading-relaxed">Pengajuan dan persetujuan cuti yang efisien dengan tracking sisa kuota cuti.</p>
                        </div>
                        
                        <!-- Feature 5 -->
                        <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100 group">
                            <div class="feature-icon w-14 h-14 bg-gradient-to-br from-rose-500 to-pink-500 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-rose-500/20">
                                <i class="fas fa-chart-line text-xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Laporan & Analitik</h4>
                            <p class="text-gray-500 leading-relaxed">Visualisasi data kinerja perusahaan dan absensi dalam bentuk grafik interaktif.</p>
                        </div>

                        <!-- Feature 6 -->
                        <div class="feature-card bg-white rounded-2xl p-8 border border-gray-100 group">
                            <div class="feature-icon w-14 h-14 bg-gradient-to-br from-teal-500 to-cyan-500 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-teal-500/20">
                                <i class="fas fa-file-pdf text-xl"></i>
                            </div>
                            <h4 class="text-xl font-bold text-gray-900 mb-3">Export Data</h4>
                            <p class="text-gray-500 leading-relaxed">Kemudahan export data laporan ke format PDF dan Excel untuk keperluan administrasi.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ====== AGENDA SECTION ====== -->
            <section id="agenda" class="py-24 bg-white">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-4">Kalender Perusahaan</span>
                        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Agenda & Hari Libur</h2>
                        <p class="mt-4 text-lg text-gray-500">Informasi agenda dan hari libur perusahaan yang akan datang.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($upcomingEvents ?? [] as $event)
                        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-14 h-14 rounded-2xl flex items-center justify-center
                                    @if($event->category == 'holiday') bg-gradient-to-br from-red-500 to-rose-500 text-white
                                    @elseif($event->category == 'cuti_bersama') bg-gradient-to-br from-orange-500 to-amber-500 text-white
                                    @else bg-gradient-to-br from-blue-500 to-indigo-500 text-white @endif shadow-lg">
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
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full
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
                                <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                                    <span class="inline-flex items-center text-xs font-bold text-red-500 bg-red-50 px-3 py-1 rounded-full">
                                        <i class="fas fa-ban mr-1.5"></i> Libur (Office Closed)
                                    </span>
                                </div>
                            @endif
                        </div>
                        @empty
                        <div class="col-span-full text-center py-16 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                            <i class="far fa-calendar-times text-5xl text-gray-300 mb-4 block"></i>
                            <p class="text-gray-500 font-medium">Belum ada agenda perusahaan dalam waktu dekat.</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- ====== TEAM SECTION ====== -->
            <section id="team" class="py-24 bg-gradient-to-b from-gray-50 to-white">
                <div class="max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold uppercase tracking-wider mb-4">Our Team</span>
                        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Tim Terbaru Bergabung</h2>
                        <p class="mt-4 text-lg text-gray-500">Menyambut talenta-talenta baru di perusahaan.</p>
                    </div>
                    
                    <div class="flex flex-wrap justify-center gap-8">
                        @forelse ($recentPegawai as $pegawai)
                            <div class="flex flex-col items-center bg-white p-6 rounded-2xl shadow-sm border border-gray-100 w-52 hover:-translate-y-3 transition-all duration-300 hover:shadow-xl group">
                                <div class="relative">
                                    <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-br from-blue-500 to-indigo-500 group-hover:from-blue-600 group-hover:to-indigo-600 transition-all duration-300">
                                        <img class="w-full h-full rounded-full object-cover border-2 border-white"
                                            src="{{ $pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png' ? asset('storage/' . $pegawai->image) : 'https://ui-avatars.com/api/?name='.urlencode($pegawai->nama_pegawai).'&color=7F9CF5&background=EBF4FF&bold=true' }}"
                                            alt="{{ $pegawai->nama_pegawai }}">
                                    </div>
                                    <span class="absolute bottom-1 right-1 w-5 h-5 bg-green-500 border-2 border-white rounded-full shadow-sm"></span>
                                </div>
                                <h3 class="mt-4 text-sm font-bold text-gray-900 text-center">{{ Str::limit($pegawai->nama_pegawai, 18) }}</h3>
                                <p class="text-xs text-blue-600 mt-2 text-center font-semibold px-3 py-1 bg-blue-50 rounded-full">
                                    {{ $pegawai->jabatans->nama_jabatan ?? 'Pegawai' }}
                                </p>
                            </div>
                        @empty
                            <div class="p-12 text-center text-gray-500 bg-gray-50 rounded-2xl w-full border-2 border-dashed border-gray-200">
                                <i class="fas fa-user-slash text-5xl mb-4 text-gray-300"></i>
                                <p class="font-medium">Belum ada data pegawai baru.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </section>

            <!-- ====== CTA SECTION ====== -->
            <section class="py-24 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-700"></div>
                <div class="relative max-w-4xl mx-auto text-center px-6">
                    <span class="inline-block px-4 py-1.5 rounded-full bg-white/20 text-white text-xs font-bold uppercase tracking-wider mb-6">Get Started</span>
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl lg:text-5xl mb-6">Siap Mengoptimalkan<br>Manajemen SDM?</h2>
                    <p class="text-blue-100 text-lg mb-10 max-w-2xl mx-auto">Bergabunglah sekarang dan rasakan kemudahan pengelolaan administrasi kepegawaian yang lebih efisien.</p>
                    <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-10 py-4 text-base font-bold text-blue-600 bg-white rounded-2xl hover:bg-gray-50 transition-all duration-300 shadow-2xl hover:shadow-white/30 transform hover:-translate-y-1">
                        <i class="fas fa-rocket mr-2"></i> Akses Dashboard
                    </a>
                </div>
            </section>
        </main>

        <!-- ====== FOOTER ====== -->
        <footer class="bg-gray-900 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-6 py-16 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                    <!-- Brand -->
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-500 rounded-xl flex items-center justify-center">
                                <i class="fas fa-users-cog text-white text-sm"></i>
                            </div>
                            <span class="text-white text-xl font-extrabold">{{ \App\Models\Setting::value('app_name', config('app.name')) }}</span>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Aplikasi manajemen sumber daya manusia berbasis web yang modern, aman, dan mudah digunakan.
                        </p>
                        @if(\App\Models\Setting::value('company_address'))
                        <div class="flex items-start gap-2 text-sm text-gray-400">
                            <i class="fas fa-map-marker-alt text-gray-500 mt-1"></i>
                            <span>{{ \App\Models\Setting::value('company_address') }}</span>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Quick Links -->
                    <div>
                        <h3 class="text-white font-bold mb-5">Akses Cepat</h3>
                        <ul class="space-y-3 text-sm text-gray-400">
                            <li><a href="{{ route('home') }}" class="hover:text-blue-400 transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-gray-600"></i> Beranda</a></li>
                            <li><a href="#features" class="hover:text-blue-400 transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-gray-600"></i> Fitur</a></li>
                            <li><a href="#agenda" class="hover:text-blue-400 transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-gray-600"></i> Agenda</a></li>
                            <li><a href="{{ route('login') }}" class="hover:text-blue-400 transition flex items-center gap-2"><i class="fas fa-chevron-right text-xs text-gray-600"></i> Login</a></li>
                        </ul>
                    </div>

                    <!-- Contact -->
                    <div>
                        <h3 class="text-white font-bold mb-5">Hubungi Kami</h3>
                        <ul class="space-y-3 text-sm text-gray-400">
                            <li class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-envelope text-gray-500 text-xs"></i>
                                </div>
                                admin@company.com
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-8 h-8 bg-gray-800 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-phone text-gray-500 text-xs"></i>
                                </div>
                                +62 21 1234 5678
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="mt-12 pt-8 border-t border-gray-800 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-gray-500 text-sm">
                        &copy; {{ date('Y') }} {{ \App\Models\Setting::value('company_name', 'Company Name') }}. All rights reserved.
                    </div>
                    <div class="text-gray-600 text-xs">
                        Powered by <span class="text-gray-400 font-medium">Laravel</span> & <span class="text-gray-400 font-medium">CoreUI</span>
                    </div>
                </div>
            </div>
        </footer>

        <!-- Scroll to Top Button -->
        <button x-show="scrollTop" x-cloak
                @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0"
                x-transition:leave-end="opacity-0 translate-y-4"
                class="scroll-top-btn fixed bottom-8 right-8 z-50 w-12 h-12 bg-gradient-to-br from-blue-600 to-indigo-600 text-white rounded-2xl shadow-lg shadow-blue-600/30 flex items-center justify-center"
                style="display: none;">
            <i class="fas fa-arrow-up"></i>
        </button>
    </div>

    <!-- Intersection Observer for animations -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1, rootMargin: '0px 0px -50px 0px' });

            document.querySelectorAll('[style*="opacity:0"], [style*="opacity: 0"]').forEach(el => {
                observer.observe(el);
            });
        });
    </script>
</body>

</html>
