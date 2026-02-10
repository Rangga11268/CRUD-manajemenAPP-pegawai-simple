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
        $leaveBalances = [];
        $recentSalaries = [];

        if (auth()->check() && auth()->user()->hasRole('pegawai') && auth()->user()->pegawai) {
            $pegawaiId = auth()->user()->pegawai->id;

            $todayAttendance = \App\Models\Attendance::where('pegawai_id', $pegawaiId)
                ->where('tanggal', $today)
                ->first();

            // Calculate Leave Balances
            $leaveTypes = \App\Models\LeaveType::all();
            foreach ($leaveTypes as $type) {
                $usedDays = \App\Models\Leave::where('pegawai_id', $pegawaiId)
                    ->where('leave_type_id', $type->id)
                    ->where('status', 'approved')
                    ->whereYear('start_date', date('Y'))
                    ->sum('days_count');
                
                $leaveBalances[] = [
                    'name' => $type->nama,
                    'max' => $type->max_days,
                    'used' => $usedDays,
                    'remaining' => max(0, $type->max_days - $usedDays)
                ];
            }

            // Recent Salaries
            $recentSalaries = \App\Models\Salary::where('pegawai_id', $pegawaiId)
                ->where('status', 'paid')
                ->latest('periode')
                ->take(3)
                ->get();
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
            'upcomingEvents',
            'leaveBalances',
            'recentSalaries'
        ));
    }
}
