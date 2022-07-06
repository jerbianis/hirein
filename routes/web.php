<?php

use App\Http\Controllers\JobOfferController;
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

Route::get('/test', function () {
    //
    return dd(auth()->user()->profile);
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::get('/offers',[JobOfferController::class,''])->middleware(['auth'])->name('offers');

/* Enterprise Dashboard */
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('jobOffer', JobOfferController::class);
});

