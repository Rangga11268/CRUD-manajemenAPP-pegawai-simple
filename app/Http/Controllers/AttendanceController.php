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

        Attendance::create([
            'pegawai_id' => $pegawai->id,
            'tanggal' => $today,
            'clock_in' => Carbon::now()->format('H:i:s'),
            'status' => 'hadir',
            'clock_in_location' => $request->location // Optional: if implemented later
        ]);

        return back()->with('success', 'Berhasil Absen Masuk pada ' . Carbon::now()->format('H:i'));
    }

    public function clockOut(Request $request)
    {
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
            'clock_out_location' => $request->location // Optional
        ]);

        return back()->with('success', 'Berhasil Absen Pulang pada ' . Carbon::now()->format('H:i'));
    }
    
    public function report()
    {
         // Placeholder for report view
         return view('attendance.report');
    }
}
