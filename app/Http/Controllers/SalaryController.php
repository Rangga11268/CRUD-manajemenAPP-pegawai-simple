<?php

namespace App\Http\Controllers;

use App\Models\Pegawai;
use App\Models\Salary;
use App\Models\SalaryComponent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF; // Alias for Barryvdh\DomPDF\Facade\Pdf

class SalaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view salary', ['only' => ['index', 'show']]);
        $this->middleware('permission:create salary', ['only' => ['create', 'store']]);
        $this->middleware('permission:view all salary', ['only' => ['report']]);
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Salary::with('pegawai');

        if ($user->hasRole('pegawai')) {
            $query->where('pegawai_id', $user->pegawai->id);
            // Pegawai can only see processed or paid slips
            $query->whereIn('status', ['processed', 'paid']);
        }

        if ($request->periode) {
            $query->where('periode', $request->periode);
        }

        $salaries = $query->latest('periode')->paginate(10);

        return view('salary.index', compact('salaries'));
    }

    public function create()
    {
        $pegawais = Pegawai::where('status', 'aktif')->get();
        return view('salary.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'periode' => 'required|date_format:Y-m',
            'tunjangan.*.nama' => 'nullable|string',
            'tunjangan.*.jumlah' => 'nullable|numeric',
            'potongan.*.nama' => 'nullable|string',
            'potongan.*.jumlah' => 'nullable|numeric',
        ]);

        // Check if salary already exists for this period
        $exists = Salary::where('pegawai_id', $request->pegawai_id)
            ->where('periode', $request->periode)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Gaji untuk periode ini sudah dibuat.');
        }

        $pegawai = Pegawai::findOrFail($request->pegawai_id);
        
        // Basic Calculation
        $gajiPokok = $pegawai->gaji_pokok;
        $totalTunjangan = 0;
        $totalPotongan = 0;

        // Calculate dynamic components
        if ($request->tunjangan) {
            foreach ($request->tunjangan as $t) {
                if ($t['jumlah'] > 0) $totalTunjangan += $t['jumlah'];
            }
        }
        
        if ($request->potongan) {
            foreach ($request->potongan as $p) {
                if ($p['jumlah'] > 0) $totalPotongan += $p['jumlah'];
            }
        }

        $gajiBersih = $gajiPokok + $totalTunjangan - $totalPotongan;

        $salary = Salary::create([
            'pegawai_id' => $pegawai->id,
            'periode' => $request->periode,
            'gaji_pokok' => $gajiPokok,
            'total_tunjangan' => $totalTunjangan,
            'total_potongan' => $totalPotongan,
            'gaji_bersih' => $gajiBersih,
            'status' => 'processed', // Auto processed for now
            'tanggal_bayar' => now(),
        ]);

        // Save Components
        if ($request->tunjangan) {
            foreach ($request->tunjangan as $t) {
                if ($t['jumlah'] > 0) {
                    SalaryComponent::create([
                        'salary_id' => $salary->id,
                        'nama' => $t['nama'],
                        'type' => 'tunjangan',
                        'jumlah' => $t['jumlah'],
                    ]);
                }
            }
        }

        if ($request->potongan) {
            foreach ($request->potongan as $p) {
                if ($p['jumlah'] > 0) {
                    SalaryComponent::create([
                        'salary_id' => $salary->id,
                        'nama' => $p['nama'],
                        'type' => 'potongan',
                        'jumlah' => $p['jumlah'],
                    ]);
                }
            }
        }

        // Notify Pegawai
        $salary->pegawai->user->notify(new \App\Notifications\SalarySlipGenerated($salary));

        return redirect()->route('salary.index')->with('success', 'Gaji berhasil digenerate.');
    }

    public function show(Salary $salary)
    {
        $this->authorizeView($salary);
        $salary->load(['pegawai', 'components']);
        return view('salary.show', compact('salary'));
    }

    public function slip(Salary $salary)
    {
        $this->authorizeView($salary);
        $salary->load(['pegawai.department', 'pegawai.jabatans', 'components']);
        
        $pdf = PDF::loadView('pdf.slip-gaji', compact('salary'));
        return $pdf->download('Slip-Gaji-'.$salary->pegawai->nama_pegawai.'-'.$salary->periode.'.pdf');
    }

    private function authorizeView(Salary $salary)
    {
        $user = Auth::user();
        if ($user->hasRole('pegawai') && $salary->pegawai_id !== $user->pegawai->id) {
            abort(403);
        }
    }
}
