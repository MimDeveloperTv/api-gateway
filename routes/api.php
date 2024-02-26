<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Auth\AuthController as Auth;

/* -----  API Routes --------------------------------------------------------------------- */

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    Route::post('/login',[Auth::class,'login'])->name('auth.login');
    Route::post('/register',[Auth::class,'register'])->name('auth.register');
    Route::post('/logout',[Auth::class,'logout'])->name('auth.logout')->middleware('auth:api');
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
