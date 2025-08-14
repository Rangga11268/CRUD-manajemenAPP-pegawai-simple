<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\Pegawai;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama_pegawai' => 'required|max:255|string',
            'alamat' => 'required|max:255',
            'telepon' => 'required',
            'jabatan_id' => 'required|numeric|exists:jabatans,id',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif,webp|max:2048',
        ]);

        // upload image
        if ($request->file('image')) {
            $file = $request->file('image');
            $name = $file->hashName();

            Storage::putFileAs('images', $file, $name);

            $request['image'] = $name;
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
        //
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
        //
    }
}
