@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header py-3">
                        <h5 class="mb-0 font-weight-bold">
                            <i class="fas fa-cogs mr-2 text-primary"></i>Pengaturan Aplikasi
                        </h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <ul class="nav nav-pills mb-4" id="settingTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active px-4 rounded-pill" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">
                                        <i class="fas fa-sliders-h mr-2"></i>Umum
                                    </a>
                                </li>
                                    <a class="nav-link px-4 rounded-pill" id="attendance-tab" data-toggle="tab" href="#attendance" role="tab" aria-controls="attendance" aria-selected="false">
                                        <i class="fas fa-clock mr-2"></i>Absensi & Jam Kerja
                                    </a>
                                </li>
                                <li class="nav-item ml-2">
                                    <a class="nav-link px-4 rounded-pill" id="payroll-tab" data-toggle="tab" href="#payroll" role="tab" aria-controls="payroll" aria-selected="false">
                                        <i class="fas fa-money-check-alt mr-2"></i>Payroll & BPJS
                                    </a>
                                </li>
                            </ul>
                            
                            <div class="tab-content mt-4" id="settingTabContent">
                                <!-- General Tab -->
                                <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label font-weight-bold">Nama Aplikasi</label>
                                        <div class="col-md-9">
                                            <input type="text" name="app_name" class="form-control rounded-lg" value="{{ old('app_name', $settings['app_name'] ?? config('app.name')) }}">
                                        </div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label font-weight-bold">Logo Aplikasi</label>
                                        <div class="col-md-9">
                                            @if(isset($settings['app_logo']))
                                                <div class="mb-3 p-2 bg-light rounded d-inline-block border">
                                                    <img src="{{ asset('storage/' . $settings['app_logo']) }}" alt="App Logo" height="50">
                                                </div>
                                            @endif
                                            <input type="file" name="app_logo" class="form-control-file">
                                            <small class="text-muted d-block mt-1">Format: PNG, JPG (Max 2MB)</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label font-weight-bold">Nama Perusahaan</label>
                                        <div class="col-md-9">
                                            <input type="text" name="company_name" class="form-control rounded-lg" value="{{ old('company_name', $settings['company_name'] ?? 'PT. Maju Mundur') }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label font-weight-bold">Email Perusahaan</label>
                                        <div class="col-md-9">
                                            <input type="email" name="company_email" class="form-control rounded-lg" value="{{ old('company_email', $settings['company_email'] ?? '') }}" placeholder="admin@company.com">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label font-weight-bold">No. Telepon</label>
                                        <div class="col-md-9">
                                            <input type="text" name="company_phone" class="form-control rounded-lg" value="{{ old('company_phone', $settings['company_phone'] ?? '') }}" placeholder="+62 21 1234 5678">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label font-weight-bold">Alamat Perusahaan</label>
                                        <div class="col-md-9">
                                            <textarea name="company_address" class="form-control rounded-lg" rows="3">{{ old('company_address', $settings['company_address'] ?? '-') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Attendance Tab -->
                                <div class="tab-pane fade" id="attendance" role="tabpanel" aria-labelledby="attendance-tab">
                                    <div class="alert alert-info border-0 shadow-sm rounded-lg">
                                        <i class="fas fa-info-circle mr-2"></i> Pengaturan ini akan mempengaruhi validasi absensi harian pegawai.
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label font-weight-bold">Jam Masuk (Start)</label>
                                        <div class="col-md-3">
                                            <input type="time" name="work_start_time" class="form-control rounded-lg" value="{{ old('work_start_time', $settings['work_start_time'] ?? '08:00') }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label font-weight-bold">Jam Pulang (End)</label>
                                        <div class="col-md-3">
                                            <input type="time" name="work_end_time" class="form-control rounded-lg" value="{{ old('work_end_time', $settings['work_end_time'] ?? '17:00') }}">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label font-weight-bold">Toleransi Keterlambatan</label>
                                        <div class="col-md-3">
                                            <div class="input-group">
                                                <input type="number" name="late_tolerance" class="form-control rounded-left-lg" value="{{ $settings['late_tolerance'] ?? '15' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text rounded-right-lg">Menit</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <h5 class="mb-3 font-weight-bold text-primary">Validasi Lokasi (Geofencing)</h5>
                                    
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label font-weight-bold">Koordinat Kantor</label>
                                        <div class="col-md-6">
                                            <input type="text" name="office_coordinates" class="form-control rounded-lg" value="{{ old('office_coordinates', $settings['office_coordinates'] ?? '-6.200000, 106.816666') }}" placeholder="-6.200000, 106.816666">
                                            <small class="text-muted d-block mt-1">Format: Latitude, Longitude. Gunakan Google Maps untuk mendapatkan titik akurat.</small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label font-weight-bold">Radius Absensi</label>
                                        <div class="col-md-3">
                                           <div class="input-group">
                                                <input type="number" name="attendance_radius" class="form-control rounded-left-lg" value="{{ $settings['attendance_radius'] ?? '100' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text rounded-right-lg">Meter</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                                <!-- Payroll Tab -->
                                <div class="tab-pane fade" id="payroll" role="tabpanel" aria-labelledby="payroll-tab">
                                    <div class="alert alert-warning border-0 shadow-sm rounded-lg">
                                        <i class="fas fa-calculator mr-2"></i> Pengaturan ini digunakan untuk kalkulasi otomatis Gaji & BPJS. Masukkan dalam format persentase (contoh: 4.0).
                                    </div>

                                    <h5 class="mb-3 font-weight-bold text-success">BPJS Kesehatan</h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="font-weight-bold">Ditanggung Perusahaan (%)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="bpjs_kesehatan_perusahaan" class="form-control" value="{{ $settings['bpjs_kesehatan_perusahaan'] ?? '4.0' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="font-weight-bold">Ditanggung Pegawai (%)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="bpjs_kesehatan_pegawai" class="form-control" value="{{ $settings['bpjs_kesehatan_pegawai'] ?? '1.0' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <hr>

                                    <h5 class="mb-3 font-weight-bold text-success">BPJS Ketenagakerjaan</h5>
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="font-weight-bold">Jaminan Hari Tua (JHT) - Perusahaan (%)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="bpjs_jht_perusahaan" class="form-control" value="{{ $settings['bpjs_jht_perusahaan'] ?? '3.7' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="font-weight-bold">Jaminan Hari Tua (JHT) - Pegawai (%)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="bpjs_jht_pegawai" class="form-control" value="{{ $settings['bpjs_jht_pegawai'] ?? '2.0' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="font-weight-bold">Jaminan Kecelakaan Kerja (JKK) - Perusahaan (%)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="bpjs_jkk_perusahaan" class="form-control" value="{{ $settings['bpjs_jkk_perusahaan'] ?? '0.24' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="font-weight-bold">Jaminan Kematian (JKM) - Perusahaan (%)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="bpjs_jkm_perusahaan" class="form-control" value="{{ $settings['bpjs_jkm_perusahaan'] ?? '0.30' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label class="font-weight-bold">Jaminan Pensiun (JP) - Perusahaan (%)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="bpjs_jp_perusahaan" class="form-control" value="{{ $settings['bpjs_jp_perusahaan'] ?? '2.0' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label class="font-weight-bold">Jaminan Pensiun (JP) - Pegawai (%)</label>
                                            <div class="input-group">
                                                <input type="number" step="0.01" name="bpjs_jp_pegawai" class="form-control" value="{{ $settings['bpjs_jp_pegawai'] ?? '1.0' }}">
                                                <div class="input-group-append">
                                                    <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mt-4">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn btn-primary shadow-sm rounded-pill px-4">
                                        <i class="fas fa-save mr-1"></i> Simpan Pengaturan
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
