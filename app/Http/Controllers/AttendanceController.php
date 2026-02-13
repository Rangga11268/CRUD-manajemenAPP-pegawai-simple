<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view attendance', ['only' => ['index']]);
        $this->middleware('permission:create attendance', ['only' => ['clockIn', 'clockOut']]);
        $this->middleware('permission:view all attendance', ['only' => ['report']]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Attendance::with('pegawai');

        if ($user->hasRole('pegawai')) {
            $pegawai = $user->pegawai;
            if (!$pegawai) {
                return redirect()->route('dashboard')->with('error', 'Data Pegawai tidak ditemukan untuk user ini.');
            }
            $query->where('pegawai_id', $pegawai->id);
        }

        if ($request->date) {
            $query->where('tanggal', $request->date);
        }

        $attendances = $query->latest('tanggal')->latest('clock_in')->paginate(10);

        return view('attendance.index', compact('attendances'));
    }

    public function clockIn(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'nullable', // Base64 image (Optional for Manual Mode)
        ]);

        $user = Auth::user();
        $pegawai = $user->pegawai;

        if (!$pegawai) {
            return back()->with('error', 'Data Pegawai tidak ditemukan.');
        }

        $today = Carbon::today()->format('Y-m-d');
        $existing = Attendance::where('pegawai_id', $pegawai->id)
            ->where('tanggal', $today)
            ->first();

        if ($existing) {
            return back()->with('error', 'Anda sudah melakukan absen masuk hari ini.');
        }

        // --- GEOFENCING VALIDATION ---
        $officeCoords = \App\Models\Setting::where('key', 'office_coordinates')->value('value');
        $allowedRadius = \App\Models\Setting::where('key', 'attendance_radius')->value('value') ?? 100;

        if ($officeCoords) {
            [$officeLat, $officeLong] = explode(',', $officeCoords);
            $officeLat = trim($officeLat);
            $officeLong = trim($officeLong);

            $distance = $this->calculateDistance($request->latitude, $request->longitude, $officeLat, $officeLong);

            if ($distance > $allowedRadius) {
                return back()->with('error', 'Anda berada di luar radius kantor! Jarak Anda: ' . round($distance) . ' meter. Batas: ' . $allowedRadius . ' meter.');
            }
        }
        // -----------------------------

        // Handle Image Upload
        $imagePath = null;
        if ($request->image) {
            $image = $request->image;  // your base64 encoded
            $image = str_replace('data:image/jpeg;base64,', '', $image);
            $image = str_replace(' ', '+', $image);
            $imageName = 'attendance_' . $pegawai->id . '_' . time() . '.jpg';
            
            $path = storage_path('app/public/uploads/attendance');
            if (!file_exists($path)) {
                mkdir($path, 0777, true);
            }
            
            \File::put($path . '/' . $imageName, base64_decode($image));
            $imagePath = 'uploads/attendance/' . $imageName;
        }

        Attendance::create([
            'pegawai_id' => $pegawai->id,
            'tanggal' => $today,
            'clock_in' => Carbon::now()->format('H:i:s'),
            'status' => 'hadir',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'address' => $request->address, // From reverse geocoding frontend
            'image_path' => $imagePath,
            'clock_in_location' => $request->latitude . ',' . $request->longitude // Legacy support
        ]);

        return back()->with('success', 'Berhasil Absen Masuk pada ' . Carbon::now()->format('H:i'));
    }

    public function clockOut(Request $request)
    {
        $request->validate([
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $user = Auth::user();
        $pegawai = $user->pegawai;

        if (!$pegawai) {
            return back()->with('error', 'Data Pegawai tidak ditemukan.');
        }

        $today = Carbon::today()->format('Y-m-d');
        $attendance = Attendance::where('pegawai_id', $pegawai->id)
            ->where('tanggal', $today)
            ->first();

        if (!$attendance) {
            return back()->with('error', 'Anda belum melakukan absen masuk hari ini.');
        }

        if ($attendance->clock_out) {
            return back()->with('error', 'Anda sudah melakukan absen pulang hari ini.');
        }

        $attendance->update([
            'clock_out' => Carbon::now()->format('H:i:s'),
            'clock_out_location' => $request->latitude . ',' . $request->longitude, // Legacy
            // Note: We only capture location on clock out, photo is usually only for clock in
        ]);

        return back()->with('success', 'Berhasil Absen Pulang pada ' . Carbon::now()->format('H:i'));
    }
    
    public function create()
    {
        $pegawais = Pegawai::orderBy('nama_pegawai')->get();
        return view('attendance.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'tanggal' => 'required|date',
            'clock_in' => 'required',
            'clock_out' => 'nullable|after:clock_in',
            'status' => 'required|in:hadir,sakit,izin,alpa,telat',
        ]);

        // Check for existing attendance
        $exists = Attendance::where('pegawai_id', $request->pegawai_id)
            ->where('tanggal', $request->tanggal)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Absensi untuk pegawai ini pada tanggal tersebut sudah ada.');
        }

        Attendance::create($request->all());

        return redirect()->route('attendance.index')->with('success', 'Data absensi berhasil ditambahkan.');
    }

    public function edit(Attendance $attendance)
    {
        $pegawais = Pegawai::orderBy('nama_pegawai')->get();
        return view('attendance.edit', compact('attendance', 'pegawais'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'tanggal' => 'required|date',
            'clock_in' => 'required',
            'clock_out' => 'nullable|after:clock_in',
            'status' => 'required|in:hadir,sakit,izin,alpa,telat',
        ]);

        $attendance->update($request->all());

        return redirect()->route('attendance.index')->with('success', 'Data absensi berhasil diperbarui.');
    }

    public function destroy(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendance.index')->with('delete', 'Data absensi berhasil dihapus.');
    }

    public function report()
    {
         // Placeholder for report view
         return view('attendance.report');
    }

    private function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371000; // meters

        $lat1 = deg2rad($lat1);
        $lon1 = deg2rad($lon1);
        $lat2 = deg2rad($lat2);
        $lon2 = deg2rad($lon2);

        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        $a = sin($dLat / 2) * sin($dLat / 2) +
             cos($lat1) * cos($lat2) *
             sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
