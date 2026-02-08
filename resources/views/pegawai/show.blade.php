@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Detail Pegawai: {{ $pegawai->nama_pegawai }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Pegawai</a></li>
                <li class="breadcrumb-item active" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Profile Card -->
        <div class="card mb-4">
            <div class="card-body text-center">
                @if ($pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png')
                    <img class="img-thumbnail rounded-circle mb-3" src="{{ asset('storage/' . $pegawai->image) }}" alt="Photo" width="150" height="150">
                @else
                    <img class="img-thumbnail rounded-circle mb-3" src="https://ui-avatars.com/api/?name={{ urlencode($pegawai->nama_pegawai) }}&color=7F9CF5&background=EBF4FF" alt="Photo" width="150" height="150">
                @endif
                <h4 class="mb-1">{{ $pegawai->nama_pegawai }}</h4>
                <p class="text-muted mb-3">{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</p>
                <div class="d-flex justify-content-center mb-4">
                    <span class="badge badge-{{ $pegawai->status == 'aktif' ? 'success' : 'secondary' }} mr-2">
                        {{ strtoupper($pegawai->status) }}
                    </span>
                    @if($pegawai->user)
                        <span class="badge badge-success">Linked to User</span>
                    @endif
                </div>
                <div>
                   <a href="{{ route('pegawai.edit', $pegawai->id) }}" class="btn btn-primary">
                        <i class="cil-pencil c-icon mr-1"></i> Edit
                   </a>
                   <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>

        <!-- Job Info Card -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>Informasi Pekerjaan</strong>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">Department</small>
                    <div class="font-weight-bold">{{ $pegawai->department->name ?? '-' }}</div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Jabatan</small>
                    <div class="font-weight-bold">{{ $pegawai->jabatans->nama_jabatan ?? '-' }}</div>
                </div>
                <div class="mb-3">
                    <small class="text-muted">Tanggal Masuk</small>
                    <div class="font-weight-bold">{{ $pegawai->tanggal_masuk?->translatedFormat('d F Y') }}</div>
                </div>
                <div>
                    <small class="text-muted">Gaji Pokok</small>
                    <div class="font-weight-bold text-primary">Rp {{ number_format($pegawai->gaji_pokok, 0, ',', '.') }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <!-- Identity Card -->
        <div class="card mb-4">
            <div class="card-header">
                <strong>Identitas & Kontak</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <small class="text-muted">ID Pegawai (NIP)</small>
                        <div class="font-weight-bold">{{ $pegawai->employee_id }}</div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <small class="text-muted">NIK (KTP)</small>
                        <div class="font-weight-bold">{{ $pegawai->nik }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <small class="text-muted">Email</small>
                        <div class="font-weight-bold">{{ $pegawai->email }}</div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <small class="text-muted">No. Telepon</small>
                        <div class="font-weight-bold">{{ $pegawai->telepon }}</div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <small class="text-muted">Jenis Kelamin</small>
                        <div class="font-weight-bold">{{ $pegawai->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <small class="text-muted">Tanggal Lahir</small>
                        <div class="font-weight-bold">{{ $pegawai->tanggal_lahir?->translatedFormat('d F Y') }}</div>
                    </div>
                </div>
                <div>
                    <small class="text-muted">Alamat</small>
                    <div class="font-italic">{{ $pegawai->alamat }}</div>
                </div>
            </div>
        </div>

        <!-- Security Card -->
        <div class="card">
            <div class="card-header">
                <strong>Akun Keamanan</strong>
            </div>
            <div class="card-body">
                @if($pegawai->user)
                    <div class="media">
                        <i class="cil-shield-alt c-icon c-icon-3xl text-success mr-3"></i>
                        <div class="media-body">
                            <h5 class="mt-0">Terhubung dengan: {{ $pegawai->user->name }}</h5>
                            <span class="text-muted">Role: {{ ucfirst($pegawai->user->role) }} | Email: {{ $pegawai->user->email }}</span>
                        </div>
                    </div>
                @else
                    <div class="alert alert-warning d-flex align-items-center" role="alert">
                        <i class="cil-warning c-icon mr-2"></i>
                        <div>
                            Pegawai ini belum memiliki akun login sistem. Silahkan buat akun di menu <a href="{{ route('users.index') }}" class="font-weight-bold">Management User</a>.
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
