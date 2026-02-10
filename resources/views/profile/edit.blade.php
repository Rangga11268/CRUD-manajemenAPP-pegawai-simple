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
        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="mb-0 font-weight-bold text-primary">
                    <i class="fas fa-user-edit mr-2"></i>{{ __('Profile Information') }}
                </h5>
            </div>
            <div class="card-body pt-0">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card border-0 shadow-sm rounded-lg mb-4">
            <div class="card-header bg-white py-3 border-bottom-0">
                <h5 class="mb-0 font-weight-bold text-warning">
                    <i class="fas fa-key mr-2"></i>{{ __('Update Password') }}
                </h5>
            </div>
            <div class="card-body pt-0">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-lg">
            <div class="card-header bg-danger text-white py-3 rounded-top-lg">
                <h5 class="mb-0 font-weight-bold">
                    <i class="fas fa-exclamation-triangle mr-2"></i>{{ __('Delete Account') }}
                </h5>
            </div>
            <div class="card-body bg-white rounded-bottom-lg border border-danger border-top-0">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
