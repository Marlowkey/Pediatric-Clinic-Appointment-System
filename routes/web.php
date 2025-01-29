<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AvailableTimeController;
use App\Http\Controllers\Auth\UserLoginController;
use App\Http\Controllers\Auth\UserRegisterController;



Route::get('/', function () {
    return view('auth/login');
});


Route::get('/home', [HomeController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('home');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');


Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

Route::get('logout', [UserLoginController::class, 'UserLogout'])->name('logout');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
Route::get('/my-reservations', [ReservationController::class, 'getMyReservations'])->name('reservations.my_reservations');
Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
Route::get('/reservations/pending', [ReservationController::class, 'pendingAppointments'])->name('reservations.pending');
Route::get('/reservations/completed', [ReservationController::class, 'completedAppointments'])
    ->name('reservations.completed');
Route::get('/reservations/book', [ReservationController::class, 'bookReservations'])->name('reservations.book');
Route::patch('/reservations/{id}/status', [ReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
Route::patch('/reservations/{id}/update', [ReservationController::class, 'updateSchedule'])->name('reservations.updateSchedule');
Route::patch('/reservations/{id}/update-details', [ReservationController::class, 'update'])->name('reservations.update');
Route::delete('reservations/{id}', [ReservationController::class, 'destroy'])->name('reservations.destroy');


Route::get('/available-times', [AvailableTimeController::class, 'index'])->name('available-times.index');
Route::put('available-times/{id}', [AvailableTimeController::class, 'update'])->name('available-times.update');
Route::delete('/available-times/{id}', [AvailableTimeController::class, 'destroy'])->name('available-times.delete');
Route::post('/available-times/{id}/unavailable', [AvailableTimeController::class, 'makeUnavailable'])
    ->name('available-times.make-unavailable');

Route::delete('available-times/{id}/make-available', [AvailableTimeController::class, 'makeAvailable'])->name('available-times.make-available');


Route::post('unavailable-dates/make-unavailable', [AvailableTimeController::class, 'makeDateUnavailable'])->name('unavailable-dates.make-unavailable');
Route::delete('unavailable-dates/{id}/make-available', [AvailableTimeController::class, 'makeDateAvailable'])->name('unavailable-dates.make-available');

Route::resource('users', UserController::class);

Route::get('/reservations/search', [SearchController::class, 'index'])->name('reservations.index.search');
Route::get('/reservations/pending/search', [SearchController::class, 'pendingAppointments'])->name('reservations.pending.search');
Route::get('/reservations/completed/search', [SearchController::class, 'completedAppointments'])->name('reservations.completed.search');

Route::get('/verify-otp', [UserRegisterController::class, 'verifyOtpView'])->name('otp.verify');
Route::post('/verify-otp', [UserRegisterController::class, 'verifyOtp'])->name('otp.verify.submit');
Route::post('/resend-otp', [UserRegisterController::class, 'resendOtp'])->name('otp.resend');

require __DIR__ . '/auth.php';
require __DIR__ . '/admin-auth.php';
