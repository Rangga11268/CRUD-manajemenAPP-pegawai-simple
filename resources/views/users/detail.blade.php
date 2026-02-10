@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-header bg-white border-bottom-0 py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark font-weight-bold">
                            <i class="fas fa-user mr-2 text-primary"></i>Detail Pengguna
                        </h5>
                        <a href="{{ route('users.index') }}" class="btn btn-secondary shadow-sm rounded-pill btn-sm">
                            <i class="fas fa-arrow-left mr-1"></i> Kembali
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- User Info -->
            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-lg mb-4">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            @if($user->profile_photo_path)
                                <img src="{{ asset('storage/' . $user->profile_photo_path) }}" class="img-fluid rounded-circle shadow-sm" style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="avatar-placeholder rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto shadow-sm" style="width: 120px; height: 120px; font-size: 2.5rem;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <h5 class="font-weight-bold mb-1">{{ $user->name }}</h5>
                        <p class="text-muted mb-2">{{ $user->email }}</p>
                        <span class="badge badge-primary rounded-pill px-3">{{ $user->roles->pluck('name')->implode(', ') }}</span>

                        <hr>

                        <div class="text-left">
                            <p class="mb-2"><strong><i class="fas fa-calendar-alt mr-2 text-muted"></i> Bergabung:</strong> <br> {{ $user->created_at->format('d M Y') }}</p>
                            <p class="mb-0"><strong><i class="fas fa-check-circle mr-2 text-muted"></i> Status:</strong> <br> 
                                @if($user->email_verified_at)
                                    <span class="text-success">Terverifikasi</span>
                                @else
                                    <span class="text-warning">Belum Verifikasi</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Linked Data -->
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-lg">
                    <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                        <h6 class="font-weight-bold text-muted">DATA TERKAIT</h6>
                    </div>
                    <div class="card-body">
                        @if($user->pegawai)
                            <div class="alert alert-success border-0 rounded-lg shadow-sm mb-4">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <div class="icon-circle bg-white text-success rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                                            <i class="fas fa-id-badge fa-lg"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h6 class="font-weight-bold mb-1">Terhubung dengan Data Pegawai</h6>
                                        <p class="mb-0 small">Akun ini terhubung dengan pegawai <strong>{{ $user->pegawai->nama_pegawai }}</strong>.</p>
                                    </div>
                                    <div class="ml-auto">
                                        <a href="{{ route('pegawai.show', $user->pegawai->id) }}" class="btn btn-sm btn-success rounded-pill shadow-sm">
                                            Lihat Pegawai <i class="fas fa-arrow-right ml-1"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted font-weight-bold small text-uppercase">NIP</label>
                                    <p class="font-weight-bold text-dark">{{ $user->pegawai->nip }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted font-weight-bold small text-uppercase">Jabatan</label>
                                    <p class="font-weight-bold text-dark">{{ $user->pegawai->jabatans->first()->nama_jabatan ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted font-weight-bold small text-uppercase">Departemen</label>
                                    <p class="font-weight-bold text-dark">{{ $user->pegawai->department->name ?? '-' }}</p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted font-weight-bold small text-uppercase">Status Pegawai</label>
                                    <p class="font-weight-bold text-dark">{{ ucfirst($user->pegawai->status) }}</p>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <img src="https://img.freepik.com/free-vector/no-data-concept-illustration_114360-536.jpg" alt="No Data" class="img-fluid mb-3" style="max-width: 200px;">
                                <h6 class="font-weight-bold text-muted">Belum Terhubung Data Pegawai</h6>
                                <p class="text-muted mb-4">Akun ini belum ditautkan dengan data pegawai manapun.</p>
                                <a href="{{ route('pegawai.create') }}" class="btn btn-primary rounded-pill shadow-sm">
                                    <i class="fas fa-plus mr-1"></i> Buat Data Pegawai
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
