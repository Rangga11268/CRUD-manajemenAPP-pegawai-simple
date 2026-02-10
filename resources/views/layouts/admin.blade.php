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
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
    @yield('css')
</head>
<body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">
            <h3 class="c-sidebar-brand-full" style="color: white; margin: 0; padding: 10px;">Manajemen SDM</h3>
            <h3 class="c-sidebar-brand-minimized" style="color: white; margin: 0; padding: 10px;">APP</h3>
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
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (session('failed'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-times-circle mr-2"></i> {{ session('failed') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        @if (session('delete'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-trash-alt mr-2"></i> {{ session('delete') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

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
        });
    </script>
    @yield('javascript')
</body>
</html>
