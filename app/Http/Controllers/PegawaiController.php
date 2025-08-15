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
    public function index()
    {
        $pegawais = Pegawai::with('jabatans')->latest()->orderBy('created_at', 'desc')->get();
        return view('pegawai.index', compact('pegawais'));
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
    public function store(Request $request, Pegawai $pegawai)
    {
        $validatedData = $request->validate([
            'nama_pegawai' => 'required|max:255|string',
            'alamat' => 'required|max:255',
            'telepon' => 'required',
            'jabatan_id' => 'required|numeric|exists:jabatans,id',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
        ]);

        // upload image
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('uploads/pegawai', 'public');
            $validatedData['image'] = $path;
        }


        Pegawai::create($validatedData);
        return to_route('pegawai.index')->with('success', 'Data pegawai berhasil di tambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $pegawai = Pegawai::findOrFail($id);
        $imagePath = public_path('uploads/pegawai/' . $pegawai->image);
        if (!empty($pegawai->image) && File::exists($imagePath)) {
            File::delete($imagePath);
        }
        $pegawai->delete();
        return to_route('pegawai.index')->with('delete', 'Data pegawai berhasil di delete');
    }
}
