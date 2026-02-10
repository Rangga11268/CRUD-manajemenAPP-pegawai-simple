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
        $totalDepartment = \App\Models\Department::count();
        
        $today = date('Y-m-d');
        $todayAttendanceCount = \App\Models\Attendance::where('tanggal', $today)->whereIn('status', ['hadir', 'telat'])->count();
        $todayLateCount = \App\Models\Attendance::where('tanggal', $today)->where('status', 'telat')->count();
        
        $todayLeavesCount = \App\Models\Leave::where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->count();
            
        $pendingLeavesCount = \App\Models\Leave::where('status', 'pending')->count();

        $recentPegawai = Pegawai::with('jabatans')->latest()->take(5)->get();
        
        $upcomingEvents = \App\Models\CalendarEvent::where('start_date', '>=', $today)
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();

        $todayAttendance = null;
        if (auth()->check() && auth()->user()->hasRole('pegawai') && auth()->user()->pegawai) {
            $todayAttendance = \App\Models\Attendance::where('pegawai_id', auth()->user()->pegawai->id)
                ->where('tanggal', $today)
                ->first();
        }

        return view('admin.dashboard', compact(
            'totalPegawai', 
            'totalJabatan', 
            'totalDepartment',
            'recentPegawai', 
            'todayAttendance',
            'todayAttendanceCount',
            'todayLateCount',
            'todayLeavesCount',
            'pendingLeavesCount',
            'upcomingEvents'
        ));
    }
}
