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
        $recentPegawai = Pegawai::orderBy('id', 'desc')->limit(5)->get();
        return view('dashboard', compact('totalPegawai', 'totalJabatan', 'recentPegawai'));
    }
}
