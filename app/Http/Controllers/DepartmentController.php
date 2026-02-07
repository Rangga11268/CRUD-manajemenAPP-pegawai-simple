<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view department', ['only' => ['index', 'show']]);
        $this->middleware('permission:create department', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit department', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete department', ['only' => ['destroy']]);
    }

    public function index(Request $request): View
    {
        $search = $request->search;
        $departments = Department::with('parent')
            ->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('code', 'like', '%' . $search . '%');
            })
            ->orderBy('name')
            ->paginate(10);

        return view('department.index', compact('departments', 'search'));
    }

    public function create(): View
    {
        $parents = Department::whereNull('parent_id')->get();
        return view('department.create', compact('parents'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:departments,code',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:departments,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Department::create($validated);

        return to_route('department.index')->with('success', 'Department berhasil ditambahkan');
    }

    public function show(Department $department): View
    {
        $department->load(['parent', 'children', 'pegawais.jabatans']);
        return view('department.show', compact('department'));
    }

    public function edit(Department $department): View
    {
        $parents = Department::where('id', '!=', $department->id)
            ->whereNull('parent_id')
            ->get();
        return view('department.edit', compact('department', 'parents'));
    }

    public function update(Request $request, Department $department): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:departments,code,' . $department->id,
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:departments,id',
            'is_active' => 'boolean',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $department->update($validated);

        return to_route('department.index')->with('success', 'Department berhasil diperbarui');
    }

    public function destroy(Department $department): RedirectResponse
    {
        if ($department->pegawais()->count() > 0) {
            return to_route('department.index')->with('failed', 'Department tidak dapat dihapus karena masih memiliki pegawai');
        }

        if ($department->children()->count() > 0) {
            return to_route('department.index')->with('failed', 'Department tidak dapat dihapus karena memiliki sub-department');
        }

        $department->delete();

        return to_route('department.index')->with('delete', 'Department berhasil dihapus');
    }
}
