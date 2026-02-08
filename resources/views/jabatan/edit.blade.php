@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Edit Jabatan: {{ $jabatan->nama_jabatan }}</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('jabatan.index') }}">Jabatan</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>Edit Jabatan</strong>
    </div>
    <div class="card-body">
        <form action="{{ route('jabatan.update', $jabatan) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nama_jabatan">Nama Jabatan</label>
                <input type="text" class="form-control @error('nama_jabatan') is-invalid @enderror" id="nama_jabatan" name="nama_jabatan" value="{{ old('nama_jabatan', $jabatan->nama_jabatan) }}" required>
                @error('nama_jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="deskripsi_jabatan">Deskripsi Jabatan</label>
                <textarea class="form-control @error('deskripsi_jabatan') is-invalid @enderror" id="deskripsi_jabatan" name="deskripsi_jabatan" rows="4">{{ old('deskripsi_jabatan', $jabatan->deskripsi_jabatan) }}</textarea>
                @error('deskripsi_jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-actions text-right">
                <a href="{{ route('jabatan.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Update Jabatan</button>
            </div>
        </form>
    </div>
</div>
@endsection
