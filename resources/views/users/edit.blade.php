@extends('layouts.admin')

@section('content')
    <div class="row mb-4">
        <div class="col-12 d-flex justify-content-between align-items-center">
            <h2 class="mb-0">Edit User: {{ $users->name }}</h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-lg">
        <div class="card-header bg-white py-3">
             <h5 class="mb-0 font-weight-bold text-primary">Form Edit User</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('users.update', $users->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="name" class="font-weight-bold">Nama Lengkap</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $users->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="font-weight-bold">Email</label>
                            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $users->email) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="role" class="font-weight-bold">Role Akses</label>
                            <select id="role" name="role" class="form-control">
                                <option value="admin" {{ old('role', $users->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="pegawai" {{ old('role', $users->role) == 'pegawai' ? 'selected' : '' }}>Pegawai</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="fas fa-info-circle mr-2"></i> Password tidak dapat diubah dari halaman ini. Gunakan fitur Reset Password atau minta user mengubahnya dari profil mereka.
                </div>

                <div class="text-right mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-secondary rounded-pill px-4 mr-2">Batal</a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">Update User</button>
                </div>
            </form>
        </div>
    </div>
@endsection
