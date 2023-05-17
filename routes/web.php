<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuestionsController;

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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




// Questions
Route::get('/questions', [QuestionsController::class, 'index'])->name('questions.index');
Route::post('/questions', [QuestionsController::class, 'store'])->name('addquestions');
Route::put('/questions/update', [QuestionsController::class, 'update'])->name('questions.update');
Route::get('/questions/{id}', [QuestionsController::class, 'destroy'])->name('questions.destroy');
