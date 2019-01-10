<?php

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace'=>'App\Http\Controllers\Frontend\V1'], function ($api) {
	$api->post('login', 'LoginController@login');
	$api->post('register', 'LoginController@register');

	$api->group(['middleware' => 'auth:api'], function ($api) {
		$api->post('info', 'LoginController@info');
	});

});
