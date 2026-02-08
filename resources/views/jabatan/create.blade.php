@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Tambah Jabatan Baru</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jabatan.index') }}">Jabatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>Form Jabatan</strong>
    </div>
    <div class="card-body">
        <form action="{{ route('jabatan.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="nama_jabatan">Nama Jabatan</label>
                <input type="text" class="form-control @error('nama_jabatan') is-invalid @enderror" id="nama_jabatan" name="nama_jabatan" value="{{ old('nama_jabatan') }}" placeholder="Contoh: Manager Operasional" required>
                @error('nama_jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="deskripsi_jabatan">Deskripsi Jabatan</label>
                <textarea class="form-control @error('deskripsi_jabatan') is-invalid @enderror" id="deskripsi_jabatan" name="deskripsi_jabatan" rows="4" placeholder="Tanggung jawab utama...">{{ old('deskripsi_jabatan') }}</textarea>
                @error('deskripsi_jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-actions text-right">
                <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Simpan Jabatan</button>
            </div>
        </form>
    </div>
</div>
@endsection
