<?php

use App\Http\Controllers\Admin\Auth\AdminLoginController;
use App\Http\Controllers\Admin\Auth\AdminRegisterController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('guest:admin')->group(function () {
    Route::get('register', [AdminRegisterController::class, 'create'])
        ->name('admin.register');
    Route::post('register', [AdminRegisterController::class, 'store']);

    Route::get('login', [AdminLoginController::class, 'create'])
        ->name('admin.login');
    Route::post('login', [AdminLoginController::class, 'store']);
});

Route::prefix('admin')->middleware('auth:admin')->group(function () {

    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.pages.dashboard');
    })->name('admin.pages.dashboard');

    // Tabs
    Route::get('/appointment-calendar', [AdminController::class, 'appointmentCalendar'])->name('admin.pages.appointment_calendar');
    Route::get('/pending-appointments', [AdminController::class, 'pendingAppointments'])->name('admin.pages.pending_appointments');
    Route::get('/walk-in-appointments', [AdminController::class, 'walkInAppointments'])->name('admin.pages.walk_in_appointments');
    Route::get('/account', [AdminController::class, 'account'])->name('admin.pages.account');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Logout
    // Route::post('logout', [AdminLoginController::class, 'destroy'])
    //     ->name('admin.logout');
    Route::get('admin/logout', [AdminLoginController::class, 'AdminLogout'])->name('admin.logout');
});
