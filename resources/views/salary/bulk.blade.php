@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header font-weight-bold">
                        <i class="fas fa-magic mr-1"></i> Generate Gaji Massal
                    </div>
                    <form action="{{ route('salary.generate_bulk') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            <div class="alert alert-info">
                                <i class="fas fa-info-circle mr-1"></i>
                                Fitur ini akan membuat slip gaji (Gaji Pokok) untuk <strong>semua pegawai aktif</strong> pada periode yang dipilih.
                                Jika slip gaji sudah ada, tidak akan ditimpa.
                            </div>

                            <div class="form-group">
                                <label for="month">Bulan</label>
                                <select name="month" id="month" class="form-control" required>
                                    @foreach(range(1, 12) as $m)
                                        <option value="{{ $m }}" {{ date('n') == $m ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $m, 1)) }} ({{ $m }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="year">Tahun</label>
                                <select name="year" id="year" class="form-control" required>
                                    @foreach(range(date('Y')-1, date('Y')+1) as $y)
                                        <option value="{{ $y }}" {{ date('Y') == $y ? 'selected' : '' }}>
                                            {{ $y }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('salary.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-cogs mr-1"></i> Generate Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
