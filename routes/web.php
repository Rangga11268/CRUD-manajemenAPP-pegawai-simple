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
use App\Http\Controllers\ReportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

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

    // Salary routes
    Route::get('/salary', [SalaryController::class, 'index'])->name('salary.index');
    Route::get('/salary/create', [SalaryController::class, 'create'])->name('salary.create');
    Route::post('/salary', [SalaryController::class, 'store'])->name('salary.store');
    Route::get('/salary/{salary}', [SalaryController::class, 'show'])->name('salary.show');
    Route::get('/salary/{salary}/slip', [SalaryController::class, 'slip'])->name('salary.slip');
    
    // Leave routes
    Route::resource('/leave', LeaveController::class);
    Route::post('/leave/{leave}/approve', [LeaveController::class, 'approve'])->name('leave.approve');
    Route::post('/leave/{leave}/reject', [LeaveController::class, 'reject'])->name('leave.reject');
    
    // Report routes
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/chart-data', [ReportController::class, 'getChartData'])->name('reports.chart-data');
    Route::get('/reports/export/pegawai', [ReportController::class, 'exportPegawai'])->name('reports.export.pegawai');
    Route::get('/reports/export/attendance', [ReportController::class, 'exportAttendance'])->name('reports.export.attendance');

    // Notification routes
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
});

require __DIR__ . '/auth.php';
