<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link {{ request()->routeIs('dashboard') ? 'c-active' : '' }}" href="{{ route('dashboard') }}">
        <i class="c-sidebar-nav-icon fas fa-tachometer-alt"></i> Dashboard
    </a>
</li>

@can('view pegawai')
<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link {{ request()->routeIs('pegawai.*') ? 'c-active' : '' }}" href="{{ route('pegawai.index') }}">
        <i class="c-sidebar-nav-icon fas fa-user"></i> Pegawai
    </a>
</li>
@endcan

@can('view jabatan')
<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link {{ request()->routeIs('jabatan.*') ? 'c-active' : '' }}" href="{{ route('jabatan.index') }}">
        <i class="c-sidebar-nav-icon fas fa-briefcase"></i> Jabatan
    </a>
</li>
@endcan

@can('view department')
<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link {{ request()->routeIs('department.*') ? 'c-active' : '' }}" href="{{ route('department.index') }}">
        <i class="c-sidebar-nav-icon fas fa-building"></i> Department
    </a>
</li>
@endcan

@can('view attendance')
<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link {{ request()->routeIs('attendance.*') ? 'c-active' : '' }}" href="{{ route('attendance.index') }}">
        <i class="c-sidebar-nav-icon fas fa-clock"></i> Absensi
    </a>
</li>
@endcan

@can('view leave')
<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link {{ request()->routeIs('leave.*') ? 'c-active' : '' }}" href="{{ route('leave.index') }}">
        <i class="c-sidebar-nav-icon fas fa-calendar-alt"></i> Cuti
    </a>
</li>
@endcan

@can('view salary')
<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link {{ request()->routeIs('salary.*') ? 'c-active' : '' }}" href="{{ route('salary.index') }}">
        <i class="c-sidebar-nav-icon fas fa-money-bill-wave"></i> Penggajian
    </a>
</li>
@endcan

@can('view reports')
<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link {{ request()->routeIs('reports.*') ? 'c-active' : '' }}" href="{{ route('reports.index') }}">
        <i class="c-sidebar-nav-icon fas fa-chart-pie"></i> Laporan
    </a>
</li>
@endcan

<li class="c-sidebar-nav-title">System</li>
<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{ route('roles.index') }}">
        <i class="c-sidebar-nav-icon fas fa-user-shield"></i> Data Roles (RBAC)
    </a>
</li>
<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{ route('calendar.index') }}">
        <i class="c-sidebar-nav-icon fas fa-calendar-alt"></i> Kalender Perusahaan
    </a>
</li>
<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{ route('settings.index') }}">
        <i class="c-sidebar-nav-icon fas fa-cogs"></i> Pengaturan
    </a>
</li>
<li class="c-sidebar-nav-item">
    <a class="c-sidebar-nav-link" href="{{ route('home') }}">
        <i class="c-sidebar-nav-icon fas fa-home"></i> Landing Page
    </a>
</li>
