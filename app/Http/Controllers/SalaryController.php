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
        
        // --- BPJS Calculations ---
        $bpjsData = $this->calculateBpjs($gajiPokok);
        $totalPotongan += $bpjsData['total_deduction'];
        // -------------------------

        // --- PPh 21 Calculation (TER) ---
        $grossSalary = $gajiPokok + $totalTunjangan;
        $taxService = new \App\Services\TaxService();
        $pph21 = $taxService->calculatePPh21($pegawai, $grossSalary);

        if ($pph21 > 0) {
            $totalPotongan += $pph21;
        }
        // --------------------------------

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
        
        // Save BPJS Components
        foreach ($bpjsData['components'] as $comp) {
            SalaryComponent::create([
                'salary_id' => $salary->id,
                'nama' => $comp['nama'],
                'type' => 'potongan',
                'jumlah' => $comp['jumlah'],
            ]);
        }

        // Save PPh 21 Component
        if ($pph21 > 0) {
            SalaryComponent::create([
                'salary_id' => $salary->id,
                'nama' => 'PPh 21 (TER)',
                'type' => 'potongan',
                'jumlah' => $pph21,
            ]);
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

    public function edit(Salary $salary)
    {
        $this->authorizeView($salary);
        $salary->load(['pegawai', 'components']);
        return view('salary.edit', compact('salary'));
    }

    public function update(Request $request, Salary $salary)
    {
        $request->validate([
            'tunjangan.*.nama' => 'nullable|string',
            'tunjangan.*.jumlah' => 'nullable|numeric',
            'potongan.*.nama' => 'nullable|string',
            'potongan.*.jumlah' => 'nullable|numeric',
        ]);

        $gajiPokok = $salary->gaji_pokok;
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
        
        // --- BPJS Calculations ---
        $bpjsData = $this->calculateBpjs($gajiPokok);
        $totalPotongan += $bpjsData['total_deduction'];
        // -------------------------

        // --- PPh 21 Calculation (TER) ---
        $grossSalary = $gajiPokok + $totalTunjangan;
        $taxService = new \App\Services\TaxService();
        $pph21 = $taxService->calculatePPh21($salary->pegawai, $grossSalary);

        if ($pph21 > 0) {
            $totalPotongan += $pph21;
        }
        // --------------------------------

        $gajiBersih = $gajiPokok + $totalTunjangan - $totalPotongan;

        $salary->update([
            'total_tunjangan' => $totalTunjangan,
            'total_potongan' => $totalPotongan,
            'gaji_bersih' => $gajiBersih,
        ]);

        // Sync Components (Delete old, create new)
        $salary->components()->delete();

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
        
        // Save BPJS Components
        foreach ($bpjsData['components'] as $comp) {
            SalaryComponent::create([
                'salary_id' => $salary->id,
                'nama' => $comp['nama'],
                'type' => 'potongan',
                'jumlah' => $comp['jumlah'],
            ]);
        }

        // Save PPh 21 Component
        if ($pph21 > 0) {
            SalaryComponent::create([
                'salary_id' => $salary->id,
                'nama' => 'PPh 21 (TER)',
                'type' => 'potongan',
                'jumlah' => $pph21,
            ]);
        }

        return redirect()->route('salary.index')->with('success', 'Gaji berhasil diperbarui.');
    }

    public function destroy(Salary $salary)
    {
        // Optional: Check permission or role
        if (!Auth::user()->isAdmin() && !Auth::user()->isHR()) {
            abort(403);
        }

        $salary->components()->delete();
        $salary->delete();

        return redirect()->route('salary.index')->with('delete', 'Data gaji berhasil dihapus.');
    }

    private function authorizeView(Salary $salary)
    {
        $user = Auth::user();
        if ($user->hasRole('pegawai') && $salary->pegawai_id !== $user->pegawai->id) {
            abort(403);
        }
    }

    public function showBulkForm()
    {
        return view('salary.bulk');
    }

    public function generateBulk(Request $request)
    {
        $request->validate([
            'periode' => 'required|date_format:Y-m',
            'tanggal_bayar' => 'required|date',
        ]);

        $pegawais = Pegawai::where('status', 'aktif')->get();
        $count = 0;

        foreach ($pegawais as $pegawai) {
            // Check existence
            $exists = Salary::where('pegawai_id', $pegawai->id)
                ->where('periode', $request->periode)
                ->exists();
            
            if ($exists) continue;

            // Basic Vars
            $gajiPokok = $pegawai->gaji_pokok;
            $totalTunjangan = 0;
            $totalPotongan = 0;
            
            // --- BPJS Calculations ---
            $bpjsData = $this->calculateBpjs($gajiPokok);
            $totalPotongan += $bpjsData['total_deduction'];
            // -------------------------

            // --- PPh 21 Calculation (TER) ---
            $grossSalary = $gajiPokok + $totalTunjangan;
            $taxService = new \App\Services\TaxService();
            $pph21 = $taxService->calculatePPh21($pegawai, $grossSalary);
            if ($pph21 > 0) $totalPotongan += $pph21;
            // --------------------------------

            $gajiBersih = $gajiPokok + $totalTunjangan - $totalPotongan;

            $salary = Salary::create([
                'pegawai_id' => $pegawai->id,
                'periode' => $request->periode,
                'gaji_pokok' => $gajiPokok,
                'total_tunjangan' => $totalTunjangan,
                'total_potongan' => $totalPotongan,
                'gaji_bersih' => $gajiBersih,
                'status' => 'processed',
                'tanggal_bayar' => $request->tanggal_bayar,
            ]);

            // Save BPJS Components
            foreach ($bpjsData['components'] as $comp) {
                SalaryComponent::create([
                    'salary_id' => $salary->id,
                    'nama' => $comp['nama'],
                    'type' => 'potongan',
                    'jumlah' => $comp['jumlah'],
                ]);
            }

            // Save PPh 21
            if ($pph21 > 0) {
                SalaryComponent::create([
                    'salary_id' => $salary->id,
                    'nama' => 'PPh 21 (TER)',
                    'type' => 'potongan',
                    'jumlah' => $pph21,
                ]);
            }

            // Notify Pegawai
            if ($pegawai->user) {
                 $pegawai->user->notify(new \App\Notifications\SalarySlipGenerated($salary));
            }

            $count++;
        }

        return redirect()->route('salary.index')->with('success', "Berhasil generate gaji untuk $count pegawai.");
    }

    public function export(Request $request)
    {
        return \Maatwebsite\Excel\Facades\Excel::download(new \App\Exports\SalaryExport($request->periode, $request->department_id), 'salary_report.xlsx');
    }

    /**
     * Calculate BPJS Deductions (Employee Share)
     */
    private function calculateBpjs($gajiPokok)
    {
        $settings = \App\Models\Setting::all()->pluck('value', 'key');
        
        $bpjsKesRate = $settings['bpjs_kesehatan_pegawai'] ?? 1.0;
        $jhtRate = $settings['bpjs_jht_pegawai'] ?? 2.0;
        $jpRate = $settings['bpjs_jp_pegawai'] ?? 1.0;

        $bpjsKes = $gajiPokok * ($bpjsKesRate / 100);
        $jht = $gajiPokok * ($jhtRate / 100);
        $jp = $gajiPokok * ($jpRate / 100);

        return [
            'total_deduction' => $bpjsKes + $jht + $jp,
            'components' => [
                ['nama' => 'BPJS Kesehatan (' . $bpjsKesRate . '%)', 'jumlah' => $bpjsKes],
                ['nama' => 'BPJS TK - JHT (' . $jhtRate . '%)', 'jumlah' => $jht],
                ['nama' => 'BPJS TK - JP (' . $jpRate . '%)', 'jumlah' => $jp],
            ]
        ];
    }
}
