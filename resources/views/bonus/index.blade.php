@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="mb-0">Riwayat Bonus & THR</h3>
                    <div>
                        <a href="{{ route('bonus.create') }}" class="btn btn-primary"><i class="fas fa-plus mr-1"></i> Tambah Bonus Manual</a>
                        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#generateTHRModal">
                            <i class="fas fa-magic mr-1"></i> Generate THR Otomatis
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover table-striped">
                        <thead class="thead-dark">
                            <tr>
                                <th>Tanggal</th>
                                <th>Pegawai</th>
                                <th>Jenis</th>
                                <th>Nominal (Rp)</th>
                                <th>Pajak (Rp)</th>
                                <th>Netto (Rp)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bonuses as $bonus)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($bonus->date_paid)->format('d M Y') }}</td>
                                <td>
                                    <strong>{{ $bonus->pegawai->nama_pegawai }}</strong><br>
                                    <small class="text-muted">{{ $bonus->pegawai->nip ?? $bonus->pegawai->nik }}</small>
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ $bonus->type }}</span>
                                </td>
                                <td class="text-right">{{ number_format($bonus->amount, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($bonus->tax_deduction, 0, ',', '.') }}</td>
                                <td class="text-right font-weight-bold">{{ number_format($bonus->amount - $bonus->tax_deduction, 0, ',', '.') }}</td>
                                <td>
                                    <form action="{{ route('bonus.destroy', $bonus->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus data ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4 text-muted">Belum ada data bonus/THR.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                {{ $bonuses->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal Generate THR -->
<div class="modal fade" id="generateTHRModal" tabindex="-1" role="dialog" aria-labelledby="generateTHRModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <form action="{{ route('bonus.generate-thr') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="generateTHRModalLabel">Generate THR Massal</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Sistem akan menghitung THR untuk <strong>semua pegawai aktif</strong> dengan aturan:</p>
                    <ul>
                        <li>Masa kerja &ge; 12 bulan: 1x Gaji Pokok</li>
                        <li>Masa kerja < 12 bulan: Pro-rate (Masa Kerja / 12 * Gaji Pokok)</li>
                    </ul>
                    <div class="form-group">
                        <label>Tanggal Pembayaran</label>
                        <input type="date" name="date_paid" class="form-control" value="{{ date('Y-m-d') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Proses Sekarang</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
