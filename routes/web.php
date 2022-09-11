<?php


use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\JobOfferController;
use App\Http\Controllers\ManageCandidatureController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
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
    $to_name = "Anis";
    $to_email = "anisjerbi2@gmail.com";
    $data = array("name" => "Anis", "body" => "this is a test");
    Mail::send('emails.mail',$data,function ($msg) use ($to_name,$to_email) {
        $msg->to($to_email, $to_name)->subject("Laravel Test Mail");
    });
    return to_route('/');
});

Route::get('/', function () {
    return to_route('offers');
});

Auth::routes();

//Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');


Route::get('/offers',[JobOfferController::class,'public'])->name('offers');


/* Profile Auth*/
Route::middleware(['auth'])->group(function () {
    Route::get('profile/{candidate}',[ProfileController::class,'showCandidate'])->name('candidate.show');
    Route::get('profile/{enterprise}',[ProfileController::class,'showEnterprise'])->name('enterprise.show');
    Route::get('/myprofile/edit/',[ProfileController::class,'edit'])->name('profile.edit');
});

/* Profile Candidate*/
Route::middleware(['auth'])->group(function () {
    Route::put('/myprofile/edit/candidate',[ProfileController::class,'updateCandidate'])->name('profile.edit.candidate');
    Route::patch('/myprofile/edit/picture',[ProfileController::class,'uploadpicture'])->name('profile.edit.picture');
    Route::delete('/myprofile/edit/picture/delete',[ProfileController::class,'deletePicture'])->name('profile.delete.picture');
    Route::patch('/myprofile/edit/cv',[ProfileController::class,'uploadCV'])->name('profile.edit.cv');
    Route::delete('/myprofile/edit/cv/delete',[ProfileController::class,'deleteCV'])->name('profile.delete.cv');

});

/* Profile Enterprise*/
Route::middleware(['auth'])->group(function () {
    Route::put('/myprofile/edit/enterprise',[ProfileController::class,'updateEnterprise'])->name('profile.edit.enterprise');
    Route::patch('/myprofile/edit/logo',[ProfileController::class,'uploadLogo'])->name('profile.edit.logo');
    Route::delete('/myprofile/edit/logo/delete',[ProfileController::class,'deleteLogo'])->name('profile.delete.logo');

});

/* Enterprise Dashboard */
Route::middleware(['auth'])->prefix('dashboard')->group(function () {
    Route::resource('jobOffer', JobOfferController::class);
    Route::get('jobOffer/{jobOffer}/candidatures', [ManageCandidatureController::class,'index'])->name('jobOffer.candidatures.index');
    Route::put('jobOffer/{jobOffer}/candidatures/{candidature}',[ManageCandidatureController::class,'update'])->name('jobOffer.candidatures.update');
    Route::patch('jobOffer/{jobOffer}/candidatures/',[ManageCandidatureController::class,'reject_the_rest'])->name('jobOffer.candidatures.reject_the_rest');
    Route::get('/quiz/create', function () {
        return view('enterprise.quiz.index');
    })->name('quiz.create');
    Route::get('/interviews',[InterviewController::class,'index'])->name('interview.index');
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


Route::get('/interview/{interview}', [InterviewController::class,'interview']);
