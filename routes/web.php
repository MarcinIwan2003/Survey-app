<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\QuizSessionController;

// 🔸 Strona główna
Route::get('/', function () {
    return view('welcome');
})->name('home');

// 🔸 Start quizu (gość lub użytkownik)
Route::post('/quiz/start', [QuizSessionController::class, 'start'])->name('quiz.start');
Route::get('/quiz/play/{session}', [QuizSessionController::class, 'play'])->name('quiz.play');
Route::post('/quiz/answer/{session}', [QuizSessionController::class, 'answer'])->name('quiz.answer');
Route::get('/quiz/summary/{session}', [QuizSessionController::class, 'summary'])->name('quiz.summary');

// 🔸 Autoryzacja (Laravel Auth)
Auth::routes();

// 🔒 Trasy dostępne tylko po zalogowaniu
Route::middleware(['auth'])->group(function () {
    // 🔹 Panel
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 🔹 Tworzenie ankiety (statyczne trasy MUSZĄ być przed dynamicznymi)
    Route::get('/surveys/create', [SurveyController::class, 'create'])->name('surveys.create');
    Route::post('/surveys', [SurveyController::class, 'store'])->name('surveys.store');

    // 🔹 Lista ankiet i podgląd pojedynczej
    Route::get('/surveys', [SurveyController::class, 'index'])->name('surveys.index');
    Route::get('/surveys/{survey}', [SurveyController::class, 'show'])->name('surveys.show');

    // 🔹 Statystyki wyników
    Route::get('/results', [ResultController::class, 'index'])->name('results.index');

    // 🔸 WAŻNE: dynamiczne trasy na końcu, + ograniczenie do ID (opcjonalnie)
    Route::get('/results/{survey}', [ResultController::class, 'show'])
        ->where('survey', '[0-9]+')
        ->name('results.show');
});
