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

<body class="font-sans antialiased text-gray-900 bg-white">
    <div class="min-h-screen flex">
        <!-- Left Side: Branding & Info (Hidden on mobile) -->
        <div class="hidden lg:flex w-1/2 bg-blue-600 relative overflow-hidden flex-col justify-between p-12 text-white">
            <!-- Background Decoration -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-700 to-blue-500 opacity-90 z-0"></div>
            <svg class="absolute bottom-0 left-0 w-full h-auto text-blue-700 opacity-30 z-0" viewBox="0 0 100 50" preserveAspectRatio="none">
                <path d="M0 50 L 100 50 L 100 0 Q 50 100 0 0 Z" fill="currentColor"></path>
            </svg>
             <div class="absolute top-0 right-0 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
             <div class="absolute bottom-0 left-0 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
            
            <!-- Branding Content -->
            <div class="relative z-10">
                <a href="/" class="flex items-center gap-3 mb-8 group">
                    <div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm group-hover:bg-white/20 transition">
                        @php
                            $logo = \App\Models\Setting::value('app_logo');
                        @endphp
                        @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-10 w-auto">
                        @else
                            <x-application-logo class="w-10 h-10 fill-current text-white" />
                        @endif
                    </div>
                    <span class="text-2xl font-bold tracking-tight">
                        {{ \App\Models\Setting::value('app_name', config('app.name')) }}
                    </span>
                </a>
            </div>

            <div class="relative z-10 mb-auto mt-16">
                <h1 class="text-4xl md:text-5xl font-extrabold leading-tight mb-6">
                    Manage Your Team <br>
                    <span class="text-blue-200">With Confidence.</span>
                </h1>
                <p class="text-lg text-blue-100 max-w-md leading-relaxed">
                    A complete HRIS solution for modern companies. Streamline attendance, payroll, and leave management in one secure platform.
                </p>
                
                <div class="mt-8 flex gap-4">
                    <div class="flex items-center gap-2 text-sm font-medium bg-blue-800/30 px-4 py-2 rounded-full border border-blue-400/30">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Secure
                    </div>
                    <div class="flex items-center gap-2 text-sm font-medium bg-blue-800/30 px-4 py-2 rounded-full border border-blue-400/30">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Fast
                    </div>
                     <div class="flex items-center gap-2 text-sm font-medium bg-blue-800/30 px-4 py-2 rounded-full border border-blue-400/30">
                        <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        Reliable
                    </div>
                </div>
            </div>

            <div class="mt-8 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} {{ \App\Models\Setting::value('company_name', 'Company Name') }}. <br>All rights reserved.
        </div>
        </div>

        <!-- Right Side: Form (Full width on mobile, half on desktop) -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-8 sm:p-12 relative bg-white">
             <!-- Mobile Background Decoration -->
             <div class="absolute inset-x-0 top-0 h-32 bg-blue-600 lg:hidden"></div>
             
             <!-- Mobile Logo -->
             <div class="absolute top-6 left-6 lg:hidden z-20">
                 <a href="/" class="flex items-center gap-2 group">
                     <div class="bg-white p-1.5 rounded-lg shadow-sm">
                        @if($logo)
                            <img src="{{ asset('storage/' . $logo) }}" alt="Logo" class="h-8 w-auto">
                        @else
                            <x-application-logo class="w-8 h-8 fill-current text-blue-600" />
                        @endif
                     </div>
                     <span class="text-xl font-bold text-white tracking-tight">
                        {{ \App\Models\Setting::value('app_name', config('app.name')) }}
                     </span>
                 </a>
             </div>

            <div class="w-full max-w-md bg-white rounded-3xl shadow-xl lg:shadow-none p-8 lg:p-0 z-10 relative">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>

</html>
