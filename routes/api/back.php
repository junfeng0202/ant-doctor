<?php


/*$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace'=>'App\Http\Controllers\Backend\V1','prefix'=>'back'], function ($api) {
	$api->post('login', 'LoginController@login');
	$api->post('test', 'LoginController@test');
});*/

Route::group(['namespace'=>'App\Http\Controllers\Backend\V1','prefix'=>'back'], function (){
	Route::post('login', 'LoginController@login');
	Route::get('/material/video/list', 'CourseController@list');
	Route::get('/doctor/list', 'CourseController@list');
});
