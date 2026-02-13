<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Jabatan;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view pegawai', ['only' => ['index', 'show']]);
        $this->middleware('permission:create pegawai', ['only' => ['create', 'store', 'import']]);
        $this->middleware('permission:edit pegawai', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete pegawai', ['only' => ['destroy']]);
    }

    public function import(Request $request) 
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv',
        ]);
 
        \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\PegawaiImport, $request->file('file'));
 
        return back()->with('success', 'Data Pegawai berhasil diimport!');
    }

    public function index(Request $request)
    {
        $nama_pegawai = $request->nama_pegawai;
        $query = Pegawai::with(['jabatans', 'department']);
        
        if ($nama_pegawai) {
            $query->where('nama_pegawai', 'like', '%' . $nama_pegawai . '%')
                  ->orWhere('nik', 'like', '%' . $nama_pegawai . '%');
        }

        $pegawais = $query->orderBy('created_at', 'desc')->paginate(10);
            
        return view('pegawai.index', compact('pegawais', 'nama_pegawai'));
    }

    public function create()
    {
        $jabatans = Jabatan::all();
        $departments = Department::where('is_active', true)->get();
        $users = User::doesntHave('pegawai')->where('role', 'pegawai')->get();
        
        return view('pegawai.create', compact('jabatans', 'departments', 'users'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pegawai' => 'required|max:255|string',
            'nik' => 'required|numeric|digits:16|unique:pegawais,nik',
            'employee_id' => 'required|string|unique:pegawais,employee_id',
            'email' => 'required|email|unique:pegawais,email',
            'gender' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'alamat' => 'required|max:255',
            'telepon' => 'required',
            'jabatan_id' => 'required|exists:jabatans,id',
            'department_id' => 'required|exists:departments,id',
            'user_id' => 'nullable|exists:users,id|unique:pegawais,user_id',
            'gaji_pokok' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,cuti,resign,pensiun',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            'status_pernikahan' => 'required|in:lajang,menikah,janda/duda',
            'jumlah_tanggungan' => 'required|integer|min:0|max:10',
        ]);

        if ($request->hasFile('image')) {
            $validatedData['image'] = $request->file('image')->store('uploads/pegawai', 'public');
        } else {
            $validatedData['image'] = 'uploads/pegawai/default.png';
        }

        // Add default values if not present in request (though validation requires them, so they are present)
        // $validatedData is already populated with validated fields ONLY if we used $request->validate() result directly.
        // Wait, $validatedData contains ONLY validated fields.
        // So we can just use $validatedData for create if keys match.
        // status_pernikahan and jumlah_tanggungan are in validation, so they are in $validatedData.

        Pegawai::create($validatedData);
        
        return to_route('pegawai.index')->with('success', 'Data pegawai berhasil ditambahkan');
    }

    public function show(string $id)
    {
        $pegawai = Pegawai::with(['jabatans', 'department', 'user'])->findOrFail($id);
        return view('pegawai.show', compact('pegawai'));
    }

    public function edit(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $jabatans = Jabatan::all();
        $departments = Department::where('is_active', true)->get();
        // Allow current user or users without pegawai
        $users = User::where(function($query) use ($pegawai) {
                $query->doesntHave('pegawai')
                      ->orWhere('id', $pegawai->user_id);
            })
            ->where('role', 'pegawai')
            ->get();

        return view('pegawai.edit', compact('pegawai', 'jabatans', 'departments', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $validatedData = $request->validate([
            'nama_pegawai' => 'required|max:255|string',
            'nik' => 'required|numeric|digits:16|unique:pegawais,nik,' . $id,
            'employee_id' => 'required|string|unique:pegawais,employee_id,' . $id,
            'email' => 'required|email|unique:pegawais,email,' . $id,
            'gender' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'tanggal_masuk' => 'required|date',
            'alamat' => 'required|max:255',
            'telepon' => 'required',
            'jabatan_id' => 'required|exists:jabatans,id',
            'department_id' => 'required|exists:departments,id',
            'user_id' => 'nullable|exists:users,id|unique:pegawais,user_id,' . $id,
            'gaji_pokok' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,cuti,resign,pensiun',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
            'status_pernikahan' => 'required|in:lajang,menikah,janda/duda',
            'jumlah_tanggungan' => 'required|integer|min:0|max:10',
        ]);

        if ($request->hasFile('image')) {
            if ($pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png' && Storage::disk('public')->exists($pegawai->image)) {
                Storage::disk('public')->delete($pegawai->image);
            }
            $validatedData['image'] = $request->file('image')->store('uploads/pegawai', 'public');
        }

        $pegawai->update($validatedData);

        return to_route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        if ($pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png' && Storage::disk('public')->exists($pegawai->image)) {
            Storage::disk('public')->delete($pegawai->image);
        }

        $pegawai->delete();
        return to_route('pegawai.index')->with('delete', 'Data pegawai berhasil dihapus');
    }
}
