@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Ajukan Cuti Baru</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('leave.index') }}">Cuti</a></li>
                <li class="breadcrumb-item active" aria-current="page">Ajukan</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>Form Pengajuan Cuti</strong>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('leave.store') }}">
            @csrf
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="leave_type_id">Jenis Cuti</label>
                    <select id="leave_type_id" name="leave_type_id" class="form-control">
                        @foreach($leaveTypes as $type)
                            <option value="{{ $type->id }}">{{ $type->nama }} (Sisa: {{ $type->max_days }} hari)</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="start_date">Tanggal Mulai</label>
                    <input type="date" class="form-control" id="start_date" name="start_date" value="{{ old('start_date') }}" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="end_date">Tanggal Selesai</label>
                    <input type="date" class="form-control" id="end_date" name="end_date" value="{{ old('end_date') }}" required>
                </div>
            </div>

            <div class="form-group">
                <label for="alasan">Alasan Cuti</label>
                <textarea class="form-control" id="alasan" name="alasan" rows="4" placeholder="Berikan alasan pengajuan cuti...">{{ old('alasan') }}</textarea>
            </div>

            <div class="form-actions text-right">
                <a href="{{ route('leave.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Ajukan Cuti</button>
            </div>
        </form>
    </div>
</div>
@endsection
