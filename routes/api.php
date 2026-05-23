<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservaController; 

Route::post('/booking-webhook', [ReservaController::class, 'receiveWebhook']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
