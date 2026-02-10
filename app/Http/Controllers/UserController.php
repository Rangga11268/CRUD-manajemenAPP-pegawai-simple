<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $namaUsers = $request->name;
        $users = User::where('name', 'like', '%' . $namaUsers . '%')->orderBy('id', 'asc')->get();
        return view('users.index', compact('users', 'namaUsers'));
    }
    public function create()
    {
        $users = User::all();
        return view('users.create', compact('users'));
    }
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'role' => 'required|in:admin,pegawai',
        ]);
        User::create($validatedData);
        return to_route('users.index')->with('success', 'Data user baru berhasil di tambahkan');
    }
    public function show()
    {
        $users = User::all();
        return view('users.detail', compact('users'));
    }
    public function edit(string $id)
    {
        $users = User::findOrFail($id);
        return view('users.edit', compact('users'));
    }
    public function update(Request $request, string $id)
    {
        $users = User::findOrFail($id);
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,pegawai',
        ]);
        $users->update($validatedData);
        return to_route('users.index')->with('success', 'Data user berhasil di update');
    }
    public function destroy($id)
    {
        $users = User::findOrFail($id);
        $users->delete();
        return to_route('users.index')->with('delete', 'Data user berhasil di delete');
    }
}
