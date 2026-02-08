@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Generate Payroll Baru</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('salary.index') }}">Payroll</a></li>
                <li class="breadcrumb-item active" aria-current="page">Generate</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>Form Payroll</strong>
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('salary.store') }}">
            @csrf
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="pegawai_id">Pilih Pegawai</label>
                    <select id="pegawai_id" name="pegawai_id" class="form-control">
                        @foreach($pegawais as $pegawai)
                            <option value="{{ $pegawai->id }}">{{ $pegawai->nama_pegawai }} - {{ $pegawai->jabatan->nama_jabatan ?? '-' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="periode">Periode (Bulan/Tahun)</label>
                    <input type="month" class="form-control" id="periode" name="periode" value="{{ date('Y-m') }}" required>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-6">
                    <div class="card border-success mb-3">
                        <div class="card-header bg-success text-white">
                            <i class="fas fa-plus c-icon mr-1"></i> Tunjangan (Allowance)
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-6"><input type="text" name="tunjangan[0][nama]" placeholder="Nama Tunjangan" class="form-control"></div>
                                <div class="col-6"><input type="number" name="tunjangan[0][jumlah]" placeholder="Jumlah" class="form-control"></div>
                            </div>
                            <div class="row">
                                <div class="col-6"><input type="text" name="tunjangan[1][nama]" placeholder="Nama Tunjangan" class="form-control"></div>
                                <div class="col-6"><input type="number" name="tunjangan[1][jumlah]" placeholder="Jumlah" class="form-control"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-danger mb-3">
                        <div class="card-header bg-danger text-white">
                            <i class="fas fa-minus c-icon mr-1"></i> Potongan (Deduction)
                        </div>
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-6"><input type="text" name="potongan[0][nama]" placeholder="Nama Potongan" class="form-control"></div>
                                <div class="col-6"><input type="number" name="potongan[0][jumlah]" placeholder="Jumlah" class="form-control"></div>
                            </div>
                            <div class="row">
                                <div class="col-6"><input type="text" name="potongan[1][nama]" placeholder="Nama Potongan" class="form-control"></div>
                                <div class="col-6"><input type="number" name="potongan[1][jumlah]" placeholder="Jumlah" class="form-control"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-actions text-right mt-3">
                <a href="{{ route('salary.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Generate Payroll</button>
            </div>
        </form>
    </div>
</div>
@endsection
