<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;


Route::get('/', function () { return redirect()->route('login');});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');
    Route::get('/my-attendance', [AttendanceController::class, 'myAttendance'])->name('attendance.my');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('/employees', EmployeeController::class);
        Route::get('/attendance-report', [AttendanceController::class, 'report'])->name('attendance.report');
    });
});