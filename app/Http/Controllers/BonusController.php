<?php

namespace App\Http\Controllers;

use App\Models\Bonus;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BonusController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view salary'); // Re-use salary permission or create new one?
    }

    public function index()
    {
        $bonuses = Bonus::with('pegawai')->latest()->paginate(10);
        return view('bonus.index', compact('bonuses'));
    }

    public function create()
    {
        $pegawais = Pegawai::where('status', 'aktif')->get();
        return view('bonus.create', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pegawai_id' => 'required|exists:pegawais,id',
            'type' => 'required|string',
            'amount' => 'required|numeric|min:0',
            'date_paid' => 'required|date',
        ]);

        Bonus::create($request->all());

        return redirect()->route('bonus.index')->with('success', 'Bonus berhasil ditambahkan.');
    }

    public function generateThr(Request $request)
    {
        // Mass Generate THR
        // Rule: 
        // Masa kerja >= 12 bulan -> 1x Gaji Pokok
        // Masa kerja < 12 bulan -> (Masa kerja / 12) * Gaji Pokok
        // Cut-off date for calculation: Today or request date?

        $date = Carbon::parse($request->date_paid ?? now());
        $pegawais = Pegawai::where('status', 'aktif')->get();
        $count = 0;

        foreach ($pegawais as $pegawai) {
            $joinDate = Carbon::parse($pegawai->tanggal_masuk);
            $tenureMonths = $joinDate->diffInMonths($date); // Full months
            
            // Should verify if diffInMonths counts strictly? 
            // Often THR uses pro-rate if < 1 month? Usually min 1 month.
            // Let's assume > 0 months.

            if ($tenureMonths < 1) continue; 

            $amount = 0;
            if ($tenureMonths >= 12) {
                $amount = $pegawai->gaji_pokok;
            } else {
                $amount = ($tenureMonths / 12) * $pegawai->gaji_pokok;
            }
            
            // Round down to nearest thousands usually?? Or keep precision?
            // Let's keep decimal:2 for now.

            // Check if already created for this year?
            // Simple check: type='THR' and year matches
            $exists = Bonus::where('pegawai_id', $pegawai->id)
                ->where('type', 'THR')
                ->whereYear('date_paid', $date->year)
                ->exists();

            if (!$exists) {
                Bonus::create([
                    'pegawai_id' => $pegawai->id,
                    'type' => 'THR',
                    'amount' => $amount,
                    'date_paid' => $date,
                    'tax_deduction' => 0, // Tax logic for THR is complex (TER applies on TOTAL Gross that month). 
                                          // Usually, THR is paid specifically. 
                                          // We will store it here. 
                                          // If user generates Salary later, they can deciding to "Pull" bonus into Salary Slip or separate slip?
                                          // For now, let's keep it 0 here.
                ]);
                $count++;
            }
        }

        return redirect()->route('bonus.index')->with('success', "Berhasil generate THR untuk $count pegawai.");
    }
    
    public function destroy(Bonus $bonus)
    {
        $bonus->delete();
        return back()->with('success', 'Data bonus berhasil dihapus.');
    }
}
