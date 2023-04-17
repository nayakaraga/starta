<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;

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

Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name("login");
Route::post('/login', [AuthController::class, 'authenticate']);

Route::group(['middleware' => 'auth'], function () {

    Route::get('/logout', [AuthController::class, 'logout'])->name("logout");

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::resource('/users', UserController::class);
});
