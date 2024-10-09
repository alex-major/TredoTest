<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/fcm/auth', [App\Http\Controllers\api\FCMController::class, 'auth']);
Route::get('/api/fcm/set-token', [App\Http\Controllers\api\FCMController::class, 'setToken']);
