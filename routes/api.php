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
