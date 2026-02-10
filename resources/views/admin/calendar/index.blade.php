@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="fade-in">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Kalender Perusahaan</strong>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#createEventksModal">
                            <i class="fas fa-plus mr-1"></i> Tambah Agenda
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-hover datatable">
                                <thead>
                                    <tr>
                                        <th>Tanggal</th>
                                        <th>Nama Agenda</th>
                                        <th>Kategori</th>
                                        <th>Status Hari Libur</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($events as $event)
                                    <tr>
                                        <td>
                                            <span class="font-weight-bold">{{ $event->start_date->format('d M Y') }}</span>
                                            @if($event->end_date && $event->end_date != $event->start_date)
                                                - {{ $event->end_date->format('d M Y') }}
                                            @endif
                                            <br>
                                            <small class="text-muted">{{ $event->start_date->diffForHumans() }}</small>
                                        </td>
                                        <td>
                                            <div class="font-weight-bold">{{ $event->title }}</div>
                                            @if($event->description)
                                                <small class="text-muted">{{ $event->description }}</small>
                                            @endif
                                        </td>
                                        <td>
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
                                            <span class="badge badge-{{ $badges[$event->category] ?? 'secondary' }}">
                                                {{ $labels[$event->category] ?? ucfirst($event->category) }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($event->is_day_off)
                                                <span class="badge badge-success"><i class="fas fa-check mr-1"></i> Libur (Off)</span>
                                            @else
                                                <span class="badge badge-secondary"><i class="fas fa-briefcase mr-1"></i> Masuk (Work)</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-info text-white" 
                                                data-toggle="modal" 
                                                data-target="#editEventModal{{ $event->id }}"
                                                title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('calendar.destroy', $event->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus agenda ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editEventModal{{ $event->id }}" tabindex="-1" role="dialog" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Edit Agenda</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('calendar.update', $event->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label>Nama Agenda</label>
                                                            <input type="text" name="title" class="form-control" value="{{ $event->title }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tanggal Mulai</label>
                                                            <input type="date" name="start_date" class="form-control" value="{{ $event->start_date->format('Y-m-d') }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Tanggal Selesai (Opsional)</label>
                                                            <input type="date" name="end_date" class="form-control" value="{{ $event->end_date ? $event->end_date->format('Y-m-d') : '' }}">
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Kategori</label>
                                                            <select name="category" class="form-control">
                                                                <option value="event" {{ $event->category == 'event' ? 'selected' : '' }}>Event Kantor</option>
                                                                <option value="holiday" {{ $event->category == 'holiday' ? 'selected' : '' }}>Hari Libur Nasional</option>
                                                                <option value="cuti_bersama" {{ $event->category == 'cuti_bersama' ? 'selected' : '' }}>Cuti Bersama</option>
                                                            </select>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Deskripsi</label>
                                                            <textarea name="description" class="form-control" rows="2">{{ $event->description }}</textarea>
                                                        </div>
                                                        <div class="form-group form-check">
                                                            <input type="hidden" name="is_day_off" value="0">
                                                            <input type="checkbox" class="form-check-input" name="is_day_off" value="1" id="editIsDayOff{{ $event->id }}" {{ $event->is_day_off ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="editIsDayOff{{ $event->id }}">Liburkan Karyawan (Day Off)</label>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-5">
                                            <i class="fas fa-calendar-times fa-3x text-muted mb-3 d-block opacity-25"></i>
                                            Belum ada agenda perusahaan.
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
