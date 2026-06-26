<?php

use App\Http\Controllers\AiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\NotesController;
use App\Http\Controllers\StartController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'loginPage'])->name('loginPage');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::get('/sign-up', [AuthController::class, 'signUpPage'])->name('signUpPage');
    Route::post('/sign-up', [AuthController::class, 'sigUp'])->name('signUp');
    Route::get('/forgot-password', [AuthController::class, 'forgotPasswordPage'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPasswordPost'])->name('forgotPassword');
    Route::get('/verify-otp', [AuthController::class, 'showOtp'])->name('otp.form');
    Route::get('/verify-otp-pass', [AuthController::class, 'showOtpPass'])->name('otp.form.pass');
    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('otp.verify');
    Route::post('/resend-otp', [AuthController::class, 'resendOtpCode'])->name('resendOtp');
    Route::get('/auth/redirect', [AuthController::class, 'redirectToGoogle'])->name('redirect');
    Route::get('/auth/google/callback', [AuthController::class, 'handelGoogleCallback']);
    Route::post('/verify-pass', [AuthController::class, 'verifyOtpPass'])->name('verify.pass');
    Route::get('/reset-password/{email}', [AuthController::class, 'showPasswordResetForm'])
        ->middleware('signed')
        ->name('password.reset.form');
    Route::post('/reset-password', [AuthController::class, 'updatePassword'])->name('password.update');
});


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [StartController::class, 'Inicio'])->name('dashboard');
    Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoriesController::class, 'createPage'])->name('categories.createPage');
    Route::get('/categories/{id}/edit', [CategoriesController::class, 'editPage'])->name('categories.editPage');
    Route::get('/notes', [NotesController::class, 'index'])->name('notes.index');
    Route::get('/notes/create', [NotesController::class, 'createPage'])->name('notes.createPage');
    Route::get('/notes/{id}/edit', [NotesController::class, 'editPage'])->name('notes.editPage');
    Route::post('/notes/create', [NotesController::class, 'create'])->name('notes.create');
    Route::put('/notes/{id}/edit', [NotesController::class, 'update'])->name('notes.update');
    Route::post('/categories/create', [CategoriesController::class, 'create'])->name('categories.create');
    Route::delete('/notes/{id}/delete', [NotesController::class, 'deleteNote'])->name('notes.delete');
    Route::delete('/categories/{id}/delete', [CategoriesController::class, 'deleteCategory'])->name('categories.delete');
    Route::put('/categories/{id}/edit', [CategoriesController::class, 'edit'])->name('categories.edit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/ai/suggest-content', [AiController::class, 'generateContent'])->name('ai.suggest');
    Route::post('/ai/improve-content', [AiController::class, 'improveContent'])->name('ai.improve');
});


Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/users', [UserController::class, 'index'])->name('usersPage');
    Route::get('/users/{id}/edit', [UserController::class, 'editPage'])->name('user.editPage');
    Route::put('/users/{id}/edit', [UserController::class, 'updateUser'])->name('user.update');
    Route::delete('/users/{id}/delete', [UserController::class, 'deleteUser'])->name('user.delete');
});
