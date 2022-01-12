<?php

use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [BookingController::class, 'index'])->name('index');
Route::post('/check-booking', [BookingController::class, 'show'])->name('check-booking');
Route::post('/book', [BookingController::class, 'store'])->name('book');
