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
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/collapse@3.x.x/dist/cdn.min.js"></script>

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
        .delay-600 { animation-delay: 0.6s; }
        .delay-700 { animation-delay: 0.7s; }
        .delay-800 { animation-delay: 0.8s; }

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

        /* Folder Card Effect */
        .feature-card {
            position: relative;
            margin-top: 25px;
            border-radius: 0 20px 20px 20px;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1;
        }
        .feature-card::after {
            content: '';
            position: absolute;
            top: -18px;
            left: 0;
            width: 120px;
            height: 25px;
            background-color: inherit;
            border-radius: 16px 16px 0 0;
            z-index: -1;
            box-shadow: inherit;
        }
        /* Gradient borders for folder tabs via pseudo elements is tricky, 
           so we use a simpler approach: specific background matching */
        
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

        /* Specific Folder Colors to match gradients */
        .folder-blue::after { background: linear-gradient(to right, #eff6ff, white); }
        .folder-emerald::after { background: linear-gradient(to right, #ecfdf5, white); }
        .folder-violet::after { background: linear-gradient(to right, #f5f3ff, white); }
        .folder-amber::after { background: linear-gradient(to right, #fffbeb, white); }
        .folder-rose::after { background: linear-gradient(to right, #fff1f2, white); }
        .folder-teal::after { background: linear-gradient(to right, #f0fdfa, white); }

        /* Darken the tab slightly for depth */
        .feature-card::before {
            content: '';
            position: absolute;
            top: -18px;
            left: 0;
            width: 120px;
            height: 25px;
            background: rgba(0,0,0,0.03); /* Slight shadow for depth */
            border-radius: 16px 16px 0 0;
            z-index: 0;
        }

        /* Scroll to top */
        .scroll-top-btn {
            transition: all 0.3s ease;
            animation: bounce-gentle 2s ease-in-out infinite;
        }
        .scroll-top-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.4);
            animation: none;
        }
        @keyframes bounce-gentle {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }

        /* Navbar shrink on scroll */
        .nav-shrink { padding-top: 0.25rem; padding-bottom: 0.25rem; }
        .nav-shrink .nav-inner { height: 3.5rem; }

        /* Blob / Cloud shapes */
        .blob {
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        }
        .blob-2 {
            border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
        }
        .blob-3 {
            border-radius: 40% 60% 60% 40% / 70% 30% 60% 40%;
        }
    </style>
</head>

<body class="text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col" x-data="{ scrollTop: false, navShrink: false }" @scroll.window="scrollTop = (window.scrollY > 400); navShrink = (window.scrollY > 80)">
        <!-- Navigation -->
        <nav class="bg-white/80 backdrop-blur-xl fixed w-full z-50 shadow-sm border-b border-gray-100/50 transition-all duration-300" :class="{ 'nav-shrink shadow-md': navShrink }">
            <div x-data="{ mobileMenuOpen: false }" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="nav-inner flex justify-between items-center h-20 transition-all duration-300">
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
                        <a href="#faq" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition">FAQ</a>
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
                        <a href="#faq" @click="mobileMenuOpen = false" class="px-4 py-2.5 text-sm font-medium text-gray-600 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition">FAQ</a>
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
                <!-- Blob / Cloud Decorations -->
                <div class="absolute top-10 -right-20 w-[500px] h-[500px] bg-blue-100/40 blob blur-3xl"></div>
                <div class="absolute -bottom-20 -left-20 w-[400px] h-[400px] bg-indigo-100/30 blob-2 blur-3xl"></div>
                <div class="absolute top-1/3 left-1/3 w-[300px] h-[300px] bg-purple-50/30 blob-3 blur-3xl"></div>

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

            <!-- ====== HOW IT WORKS ====== -->
            <section class="py-24 bg-white relative overflow-hidden">
                <div class="absolute top-0 right-0 w-[300px] h-[300px] bg-blue-50/40 blob-3 blur-3xl"></div>
                <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-violet-100 text-violet-700 text-xs font-bold uppercase tracking-wider mb-4">Cara Kerja</span>
                        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl lg:text-5xl">
                            Mulai dalam <span class="gradient-text">3 Langkah</span> Mudah
                        </h2>
                        <p class="mt-4 max-w-2xl text-lg text-gray-500 mx-auto">Proses sederhana untuk memulai pengelolaan SDM yang lebih efisien.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative">
                        <!-- Connecting line (desktop) -->
                        <div class="hidden md:block absolute top-16 left-[20%] right-[20%] h-0.5 bg-gradient-to-r from-blue-200 via-violet-200 to-emerald-200"></div>

                        <!-- Step 1 -->
                        <div class="relative text-center animate-fade-in-up" style="opacity:0;">
                            <div class="relative mx-auto w-32 h-32 mb-8">
                                <div class="absolute inset-0 bg-blue-100/50 rounded-full blur-xl"></div>
                                <div class="relative w-32 h-32 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center shadow-xl shadow-blue-500/20">
                                    <i class="fas fa-user-plus text-white text-3xl"></i>
                                </div>
                                <div class="absolute -top-2 -right-2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center">
                                    <span class="text-blue-600 font-extrabold text-lg">1</span>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Daftar Akun</h3>
                            <p class="text-gray-500 leading-relaxed max-w-xs mx-auto">Buat akun admin Anda dan siapkan profil perusahaan dengan mudah.</p>
                        </div>

                        <!-- Step 2 -->
                        <div class="relative text-center animate-fade-in-up delay-200" style="opacity:0;">
                            <div class="relative mx-auto w-32 h-32 mb-8">
                                <div class="absolute inset-0 bg-violet-100/50 rounded-full blur-xl"></div>
                                <div class="relative w-32 h-32 bg-gradient-to-br from-violet-500 to-violet-600 rounded-full flex items-center justify-center shadow-xl shadow-violet-500/20">
                                    <i class="fas fa-cogs text-white text-3xl"></i>
                                </div>
                                <div class="absolute -top-2 -right-2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center">
                                    <span class="text-violet-600 font-extrabold text-lg">2</span>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Konfigurasi</h3>
                            <p class="text-gray-500 leading-relaxed max-w-xs mx-auto">Atur jabatan, departemen, jadwal kerja, dan kebijakan cuti sesuai kebutuhan.</p>
                        </div>

                        <!-- Step 3 -->
                        <div class="relative text-center animate-fade-in-up delay-400" style="opacity:0;">
                            <div class="relative mx-auto w-32 h-32 mb-8">
                                <div class="absolute inset-0 bg-emerald-100/50 rounded-full blur-xl"></div>
                                <div class="relative w-32 h-32 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-full flex items-center justify-center shadow-xl shadow-emerald-500/20">
                                    <i class="fas fa-chart-pie text-white text-3xl"></i>
                                </div>
                                <div class="absolute -top-2 -right-2 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center">
                                    <span class="text-emerald-600 font-extrabold text-lg">3</span>
                                </div>
                            </div>
                            <h3 class="text-xl font-bold text-gray-900 mb-3">Kelola SDM</h3>
                            <p class="text-gray-500 leading-relaxed max-w-xs mx-auto">Mulai kelola pegawai, absensi, gaji, dan laporan dari satu dashboard.</p>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ====== FEATURES SECTION ====== -->
            <section id="features" class="py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
                <!-- Blob / Cloud Decorations -->
                <div class="absolute -top-20 -right-32 w-[400px] h-[400px] bg-blue-50/50 blob-2 blur-3xl"></div>
                <div class="absolute bottom-0 -left-20 w-[350px] h-[350px] bg-indigo-50/40 blob blur-3xl"></div>
                <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase tracking-wider mb-4">Fitur Unggulan</span>
                        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl lg:text-5xl">
                            Semua Kebutuhan HR <br class="hidden sm:block">dalam <span class="gradient-text">Satu Aplikasi</span>
                        </h2>
                        <p class="mt-4 max-w-2xl text-lg text-gray-500 mx-auto">Dirancang untuk memudahkan administrasi perusahaan Anda dengan teknologi modern.</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        <!-- Feature 1 -->
                        <div class="feature-card folder-blue relative bg-gradient-to-br from-white to-blue-50/40 rounded-2xl p-8 border border-blue-100/60 group overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-100/40 rounded-full blur-2xl group-hover:bg-blue-100/60 transition-all duration-500"></div>
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-2xl"></div>
                            <div class="relative">
                                <div class="feature-icon w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-blue-500/20">
                                    <i class="fas fa-users text-xl"></i>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 mb-3">Database Pegawai</h4>
                                <p class="text-gray-500 leading-relaxed">Penyimpanan data pegawai terpusat dengan profil detail, riwayat jabatan, dan dokumen penting.</p>
                            </div>
                        </div>
                        
                        <!-- Feature 2 -->
                        <div class="feature-card folder-emerald relative bg-gradient-to-br from-white to-emerald-50/40 rounded-2xl p-8 border border-emerald-100/60 group overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-emerald-100/40 rounded-full blur-2xl group-hover:bg-emerald-100/60 transition-all duration-500"></div>
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-t-2xl"></div>
                            <div class="relative">
                                <div class="feature-icon w-14 h-14 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-emerald-500/20">
                                    <i class="fas fa-clock text-xl"></i>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 mb-3">Absensi Online</h4>
                                <p class="text-gray-500 leading-relaxed">Sistem pencatatan kehadiran real-time dengan clock-in/out yang mudah dan akurat.</p>
                            </div>
                        </div>
                        
                        <!-- Feature 3 -->
                        <div class="feature-card folder-violet relative bg-gradient-to-br from-white to-violet-50/40 rounded-2xl p-8 border border-violet-100/60 group overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-violet-100/40 rounded-full blur-2xl group-hover:bg-violet-100/60 transition-all duration-500"></div>
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-violet-500 to-violet-600 rounded-t-2xl"></div>
                            <div class="relative">
                                <div class="feature-icon w-14 h-14 bg-gradient-to-br from-violet-500 to-violet-600 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-violet-500/20">
                                    <i class="fas fa-money-bill-wave text-xl"></i>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 mb-3">Payroll System</h4>
                                <p class="text-gray-500 leading-relaxed">Otomatisasi perhitungan gaji, tunjangan, dan potongan dengan slip gaji digital.</p>
                            </div>
                        </div>

                        <!-- Feature 4 -->
                        <div class="feature-card folder-amber relative bg-gradient-to-br from-white to-amber-50/40 rounded-2xl p-8 border border-amber-100/60 group overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-amber-100/40 rounded-full blur-2xl group-hover:bg-amber-100/60 transition-all duration-500"></div>
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-amber-500 to-orange-500 rounded-t-2xl"></div>
                            <div class="relative">
                                <div class="feature-icon w-14 h-14 bg-gradient-to-br from-amber-500 to-orange-500 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-amber-500/20">
                                    <i class="fas fa-plane-departure text-xl"></i>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 mb-3">Manajemen Cuti</h4>
                                <p class="text-gray-500 leading-relaxed">Pengajuan dan persetujuan cuti yang efisien dengan tracking sisa kuota cuti.</p>
                            </div>
                        </div>
                        
                        <!-- Feature 5 -->
                        <div class="feature-card folder-rose relative bg-gradient-to-br from-white to-rose-50/40 rounded-2xl p-8 border border-rose-100/60 group overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-rose-100/40 rounded-full blur-2xl group-hover:bg-rose-100/60 transition-all duration-500"></div>
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-rose-500 to-pink-500 rounded-t-2xl"></div>
                            <div class="relative">
                                <div class="feature-icon w-14 h-14 bg-gradient-to-br from-rose-500 to-pink-500 rounded-2xl flex items-center justify-center text-white mb-6 shadow-lg shadow-rose-500/20">
                                    <i class="fas fa-chart-line text-xl"></i>
                                </div>
                                <h4 class="text-xl font-bold text-gray-900 mb-3">Laporan & Analitik</h4>
                                <p class="text-gray-500 leading-relaxed">Visualisasi data kinerja perusahaan dan absensi dalam bentuk grafik interaktif.</p>
                            </div>
                        </div>

                        <!-- Feature 6 -->
                        <div class="feature-card folder-teal relative bg-gradient-to-br from-white to-teal-50/40 rounded-2xl p-8 border border-teal-100/60 group overflow-hidden">
                            <div class="absolute -top-10 -right-10 w-32 h-32 bg-teal-100/40 rounded-full blur-2xl group-hover:bg-teal-100/60 transition-all duration-500"></div>
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-teal-500 to-cyan-500 rounded-t-2xl"></div>
                            <div class="relative">
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
            <section id="agenda" class="py-24 bg-white relative overflow-hidden">
                <div class="absolute -bottom-20 -right-20 w-[350px] h-[350px] bg-indigo-50/40 blob blur-3xl"></div>
                <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-indigo-100 text-indigo-700 text-xs font-bold uppercase tracking-wider mb-4">Kalender Perusahaan</span>
                        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Agenda & Hari Libur</h2>
                        <p class="mt-4 text-lg text-gray-500">Informasi agenda dan hari libur perusahaan yang akan datang.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @forelse($upcomingEvents ?? [] as $event)
                        <div class="relative rounded-2xl p-6 border group overflow-hidden hover:shadow-xl transition-all duration-300 hover:-translate-y-1
                            @if($event->category == 'holiday') bg-gradient-to-br from-white to-red-50/40 border-red-100/60
                            @elseif($event->category == 'cuti_bersama') bg-gradient-to-br from-white to-orange-50/40 border-orange-100/60
                            @else bg-gradient-to-br from-white to-blue-50/40 border-blue-100/60 @endif">
                            <div class="absolute -top-10 -right-10 w-28 h-28 rounded-full blur-2xl transition-all duration-500
                                @if($event->category == 'holiday') bg-red-100/40 group-hover:bg-red-100/60
                                @elseif($event->category == 'cuti_bersama') bg-orange-100/40 group-hover:bg-orange-100/60
                                @else bg-blue-100/40 group-hover:bg-blue-100/60 @endif"></div>
                            <div class="absolute top-0 left-0 w-full h-1 rounded-t-2xl
                                @if($event->category == 'holiday') bg-gradient-to-r from-red-500 to-rose-500
                                @elseif($event->category == 'cuti_bersama') bg-gradient-to-r from-orange-500 to-amber-500
                                @else bg-gradient-to-r from-blue-500 to-indigo-500 @endif"></div>
                            <div class="relative">
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

            <!-- ====== TESTIMONIAL SECTION ====== -->
            <section class="py-24 bg-white relative overflow-hidden">
                <div class="absolute top-0 -left-20 w-[350px] h-[350px] bg-amber-50/40 blob-2 blur-3xl"></div>
                <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
                    <div class="text-center mb-16">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-amber-100 text-amber-700 text-xs font-bold uppercase tracking-wider mb-4">Testimoni</span>
                        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl lg:text-5xl">
                            Apa Kata <span class="gradient-text">Pengguna</span> Kami
                        </h2>
                        <p class="mt-4 max-w-2xl text-lg text-gray-500 mx-auto">Feedback dari tim yang sudah menggunakan platform ini.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                        <!-- Testimonial 1 -->
                        <div class="relative bg-gradient-to-br from-white to-blue-50/40 rounded-2xl p-8 border border-blue-100/60 overflow-hidden group hover:-translate-y-2 transition-all duration-300 hover:shadow-xl">
                            <div class="absolute -top-10 -right-10 w-28 h-28 bg-blue-100/40 rounded-full blur-2xl"></div>
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-blue-500 to-blue-600 rounded-t-2xl"></div>
                            <div class="relative">
                                <div class="flex items-center gap-1 mb-4">
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                </div>
                                <p class="text-gray-600 leading-relaxed mb-6 italic">"Proses penggajian yang dulunya butuh 3 hari, sekarang selesai hanya dalam hitungan menit. Sangat membantu pekerjaan kami."</p>
                                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 flex items-center justify-center text-white font-bold text-sm">HR</div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">Admin HR</div>
                                        <div class="text-xs text-gray-500">Human Resources</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 2 -->
                        <div class="relative bg-gradient-to-br from-white to-emerald-50/40 rounded-2xl p-8 border border-emerald-100/60 overflow-hidden group hover:-translate-y-2 transition-all duration-300 hover:shadow-xl">
                            <div class="absolute -top-10 -right-10 w-28 h-28 bg-emerald-100/40 rounded-full blur-2xl"></div>
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-t-2xl"></div>
                            <div class="relative">
                                <div class="flex items-center gap-1 mb-4">
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                </div>
                                <p class="text-gray-600 leading-relaxed mb-6 italic">"Dashboard yang informatif memudahkan monitoring kehadiran tim secara real-time. Laporan bisa langsung di-export kapan saja."</p>
                                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-emerald-500 to-teal-500 flex items-center justify-center text-white font-bold text-sm">MG</div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">Manajer</div>
                                        <div class="text-xs text-gray-500">Management</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 3 -->
                        <div class="relative bg-gradient-to-br from-white to-violet-50/40 rounded-2xl p-8 border border-violet-100/60 overflow-hidden group hover:-translate-y-2 transition-all duration-300 hover:shadow-xl">
                            <div class="absolute -top-10 -right-10 w-28 h-28 bg-violet-100/40 rounded-full blur-2xl"></div>
                            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-violet-500 to-violet-600 rounded-t-2xl"></div>
                            <div class="relative">
                                <div class="flex items-center gap-1 mb-4">
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    <i class="fas fa-star text-amber-400 text-sm"></i>
                                    <i class="fas fa-star-half-alt text-amber-400 text-sm"></i>
                                </div>
                                <p class="text-gray-600 leading-relaxed mb-6 italic">"Pengajuan cuti jadi sangat mudah, tidak perlu isi form manual lagi. Bisa pantau sisa kuota cuti kapan pun."</p>
                                <div class="flex items-center gap-3 pt-4 border-t border-gray-100">
                                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-violet-500 to-purple-500 flex items-center justify-center text-white font-bold text-sm">PG</div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">Pegawai</div>
                                        <div class="text-xs text-gray-500">Staff</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ====== FAQ SECTION ====== -->
            <section id="faq" class="py-24 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden">
                <div class="absolute -top-20 -left-20 w-[350px] h-[350px] bg-blue-50/40 blob blur-3xl"></div>
                <div class="relative max-w-3xl mx-auto px-6 lg:px-8" x-data="{ openFaq: null }">
                    <div class="text-center mb-16">
                        <span class="inline-block px-4 py-1.5 rounded-full bg-sky-100 text-sky-700 text-xs font-bold uppercase tracking-wider mb-4">FAQ</span>
                        <h2 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl lg:text-5xl">
                            Pertanyaan <span class="gradient-text">Umum</span>
                        </h2>
                        <p class="mt-4 text-lg text-gray-500">Jawaban untuk pertanyaan yang sering ditanyakan.</p>
                    </div>

                    <div class="space-y-4">
                        <!-- FAQ 1 -->
                        <div class="relative bg-gradient-to-br from-white to-blue-50/30 rounded-2xl border border-blue-100/50 overflow-hidden transition-all duration-300" :class="{ 'shadow-lg': openFaq === 1 }">
                            <button @click="openFaq = openFaq === 1 ? null : 1" class="w-full px-6 py-5 text-left flex items-center justify-between gap-4">
                                <span class="font-bold text-gray-900">Bagaimana cara mendaftarkan akun?</span>
                                <i class="fas fa-chevron-down text-blue-500 text-sm transition-transform duration-300" :class="{ 'rotate-180': openFaq === 1 }"></i>
                            </button>
                            <div x-show="openFaq === 1" x-collapse x-cloak class="px-6 pb-5">
                                <p class="text-gray-500 leading-relaxed">Klik tombol "Register" di halaman utama, isi data yang diperlukan, dan akun Anda akan langsung aktif. Admin dapat mengatur role dan akses masing-masing pengguna.</p>
                            </div>
                        </div>

                        <!-- FAQ 2 -->
                        <div class="relative bg-gradient-to-br from-white to-emerald-50/30 rounded-2xl border border-emerald-100/50 overflow-hidden transition-all duration-300" :class="{ 'shadow-lg': openFaq === 2 }">
                            <button @click="openFaq = openFaq === 2 ? null : 2" class="w-full px-6 py-5 text-left flex items-center justify-between gap-4">
                                <span class="font-bold text-gray-900">Apakah data pegawai aman?</span>
                                <i class="fas fa-chevron-down text-emerald-500 text-sm transition-transform duration-300" :class="{ 'rotate-180': openFaq === 2 }"></i>
                            </button>
                            <div x-show="openFaq === 2" x-collapse x-cloak class="px-6 pb-5">
                                <p class="text-gray-500 leading-relaxed">Ya, sangat aman. Sistem kami menggunakan enkripsi dan autentikasi berbasis Laravel dengan role-based access control (RBAC) sehingga hanya pengguna yang berwenang yang bisa mengakses data.</p>
                            </div>
                        </div>

                        <!-- FAQ 3 -->
                        <div class="relative bg-gradient-to-br from-white to-violet-50/30 rounded-2xl border border-violet-100/50 overflow-hidden transition-all duration-300" :class="{ 'shadow-lg': openFaq === 3 }">
                            <button @click="openFaq = openFaq === 3 ? null : 3" class="w-full px-6 py-5 text-left flex items-center justify-between gap-4">
                                <span class="font-bold text-gray-900">Bagaimana cara melakukan absensi?</span>
                                <i class="fas fa-chevron-down text-violet-500 text-sm transition-transform duration-300" :class="{ 'rotate-180': openFaq === 3 }"></i>
                            </button>
                            <div x-show="openFaq === 3" x-collapse x-cloak class="px-6 pb-5">
                                <p class="text-gray-500 leading-relaxed">Pegawai cukup login ke dashboard dan klik tombol Clock In/Out. Sistem akan mencatat waktu dan tanggal secara otomatis. Admin juga bisa memonitor kehadiran secara real-time.</p>
                            </div>
                        </div>

                        <!-- FAQ 4 -->
                        <div class="relative bg-gradient-to-br from-white to-amber-50/30 rounded-2xl border border-amber-100/50 overflow-hidden transition-all duration-300" :class="{ 'shadow-lg': openFaq === 4 }">
                            <button @click="openFaq = openFaq === 4 ? null : 4" class="w-full px-6 py-5 text-left flex items-center justify-between gap-4">
                                <span class="font-bold text-gray-900">Bisa export laporan ke format apa saja?</span>
                                <i class="fas fa-chevron-down text-amber-500 text-sm transition-transform duration-300" :class="{ 'rotate-180': openFaq === 4 }"></i>
                            </button>
                            <div x-show="openFaq === 4" x-collapse x-cloak class="px-6 pb-5">
                                <p class="text-gray-500 leading-relaxed">Saat ini mendukung export ke format PDF dan Excel (XLSX). Laporan yang tersedia meliputi absensi, penggajian, data pegawai, dan rekap cuti.</p>
                            </div>
                        </div>

                        <!-- FAQ 5 -->
                        <div class="relative bg-gradient-to-br from-white to-rose-50/30 rounded-2xl border border-rose-100/50 overflow-hidden transition-all duration-300" :class="{ 'shadow-lg': openFaq === 5 }">
                            <button @click="openFaq = openFaq === 5 ? null : 5" class="w-full px-6 py-5 text-left flex items-center justify-between gap-4">
                                <span class="font-bold text-gray-900">Apakah bisa diakses dari HP?</span>
                                <i class="fas fa-chevron-down text-rose-500 text-sm transition-transform duration-300" :class="{ 'rotate-180': openFaq === 5 }"></i>
                            </button>
                            <div x-show="openFaq === 5" x-collapse x-cloak class="px-6 pb-5">
                                <p class="text-gray-500 leading-relaxed">Ya! Platform ini sepenuhnya responsive dan bisa diakses dari browser HP, tablet, maupun desktop. Tidak perlu install aplikasi tambahan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <!-- ====== CTA SECTION ====== -->
            <section class="py-28 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800"></div>
                <!-- Blob / Cloud Decorations -->
                <div class="absolute top-0 -left-20 w-[450px] h-[450px] bg-white/10 blob blur-3xl"></div>
                <div class="absolute -bottom-20 -right-20 w-[500px] h-[500px] bg-indigo-400/15 blob-2 blur-3xl"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[350px] h-[350px] bg-blue-300/10 blob-3 blur-3xl"></div>

                <div class="relative max-w-4xl mx-auto text-center px-6">
                    <div class="inline-flex items-center px-5 py-2 rounded-full bg-white/15 backdrop-blur-sm text-white text-sm font-semibold mb-8 border border-white/20">
                        <i class="fas fa-sparkles mr-2"></i> Get Started Today
                    </div>
                    <h2 class="text-3xl font-extrabold text-white sm:text-4xl lg:text-5xl mb-6 leading-tight">Siap Mengoptimalkan<br>Manajemen SDM?</h2>
                    <p class="text-blue-100/90 text-lg mb-12 max-w-2xl mx-auto leading-relaxed">Bergabunglah sekarang dan rasakan kemudahan pengelolaan administrasi kepegawaian yang lebih efisien dan modern.</p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('login') }}" class="inline-flex justify-center items-center px-10 py-4 text-base font-bold text-blue-700 bg-white rounded-2xl hover:bg-gray-50 transition-all duration-300 shadow-2xl shadow-black/10 transform hover:-translate-y-1">
                            <i class="fas fa-rocket mr-2"></i> Akses Dashboard
                        </a>
                        <a href="#features" class="inline-flex justify-center items-center px-10 py-4 text-base font-bold text-white bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl hover:bg-white/20 transition-all duration-300 transform hover:-translate-y-1">
                            <i class="fas fa-info-circle mr-2"></i> Pelajari Lebih
                        </a>
                    </div>
                </div>
            </section>
        </main>

        <!-- ====== FOOTER ====== -->
        <footer class="relative bg-gradient-to-b from-gray-900 via-gray-900 to-gray-950 overflow-hidden">
            <!-- Blob / Cloud Decorations -->
            <div class="absolute top-0 -right-32 w-[400px] h-[400px] bg-blue-600/5 blob blur-3xl"></div>
            <div class="absolute bottom-0 -left-20 w-[350px] h-[350px] bg-indigo-600/5 blob-2 blur-3xl"></div>

            <div class="relative max-w-7xl mx-auto px-6 pt-20 pb-12 lg:px-8">
                <!-- Top: Brand + Newsletter -->
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-8 mb-16 pb-12 border-b border-gray-800/60">
                    <div class="space-y-4 max-w-md">
                        <div class="flex items-center gap-3">
                            <div class="w-11 h-11 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg shadow-blue-500/20">
                                <i class="fas fa-users-cog text-white"></i>
                            </div>
                            <span class="text-white text-2xl font-extrabold tracking-tight">{{ \App\Models\Setting::value('app_name', config('app.name')) }}</span>
                        </div>
                        <p class="text-gray-400 text-sm leading-relaxed">
                            Platform manajemen sumber daya manusia berbasis web yang modern, aman, dan mudah digunakan untuk kebutuhan perusahaan Anda.
                        </p>
                    </div>
                    <!-- Social links -->
                    <div class="flex items-center gap-3">
                        <a href="#" class="w-10 h-10 bg-gray-800/80 hover:bg-blue-600 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300 hover:-translate-y-1">
                            <i class="fab fa-facebook-f text-sm"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800/80 hover:bg-sky-500 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300 hover:-translate-y-1">
                            <i class="fab fa-twitter text-sm"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800/80 hover:bg-pink-600 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300 hover:-translate-y-1">
                            <i class="fab fa-instagram text-sm"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800/80 hover:bg-blue-700 rounded-xl flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300 hover:-translate-y-1">
                            <i class="fab fa-linkedin-in text-sm"></i>
                        </a>
                    </div>
                </div>

                <!-- Middle: Links Grid -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-10 mb-16">
                    <!-- Company -->
                    <div>
                        <h3 class="text-white font-bold text-sm uppercase tracking-wider mb-5">Perusahaan</h3>
                        <ul class="space-y-3 text-sm">
                            <li><a href="{{ route('home') }}" class="text-gray-400 hover:text-blue-400 transition flex items-center gap-2 group"><i class="fas fa-chevron-right text-[10px] text-gray-600 group-hover:text-blue-400 transition"></i> Beranda</a></li>
                            <li><a href="#features" class="text-gray-400 hover:text-blue-400 transition flex items-center gap-2 group"><i class="fas fa-chevron-right text-[10px] text-gray-600 group-hover:text-blue-400 transition"></i> Fitur</a></li>
                            <li><a href="#agenda" class="text-gray-400 hover:text-blue-400 transition flex items-center gap-2 group"><i class="fas fa-chevron-right text-[10px] text-gray-600 group-hover:text-blue-400 transition"></i> Agenda</a></li>
                            <li><a href="#team" class="text-gray-400 hover:text-blue-400 transition flex items-center gap-2 group"><i class="fas fa-chevron-right text-[10px] text-gray-600 group-hover:text-blue-400 transition"></i> Tim</a></li>
                        </ul>
                    </div>

                    <!-- Akses -->
                    <div>
                        <h3 class="text-white font-bold text-sm uppercase tracking-wider mb-5">Akses</h3>
                        <ul class="space-y-3 text-sm">
                            <li><a href="{{ route('login') }}" class="text-gray-400 hover:text-blue-400 transition flex items-center gap-2 group"><i class="fas fa-chevron-right text-[10px] text-gray-600 group-hover:text-blue-400 transition"></i> Login</a></li>
                            @if(Route::has('register'))
                            <li><a href="{{ route('register') }}" class="text-gray-400 hover:text-blue-400 transition flex items-center gap-2 group"><i class="fas fa-chevron-right text-[10px] text-gray-600 group-hover:text-blue-400 transition"></i> Register</a></li>
                            @endif
                        </ul>
                    </div>

                    <!-- Contact  -->
                    <div>
                        <h3 class="text-white font-bold text-sm uppercase tracking-wider mb-5">Kontak</h3>
                        <ul class="space-y-4 text-sm">
                            <li class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-gray-800/60 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-envelope text-blue-400 text-xs"></i>
                                </div>
                                <span class="text-gray-400">{{ \App\Models\Setting::value('company_email', 'admin@company.com') }}</span>
                            </li>
                            <li class="flex items-center gap-3">
                                <div class="w-9 h-9 bg-gray-800/60 rounded-xl flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-phone text-blue-400 text-xs"></i>
                                </div>
                                <span class="text-gray-400">{{ \App\Models\Setting::value('company_phone', '+62 21 1234 5678') }}</span>
                            </li>
                            @if(\App\Models\Setting::value('company_address'))
                            <li class="flex items-start gap-3">
                                <div class="w-9 h-9 bg-gray-800/60 rounded-xl flex items-center justify-center flex-shrink-0 mt-0.5">
                                    <i class="fas fa-map-marker-alt text-blue-400 text-xs"></i>
                                </div>
                                <span class="text-gray-400">{{ \App\Models\Setting::value('company_address') }}</span>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <!-- Jam Operasional -->
                    <div>
                        <h3 class="text-white font-bold text-sm uppercase tracking-wider mb-5">Jam Operasional</h3>
                        <ul class="space-y-3 text-sm text-gray-400">
                            <li class="flex items-center gap-2">
                                <i class="far fa-clock text-blue-400 text-xs"></i>
                                <span>Senin - Jumat: {{ \App\Models\Setting::value('work_start_time', '08:00') }} - {{ \App\Models\Setting::value('work_end_time', '17:00') }}</span>
                            </li>
                            <li class="flex items-center gap-2">
                                <i class="far fa-clock text-gray-600 text-xs"></i>
                                <span class="text-gray-500">Sabtu - Minggu: Libur</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Bar -->
                <div class="pt-8 border-t border-gray-800/60 flex flex-col sm:flex-row justify-between items-center gap-4">
                    <div class="text-gray-500 text-sm">
                        &copy; {{ date('Y') }} {{ \App\Models\Setting::value('company_name', 'Company Name') }}. All rights reserved.
                    </div>
                    <div class="flex items-center gap-4 text-gray-600 text-xs">
                        <span>Powered by</span>
                        <div class="flex items-center gap-2">
                            <span class="px-2.5 py-1 bg-gray-800/60 rounded-md text-gray-400 font-medium">Laravel</span>
                            <span class="px-2.5 py-1 bg-gray-800/60 rounded-md text-gray-400 font-medium">Tailwind</span>
                            <span class="px-2.5 py-1 bg-gray-800/60 rounded-md text-gray-400 font-medium">CoreUI</span>
                        </div>
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
