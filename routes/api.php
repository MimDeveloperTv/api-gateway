<?php

Route::group(['prefix' => 'auth', 'as' => 'auth.'], function () {
    include 'auth/basic.php';
    include 'auth/pass.php';
});

