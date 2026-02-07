<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalaryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->middleware('guest')->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Master Data routes
    Route::resource('/jabatan', JabatanController::class);
    Route::resource('/pegawai', PegawaiController::class);
    Route::resource('/department', DepartmentController::class);
    Route::resource('/users', UserController::class);
    
    // Attendance routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance/clock-in', [AttendanceController::class, 'clockIn'])->name('attendance.clock-in');
    Route::post('/attendance/clock-out', [AttendanceController::class, 'clockOut'])->name('attendance.clock-out');
    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('attendance.report');
    
    // Leave routes
    Route::resource('/leave', LeaveController::class);
    Route::post('/leave/{leave}/approve', [LeaveController::class, 'approve'])->name('leave.approve');
    Route::post('/leave/{leave}/reject', [LeaveController::class, 'reject'])->name('leave.reject');
    
    // Salary routes
    Route::resource('/salary', SalaryController::class);
    Route::get('/salary/{salary}/slip', [SalaryController::class, 'slip'])->name('salary.slip');
});

require __DIR__ . '/auth.php';
