<?php

use App\Http\Controllers\AuthManager;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\editDetails;
use Illuminate\Support\Facades\Route;

// -------------------------------------- HOME PAGE ROUTE ---------------------------------------------
Route::get('/', function () {
    return view('index');
});

Route::get('/home', function () {
    return view('index');
})->name('home');

// ------------------------------ GET ROUTES FOR LOGIN AND REGISTRATION -------------------------------
// this is a route to the page
Route::get('/register', [AuthManager::class, 'register'])->name('register');
Route::get('/login', [AuthManager::class, 'login'])->name('login');

// these are routes that do the actual actions (login and registration)
Route::post('/login', [AuthManager::class, 'loginPost'])->name('login.post');
Route::post('/register', [AuthManager::class, 'registerPost'])->name('register.post');

// ----------------------------------------- LOGOUT ROUTE ---------------------------------------------
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

// ------------------------------------- RESET PASSWORD ROUTE -----------------------------------------
Route::get('/forgotpassword', function () {
    return view('/auth/forgotpassword');
});

// ------------------------------------- DASHBOARD ROUTE ----------------------------------------------
// to dashboard page
Route::get('/dashboard', [DashboardController::class, 'toDashboard'])->name('dashboard');

// to edit details page
Route::get('/edit/{id}', [DashboardController::class, 'edit']);

// to delete the user's account
Route::get('delete/{id}', [DashboardController::class, 'destroy']);

// to actually update the user's details
Route::put('/update-data/{id}', [editDetails::class, 'editStuff']);

// ------------------------------------- TRAINER ROUTES ------------------------------------------------------

Route::get('/trainer-register', [AuthManager::class, 'trainerregister'])->name('trainer.register');
Route::get('/trainer-login', [AuthManager::class, 'trainerlogin'])->name('trainer.login');

Route::post('/trainer-login', [AuthManager::class, 'trainerloginPost'])->name('trainer.login.post');
Route::post('/trainer-register', [AuthManager::class, 'trainerregisterPost'])->name('trainer.register.post');

// -------------------------------------- BOOKING ROUTES ----------------------------------------------

Route::get('/book-trainer/{userID}/{trainerID}', [DashboardController::class, 'bookTrainer']);

Route::post('/processing-booking/{userID}/{trainerID}', [BookingController::class, 'book']);

// to delete the user's booking
Route::get('cancel-booking/{bookingID}', [DashboardController::class, 'cancelBooking']);
