<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class PegawaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $nama_pegawai = $request->nama_pegawai;
        $pegawais = Pegawai::with('jabatans')->latest()->where('nama_pegawai', 'like', '%' . $nama_pegawai . '%')
            ->orderBy('id', 'asc')->paginate(5);
        return view('pegawai.index', compact('pegawais', 'nama_pegawai'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatans = Jabatan::all();
        return view('pegawai.create', compact('jabatans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pegawai' => 'required|max:255|string',
            'alamat' => 'required|max:255',
            'telepon' => 'required',
            'jabatan_id' => 'required|numeric|exists:jabatans,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/pegawai', 'public');
            $validatedData['image'] = $path;
        } else {
            $validatedData['image'] = 'uploads/pegawai/default.png';
        }

        Pegawai::create($validatedData);
        return to_route('pegawai.index')->with('success', 'Data pegawai berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        return view('pegawai.show', compact('pegawai'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $jabatan = Jabatan::all();
        $pegawai = Pegawai::with('jabatans')->findOrFail($id);

        return view('pegawai.edit', compact(['pegawai', 'jabatan']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pegawai = Pegawai::findOrFail($id);

        $validatedData = $request->validate([
            'nama_pegawai' => 'required|max:255|string',
            'alamat' => 'required|max:255',
            'telepon' => 'required',
            'jabatan_id' => 'required|numeric|exists:jabatans,id',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png' && Storage::disk('public')->exists($pegawai->image)) {
                Storage::disk('public')->delete($pegawai->image);
            }

            $path = $request->file('image')->store('uploads/pegawai', 'public');
            $validatedData['image'] = $path;
        }

        $pegawai->update($validatedData);

        return to_route('pegawai.index')->with('success', 'Data pegawai berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $pegawai = Pegawai::findOrFail($id);


        if ($pegawai->image && $pegawai->image !== 'uploads/pegawai/default.png' && Storage::disk('public')->exists($pegawai->image)) {
            Storage::disk('public')->delete($pegawai->image);
        }

        $pegawai->delete();
        return to_route('pegawai.index')->with('delete', 'Data pegawai berhasil di delete');
    }
}
