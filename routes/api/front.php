<?php

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace'=>'App\Http\Controllers\Frontend\V1'], function ($api) {
	$api->post('login', 'LoginController@login');
	$api->post('register', 'LoginController@register');
	//首页获取数据
    $api->get('index', 'IndexController@index');

	$api->group(['middleware' => 'auth:api'], function ($api) {
		$api->post('info', 'LoginController@info');
	});

});
