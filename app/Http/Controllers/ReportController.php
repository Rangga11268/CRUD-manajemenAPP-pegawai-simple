<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PegawaiExport;
use App\Exports\AttendanceExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Department;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view reports', ['only' => ['index', 'getChartData']]);
        $this->middleware('permission:export reports', ['only' => ['exportPegawai', 'exportAttendance']]);
    }

    public function index()
    {
        return view('reports.index');
    }

    public function exportPegawai()
    {
        return Excel::download(new PegawaiExport, 'pegawai.xlsx');
    }

    public function exportAttendance(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        return Excel::download(new AttendanceExport($request->start_date, $request->end_date), 'attendance-'.$request->start_date.'-to-'.$request->end_date.'.xlsx');
    }

    public function getChartData()
    {
        // Department Distribution
        $departments = Department::withCount('pegawais')->get();
        $deptLabels = $departments->pluck('name');
        $deptData = $departments->pluck('pegawais_count');

        // Attendance Trends (Last 7 Days)
        $dates = collect();
        $onTimeData = collect();
        $lateData = collect();

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->format('Y-m-d');
            $dates->push(now()->subDays($i)->format('d M'));
            
            $onTime = Attendance::whereDate('tanggal', $date)
                ->where('status', 'hadir')
                ->whereRaw('clock_in <= "09:00:00"') // Assuming 9 AM is late threshold
                ->count();
                
            $late = Attendance::whereDate('tanggal', $date)
                ->where('status', 'hadir')
                ->whereRaw('clock_in > "09:00:00"')
                ->count();

            $onTimeData->push($onTime);
            $lateData->push($late);
        }

        return response()->json([
            'department' => [
                'labels' => $deptLabels,
                'data' => $deptData,
            ],
            'attendance' => [
                'labels' => $dates,
                'onTime' => $onTimeData,
                'late' => $lateData,
            ]
        ]);
    }
}
