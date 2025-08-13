<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;

class JabatanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jabatans = Jabatan::orderBy('created_at', 'desc')->get();
        return view('jabatan.index', compact('jabatans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jabatan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_jabatan' => 'required|max:100',
            'deskripsi_jabatan' => 'required|max:100',
        ]);

        Jabatan::create($request->all());
        return to_route('jabatan.index')->with('success', 'Data jabatan berhasil di tambahkan');
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
        $jabatan = Jabatan::findOrFail($id);
        return view('jabatan.edit', compact('jabatan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_jabatan' => 'required|max:100',
            'deskripsi_jabatan' => 'required|max:100',
        ]);

        $jabatan = Jabatan::findOrFail($id);
        $jabatan->update($request->all());
        return to_route('jabatan.index', compact('jabatan'))->with('success', 'Data jabatan berhasil di update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Jabatan::findOrFail($id)->delete();
        return to_route('jabatan.index')->with('delete', 'Data jabatan berhasil di delete');
    }
}
