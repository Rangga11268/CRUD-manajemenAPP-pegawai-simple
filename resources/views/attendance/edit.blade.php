@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Edit Data Absensi</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('attendance.index') }}">Kehadiran</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white font-weight-bold">
        <i class="fas fa-edit text-primary mr-2"></i> Form Edit Absensi
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('attendance.update', $attendance->id) }}">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="pegawai_id">Pegawai <span class="text-danger">*</span></label>
                    <select id="pegawai_id" name="pegawai_id" class="form-control" readonly style="pointer-events: none; background-color: #e9ecef;">
                        <option value="{{ $attendance->pegawai_id }}" selected>
                            {{ $attendance->pegawai->nama_pegawai }} - {{ $attendance->pegawai->jabatans->nama_jabatan ?? 'N/A' }}
                        </option>
                    </select>
                    <small class="text-muted">Pegawai tidak dapat diubah.</small>
                </div>
                
                <div class="form-group col-md-6">
                    <label for="tanggal">Tanggal <span class="text-danger">*</span></label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $attendance->tanggal) }}" required>
                    @error('tanggal')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="clock_in">Jam Masuk <span class="text-danger">*</span></label>
                    <input type="time" class="form-control @error('clock_in') is-invalid @enderror" id="clock_in" name="clock_in" value="{{ old('clock_in', date('H:i', strtotime($attendance->clock_in))) }}" required>
                    @error('clock_in')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                
                <div class="form-group col-md-4">
                    <label for="clock_out">Jam Pulang</label>
                    <input type="time" class="form-control @error('clock_out') is-invalid @enderror" id="clock_out" name="clock_out" value="{{ old('clock_out', $attendance->clock_out ? date('H:i', strtotime($attendance->clock_out)) : '') }}">
                    @error('clock_out')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group col-md-4">
                    <label for="status">Status Kehadiran <span class="text-danger">*</span></label>
                    <select id="status" name="status" class="form-control @error('status') is-invalid @enderror" required>
                        <option value="hadir" {{ old('status', $attendance->status) == 'hadir' ? 'selected' : '' }}>Hadir</option>
                        <option value="telat" {{ old('status', $attendance->status) == 'telat' ? 'selected' : '' }}>Telat</option>
                        <option value="izin" {{ old('status', $attendance->status) == 'izin' ? 'selected' : '' }}>Izin</option>
                        <option value="sakit" {{ old('status', $attendance->status) == 'sakit' ? 'selected' : '' }}>Sakit</option>
                        <option value="alpa" {{ old('status', $attendance->status) == 'alpa' ? 'selected' : '' }}>Alpa</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="form-actions d-flex justify-content-end mt-3">
                <a href="{{ route('attendance.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save mr-1"></i> Update Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
