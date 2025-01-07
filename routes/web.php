<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\UserLoginController;



Route::get('/', function () {
    return view('auth/login');
});

// User routes

// Index.blade
Route::get('/home', function () {
    return view('pages.index');
})->middleware(['auth', 'verified'])->name('home');;


Route::get('/about', function () {
    return view('pages.about');
})->name('about');


Route::get('/contact', function () {
    return view('pages.contact'); // This is the contact.blade.php view
})->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


Route::get('/reservations', function () {
    return view('pages.booking');
})->name('booking');
Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');


// Logout
Route::get('logout', [UserLoginController::class, 'UserLogout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/admin-auth.php';
