<?php

use App\Http\Controllers\API\Auth\Pass\AuthController as Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController as AccessToken;
use Illuminate\Http\Request;

/* -----  API Routes --------------------------------------------------------------------- */

Route::group(['prefix' => 'pass', 'as' => 'pass.'], function () {
    Route::post('/login',[Auth::class,'login'])->middleware('throttle')->name('auth.login');
    Route::post('/logout',[Auth::class,'logout'])->name('auth.logout')->middleware('auth:api');
   // Route::post('/register',[Auth::class,'register'])->name('auth.register');
});
