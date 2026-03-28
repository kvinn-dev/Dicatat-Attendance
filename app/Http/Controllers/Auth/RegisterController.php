<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // nanti kita buat file view ini
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required|in:admin,employee',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            if ($request->role === 'employee') {
                $lastEmployee = Employee::latest('id')->first();
                $nextNumber = $lastEmployee ? ((int) substr($lastEmployee->employee_id, 4)) + 1 : 1;
                $employeeId = 'EMP-' . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

                $employee = new Employee();
                $employee->user_id = $user->id;
                $employee->employee_id = $employeeId;
                $employee->department = '-';
                $employee->position = '-';
                $employee->status = 'active';
                $employee->save();
            }

            DB::commit();
            return redirect()->route('login')->with('success', 'Akun berhasil dibuat, silakan login.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem, karyawan gagal ditambahkan.');
        }
    }
}
