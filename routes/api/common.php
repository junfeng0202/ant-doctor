<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace'=>'App\Http\Controllers\Common'], function ($api) {
	$api->get('disease', 'CommonController@disease');
	$api->get('province', 'CommonController@province');
});
