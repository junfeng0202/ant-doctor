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
	Route::get('/material/course/sections/{id}', 'CourseController@sections');//获取课程章节
	Route::post('/material/course/section/add/{id}', 'CourseController@addSection');//添加章节



	Route::get('/doctor/list', 'CommonController@doctor');
	Route::get('/disease/list', 'CommonController@disease');
	Route::get('/upload/getTempKeys', 'CommonController@getTempKeys');

});
