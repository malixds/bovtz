<?php

use App\Http\Controllers\GuestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::get('/guests', [GuestController::class, 'index']);
Route::get('/guests/{id}', [GuestController::class, 'get']);
Route::post('/guests', [GuestController::class, 'create']);
Route::put('/guests/{id}', [GuestController::class, 'update']);
Route::delete('/guests/{id}', [GuestController::class, 'delete']);

