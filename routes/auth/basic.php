<?php

use App\Http\Controllers\API\Auth\Basic\AuthController as Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* -----  API Routes --------------------------------------------------------------------- */

Route::group(['prefix' => 'basic', 'as' => 'basic.'], function () {
    Route::post('/login',[Auth::class,'login'])->name('auth.login');
    Route::post('/register',[Auth::class,'register'])->name('auth.register');
    Route::post('/logout',[Auth::class,'logout'])->name('auth.logout')->middleware('auth:api');
});
