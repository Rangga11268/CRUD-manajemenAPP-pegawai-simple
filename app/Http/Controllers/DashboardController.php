<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPegawai = Pegawai::count();
        $totalJabatan = Jabatan::count();
        $recentPegawai = Pegawai::with('jabatans')->latest()->take(5)->get();

        $todayAttendance = null;
        if (auth()->check() && auth()->user()->hasRole('pegawai') && auth()->user()->pegawai) {
            $todayAttendance = \App\Models\Attendance::where('pegawai_id', auth()->user()->pegawai->id)
                ->where('tanggal', date('Y-m-d'))
                ->first();
        }

        return view('admin.dashboard', compact('totalPegawai', 'totalJabatan', 'recentPegawai', 'todayAttendance'));
    }
}
