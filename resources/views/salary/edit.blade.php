@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Edit Slip Gaji</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('salary.index') }}">Payroll</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white font-weight-bold">
        <i class="fas fa-edit text-primary mr-2"></i> Form Edit Payroll
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route('salary.update', $salary->id) }}">
            @csrf
            @method('PUT')
            
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="pegawai_nama">Nama Pegawai</label>
                    <input type="text" class="form-control" id="pegawai_nama" value="{{ $salary->pegawai->nama_pegawai }} - {{ $salary->pegawai->jabatans->nama_jabatan ?? '-' }}" readonly>
                    <small class="text-muted">Pegawai tidak dapat diubah saat edit.</small>
                </div>
                <div class="form-group col-md-6">
                    <label for="periode">Periode (Bulan/Tahun)</label>
                    <input type="month" class="form-control" id="periode" value="{{ $salary->periode }}" readonly>
                    <small class="text-muted">Periode tidak dapat diubah saat edit.</small>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-6">
                    <div class="card border-success mb-3 shadow-sm">
                        <div class="card-header bg-success text-white font-weight-bold">
                            <i class="fas fa-plus-circle mr-2"></i> Tunjangan (Allowance)
                        </div>
                        <div class="card-body bg-light">
                            <!-- Existing Allowances -->
                            @foreach($salary->components->where('type', 'tunjangan') as $index => $component)
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <input type="text" name="tunjangan[{{ $index }}][nama]" value="{{ $component->nama }}" placeholder="Nama Tunjangan" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" name="tunjangan[{{ $index }}][jumlah]" value="{{ $component->jumlah }}" placeholder="Jumlah" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                            <!-- Extra Empty Slots for New Allowances -->
                            @for($i = $salary->components->where('type', 'tunjangan')->count(); $i < 5; $i++)
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <input type="text" name="tunjangan[{{ $i }}][nama]" placeholder="Nama Tunjangan" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" name="tunjangan[{{ $i }}][jumlah]" placeholder="Jumlah" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card border-danger mb-3 shadow-sm">
                        <div class="card-header bg-danger text-white font-weight-bold">
                            <i class="fas fa-minus-circle mr-2"></i> Potongan (Deduction)
                        </div>
                        <div class="card-body bg-light">
                             <!-- Existing Deductions -->
                             @foreach($salary->components->where('type', 'potongan') as $index => $component)
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <input type="text" name="potongan[{{ $index }}][nama]" value="{{ $component->nama }}" placeholder="Nama Potongan" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" name="potongan[{{ $index }}][jumlah]" value="{{ $component->jumlah }}" placeholder="Jumlah" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            
                             <!-- Extra Empty Slots for New Deductions -->
                             @for($i = $salary->components->where('type', 'potongan')->count(); $i < 5; $i++)
                                <div class="row mb-2">
                                    <div class="col-6">
                                        <input type="text" name="potongan[{{ $i }}][nama]" placeholder="Nama Potongan" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Rp</span>
                                            </div>
                                            <input type="number" name="potongan[{{ $i }}][jumlah]" placeholder="Jumlah" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info border-left-lg">
                <i class="fas fa-info-circle mr-2"></i> <strong>Catatan:</strong> Gaji Bersih akan dihitung ulang otomatis berdasarkan perubahan tunjangan dan potongan.
            </div>

            <div class="form-actions d-flex justify-content-end mt-4">
                <a href="{{ route('salary.index') }}" class="btn btn-secondary mr-2">
                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                </a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save mr-1"></i> Update Payroll
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
