<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $totalPegawai = Pegawai::count();
        $totalJabatan = Jabatan::count();
        $recentPegawai = Pegawai::with('jabatans')->latest()->take(5)->get();
        $upcomingEvents = \App\Models\CalendarEvent::where('start_date', '>=', now())
            ->orderBy('start_date', 'asc')
            ->take(3)
            ->get();
            
        return view('welcome', compact('totalPegawai', 'totalJabatan', 'recentPegawai', 'upcomingEvents'));
    }

}

