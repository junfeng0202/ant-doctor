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
	//首页获取数据
	Route::get('index', 'IndexController@index');

	Route::get('article', 'ArticleController@index');
	Route::get('article/{id}', 'ArticleController@info')->name('article.info');

	Route::get('course', 'CourseController@index');
	Route::get('course/{id}', 'CourseController@info')->name('course.info');

	Route::get('live', 'LiveController@index');
	Route::get('live/{id}', 'LiveController@info')->name('live.info');

	Route::get('video', 'VideoController@index');
	Route::get('video/{id}', 'VideoController@info')->name('video.info');


});
