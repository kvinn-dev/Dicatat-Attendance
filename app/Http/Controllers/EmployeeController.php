<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'password' => 'required|string|min:8|confirmed',
            'department' => 'nullable|string|max:255',
            'position' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah digunakan, silakan gunakan email lain.',
            'password.required' => 'Password wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        try {
            DB::beginTransaction(); // Mulai transaksi DB

            // buat User dengan role employee
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'role' => 'employee',
                'password' => bcrypt($request->password), // password dari input admin
            ]);

            $lastEmployee = Employee::latest('id')->first();

            $nextNumber = $lastEmployee
                ? ((int) substr($lastEmployee->employee_id, 4)) + 1
                : 1;

            $employeeId = 'EMP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            $user->employee()->create([
                'employee_id' => $employeeId,
                'department' => $request->department,
                'position' => $request->position,
                'status' => 'active',
            ]);

            // Kirim notifikasi peringatan ganti password ke karyawan baru
            \App\Models\Notification::create([
                'user_id' => $user->id,
                'title' => 'Peringatan Keamanan',
                'content' => 'Selamat datang! Admin telah membuatkan akun untuk Anda. Demi keamanan, mohon segera ubah kata sandi Anda di menu Pengaturan Profil.',
            ]);

            DB::commit(); // Simpan permanen jika semua operasi sukses
            return redirect()->route('employees.index')->with('success', 'Karyawan berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua insert jika ada yang error
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem, karyawan gagal ditambahkan.');
        }
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
            'status' => 'required|in:active,inactive',
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
            'status' => $request->status,
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
