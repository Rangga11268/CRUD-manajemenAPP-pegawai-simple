@extends('layouts.admin')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <strong>Tambah Bonus Manual</strong>
            </div>
            <div class="card-body">
                <form action="{{ route('bonus.store') }}" method="POST">
                    @csrf
                    
                    <div class="form-group">
                        <label>Pegawai</label>
                        <select name="pegawai_id" class="form-control select2" required>
                            <option value="">-- Pilih Pegawai --</option>
                            @foreach($pegawais as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_pegawai }} ({{ $p->jabatans->nama_jabatan ?? '-' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Jenis Bonus</label>
                        <select name="type" class="form-control" required>
                            <option value="THR">Tunjangan Hari Raya (THR)</option>
                            <option value="Bonus Tahunan">Bonus Tahunan</option>
                            <option value="Bonus Project">Bonus Project</option>
                            <option value="Lembur Khusus">Lembur Khusus</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Jumlah (Rp)</label>
                            <input type="number" name="amount" class="form-control" min="0" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Tanggal Bayar</label>
                            <input type="date" name="date_paid" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>

                    <div class="text-right">
                        <a href="{{ route('bonus.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
