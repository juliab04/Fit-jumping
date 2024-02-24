<?php

use App\Http\Controllers\MainController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\PhoneVerificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserAuthController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//Auth::routes(['verify' => true]);

Route::get('dashboard', [UserAuthController::class, 'dashboard']);
Route::get('login', [UserAuthController::class, 'index'])->name('login');
Route::post('login', [UserAuthController::class, 'login'])->name('login.user');
Route::get('registration', [UserAuthController::class, 'registration'])->name('register-user');
Route::post('registration', [UserAuthController::class, 'userRegistration']);

Route::get('/email/verify', function () {return view('auth.verify-email');})->middleware('auth', 'verified')
    ->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('signout', [UserAuthController::class, 'signOut'])->name('signout');
Route::get('coaches', [MainController::class, 'getCoaches'])->name('coaches');
Route::get('groups', [MainController::class, 'getGroups'])->name('groups');

Route::get('note', [NoteController::class, 'note'])->name('note');
Route::post('note', [NoteController::class, 'userNote'])->name('note.user');
Route::post('verify-phone', [NoteController::class, 'sendSms'])->name('sms');
Route::post('confirm-phone', [NoteController::class, 'sendSms'])->name('sms');

Route::get('myNotes', [MainController::class, 'myNotes'])->name('mynotes');
Route::post('deleteNote', [MainController::class, 'deleteMyGroup'])->name('note.delete');
Route::get('getNotes', [MainController::class, 'getNotes'])->name('get.notes');
Route::post('updateNote', [MainController::class, 'updateNotes'])->name('update');


Route::get('/admin/dashboard', [App\Http\Controllers\Admin\MainController::class, 'dashboard'])->name('admin');
Route::get('/admin/getUsers', [App\Http\Controllers\Admin\MainController::class, 'getUsers'])->name('get.users');
Route::get('/admin/getUserPanel/{id}', [App\Http\Controllers\Admin\MainController::class, 'getUserPanel'])->name('get.users');
Route::post('/admin/deleteUser', [App\Http\Controllers\Admin\MainController::class, 'deleteUser'])->name('note.delete');
//Route::get('/admin/updateUser', [App\Http\Controllers\Admin\MainController::class, 'updateUser'])->name('update');
Route::post('/admin/updateUser', [App\Http\Controllers\Admin\MainController::class, 'updateUser'])->name('update');
Route::get('/admin/search', [App\Http\Controllers\Admin\MainController::class, 'search'])->name('search');
