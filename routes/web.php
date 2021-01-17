<?php

Route::view('blog', 'press::test');

//Route::get('/controller', [\amirgonvt\Press\Http\Controllers\TestController::class, 'index']);
Route::get('controller', 'TestController@index');