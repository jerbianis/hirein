<?php

use App\Http\Controllers\CandidatureController;
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

Route::get('/offers',[JobOfferController::class,'public'])->name('offers');

/* Enterprise Dashboard */
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('jobOffer', JobOfferController::class);
});


/* Candidate */
Route::middleware(['auth'])->group(function () {
    Route::post('/candidature',[CandidatureController::class,'store'])->name('candidature.store');
});

/* Candidate Dashboard */
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    //Route::resource('candidature', CandidatureController::class);
    Route::get('/candidature',[CandidatureController::class,'index'])->name('candidature.index');
    Route::delete('/candidature/{candidature}',[CandidatureController::class,'destroy'])->name('candidature.destroy');
});
