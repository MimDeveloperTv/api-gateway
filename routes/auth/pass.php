<?php

use App\Http\Controllers\API\Auth\Pass\AuthController as Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController as AccessToken;
use Illuminate\Http\Request;

/* -----  API Routes --------------------------------------------------------------------- */

Route::group(['prefix' => 'pass', 'as' => 'pass.','middleware' => ['secret.check','throttle']], function () {
    Route::post('/login',[Auth::class,'login']) ->name('auth.login');
    // Route::post('/register',[Auth::class,'register'])->name('auth.register');

    Route::middleware('auth:api')->group( function () {
        Route::post('/logout',[Auth::class,'logout'])->name('auth.logout');
    });

});
