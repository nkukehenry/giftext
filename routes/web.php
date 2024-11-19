<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminAuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/participant', [ParticipantController::class, 'index'])->middleware('auth:participant');

Auth::routes();

Route::get('/email/verify', [EmailVerificationController::class, 'index'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, 'verify'])->name('verification.verify');
Route::post('/email/resend', [EmailVerificationController::class, 'resend'])->name('verification.resend');

Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/profile', [ProfileController::class, 'index'])->name('profile');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'web','admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/reports', [AdminController::class, 'reports'])->name('admin.reports');
    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/settings', [AdminController::class, 'settings'])->name('admin.settings');
    
    Route::get('/participants', [AdminController::class, 'participants'])->name('admin.participants');
    Route::post('/participants', [AdminController::class, 'storeParticipant'])->name('admin.participants.store');
    Route::get('/participants/{id}/edit', [AdminController::class, 'editParticipant'])->name('admin.participants.edit');
    Route::put('/participants/{id}', [AdminController::class, 'updateParticipant'])->name('admin.participants.update');

    Route::get('/groups', [AdminController::class, 'groups'])->name('admin.groups');
    Route::post('/groups', [AdminController::class, 'storeGroup'])->name('admin.groups.store');
    Route::put('/groups/{id}', [AdminController::class, 'updateGroup'])->name('admin.groups.update');
    Route::delete('/groups/{id}', [AdminController::class, 'destroyGroup'])->name('admin.groups.destroy');
});

Route::prefix('admin')->group(function () {
    Route::get('register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('register', [AdminAuthController::class, 'register']);
});

