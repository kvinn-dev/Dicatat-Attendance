<?php

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\SettingsController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'password'])->name('profile.password');

    Route::post('/attendance/check-in', [AttendanceController::class, 'checkIn'])->name('attendance.checkIn');
    Route::post('/attendance/check-out', [AttendanceController::class, 'checkOut'])->name('attendance.checkOut');
    Route::get('/my-attendance', [AttendanceController::class, 'myAttendance'])->name('attendance.my');

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::middleware([RoleMiddleware::class . ':admin'])->group(function () {
        Route::resource('/employees', EmployeeController::class);
        Route::get('/attendances-index', [AttendanceController::class, 'index'])->name('attendances.index');
        Route::patch('/leave/{id}', [LeaveController::class, 'update'])->name('leave.update');
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('/leave', [LeaveController::class, 'index'])->name('leave.index');
        Route::post('/leave', [LeaveController::class, 'store'])->name('leave.store');
    });

    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    Route::get('/settings/system-setting', [SettingsController::class, 'system_setting'])->name('settings.system_setting');
    Route::get('/settings/notification', [SettingsController::class, 'notiication'])->name('settings.notification');
});
