<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/auth', [\App\Http\Controllers\AuthController::class, 'login'])->name('auth');
Route::get('/auth?invalid=true', [\App\Http\Controllers\AuthController::class, 'login'])->name('invalid-login');
Route::post('/auth', [\App\Http\Controllers\AuthController::class, 'validateLogin'])->name('auth.validate');
Route::get('/logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('auth.logout');

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

Route::resource('rekening', 'App\Http\Controllers\RekeningController');
Route::get('/data-rekening', [\App\Http\Controllers\RekeningController::class, 'dataRekening'])->name('data-rekening');
Route::post('/rekening-update', [\App\Http\Controllers\RekeningController::class, 'update'])->name('rekening.update');
Route::post('/rekening-approve', [\App\Http\Controllers\RekeningController::class, 'approve'])->name('rekening.approve');

// Route::get('/sender', function () {
//     broadcast(new \App\Events\RekeningEvent());
// });
