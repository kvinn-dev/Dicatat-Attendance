<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::with('user')->whereHas('user', function ($q) {
            $q->where('role', 'employee'); // hanya employee
        });

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $employees = $query->paginate(10)->withQueryString();

        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        // buat User dengan role employee
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'employee',
            'password' => bcrypt('password123'), // default password
        ]);

        // buat Employee terkait
        $user->employee()->create([
            'department' => $request->department,
            'position' => $request->position,
            'status' => 'active',
        ]);

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $employee = Employee::with('user')->findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::with('user')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $employee->user->id,
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        // update User
        $employee->user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // update Employee
        $employee->update([
            'department' => $request->department,
            'position' => $request->position,
        ]);

        return redirect()->route('employees.index')->with('success', 'Data karyawan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $employee = Employee::with('user')->findOrFail($id);
        $employee->user->delete(); // otomatis hapus Employee jika FK cascade

        return redirect()->route('employees.index')->with('success', 'Karyawan berhasil dihapus.');
    }
}
