@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>Pengaturan Aplikasi</strong>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <ul class="nav nav-tabs" id="settingTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
                                        <i class="c-icon cil-settings mr-2"></i>Umum
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab" aria-controls="attendance" aria-selected="false">
                                        <i class="c-icon cil-clock mr-2"></i>Absensi & Jam Kerja
                                    </a>
                                </li>
                            </ul>
                            
                            <div class="tab-content mt-4" id="settingTabContent">
                                <!-- General Tab -->
                                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Nama Aplikasi</label>
                                        <div class="col-md-9">
                                            <input type="text" name="app_name" class="form-control" value="{{ $settings['app_name'] ?? config('app.name') }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Logo Aplikasi</label>
                                        <div class="col-md-9">
                                            @if(isset($settings['app_logo']))
                                                <div class="mb-2">
                                                    <img src="{{ asset('storage/' . $settings['app_logo']) }}" alt="App Logo" height="50">
                                                </div>
                                            @endif
                                            <input type="file" name="app_logo" class="form-control-file">
                                            <small class="text-muted">Format: PNG, JPG (Max 2MB)</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Nama Perusahaan</label>
                                        <div class="col-md-9">
                                            <input type="text" name="company_name" class="form-control" value="{{ $settings['company_name'] ?? 'PT. Maju Mundur' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Alamat Perusahaan</label>
                                        <div class="col-md-9">
                                            <textarea name="company_address" class="form-control" rows="3">{{ $settings['company_address'] ?? '-' }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Attendance Tab -->
                                <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                                    <div class="alert alert-info">
                                        <i class="fas fa-info-circle mr-2"></i> Pengaturan ini akan mempengaruhi validasi absensi harian pegawai.
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Jam Masuk (Start)</label>
                                        <div class="col-md-3">
                                            <input type="time" name="work_start_time" class="form-control" value="{{ $settings['work_start_time'] ?? '08:00' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Jam Pulang (End)</label>
                                        <div class="col-md-3">
                                            <input type="time" name="work_end_time" class="form-control" value="{{ $settings['work_end_time'] ?? '17:00' }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Toleransi Keterlambatan (Menit)</label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="number" name="late_tolerance" class="form-control" value="{{ $settings['late_tolerance'] ?? '15' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Menit</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <h5 class="mb-3">Validasi Lokasi (Geofencing)</h5>
                                    
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Koordinat Kantor (Lat, Long)</label>
                                        <div class="col-md-6">
                                            <input type="text" name="office_coordinates" class="form-control" value="{{ $settings['office_coordinates'] ?? '-6.200000, 106.816666' }}" placeholder="-6.200000, 106.816666">
                                            <small class="text-muted">Format: Latitude, Longitude. Gunakan Google Maps untuk mendapatkan titik akurat.</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Radius Absensi (Meter)</label>
                                        <div class="col-md-3">
                                           <div class="input-group">
                                                <input type="number" name="attendance_radius" class="form-control" value="{{ $settings['attendance_radius'] ?? '100' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">Meter</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mt-4">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="c-icon cil-save mr-1"></i> Simpan Pengaturan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('javascript')
<script>
    // Optional: Add map preview here later
</script>
@endsection
