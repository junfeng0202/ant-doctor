<?php


/*$api = app('Dingo\Api\Routing\Router');

$api->version('v1', ['namespace'=>'App\Http\Controllers\Backend\V1','prefix'=>'back'], function ($api) {
	$api->post('login', 'LoginController@login');
	$api->post('test', 'LoginController@test');
});*/

Route::group(['namespace'=>'App\Http\Controllers\Backend\V1','prefix'=>'back'], function (){
	Route::post('login', 'LoginController@login');
	Route::get('/material/course/list', 'CourseController@list');
	Route::get('/material/course/info/{id}', 'CourseController@info');
	Route::post('/material/course/create', 'CourseController@create');
	Route::post('/material/course/toupiao', 'CourseController@toupiao');
	Route::get('/doctor/list', 'CommonController@doctor');
	Route::get('/disease/list', 'CommonController@disease');
	Route::get('/upload/getTempKeys', 'CommonController@getTempKeys');

});
