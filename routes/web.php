<?php

use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionTypeController;
use App\Models\Question;
use Illuminate\Support\Facades\Auth;
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
    return redirect('bring-it-on');
});

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/bring-it-on', function () {
    return view('quiz/bring-it-on');
})->middleware('auth');

Route::get('/admin', function () {
    if (Auth::user()->role != 100) {
        abort(403);
    }
    return view('quiz.admin-screen');
})->middleware('auth')->name('quiz.home');

Route::get('/admin/manage-questions', function () {
    return view('quiz.manage');
})->middleware('auth')->name('quiz.manage');

Route::get('/admin/quiz/create', [QuestionController::class, 'create'])->middleware('auth')->name('quiz.create');
Route::post('/admin/quiz/store', [QuestionController::class, 'store'])->middleware('auth')->name('quiz.store');
Route::get('/admin/quiz/{id}', [QuestionController::class, 'select'])->middleware('auth')->name('quiz.select');
Route::post('/admin/question/update/{id}', [QuestionController::class, 'update'])->middleware('auth')->name('quiz.select.update');
