<?php

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace'=>'App\Http\Controllers\Frontend\V1'], function ($api) {
	$api->get('login', 'LoginController@login');
});
