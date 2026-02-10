@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 text-dark font-weight-bold">
                            <i class="fas fa-calendar-alt mr-2 text-primary"></i>Kalender Perusahaan
                        </h5>
                        <button class="btn btn-primary shadow-sm rounded-pill px-3" data-toggle="modal" data-target="#createEventksModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Agenda
                        </button>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="border-top-0 pl-4">Tanggal</th>
                                        <th class="border-top-0">Nama Agenda</th>
                                        <th class="border-top-0">Kategori</th>
                                        <th class="border-top-0">Status Hari Libur</th>
                                        <th class="border-top-0 text-center pr-4">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($events as $event)
                                    <tr>
                                        <td class="pl-4 align-middle">
                                            <span class="font-weight-bold text-dark">{{ $event->start_date->format('d M Y') }}</span>
                                            @if($event->end_date && $event->end_date != $event->start_date)
                                                - {{ $event->end_date->format('d M Y') }}
                                            @endif
                                            <br>
                                            <small class="text-muted">{{ $event->start_date->diffForHumans() }}</small>
                                        </td>
                                        <td class="align-middle">
                                            <div class="font-weight-bold">{{ $event->title }}</div>
                                            @if($event->description)
                                                <small class="text-muted">{{ Str::limit($event->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td class="align-middle">
                                            @php
                                                $badges = [
                                                    'holiday' => 'danger',
                                                    'event' => 'info',
                                                    'cuti_bersama' => 'warning'
                                                ];
                                                $labels = [
                                                    'holiday' => 'Hari Libur Nasional',
                                                    'event' => 'Event Kantor',
                                                    'cuti_bersama' => 'Cuti Bersama'
                                                ];
                                            @endphp
                                            <span class="badge badge-{{ $badges[$event->category] ?? 'secondary' }} px-2 py-1">
                                                {{ $labels[$event->category] ?? ucfirst($event->category) }}
                                            </span>
                                        </td>
                                        <td class="align-middle">
                                            @if($event->is_day_off)
                                                <span class="badge badge-success px-2 py-1"><i class="fas fa-check mr-1"></i> Libur (Off)</span>
                                            @else
                                                <span class="badge badge-secondary px-2 py-1"><i class="fas fa-briefcase mr-1"></i> Masuk (Work)</span>
                                            @endif
                                        </td>
                                        <td class="text-center align-middle pr-4">
                                            <button class="btn btn-sm btn-info text-white shadow-sm rounded-circle mx-1" 
                                                data-toggle="modal" 
                                                data-target="#editEventModal{{ $event->id }}"
                                                title="Edit" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('calendar.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus agenda ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger shadow-sm rounded-circle" title="Hapus" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <!-- Edit Modal remains roughly same relative to table loop, content inside loop -->
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5 text-muted">
                                            <i class="fas fa-calendar-times fa-3x mb-3 opacity-50"></i>
                                            <p class="mb-0">Belum ada agenda perusahaan.</p>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createEventksModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Agenda Baru</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('calendar.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Agenda</label>
                        <input type="text" name="title" class="form-control" required placeholder="Contoh: Rapat Tahunan">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Selesai (Opsional)</label>
                        <input type="date" name="end_date" class="form-control">
                        <small class="text-muted">Biarkan kosong jika hanya 1 hari.</small>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="category" class="form-control">
                            <option value="event">Event Kantor</option>
                            <option value="holiday">Hari Libur Nasional</option>
                            <option value="cuti_bersama">Cuti Bersama</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Detail acara..."></textarea>
                    </div>
                    <div class="form-group form-check">
                        <input type="hidden" name="is_day_off" value="0">
                        <input type="checkbox" class="form-check-input" name="is_day_off" value="1" id="createIsDayOff">
                        <label class="form-check-label" for="createIsDayOff">Liburkan Karyawan (Day Off)</label>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Agenda</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
