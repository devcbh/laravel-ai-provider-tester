<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::get('/ai/test', [AiController::class,'test'])->name('ai.test');
Route::get('/ai-ask', [AiController::class, 'ask']);
Route::get('/ai/testTemplate', [AiController::class,'testTemplate'])->name('ai.testTemplate');
Route::get('/ai/testWithContext', [AiController::class,'testWithContext'])->name('ai.testWithContext');
Route::get('/ai/analyzeDirectory', [AiController::class,'analyzeDirectory'])->name('ai.analyzeDirectory');
Route::get('/ai/explain-commit/{hash?}', [AiController::class, 'explainCommit'])->name('ai.explainCommit');
Route::get('/ai/translation', [AiController::class, 'translation'])->name('ai.translation');
Route::get('/ai/translation1', [AiController::class, 'translation1'])->name('ai.translation1');
