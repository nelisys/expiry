<?php

Route::group(['middleware' => 'auth:api'], function() {
    Route::resource('products', 'ProductController')->except(['create', 'edit']);
});
