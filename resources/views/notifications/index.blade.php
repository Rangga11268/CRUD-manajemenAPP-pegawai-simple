@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Pusat Notifikasi</h2>
        <form action="{{ route('notifications.markAllAsRead') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-check-double c-icon mr-1"></i> Tandai semua sudah dibaca
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <strong>List Notifikasi</strong>
    </div>
    <div class="card-body">
        <div class="list-group list-group-flush">
            @forelse ($notifications as $notification)
                <a href="{{ isset($notification->data['url']) ? route('notifications.read', $notification->id) : '#' }}" class="list-group-item list-group-item-action flex-column align-items-start {{ $notification->read_at ? 'bg-light' : 'bg-white border-left-primary' }}">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1 {{ $notification->read_at ? 'text-muted' : 'text-primary font-weight-bold' }}">
                            <i class="fas fa-bell c-icon mr-2"></i> {{ $notification->data['message'] ?? 'Notifikasi Baru' }}
                        </h5>
                        <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                    </div>
                </a>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-bell-slash fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Tidak ada notifikasi baru.</p>
                </div>
            @endforelse
        </div>
        
        <div class="mt-3">
            {{ $notifications->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>

<style>
    .border-left-primary {
        border-left: 4px solid #321fdb !important;
    }
</style>
@endsection
