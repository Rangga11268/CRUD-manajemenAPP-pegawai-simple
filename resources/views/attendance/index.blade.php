@extends('layouts.admin')

@section('content')
<div class="row mb-4">
    <div class="col-12 d-flex justify-content-between align-items-center">
        <h2 class="mb-0">Laporan Absensi</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Attendance</li>
            </ol>
        </nav>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 text-dark font-weight-bold">
            <i class="fas fa-clock mr-2 text-primary"></i>Data Absensi
        </h5>
        
        @if(auth()->user()->hasRole('pegawai'))
            <div class="d-flex">
                @if(!$attendances->isNotEmpty() || $attendances->first()->tanggal->format('Y-m-d') != date('Y-m-d') || !$attendances->first()->clock_in)
                <button type="button" class="btn btn-success text-white shadow-sm rounded-pill px-4 mr-2" data-toggle="modal" data-target="#clockInModal">
                    <i class="fas fa-sign-in-alt mr-2"></i> Clock In
                </button>
                @endif
                
                @if($attendances->isNotEmpty() && $attendances->first()->tanggal->format('Y-m-d') == date('Y-m-d') && $attendances->first()->clock_in && !$attendances->first()->clock_out)
                <form action="{{ route('attendance.clock-out') }}" method="POST" id="form-clock-out">
                    @csrf
                    <input type="hidden" name="latitude" id="out_latitude">
                    <input type="hidden" name="longitude" id="out_longitude">
                    <button type="submit" class="btn btn-danger text-white shadow-sm rounded-pill px-4" onclick="clockOut(event)">
                        <i class="fas fa-sign-out-alt mr-2"></i> Clock Out
                    </button>
                </form>
                @endif
            </div>
        @else
            <a href="{{ route('attendance.create') }}" class="btn btn-primary shadow-sm rounded-pill px-3">
                <i class="fas fa-plus-circle mr-1"></i> Input Absensi
            </a>
        @endif
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-light">
                    <tr>
                        <th class="border-top-0 pl-4">Tanggal</th>
                        <th class="border-top-0">Pegawai</th>
                        <th class="border-top-0">Jam Masuk</th>
                        <th class="border-top-0">Jam Pulang</th>
                        <th class="border-top-0">Status</th>
                        <th class="border-top-0">Durasi Kerja</th>
                        @if(!auth()->user()->hasRole('pegawai'))
                        <th class="border-top-0 text-center pr-4" style="width: 120px;">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($attendances as $attendance)
                    <tr>
                        <td class="pl-4 align-middle font-weight-bold">{{ $attendance->tanggal->format('d M Y') }}</td>
                        <td class="align-middle">
                            <div class="font-weight-bold">{{ $attendance->pegawai->nama_pegawai }}</div>
                            <div class="text-muted small">{{ $attendance->pegawai->user->department->name ?? '-' }}</div>
                        </td>
                        <td class="align-middle text-success">{{ $attendance->clock_in ? $attendance->clock_in->format('H:i') : '-' }}</td>
                        <td class="align-middle text-danger">{{ $attendance->clock_out ? $attendance->clock_out->format('H:i') : '-' }}</td>
                        <td class="align-middle">
                             <span class="badge badge-{{ $attendance->status === 'hadir' ? 'success' : ($attendance->status === 'telat' ? 'warning' : 'danger') }} px-2 py-1">
                                {{ ucfirst($attendance->status) }}
                            </span>
                        </td>
                        <td class="align-middle">
                            @if($attendance->clock_in && $attendance->clock_out)
                                @php
                                    $start = \Carbon\Carbon::parse($attendance->clock_in);
                                    $end = \Carbon\Carbon::parse($attendance->clock_out);
                                    $diff = $start->diff($end);
                                @endphp
                                <span class="badge badge-light border">{{ $diff->format('%H Jam %I Menit') }}</span>
                            @else
                                -
                            @endif
                        </td>
                        @if(!auth()->user()->hasRole('pegawai'))
                        <td class="text-center align-middle pr-4">
                            <div class="btn-group" role="group">
                                <a href="{{ route('attendance.edit', $attendance->id) }}" class="btn btn-sm btn-warning text-white shadow-sm rounded-circle mx-1" title="Edit" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('attendance.destroy', $attendance->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data absensi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger shadow-sm rounded-circle" title="Hapus" style="width: 32px; height: 32px; padding: 0; line-height: 32px;">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                        @endif
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="fas fa-clock fa-2x mb-3 opacity-50"></i>
                            <p class="mb-0">Belum ada data absensi.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-3">
            {{ $attendances->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<style>
    #map { height: 250px; width: 100%; border-radius: 8px; }
    #my_camera { width: 100% !important; height: auto !important; border-radius: 8px; overflow: hidden; }
    #my_camera video { width: 100% !important; height: auto !important; object-fit: cover; border-radius: 8px; }
</style>
@endsection

@section('javascript')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.min.js"></script>
<script>
    function clockOut(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Sedang mengambil lokasi...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                document.getElementById('out_latitude').value = position.coords.latitude;
                document.getElementById('out_longitude').value = position.coords.longitude;
                Swal.close();
                document.getElementById('form-clock-out').submit();
            }, function(error) {
                Swal.fire('Error', 'Gagal mendapatkan lokasi: ' + error.message, 'error');
            });
        } else {
            Swal.fire('Error', 'Browser Anda tidak mendukung Geolocation.', 'error');
        }
    }

    // Native Camera Logic variables
    let stream = null;
    const video = document.createElement('video');
    video.autoplay = true;
    video.style.width = '100%';
    video.style.borderRadius = '8px';

    function initWebcam() {
        // Prepare container
        const container = document.getElementById('my_camera');
        container.innerHTML = '';
        container.appendChild(video);

        if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
            navigator.mediaDevices.getUserMedia({ video: true })
            .then(function(s) {
                stream = s;
                video.srcObject = stream;
                // Show capture button when video is playing
                video.onloadedmetadata = function(e) {
                    document.getElementById('btn-capture').style.display = 'inline-block';
                };
            })
            .catch(function(err) {
                console.error("Camera Error: ", err);
                let msg = 'Gagal mengakses kamera.';
                if (err.name === 'NotAllowedError') {
                    msg = 'Akses kamera ditolak. Mohon izinkan akses kamera di browser Anda.';
                } else if (err.name === 'NotFoundError') {
                    msg = 'Tidak ada kamera yang terdeteksi.';
                } else if (window.location.protocol !== 'https:') {
                     msg = 'Browser memblokir kamera di koneksi tidak aman (HTTP). Mohon gunakan HTTPS atau Localhost.';
                }
                
                Swal.fire({
                    icon: 'error',
                    title: 'Error Kamera',
                    text: msg + ' (' + err.name + ')'
                });
            });
        } else {
            Swal.fire('Error', 'Browser Anda tidak mendukung akses kamera.', 'error');
        }
    }

    function checkHttps() {
        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
            Swal.fire({
                icon: 'warning',
                title: 'Perhatian',
                text: 'Akses kamera mungkin diblokir karena Anda tidak menggunakan HTTPS. Silakan gunakan HTTPS atau localhost.',
            });
        }
    }

    // State Variables
    let hasLocation = false;
    let isManual = false;

    function checkReadyToSubmit() {
        const btn = document.getElementById('btn-submit');
        const hasImage = document.getElementById('image').value !== '';
        const locationStatus = document.getElementById('location-status');
        
        if (!hasLocation) {
            btn.disabled = true;
            if(locationStatus) locationStatus.innerHTML = '<span class="text-warning"><i class="fas fa-spinner fa-spin mr-1"></i> Sedang mencari lokasi...</span>';
            return;
        }

        if(locationStatus) locationStatus.innerHTML = '<span class="text-success"><i class="fas fa-check-circle mr-1"></i> Lokasi ditemukan</span>';

        if (isManual) {
            btn.disabled = false;
        } else {
            if (hasImage) {
                btn.disabled = false;
            } else {
                btn.disabled = true;
            }
        }
    }

    // Modal Logic
    $('#clockInModal').on('shown.bs.modal', function () {
        checkHttps();
        // Reset State
        hasLocation = false;
        document.getElementById('btn-submit').disabled = true;
        document.getElementById('location-status').innerHTML = '<span class="text-muted">Menunggu GPS...</span>';
        
        initWebcam();
        initMap();
    });

    $('#clockInModal').on('hidden.bs.modal', function () {
        if (stream) {
            stream.getTracks().forEach(track => track.stop());
        }
        document.getElementById('my_camera').innerHTML = '';
    });

    // Map Logic (Leaflet)
    let map, marker;
    function initMap() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const lat = position.coords.latitude;
                const long = position.coords.longitude;
                
                document.getElementById('latitude').value = lat;
                document.getElementById('longitude').value = long;
                
                hasLocation = true;
                checkReadyToSubmit();

                // Reverse Geocoding
                fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${long}`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('address').value = data.display_name;
                    });

                if(!map) {
                    map = L.map('map').setView([lat, long], 16);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; OpenStreetMap contributors'
                    }).addTo(map);
                    marker = L.marker([lat, long]).addTo(map);
                } else {
                    map.timeout = setTimeout(() => {
                        map.invalidateSize();
                         map.setView([lat, long], 16);
                         marker.setLatLng([lat, long]);
                    }, 200);
                }
            }, function(error) {
                 console.error("Geo Error: ", error);
                 Swal.fire('Gagal', 'Akses lokasi ditolak atau error (' + error.code + '): ' + error.message, 'error');
                 document.getElementById('location-status').innerHTML = '<span class="text-danger"><i class="fas fa-times-circle mr-1"></i> Gagal GPS</span>';
            }, {
                enableHighAccuracy: true,
                timeout: 10000, // Increased timeout
                maximumAge: 0
            });
        }
    }

    function take_snapshot() {
        const canvas = document.createElement('canvas');
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        const ctx = canvas.getContext('2d');
        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);
        
        const data_uri = canvas.toDataURL('image/jpeg');
        
        document.getElementById('image').value = data_uri;
        document.getElementById('results').innerHTML = '<img src="'+data_uri+'" class="img-fluid rounded"/>';
        
        // Hide video, show result
        document.getElementById('my_camera').style.display = 'none';
        document.getElementById('btn-capture').style.display = 'none';
        document.getElementById('btn-retake').style.display = 'inline-block';
        
        checkReadyToSubmit();
    }

    function retake_snapshot() {
        document.getElementById('my_camera').style.display = 'block';
        document.getElementById('results').innerHTML = '';
        
        // Restart stream if needed (simplified here)
        document.getElementById('my_camera').innerHTML = '';
        initWebcam();
        
        document.getElementById('btn-capture').style.display = 'inline-block';
        document.getElementById('btn-retake').style.display = 'none';
        document.getElementById('btn-submit').disabled = true;
        document.getElementById('image').value = '';
    }

    function toggleManualMode() {
        isManual = !isManual;
        const btnManual = document.getElementById('btn-manual');
        const cameraDiv = document.getElementById('my_camera');
        const captureBtn = document.getElementById('btn-capture');
        const manualText = document.getElementById('manual-text');
        
        if (isManual) {
            // Switch to Manual
            if(stream) {
                 stream.getTracks().forEach(track => track.stop());
            }
            cameraDiv.style.display = 'none';
            captureBtn.style.display = 'none';
            manualText.style.display = 'block';
            btnManual.innerHTML = '<i class="fas fa-camera mr-1"></i> Mode Kamera';
            btnManual.classList.remove('btn-secondary');
            btnManual.classList.add('btn-info');
        } else {
            // Switch back to Camera
            cameraDiv.style.display = 'block';
            manualText.style.display = 'none';
            btnManual.innerHTML = '<i class="fas fa-user-slash mr-1"></i> Mode Manual';
            btnManual.classList.remove('btn-info');
            btnManual.classList.add('btn-secondary');
            
            initWebcam(); // Restart camera
        }
        checkReadyToSubmit();
    }
</script>
@endsection

<!-- Clock In Modal -->
<div class="modal fade" id="clockInModal" tabindex="-1" role="dialog" aria-labelledby="clockInModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clockInModalLabel">Absen Masuk (Wajib Selfie)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('attendance.clock-in') }}" method="POST" id="form-clock-in">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">
                    <input type="hidden" name="address" id="address">
                    <input type="hidden" name="image" id="image">

                    <div class="form-group text-center">
                        <label>Ambil Foto Selfie</label>
                        <div id="my_camera" class="bg-light d-flex align-items-center justify-content-center" style="min-height:240px"></div>
                        <div id="results" class="mt-2"></div>
                        <div id="manual-text" class="alert alert-warning mt-2" style="display:none;">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Mode Manual: Foto tidak disertakan.
                        </div>
                    </div>
                    
                    <div class="form-group text-center">
                         <button type="button" class="btn btn-primary btn-sm rounded-pill" id="btn-capture" onClick="take_snapshot()" style="display:none;">
                            <i class="fas fa-camera mr-1"></i> Ambil Foto
                        </button>
                         <button type="button" class="btn btn-warning btn-sm rounded-pill text-white" id="btn-retake" onClick="retake_snapshot()" style="display:none;">
                            <i class="fas fa-redo mr-1"></i> Foto Ulang
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm rounded-pill ml-2" id="btn-manual" onClick="toggleManualMode()">
                            <i class="fas fa-user-slash mr-1"></i> Mode Manual
                        </button>
                    </div>

                    <div class="form-group">
                        <label>Lokasi Anda Saat Ini</label>
                        <div id="map"></div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <div id="location-status" class="small"></div>
                    <div>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success" id="btn-submit" disabled>Absen Masuk</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
