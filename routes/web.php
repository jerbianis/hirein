<?php

use App\Enum\CandidatureStatusEnum;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\ManageCandidatureController;
use App\Models\Candidature;
use App\Models\JobOffer;
use Carbon\Carbon;
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
    return '';
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
    Route::get('jobOffer/{jobOffer}/candidatures', [ManageCandidatureController::class,'index'])->name('jobOffer.candidatures.index');
    Route::put('jobOffer/{jobOffer}/candidatures/{candidature}',[ManageCandidatureController::class,'update'])->name('jobOffer.candidatures.update');
    Route::patch('jobOffer/{jobOffer}/candidatures/',[ManageCandidatureController::class,'reject_the_rest'])->name('jobOffer.candidatures.reject_the_rest');
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
