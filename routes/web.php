<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', [TaskController::class,'index']);
Route::post('/', [TaskController::class,'store']);
Route::patch('/{task}', [TaskController::class,'update']);
Route::delete('/{task}', [TaskController::class,'destroy']);
