<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthManager;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\editDetails;
use Illuminate\Support\Facades\Route;

// ---------------------------------------------------------- HOME PAGE ROUTE ---------------------------------------------------
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
// to forgot password page
Route::get('/forgotpassword', [ForgotPasswordController::class, 'forgotPasswordPage'])->name('forgotPassword');

Route::post('/forgotpassword', [ForgotPasswordController::class, 'forgotPasswordCheck'])->name('forgotpassword.post');

Route::get('/resetpassword/{id}', [ForgotPasswordController::class, 'resetPassword'])->name('resetPassword');

Route::post('/resetpassword/{id}', [ForgotPasswordController::class, 'changePassword'])->name('resetpassword.post');

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

// direct user to the page where thy can book a trainer
Route::get('/book-trainer/{userID}/{trainerID}', [DashboardController::class, 'bookTrainer']);

// create a booking
Route::post('/processing-booking/{userID}/{trainerID}', [BookingController::class, 'book']);

// to delete the user's booking
Route::get('cancel-booking/{bookingID}', [DashboardController::class, 'cancelBooking']);

// -------------------------------------- ADMIN ROUTES --------------------------------------------------

// direct admin to their dashboard page
Route::get('/admin/{adminID}', [AdminController::class, 'toAdminPage'])->name('admindash');

// create new admin
Route::post('/admin/{adminID}/create-admin', [AdminController::class, 'createNewAdmin'])->name('new_admin.post');

// suspend an admin
Route::get('/admin/{adminID}/suspend-admin/{admin_ID}', [AdminController::class, 'suspendAdmin'])->name('suspendAdmin');

// re-activate an admin after suspension
Route::get('/admin/{adminID}/reactivate-admin/{admin_ID}', [AdminController::class, 'reactivateAdmin'])->name('reactivateAdmin');

// delete an admin account
Route::get('/admin/{adminID}/delete-admin/{admin_ID}', [AdminController::class, 'deleteAdmin'])->name('deleteAdmin');

// approve trainers
Route::get('/admin/{adminID}/approve/{trainerID}', [AdminController::class, 'approveTrainers'])->name('approveTrainers');

// reject trainers
Route::get('/admin/{adminID}/reject/{trainerID}', [AdminController::class, 'rejectTrainers'])->name('rejectTrainers');

// suspend members
Route::get('/admin/{adminID}/suspend-member/{memberID}', [AdminController::class, 'suspendMembers'])->name('suspendMembers');

// re-activate members after suspension
Route::get('/admin/{adminID}/reactivate-member/{memberID}', [AdminController::class, 'reactivateMembers'])->name('reactivateMembers');

// delete member account
Route::get('/admin/{adminID}/delete-member/{memberID}', [AdminController::class, 'deleteMembers'])->name('deleteMembers');

// suspend a trainer
Route::get('/admin/{adminID}/suspend-trainer/{trainerID}', [AdminController::class, 'suspendTrainers'])->name('suspendTrainers');

// re-activate trainer after suspension
Route::get('/admin/{adminID}/reactivate-trainer/{trainerID}', [AdminController::class, 'reactivateTrainers'])->name('reactivateTrainers');

// delete trainer account
Route::get('/admin/{adminID}/delete-trainer/{trainerID}', [AdminController::class, 'deleteTrainers'])->name('deleteTrainers');

// re-approe a rejected trainer
Route::get('/admin/{adminID}/reapprove-trainer/{trainerID}', [AdminController::class, 'reapproveTrainer'])->name('reapproveTrainer');

// delete account details of a rejected trainer
Route::get('/admin/{adminID}/remove-trainer/{trainerID}', [AdminController::class, 'removeTrainer'])->name('removeTrainer');

// delete a user booking
Route::get('/admin/{adminID}/remove-booking/{bookingID}', [AdminController::class, 'removeBooking'])->name('removeBooking');


