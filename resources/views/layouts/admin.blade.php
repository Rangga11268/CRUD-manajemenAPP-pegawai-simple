<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="theme-color" content="#ffffff">
    <!-- Icons-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@coreui/icons@2.1.0/css/free.min.css" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">
    <style>
        .c-sidebar-nav-icon {
            font-size: 1.2rem;
            text-align: center;
        }
        /* Sticky Footer Fix */
        .c-body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .c-main {
            flex: 1;
        }
        .c-footer {
            flex-shrink: 0;
        }
    </style>
    <!-- Main styles for this application-->
    <link href="{{ asset('assets/coreui/css/style.css') }}" rel="stylesheet">
    
    <style>
        /* Modern Sidebar Override */
        .c-sidebar {
            background: #ffffff !important;
            box-shadow: 4px 0 24px rgba(0,0,0,0.02);
            border-right: 1px solid #f3f4f6;
        }
        
        .c-sidebar-brand {
            background: #ffffff !important;
            border-bottom: 1px solid #f3f4f6;
        }

        .c-sidebar-nav-link {
            color: #4b5563 !important; /* gray-600 */
            border-radius: 12px;
            margin: 4px 12px;
            padding: 12px 16px !important;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .c-sidebar-nav-link:hover {
            background-color: #eff6ff !important; /* blue-50 */
            color: #2563eb !important; /* blue-600 */
            transform: translateX(2px);
        }

        .c-sidebar-nav-link.c-active {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
            color: white !important;
            font-weight: 600;
        }
        
        .c-sidebar-nav-icon {
            color: inherit !important;
        }
        
        /* General cleanup */
        .c-body {
            background-color: #f3f4f6 !important;
        }
        .card {
            border-radius: 12px !important;
            transition: transform 0.2s;
        }
        .btn {
            border-radius: 6px; 
            font-weight: 500;
        }

        /* Dark Mode Overrides */
        .c-dark-theme .c-body { background-color: #181924 !important; color: #e1e1e6; }
        .c-dark-theme .c-sidebar { background-color: #202b3c !important; border-right: 1px solid #2d3748; }
        .c-dark-theme .c-sidebar-brand { background-color: #1a2236 !important; border-bottom: 1px solid #2d3748; }
        .c-dark-theme .c-sidebar-nav-link { color: #a0aec0 !important; }
        .c-dark-theme .c-sidebar-nav-link:hover { background-color: #2d3748 !important; color: #fff !important; }
        .c-dark-theme .c-sidebar-nav-link.c-active { color: #fff !important; box-shadow: 0 4px 12px rgba(0,0,0,0.3); }
        .c-dark-theme .c-sidebar-nav-title { color: #cbd5e0 !important; }
        
        .c-dark-theme .c-header { background-color: #202b3c !important; border-bottom: 1px solid #2d3748; }
        .c-dark-theme .c-header .c-header-nav-link { color: #e1e1e6 !important; }
        .c-dark-theme .c-header-brand { color: #fff !important; }
        
        /* Cards */
        .c-dark-theme .card { background-color: #202b3c !important; color: #fff; border-color: #2d3748; }
        .c-dark-theme .card-header { background-color: #263345 !important; border-bottom: 1px solid #2d3748; color: #fff; }
        .c-dark-theme .card-header .text-dark { color: #fff !important; }
        
        /* Tables */
        .c-dark-theme .table { color: #e1e1e6; background-color: #202b3c; }
        .c-dark-theme .table td, .c-dark-theme .table th { border-color: #2d3748; }
        .c-dark-theme .table thead th { background-color: #1a2236; border-color: #2d3748; color: #fff; }
        
        /* Forms */
        .c-dark-theme .form-control { background-color: #1a2236; border-color: #2d3748; color: #fff; }
        .c-dark-theme .form-control:focus { background-color: #1a2236; color: #fff; border-color: #4a5568; }
        
        /* Dropdowns */
        .c-dark-theme .dropdown-menu { background-color: #202b3c; border-color: #2d3748; }
        .c-dark-theme .dropdown-item { color: #e1e1e6; }
        .c-dark-theme .dropdown-item:hover { background-color: #2d3748; color: #fff; }
        .c-dark-theme .dropdown-header { background-color: #263345 !important; color: #a0aec0; }
        
        /* Footer */
        .c-dark-theme .c-footer { background-color: #202b3c !important; border-top: 1px solid #2d3748; color: #a0aec0; }
        .c-dark-theme .c-footer a { color: #cbd5e0; }

        /* Utilities */
        .c-dark-theme .text-dark { color: #e1e1e6 !important; }
        .c-dark-theme .bg-white { background-color: #202b3c !important; }
        .c-dark-theme .bg-light { background-color: #263345 !important; }
        .c-dark-theme .border-bottom-0 { border-bottom: 0 !important; }
        .c-dark-theme .text-muted { color: #a0aec0 !important; }
        .c-dark-theme .border-0 { border: none !important; }

        /* Sidebar Minimizer */
        .c-sidebar-minimizer {
            background-color: #f9fafb; 
            border-top: 1px solid #e5e7eb; 
            color: #6b7280;
        }
        .c-dark-theme .c-sidebar-minimizer {
            background-color: #1a2236 !important;
            border-top: 1px solid #2d3748 !important;
            color: #a0aec0 !important;
        }
    </style>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    @yield('css')
</head>
<body class="c-app">
    <div class="c-sidebar c-sidebar-light c-sidebar-fixed c-sidebar-lg-show shadow-sm" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">
            @if(\App\Models\Setting::value('app_logo'))
                <img src="{{ asset('storage/' . \App\Models\Setting::value('app_logo')) }}" alt="Logo" class="c-sidebar-brand-full" height="35">
                <img src="{{ asset('storage/' . \App\Models\Setting::value('app_logo')) }}" alt="Logo" class="c-sidebar-brand-minimized" height="35">
            @else
                <h3 class="c-sidebar-brand-full" style="color: #374151; margin: 0; padding: 10px;">{{ \App\Models\Setting::value('app_name', config('app.name')) }}</h3>
                <h3 class="c-sidebar-brand-minimized" style="color: #374151; margin: 0; padding: 10px;">APP</h3>
            @endif
        </div>
        <ul class="c-sidebar-nav">
            @include('admin.partials.sidebar')
        </ul>
        <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
    </div>
    
    <div class="c-wrapper c-fixed-components">
        <header class="c-header c-header-light c-header-fixed c-header-with-subheader">
            <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show">
                <i class="c-icon c-icon-lg fas fa-bars"></i>
            </button>
            <a class="c-header-brand d-lg-none" href="#">
                <h3 style="margin: 0; padding: 10px;">{{ config('app.name') }}</h3>
            </a>
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
                <i class="c-icon c-icon-lg fas fa-bars"></i>
            </button>
            
            <ul class="c-header-nav ml-auto mr-4">
                <li class="c-header-nav-item dropdown d-md-down-none mx-2">
                    <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <i class="c-icon fas fa-bell"></i>
                        @if(auth()->user()->unreadNotifications->count() > 0)
                            <span class="badge badge-pill badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                        @endif
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg pt-0">
                        <div class="dropdown-header bg-light">
                            <strong>You have {{ auth()->user()->unreadNotifications->count() }} notifications</strong>
                        </div>
                        @forelse(auth()->user()->unreadNotifications->take(5) as $notification)
                            <a class="dropdown-item" href="{{ isset($notification->data['url']) ? route('notifications.read', $notification->id) : '#' }}">
                                <i class="fas fa-info-circle mr-2 text-primary"></i> {{ Str::limit($notification->data['message'] ?? 'New Notification', 30) }}
                            </a>
                        @empty
                            <a class="dropdown-item text-center" href="#">
                                <small class="text-muted">No new notifications</small>
                            </a>
                        @endforelse
                        <a class="dropdown-item text-center border-top" href="{{ route('notifications.index') }}">
                            <strong>View all notifications</strong>
                        </a>
                    </div>
                </li>
                <li class="c-header-nav-item dropdown d-md-down-none mx-2">
                    <button class="c-header-nav-link btn btn-link" type="button" id="darkModeToggle">
                        <i class="fas fa-moon c-icon"></i>
                    </button>
                </li>
                <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="c-avatar">
                        @php
                            $pegawai = auth()->user()->pegawai;
                            $imagePath = $pegawai && $pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png' 
                                ? asset('storage/' . $pegawai->image) 
                                : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name).'&color=7F9CF5&background=EBF4FF';
                        @endphp
                        <img class="c-avatar-img" src="{{ $imagePath }}" alt="{{ auth()->user()->email }}">
                    </div>
                    <span class="ml-2 d-md-down-none font-weight-bold text-dark">{{ auth()->user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pt-0">
                        <div class="dropdown-header bg-light py-2"><strong>Account</strong></div>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="c-icon mr-2 fas fa-user"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="c-icon mr-2 fas fa-sign-out-alt"></i> Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </header>
        
        <div class="c-body">
            <main class="c-main">
                <div class="container-fluid">
                    <div class="fade-in">
                        <!-- Alerts handled by SweetAlert2 -->

                        @yield('content')
                    </div>
                </div>
            </main>
            @include('admin.partials.footer')
        </div>
    </div>
    
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('assets/coreui/js/coreui.bundle.min.js') }}"></script>
    <!-- DataTables -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.datatable').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Indonesian.json"
                }
            });

            // SweetAlert2 Toast Configuration
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            @if(session('success'))
                Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
            @endif

            @if(session('failed'))
                Toast.fire({ icon: 'error', title: "{{ session('failed') }}" });
            @endif

            @if(session('delete'))
                Toast.fire({ icon: 'warning', title: "{{ session('delete') }}" });
            @endif

            @if(session('error'))
                Toast.fire({ icon: 'error', title: "{{ session('error') }}" });
            @endif

            @if ($errors->any())
                let errorHtml = '<ul class="text-left" style="list-style-type: none; padding-left: 0;">';
                @foreach ($errors->all() as $error)
                    errorHtml += '<li><i class="fas fa-exclamation-circle text-danger mr-2"></i> {{ $error }}</li>';
                @endforeach
                errorHtml += '</ul>';

                Swal.fire({
                    icon: 'error',
                    title: 'Validasi Gagal!',
                    html: errorHtml,
                    confirmButtonText: 'Perbaiki',
                    confirmButtonColor: '#e55353'
                });
            @endif

            // Global SweetAlert Delete Confirmation
            $(document).on('click', '.btn-delete', function(e) {
                e.preventDefault();
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e55353',
                    cancelButtonColor: '#321fdb',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Dark Mode Logic
            const darkModeToggle = document.getElementById('darkModeToggle');
            const body = document.body;
            const icon = darkModeToggle.querySelector('i');

            // Check local storage
            if (localStorage.getItem('dark-mode') === 'enabled') {
                body.classList.add('c-dark-theme');
                icon.classList.remove('fa-moon');
                icon.classList.add('fa-sun');
            }

            darkModeToggle.addEventListener('click', () => {
                body.classList.toggle('c-dark-theme');
                if (body.classList.contains('c-dark-theme')) {
                    localStorage.setItem('dark-mode', 'enabled');
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                } else {
                    localStorage.setItem('dark-mode', 'disabled');
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                }
            });
        });
    </script>
    @yield('javascript')
</body>
</html>
