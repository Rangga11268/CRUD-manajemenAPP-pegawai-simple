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
    <link href="{{ asset('assets/coreui/icons/css/free.min.css') }}" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="{{ asset('assets/coreui/css/style.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body class="c-app">
    <div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
        <div class="c-sidebar-brand d-lg-down-none">
            <h3 class="c-sidebar-brand-full" style="color: white; margin: 0; padding: 10px;">{{ config('app.name') }}</h3>
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
                <i class="c-icon c-icon-lg cil-menu"></i>
            </button>
            <a class="c-header-brand d-lg-none" href="#">
                <h3 style="margin: 0; padding: 10px;">{{ config('app.name') }}</h3>
            </a>
            <button class="c-header-toggler c-class-toggler mfs-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true">
                <i class="c-icon c-icon-lg cil-menu"></i>
            </button>
            
            <ul class="c-header-nav ml-auto mr-4">
                <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <div class="c-avatar"><img class="c-avatar-img" src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&color=7F9CF5&background=EBF4FF" alt="{{ auth()->user()->email }}"></div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right pt-0">
                        <div class="dropdown-header bg-light py-2"><strong>Account</strong></div>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="c-icon mr-2 cil-user"></i> Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="c-icon mr-2 cil-account-logout"></i> Logout
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
                        @yield('content')
                    </div>
                </div>
            </main>
            <footer class="c-footer">
                <div><a href="https://coreui.io">CoreUI</a> © 2020 creativeLabs.</div>
                <div class="ml-auto">Powered by&nbsp;<a href="https://coreui.io/">CoreUI</a></div>
            </footer>
        </div>
    </div>
    
    <!-- CoreUI and necessary plugins-->
    <script src="{{ asset('assets/coreui/js/coreui.bundle.min.js') }}"></script>
    @yield('javascript')
</body>
</html>
