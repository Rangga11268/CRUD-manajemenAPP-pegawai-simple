@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Profile</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Profile</li>
            </ol>
        </nav>
    </div>
</div>

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white font-weight-bold py-3">
                <i class="fas fa-user-edit mr-2 text-primary"></i> {{ __('Profile Information') }}
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-white font-weight-bold py-3">
                <i class="fas fa-key mr-2 text-warning"></i> {{ __('Update Password') }}
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="card border-danger shadow-sm">
            <div class="card-header bg-danger text-white font-weight-bold py-3">
                <i class="fas fa-exclamation-triangle mr-2"></i> {{ __('Delete Account') }}
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
