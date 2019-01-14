<?php

Route::middleware('auth:member')->get('/user', function (Request $request) {
    return auth('member')->user();
});

/*$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace'=>'App\Http\Controllers\Frontend\V1'], function ($api) {
	$api->post('login', 'LoginController@login');
	$api->post('register', 'LoginController@register');

	$api->group(['middleware' => 'auth:api'], function ($api) {
		$api->post('info', 'LoginController@info');
	});

});*/

Route::group(['namespace'=>'App\Http\Controllers\Frontend\V1','prefix' => 'v1'], function () {

	Route::any('login', 'LoginController@login');
	Route::post('register', 'LoginController@register');
	Route::post('logout', 'LoginController@logout');
	Route::post('refresh', 'LoginController@refresh');
	Route::post('me', 'LoginController@me');

});
