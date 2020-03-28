<?php

Route::post('login', 'LoginController@login');

Route::group(['middleware' => 'auth:sanctum'], function() {
    Route::resource('products', 'ProductController')->except(['create', 'edit']);
});

Route::get('{any?}', function() {
    abort(404);
})->where('any', '.*');
