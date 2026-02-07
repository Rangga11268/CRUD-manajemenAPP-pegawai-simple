<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view leave', ['only' => ['index', 'show']]);
        $this->middleware('permission:create leave', ['only' => ['create', 'store']]);
        $this->middleware('permission:approve leave', ['only' => ['approve', 'reject']]);
    }

    public function index()
    {
        $user = Auth::user();
        $query = Leave::with(['pegawai', 'leaveType', 'approver']);

        if ($user->hasRole('pegawai')) {
            $query->where('pegawai_id', $user->pegawai->id);
        }

        $leaves = $query->latest()->paginate(10);

        return view('leave.index', compact('leaves'));
    }

    public function create()
    {
        $leaveTypes = LeaveType::all();
        return view('leave.create', compact('leaveTypes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after_or_equal:start_date',
            'alasan' => 'required|string|max:255',
        ]);

        $start = \Carbon\Carbon::parse($request->start_date);
        $end = \Carbon\Carbon::parse($request->end_date);
        $days_count = $start->diffInDays($end) + 1;

        $leave = Leave::create([
            'pegawai_id' => Auth::user()->pegawai->id,
            'leave_type_id' => $request->leave_type_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'days_count' => $days_count,
            'alasan' => $request->alasan,
            'status' => 'pending',
        ]);

        // Notify HR and Managers
        $managers = \App\Models\User::permission('approve leave')->get();
        \Illuminate\Support\Facades\Notification::send($managers, new \App\Notifications\NewLeaveRequest($leave));

        return redirect()->route('leave.index')->with('success', 'Pengajuan cuti berhasil dibuat.');
    }

    public function approve(Leave $leave)
    {
        $leave->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Notify Pegawai
        $leave->pegawai->user->notify(new \App\Notifications\LeaveStatusUpdated($leave));

        return back()->with('success', 'Pengajuan cuti disetujui.');
    }

    public function reject(Request $request, Leave $leave)
    {
        $request->validate([
            'rejection_reason' => 'required|string',
        ]);

        $leave->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Notify Pegawai
        $leave->pegawai->user->notify(new \App\Notifications\LeaveStatusUpdated($leave));

        return back()->with('success', 'Pengajuan cuti ditolak.');
    }
}
