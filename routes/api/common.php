<?php

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace'=>'App\Http\Controllers\Common'], function ($api) {
	$api->get('disease', 'CommonController@disease');
	$api->get('province', 'CommonController@province');
	//获取蚂蚁信息列表
    $api->get('articlesList', 'CommonController@articlesList');

});
