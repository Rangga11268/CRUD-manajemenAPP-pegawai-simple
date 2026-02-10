@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-lg">
                    <div class="card-header bg-white border-bottom-0 py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-dark font-weight-bold">
                                <i class="fas fa-chart-bar mr-2 text-primary"></i>Laporan Absensi
                            </h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('reports.export.attendance') }}" method="GET" class="mb-4">
                            <div class="row align-items-end">
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold mb-2">Tanggal Mulai</label>
                                        <input type="date" name="start_date" class="form-control rounded-lg shadow-sm" required value="{{ date('Y-m-01') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group mb-0">
                                        <label class="font-weight-bold mb-2">Tanggal Akhir</label>
                                        <input type="date" name="end_date" class="form-control rounded-lg shadow-sm" required value="{{ date('Y-m-d') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-success rounded-pill shadow-sm px-4">
                                        <i class="fas fa-file-excel mr-2"></i> Export Excel
                                    </button>
                                </div>
                            </div>
                        </form>

                        <div class="alert alert-info border-0 rounded-lg shadow-sm">
                            <i class="fas fa-info-circle mr-2"></i>
                            Silakan pilih rentang tanggal untuk mengunduh laporan absensi detail.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
