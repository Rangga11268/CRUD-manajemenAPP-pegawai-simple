@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Edit Pengajuan Cuti</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('leave.index') }}">Cuti</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm rounded-lg">
    <div class="card-header bg-white border-bottom-0 py-3">
        <h5 class="mb-0 text-dark font-weight-bold">
            <i class="fas fa-edit mr-2 text-primary"></i>Form Edit Cuti
        </h5>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('leave.update', $leave->id) }}">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="leave_type_id" class="font-weight-bold">Jenis Cuti</label>
                    <select id="leave_type_id" name="leave_type_id" class="form-control rounded-lg shadow-sm">
                        @foreach($leaveTypes as $type)
                            <option value="{{ $type->id }}" {{ $leave->leave_type_id == $type->id ? 'selected' : '' }}>
                                {{ $type->nama }} (Sisa: {{ $type->max_days }} hari)
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="start_date" class="font-weight-bold">Tanggal Mulai</label>
                    <input type="date" class="form-control rounded-lg shadow-sm" id="start_date" name="start_date" value="{{ old('start_date', $leave->start_date->format('Y-m-d')) }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="end_date" class="font-weight-bold">Tanggal Selesai</label>
                    <input type="date" class="form-control rounded-lg shadow-sm" id="end_date" name="end_date" value="{{ old('end_date', $leave->end_date->format('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="alasan" class="font-weight-bold">Alasan Cuti</label>
                <textarea class="form-control rounded-lg shadow-sm" id="alasan" name="alasan" rows="4" placeholder="Berikan alasan pengajuan cuti...">{{ old('alasan', $leave->alasan) }}</textarea>
            </div>

            <div class="form-group text-right mt-4">
                <a href="{{ route('leave.index') }}" class="btn btn-secondary rounded-pill px-4 shadow-sm mr-2">Batal</a>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                    <i class="fas fa-save mr-1"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
