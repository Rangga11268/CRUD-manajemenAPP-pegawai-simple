@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Tambah Data Pegawai Baru</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pegawai.index') }}">Pegawai</a></li>
                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
            </ol>
        </nav>
    </div>
</div>

<form action="{{ route('pegawai.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <strong>Foto Profil</strong>
                </div>
                <div class="card-body text-center">
                    <img class="img-thumbnail rounded-circle mb-3" src="https://ui-avatars.com/api/?name=New+Employee&color=7F9CF5&background=EBF4FF" alt="Employee Photo" width="150" height="150">
                    <div class="custom-file">
                        <label class="form-label" for="image">Upload Foto (Max 2MB)</label>
                        <input type="file" class="form-control" id="image" name="image">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Informasi Personal</strong>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="employee_id">NIP / Employee ID</label>
                            <input type="text" class="form-control" id="employee_id" name="employee_id" value="{{ old('employee_id') }}" placeholder="EMP001" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="nik">NIK (KTP)</label>
                            <input type="text" class="form-control" id="nik" name="nik" value="{{ old('nik') }}" placeholder="16 Digit NIK" required minlength="16" maxlength="16">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="nama_pegawai">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama_pegawai" name="nama_pegawai" value="{{ old('nama_pegawai') }}" placeholder="Nama Lengkap" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="email@perusahaan.com" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="gender">Jenis Kelamin</label>
                            <select id="gender" name="gender" class="form-control">
                                <option value="">Pilih</option>
                                <option value="L" {{ old('gender') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="P" {{ old('gender') == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat Domisili</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="3" placeholder="Alamat lengkap...">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="telepon">No. Telepon</label>
                        <input type="text" class="form-control" id="telepon" name="telepon" value="{{ old('telepon') }}" placeholder="0812..." required>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <strong>Informasi Pekerjaan</strong>
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="department_id">Department</label>
                            <select id="department_id" name="department_id" class="form-control">
                                <option value="">Pilih Department</option>
                                @foreach($departments as $dept)
                                    <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>{{ $dept->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="jabatan_id">Jabatan</label>
                            <select id="jabatan_id" name="jabatan_id" class="form-control">
                                <option value="">Pilih Jabatan</option>
                                @foreach($jabatans as $jabatan)
                                    <option value="{{ $jabatan->id }}" {{ old('jabatan_id') == $jabatan->id ? 'selected' : '' }}>{{ $jabatan->nama_jabatan }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="status">Status Kepegawaian</label>
                            <select id="status" name="status" class="form-control">
                                <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="cuti" {{ old('status') == 'cuti' ? 'selected' : '' }}>Cuti</option>
                                <option value="resign" {{ old('status') == 'resign' ? 'selected' : '' }}>Resign</option>
                                <option value="pensiun" {{ old('status') == 'pensiun' ? 'selected' : '' }}>Pensiun</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="{{ old('tanggal_masuk') }}" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="gaji_pokok">Gaji Pokok (Rp)</label>
                            <input type="number" class="form-control" id="gaji_pokok" name="gaji_pokok" value="{{ old('gaji_pokok') }}" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="user_id">Akun Login (User)</label>
                            <select id="user_id" name="user_id" class="form-control">
                                <option value="">-- Tidak Terhubung --</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('pegawai.index') }}" class="btn btn-secondary">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Pegawai</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
